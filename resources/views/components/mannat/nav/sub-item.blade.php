@props(['href' => '#', 'action' => ''])

@php
    $action = Arr::wrap($action)
@endphp

@if ($action)
    @canany($action)
        <li class="{{ request()->url() == $href ? 'mm-active' : '' }}"><a class="{{ request()->url() == $href ? 'active' : '' }}" href="{{ $href }}">{{ $slot }}</a></li>
    @endcanany
@else
    <li class="{{ request()->url() == $href ? 'mm-active' : '' }}"><a class="{{ request()->url() == $href ? 'active' : '' }}" href="{{ $href }}">{{ $slot }}</a></li>
@endif
