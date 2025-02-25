@extends($activeTemplate .'layouts.frontend')
@section('content')
<section class="py-120">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow border-0 p-5">
                    <div class="card-body">
                        <h3 class="text-center text-danger mb-0">@lang('YOU ARE BANNED')</h3>
                        <hr>
                        <p class="fw-bold mb-1">@lang('Reason'):</p>
                        <p>{{ $user->ban_reason }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
