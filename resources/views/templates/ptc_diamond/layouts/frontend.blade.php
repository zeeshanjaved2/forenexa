@extends($activeTemplate.'layouts.app')
@section('panel')
        @include($activeTemplate.'partials.header')
        @if(!request()->routeIs('home') && !request()->routeIs('user.login') && !request()->routeIs('user.register'))
            @include($activeTemplate.'partials.breadcrumb')
        @endif
        @yield('content')
@endsection
