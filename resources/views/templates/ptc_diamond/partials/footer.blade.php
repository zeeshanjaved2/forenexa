@php
	$content = getContent('footer.content', true);
	$socialIcons = getContent('social_icon.element', false, false, true);
	$links = getContent('policy_pages.element', false);
	$infos = getContent('contact.element');
@endphp
<!-- Footer  -->
<div class="section--sm pb-0">
	<footer class="footer">
		<div class="section">
			<div class="container">
				<div class="row g-4 justify-content-xl-between">
					<div class="col-md-10 col-xl-4">
						<h4 class="mt-0 footer__title">{{ __($content->data_values->heading) }}</h4>
						<p class="footer__description text--white">
							{{ __($content->data_values->description) }}
						</p>
						<ul class="list list--row social-list">
							@foreach($socialIcons as $social)
								<li>
									<a href="{{ __($social->data_values->url) }}" target="_blank" class="t-link social-list__icon" title="{{ __($social->data_values->title) }}">
										@php
											echo $social->data_values->icon
										@endphp
									</a>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="col-md-4 col-xl-3">
						<h4 class="mt-0 footer__title">@lang('Quick Link')</h4>
						<ul class="list list--column" style="--gap: .5rem;">
							@php
                            	$pages = App\Models\Page::where('tempname',$activeTemplate)->where('is_default', Status::NO)->get();
							@endphp
							@foreach($pages as $page)
                                <li>
                                    <a href="{{ route('pages',$page->slug) }}" class="t-link t-link--base text--white d-inline-block sm-text">{{ __($page->name) }}</a>
                                </li>
							@endforeach
							<li>
								<a href="{{ route('plans') }}" class="t-link t-link--base text--white d-inline-block sm-text">@lang('Plans')</a>
							</li>
							<li>
								<a href="{{ route('blog') }}" class="t-link t-link--base text--white d-inline-block sm-text">@lang('Blog')</a>
							</li>
							<li class="nav-item">
								<a href="{{ route('contact') }}" class="t-link t-link--base text--white d-inline-block sm-text">@lang('Contact')</a>
							</li>
						</ul>
					</div>
					<div class="col-md-4 col-xl-3">
						<h4 class="mt-0 footer__title">@lang('Privacy And Terms')</h4>
						<ul class="list list--column" style="--gap: .5rem;">
							@foreach($links as $link)
								<li>
									<a class="t-link t-link--base text--white d-inline-block sm-text" href="{{ route('policy.pages',[slug($link->data_values->title),$link->id]) }}">{{ __($link->data_values->title) }}</a>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="col-md-4 col-xl-2">
						<h4 class="mt-0 footer__title">@lang('Contact Info')</h4>
						<ul class="list list--column" style="--gap: .5rem;">
							@foreach($infos as $info)
								<li class="t-link t-link--base text--white d-inline-block sm-text">
									<span class="me-2">@php echo $info->data_values->icon @endphp</span>{{ __($info->data_values->content) }}
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer__copyright py-3">
			<p class="mb-0 sm-text text--white text-center">
				&copy; {{ date('Y') }}. @lang('All Rights Reserved By')
				<a href="{{ route('home') }}" class="t-link t-link--base text--base">{{ __($general->site_name) }}</a>
			</p>
		</div>
	</footer>
</div>
<!-- Footer End -->
