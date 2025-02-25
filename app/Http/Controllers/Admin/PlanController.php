<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Referral;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $pageTitle = 'Subscription Plan';
        $levels = Referral::where('commission_type','plan_subscribe_commission')->max('level');
        $plans = Plan::get();
        return view('admin.plan',compact('pageTitle','levels','plans'));
    }

    public function savePlan(Request $request)
    {

        $request->validate([
            'name' => 'required|max:255',
            'tagline' => 'required|max:255',
            'min_price' => 'required|numeric|min:1',
            'max_price' => 'required|numeric|gte:min_price',
            'monthly_profit' => 'required|numeric|min:0',
            'max_earning' => 'required|numeric|min:0',
            'ref_level' => 'required|numeric|min:0',
        ]);

        // dd($request->all());

        if($request->id == 0){
            $plan = new Plan();
        }else{
            $plan = Plan::findOrFail($request->id);
        }
        $plan->name = $request->name;
        $plan->tagline = $request->tagline;
        $plan->min_price = $request->min_price;
        $plan->max_price = $request->max_price;
        $plan->max_earning = $request->max_earning;
        $plan->monthly_profit = $request->monthly_profit;
        // $plan->daily_limit = $request->daily_limit;
        $plan->ref_level = $request->ref_level;
        $plan->validity = $request->validity;
        $plan->highlight = isset($request->highlight) ? Status::YES : Status::NO;
        $plan->save();

        $notify[] = ['success', 'Plan has been Updated Successfully.'];
        return back()->withNotify($notify);
    }

    public function status(Request $request){

        return Plan::changeStatus($request->id);
    }

}
