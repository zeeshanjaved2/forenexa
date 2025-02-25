@extends($activeTemplate.'layouts.master')
@section('content')
<div class="table-responsive">
    <table class="table--responsive--lg table">
        <thead>
          <tr>
              <th scope="col">@lang('Date')</th>
              <th scope="col">@lang('Total Click')</th>
              <th scope="col">@lang('Total Earn')</th>
          </tr>
      </thead>
        <tbody>
           @forelse($viewads as $view)
           <tr>
                <td class=""> {{ showDateTime($view->date, 'd M, Y') }} </td>
                <td>{{ $view->total_clicks }}</td>
                <td>
                    {{ showAmount($view->total_earned) }}{{ __($general->cur_text) }}
                </td>
            </tr>
          @empty
              <tr>
                  <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
              </tr>
          @endforelse
      </tbody>
  </table>
</div>

{{paginateLinks($viewads)}}

@endsection
