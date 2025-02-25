@extends($activeTemplate.'layouts.frontend')

@section('content')
@php
    $banner = getContent('banner.content', true);
@endphp
<!-- Hero  -->
<section class="hero" style="background-image: url({{ getImage('assets/images/frontend/banner/'.$banner->data_values->background_image, '1920x1280') }}), linear-gradient(45deg, hsl(var(--accent-dark)), hsl(var(--accent)));">
    <div class="hero__content">
        <div class="container">
            <div class="row g-3 align-items-center">
                <div class="col-lg-7 col-xl-6 col-xxl-5 text-center text-lg-start">
                    <h1 class="hero__content-title section__title text-capitalize text--white" data-img-src="{{ asset($activeTemplateTrue . 'images/title-bg.svg') }}" s-break="-2">{{ __($banner->data_values->heading) }}
                    </h1>
                    <p class="hero__content-para text--white mx-auto ms-lg-0">
                        {{ __($banner->data_values->subheading) }}
                    </p>

                    <div class="hero__btn-group justify-content-center justify-content-lg-start mt-4">
                        <a href="{{ __($banner->data_values->button_link) }}" class="btn btn--xl btn--base rounded-pill">
                            {{ __($banner->data_values->button_name) }}
                        </a>
                        <a href="{{ __($banner->data_values->video_link) }}" class="btn btn--light btn--circle show-video">
                            <i class="fas fa-play"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-5 col-xl-6 col-xxl-7">
                    <img src="{{ getImage('assets/images/frontend/banner/'.$banner->data_values->image, '1080x800') }}" alt="image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero End -->

    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
    
@endsection