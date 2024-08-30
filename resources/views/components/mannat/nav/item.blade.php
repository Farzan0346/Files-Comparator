@props(['href' => '#', 'iconClass' => '', 'action' => ''])
@php
    $action = $action ? Arr::wrap($action) : '';
@endphp

@if ($action)
    @canany($action)
        <li class="nav-item {{ request()->url() == $href ? 'mm-active' : '' }}">
            <a class="nav-link {{ request()->url() == $href ? 'active' : '' }}" {{ $attributes }} href="{{ $href }}">
                <i class="{{ $iconClass }}"></i>
                <span>{{ $slot }}</span>
            </a>
        </li>
    @endcanany
@else
    <li class="nav-item {{ request()->url() == $href ? 'mm-active' : '' }}">
        <a class="nav-link {{ request()->url() == $href ? 'active' : '' }}" {{ $attributes }} href="{{ $href }}">
            <i class="{{ $iconClass }}"></i>
            <span>{{ $slot }}</span>
        </a>
    </li>
@endif
