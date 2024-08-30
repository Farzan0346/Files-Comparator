@props(['hrefs' => [], 'iconClass' => '', 'label'])


@php

    $expandClass = '';
    $active = false;

    foreach ($hrefs as $href) {
        if (request()->routeIs($href)) {
            $expandClass = 'mm-active';
            $active = true;
            break;
        }
    }

@endphp

@if ($slot->isNotEmpty())
    <li class="{{ $expandClass }} nav-item">
        <a class="nav-link {{ $active ? 'mm-active' : '' }}" href="#sidebarDashboards" data-bs-toggle="collapse"
            role="button" aria-expanded="false" aria-controls="sidebarDashboards" aria-expanded="{{ $active }}">
            <i class="{{ $iconClass }}"></i>
            <span>{{ $label }}</span>

            {{-- <i class="angle fa fa-angle-right"></i> --}}
        </a>
        <div id="sidebarDashboards"class="collapse{{ $active ? 'mm-show' : '' }}">
            {{-- <li class=""><a href="#">{{ $label }}</a></li> --}}
            <ul class="nav flex-column">
                {{ $slot }}
            </ul>
        </div>
    </li>
@endif
