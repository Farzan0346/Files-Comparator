@props(['logo' => asset('images/logo.png') ])
{{-- <img src="{{ $logo }}" alt="logo" {!! $attributes->merge(['class' => 'shadow-light object-fit-contain']) !!} width="150px"> --}}

<div class="text-center mt-4">
    <div class="mb-3">
        <a href="#" class="auth-logo">
            <img src="assets/images/logo-dark.png" height="30" class="logo-dark mx-auto" alt="">
            <img src="assets/images/logo-light.png" height="30" class="logo-light mx-auto" alt="">
        </a>
    </div>
</div>
