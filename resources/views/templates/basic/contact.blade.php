@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$infos = getContent('contact.element');
$contact = getContent('contact.content',true);
@endphp
<section class="pt-150 pb-150">
    <div class="container">
      <div class="row mb-none-40">
        @foreach($infos as $info)
        <div class="col-lg-4 col-md-6 mb-40">
          <div class="contact-item">
            <div class="icon">
              @php echo $info->data_values->icon @endphp
            </div>
            <div class="content">
              <h3 class="title">{{ __($info->data_values->title) }}</h3>
              <p>{{ __($info->data_values->content) }}</p>
            </div>
          </div><!-- contact-item end -->
        </div>
        @endforeach
      </div>
      <div class="row justify-content-center mt-100">
        <div class="col-lg-12">
          <div class="contact-form-wrapper pl-5">

            
            <form action="" class="contact-form verify-gcaptcha mt-50" id="contact_form_submit" method="post">
              @csrf

                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
@endsection
