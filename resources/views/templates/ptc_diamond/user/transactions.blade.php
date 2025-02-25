@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="show-filter mb-3 text-end">
    <button type="button" class="btn btn--base showFilterBtn btn-sm"><i class="las la-filter"></i> @lang('Filter')</button>
</div>
<div class="card responsive-filter-card mb-4">
    <div class="card-body">
        <form action="">
            <div class="d-flex flex-wrap gap-4">
                <div class="flex-grow-1">
                    <label class="form-label">@lang('Transaction Number')</label>
                    <input type="text" name="search" value="{{ request()->search }}" class="form-control form--control">
                </div>
                <div class="flex-grow-1">
                    <label class="form-label">@lang('Type')</label>
                    <div class="form--select">
                        <select name="trx_type" class="form-select">
                            <option value="">@lang('All')</option>
                            <option value="+" @selected(request()->trx_type == '+')>@lang('Plus')</option>
                            <option value="-" @selected(request()->trx_type == '-')>@lang('Minus')</option>
                        </select>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <label class="form-label">@lang('Remark')</label>
                    <div class="form--select">
                        <select class="form-select" name="remark">
                            <option value="">@lang('Any')</option>
                            @foreach ($remarks as $remark)
                                <option value="{{ $remark->remark }}" @selected(request()->remark == $remark->remark)>{{ __(keyToTitle($remark->remark)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex-grow-1 align-self-end">
                    <button class="btn btn--base btn--lg w-100"><i class="las la-filter"></i> @lang('Filter')</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="custom--table-container table-responsive--md">
    <table class="table custom--table">
        <thead>
            <tr>
                <th>@lang('Trx')</th>
                <th>@lang('Transacted')</th>
                <th>@lang('Amount')</th>
                <th>@lang('Post Balance')</th>
                <th>@lang('Detail')</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
                <tr>
                    <td>
                        <strong>{{ $trx->trx }}</strong>
                    </td>

                    <td>
                        {{ showDateTime($trx->created_at) }}<br>{{ diffForHumans($trx->created_at) }}
                    </td>

                    <td class="budget">
                        <span class="fw-bold @if ($trx->trx_type == '+') text--success @else text--danger @endif">
                            {{ $trx->trx_type }} {{ showAmount($trx->amount) }} {{ $general->cur_text }}
                        </span>
                    </td>

                    <td class="budget">
                        {{ showAmount($trx->post_balance) }} {{ __($general->cur_text) }}
                    </td>


                    <td>{{ __($trx->details) }}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-end mt-4">
    {{ $transactions->links() }}
</div>
@endsection
