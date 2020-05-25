<header class="sp-header">
    <div class=" nav-header sp-logo-wrap pull-left">
        <a href="{{ route('home') }}">
            <img class="brand-img mr-10" src="{{ asset('public/img/logo.png') }}" alt="{{ __('general.appTitle') }}" />
            <span class="brand-text">{{ __('general.appTitle') }}</span>
        </a>
    </div>
    <div class="form-group mb-0 pull-right">
        <a class="inline-block btn btn-primary btn-rounded btn-outline nonecase-font" href="{{ route('home') }}">
            {{ __('general.back_to_home_label') }}
        </a>
    </div>
    <div class="clearfix"></div>
</header>