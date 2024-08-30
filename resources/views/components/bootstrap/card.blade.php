@props(['color' => 'primary'])
<div {!! $attributes->merge(['class' => "card card-$color"]) !!}>
    <div class="card-body">
        @if (isset($header))
            {{ $header }}
        @endif
        {{ $slot }}
    </div>
</div>
