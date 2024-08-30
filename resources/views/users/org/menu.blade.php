<x-mannat.nav.item wire:navigate href="{{ route('org.dashboard') }}" iconClass="iconoir-home-simple menu-icon">
    <span>Dashboard</span> </x-mannat.nav.item>
{{-- <x-mannat.nav.item wire:navigate href="{{ route('org.omparator.index') }}" iconClass="iconoir-home-simple menu-icon">
    <span>omparator File</span> </x-mannat.nav.item>v --}}


{{-- <x-mannat.nav.parent-item iconClass="iconoir-view-grid menu-icon" :hrefs="['user.*', 'organization.user.*']" label="User Management">
    <x-mannat.nav.item action="user:create" wire:navigate href="{{ route('org.role.index') }}"> <span>Role</span>
    </x-mannat.nav.item>
    <x-mannat.nav.item action="user:index" wire:navigate href="{{ route('org.user.index') }}"> <span>User List</span>
    </x-mannat.nav.item>
    <x-mannat.nav.item action="user:create" wire:navigate href="{{ route('org.user.create') }}"> <span>User Create</span>
    </x-mannat.nav.item>

</x-mannat.nav.parent-item> --}}
