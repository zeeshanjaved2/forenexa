@extends($activeTemplate.'layouts.frontend')
@section('content')
<section class="cmn-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @php
                    echo $cookie->data_values->description
                @endphp
            </div>
        </div>
    </div>
</section>
@endsection