@extends($activeTemplate.'layouts.master')
@section('content')
<div class="custom--table-container table-responsive--md">
    <table class="table table custom--table">
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
                    {{ showAmount($view->total_earned) }} {{ $general->cur_text }}
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

<div class="d-flex justify-content-end mt-4">
    {{paginateLinks($viewads)}}
</div>

@endsection
