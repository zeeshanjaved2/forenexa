@php
    $aboutCaption = getContent('about.content', true);
@endphp
<section class="ptb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 wow fadeInUp" data-wow-duration="0.3s" data-wow-delay="0.3s">
                <div class="video-thumb">
                    <img class="w-100" src="{{ getImage('assets/images/frontend/about/' . $aboutCaption->data_values->image) }}" alt="image">
                </div>
            </div>
            <div class="col-lg-6 mt-lg-0 wow fadeInUp mt-5" data-wow-duration="0.5s" data-wow-delay="0.7s">
                <div class="section-content pl-lg-4 pl-0">
                    
                    <p>@php echo $aboutCaption->data_values->description @endphp</p>
                </div>
            </div>
        </div>
    </div>
</section>
