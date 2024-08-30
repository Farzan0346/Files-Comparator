@props(['method' => ''])
<form wire:submit.prevent="{{ $method }}" {{ $attributes }}>
    @csrf
    {{ $slot }}
</form>
