<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Ptc;
use App\Models\PtcEngagement;
use App\Models\PtcReport;
use App\Models\PtcReportType;
use App\Models\PtcView;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PtcController extends Controller
{
    public function index()
    {
        $pageTitle = "PTC Ads";
        $ads = Ptc::where('status', Status::PTC_ACTIVE)
            ->where('remain', '>', 0)
            ->where('user_id', '!=', auth()->id())
            ->whereDoesntHave('views', function ($q) {
                $q->where('user_id', auth()->user()->id)->whereDate('view_date', Date('Y-m-d'));
            })
            ->inRandomOrder()
            ->orderBy('remain', 'desc')
            ->limit(45)
            ->get();
        return view($this->activeTemplate . 'user.ptc.index', compact('ads', 'pageTitle'));
    }

    public function show($hash)
    {
        $user = auth()->user();

        if (!$user->plan_id) {
            $notify[] = ['error', 'You\'ve no subscription plan. Please subscribe a plan first'];
            return to_route('plans')->withNotify($notify);
        }

        if ($user->expire_date < now()) {
            $notify[] = ['error', 'Your subscription plan has been expired. Subscribe again to plan'];
            return to_route('plans')->withNotify($notify);
        }

        $id = $this->checkEligibleAd($hash, $user);

        if (!$id) {
            $notify[] = ['error', "You are not eligible for this link"];
            return redirect()->route('user.home')->withNotify($notify);
        }

        $pageTitle = 'Show Advertisement';
        $ptc       = Ptc::where('id', $id)->where('remain', '>', 0)->where('status', 1)->firstOrFail();

        if ($ptc->schedule) {
            $currentTime = now()->format('H:i');
            if (!collect($ptc->schedule)->where('day', strtolower(now()->format('l')))->where('start', '<', $currentTime)->where('end', '>', $currentTime)->first()) {
                abort(404);
            }
        }

        if ($user->id == $ptc->user_id) {
            $notify[] = ['error', 'You couldn\'t view your own advertisement'];
            return back()->withNotify($notify);
        }

        $viewads = PtcView::where('user_id', $user->id)->whereDate('view_date', now())->get();

        if ($viewads->count() >= $user->daily_limit) {
            $notify[] = ['error', 'Oops! Your limit is over. You cannot see more ads today'];
            return back()->withNotify($notify);
        }

        if ($viewads->where('ptc_id', $ptc->id)->first()) {
            $notify[] = ['error', 'You cannot see this add before 24 hour'];
            return back()->withNotify($notify);
        }

        $types = PtcReportType::active()->orderBy('name')->get();

        $engagement = new PtcEngagement();
        $engagement->ptc_id = $ptc->id;
        $engagement->click = now();
        $engagement->save();

        return view($this->activeTemplate . 'user.ptc.show', compact('ptc', 'pageTitle', 'types', 'engagement'));
    }

    public function clicks()
    {
        $pageTitle = 'PTC Clicks';
        $query   = PtcView::where('user_id', auth()->user()->id);

        if (request()->date) {
            $query->whereDate('created_at', request()->date);
        }

        $viewads   = $query->selectRaw('DATE(view_date) as date')->groupBy('date')->selectRaw('count(id) as total_clicks, sum(amount) as total_earned')->orderBy('date', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.ptc.earnings', compact('viewads', 'pageTitle'));
    }

    // public function confirm()
    // {

    //     $user = auth()->user();
    //     $alreadyClaimed = Transaction::where('user_id', $user->id)
    //         ->whereDate('created_at', Carbon::today())
    //         ->where('remark', 'ptc_earn')
    //         ->exists();

    //     if ($alreadyClaimed) {
    //         $notify[] = ['error', 'You have claimed today earning please check next reminder'];
    //         return back()->withNotify($notify);
    //     }


    //     if (!$user->plan_id) {
    //         $notify[] = ['error', 'You\'ve no subscription plan. Please subscribe a plan first'];
    //         return back()->withNotify($notify);
    //     }

    //     $totalEarning = 0;

    //     foreach ($user->investments as $investment) {
    //         $dailyEarning = ($investment->amount * $investment->monthly_percent) / 100 / 30;
    //         if (($investment->earned + $dailyEarning) >= $investment->max_earning) {
    //             $dailyEarning = $investment->max_earning - $investment->earned;
    //             $investment->status = 'expired';
    //         }
    //         $totalEarning += $dailyEarning;
    //         $investment->earned += $dailyEarning;
    //         $investment->save();
    //     }

    //     // dd($user->investments);
    //     $user->balance += $totalEarning;
    //     $user->save();

    //     $trx                       = getTrx();
    //     $transaction               = new Transaction();
    //     $transaction->user_id      = $user->id;
    //     $transaction->amount       = $totalEarning;
    //     $transaction->post_balance = $user->balance;
    //     $transaction->charge       = 0;
    //     $transaction->trx_type     = '+';
    //     $transaction->details      = 'Claim Daily earning';
    //     $transaction->trx          = $trx;
    //     $transaction->remark       = 'ptc_earn';
    //     $transaction->save();

    //     levelCommission($user, $totalEarning, 'ptc_view_commission', $trx);
    //     $notify[] = ['success', 'Daily earning claim successfully'];
    //     return redirect()->back()->withNotify($notify);
    // }

    public function confirm()
    {
        $user = auth()->user();
        $alreadyClaimed = Transaction::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->where('remark', 'ptc_earn')
            ->exists();

        if ($alreadyClaimed) {
            $notify[] = ['error', 'You have already claimed today’s earnings. Please check back later.'];
            return back()->withNotify($notify);
        }

        if (!$user->plan_id) {
            $notify[] = ['error', 'You do not have a subscription plan. Please subscribe to a plan first.'];
            return back()->withNotify($notify);
        }

        $activeInvestments = $user->investments->filter(function ($investment) {
            return $investment->status !== 'expired';
        });

        if ($activeInvestments->isEmpty()) {
            $notify[] = ['error', 'All your investments have expired. Please reinvest to continue earning.'];
            return back()->withNotify($notify);
        }

        $totalEarning = 0;

        foreach ($user->investments as $investment) {
            if ($investment->status === 'expired') {
                continue;
            }

            $dailyEarning = ($investment->amount * $investment->monthly_percent) / 100 / 30;

            if (($investment->earned + $dailyEarning) >= $investment->max_earning) {
                $dailyEarning = $investment->max_earning - $investment->earned;
                $investment->status = 'expired';
            }

            $totalEarning += $dailyEarning;
            $investment->earned += $dailyEarning;
            $investment->save();
        }

        $user->balance += $totalEarning;
        $user->total_earning += $totalEarning;
        $user->save();

        $trx = getTrx();
        $transaction = new Transaction();
        $transaction->user_id = $user->id;
        $transaction->amount = $totalEarning;
        $transaction->post_balance = $user->balance;
        $transaction->charge = 0;
        $transaction->trx_type = '+';
        $transaction->details = 'Claim Daily earning';
        $transaction->trx = $trx;
        $transaction->remark = 'ptc_earn';
        $transaction->save();

        levelCommission($user, $totalEarning, 'ptc_view_commission', $trx);

        $notify[] = ['success', 'Daily earnings claimed successfully.'];
        return redirect()->back()->withNotify($notify);
    }


    protected function checkEligibleAd($hash, $user)
    {
        $decrypted     = decrypt($hash);
        $decryptedData = explode('|', $decrypted);
        $id            = $decryptedData[0];

        if ($decryptedData[1] != $user->id) {
            return false;
        }

        return $id;
    }

    public function ads()
    {
        $this->userPostEnabled();
        $pageTitle = 'My Ads';
        $query       = Ptc::where('user_id', auth()->id());
        if (request()->status) {
            $query->where('status', request()->status);
        }
        $ads       = $query->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.ptc.ads', compact('ads', 'pageTitle'));
    }

    public function create()
    {
        $this->userPostEnabled();
        $pageTitle = 'Create Ads';
        return view($this->activeTemplate . 'user.ptc.create', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $this->userPostEnabled();
        $this->validation($request, [
            'website_link' => 'nullable|url|required_without_all:banner_image,script,youtube',
            'banner_image' => 'nullable|mimes:jpeg,jpg,png,gif|required_without_all:website_link,script,youtube',
            'script'       => 'nullable|required_without_all:website_link,banner_image,youtube',
            'youtube'      => 'nullable|url|required_without_all:website_link,banner_image,script',
            'max_show'     => 'required|integer|min:1',
        ]);

        $ptc = new Ptc();
        return $this->submit($request, $ptc);
    }

    public function edit($id)
    {
        $this->userPostEnabled();
        $pageTitle = 'Edit Ads';
        $ptc       = Ptc::where('user_id', auth()->id())->where('status', '!=', Status::PTC_REJECT)->findOrFail($id);
        return view($this->activeTemplate . 'user.ptc.edit', compact('pageTitle', 'ptc'));
    }

    public function update(Request $request, $id)
    {
        $this->userPostEnabled();
        $this->validation($request);
        $ptc = Ptc::where('user_id', auth()->id())->where('status', '!=', Status::PTC_REJECT)->findOrFail($id);
        return $this->submit($request, $ptc, 1);
    }

    public function submit($request, $ptc, $isUpdate = 0)
    {
        $this->userPostEnabled();
        $user    = auth()->user();
        $message = 'Advertisement updated successfully.';
        $general = gs();

        if ($isUpdate == 0) {
            $message = 'Advertisement added successfully.';

            if ($request->ads_type == 1) {
                $price   = @$general->ads_setting->ad_price->url ?? 0;
                $userAmo = @$general->ads_setting->amount_for_user->url ?? 0;
            } elseif ($request->ads_type == 2) {
                $price   = @$general->ads_setting->ad_price->image ?? 0;
                $userAmo = @$general->ads_setting->amount_for_user->image ?? 0;
            } elseif ($request->ads_type == 3) {
                $price   = @$general->ads_setting->ad_price->script ?? 0;
                $userAmo = @$general->ads_setting->amount_for_user->script ?? 0;
            } else {
                $price   = @$general->ads_setting->ad_price->youtube ?? 0;
                $userAmo = @$general->ads_setting->amount_for_user->image ?? 0;
            }

            $totalPrice = $price * $request->max_show;

            if ($user->balance < $totalPrice) {
                $notify[] = ['error', 'You\'ve no sufficient balance'];
                return back()->withNotify($notify);
            }

            $user->balance -= $totalPrice;
            $user->save();

            $transaction               = new Transaction();
            $transaction->user_id      = $user->id;
            $transaction->amount       = $totalPrice;
            $transaction->post_balance = $user->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '-';
            $transaction->details      = 'PTC ad create';
            $transaction->trx          = getTrx();
            $transaction->remark       = 'ad_create';
            $transaction->save();

            $ptc->user_id  = $user->id;
            $ptc->amount   = $userAmo;
            $ptc->max_show = $request->max_show;
            $ptc->remain   = $request->max_show;
        }

        $ptc->title    = $request->title;
        $ptc->duration = $request->duration;
        $ptc->ads_type = $request->ads_type;
        $ptc->status   = $general->ad_auto_approve ? 1 : 2;

        if ($request->ads_type == 1) {
            $ptc->ads_body = $request->website_link;
        } elseif ($request->ads_type == 2) {

            if ($request->hasFile('banner_image')) {

                if ($isUpdate == 1) {
                    $old = $ptc->ads_body;
                    fileManager()->removeFile(getFilePath('ptc') . '/' . $old);
                }

                $directory     = date("Y") . "/" . date("m") . "/" . date("d");
                $path          = getFilePath('ptc') . '/' . $directory;
                $filename      = $directory . '/' . fileUploader($request->banner_image, $path);
                $ptc->ads_body = $filename;
            }
        } elseif ($request->ads_type == 3) {
            $ptc->ads_body = $request->script;
        } else {
            $ptc->ads_body = $request->youtube;
        }

        $ptc->schedule = array_values($request->schedule ?? []);

        $ptc->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function validation($request, $rules = [])
    {
        $globalRules = [
            'title'    => 'required',
            'duration' => 'required|integer|min:1',
            'ads_type' => 'required|integer|in:1,2,3,4',
            'schedule' => 'array',
            'schedule.*.day' => 'required',
            'schedule.*.start' => 'required|date_format:H:i',
            'schedule.*.end' => 'required|date_format:H:i|after:schedule.*.start'
        ];
        $rules = array_merge($globalRules, $rules);
        $request->validate($rules);
    }

    public function status($id)
    {
        $this->userPostEnabled();
        $ptc = Ptc::where('user_id', auth()->id())->whereIn('status', [Status::PTC_ACTIVE, Status::PTC_INACTIVE])->findOrFail($id);

        if ($ptc->status == Status::PTC_ACTIVE) {
            $ptc->status = Status::PTC_INACTIVE;
            $notify[]    = ['success', 'Advertisement deactivated successfully'];
        } else {
            $ptc->status = Status::PTC_ACTIVE;
            $notify[]    = ['success', 'Advertisement deactivated successfully'];
        }

        $ptc->save();
        return back()->withNotify($notify);
    }

    private function userPostEnabled()
    {
        $general = gs();

        if (!$general->user_ads_post) {
            abort(404);
        }
    }

    public function reportSubmit(Request $request)
    {
        $request->validate([
            'ptc_id' => 'required',
            'type' => 'required',
            'description' => 'required'
        ]);

        $report = new PtcReport();
        $report->ptc_id = $request->ptc_id;
        $report->user_id = auth()->id();
        $report->ptc_report_type_id = $request->type;
        $report->description = $request->description;
        $report->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->id();
        $adminNotification->title = "New ad reported submitted";
        $adminNotification->click_url = urlPath('admin.ptc.edit', $request->ptc_id);
        $adminNotification->save();

        $notify[] = ['success', 'Ad reported successfully'];
        return to_route('user.ptc.index')->withNotify($notify);
    }

    public function engagement($id)
    {
        $engagement = PtcEngagement::find($id);
        $engagement->duration = now()->parse($engagement->click)->diffInSeconds(now());
        $engagement->save();
    }
}
