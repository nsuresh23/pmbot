@push('css')
<style>
/* .wrapper {
    background: none;
}
.page-wrapper {
    background: none;
}
.page-wrapper.auth-page {
    background: none;
}
.auth-form div {
    background: #fff;
}
.wrapper.box-layout {
    max-width: 1024px;
} */
</style>
@endpush


<div class="sp-logo-wrap text-center pa-0 mb-30">
    <a href="login">
        {{-- <img class="brand-img mr-10" src="../img/logo.png" alt="brand" /> --}}
        <img class="brand-img mr-10" src="{{ asset('public/img/logo.png') }}" alt="brand" />
        <span class="brand-text">{{ __('general.appTitle') }}</span>
    </a>
</div>
