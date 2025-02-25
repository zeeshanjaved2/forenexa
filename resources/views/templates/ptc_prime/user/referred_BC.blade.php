@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="table-responsive">
        <table class="table--responsive--lg table">
            <thead>
                <tr>
                    <th>@lang('Full Name')</th>
                    <th>@lang('User Name')</th>
                    <th>@lang('Email')</th>
                    <th>@lang('Mobile')</th>
                    <th>@lang('Plan')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($refUsers as $log)
                    <tr>
                        <td>{{ __($log->fullname) }}</td>
                        <td>{{ __($log->username) }}</td>
                        <td>{{ $log->email }}</td>
                        <td>{{ $log->mobile }}</td>
                        <td>{{ __($log->plan ? $log->plan->name : 'No Plan') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="100%"> {{ __($emptyMessage) }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ paginateLinks($refUsers) }}
    </div>
@endsection
