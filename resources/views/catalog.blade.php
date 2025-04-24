@php
    $layout = match(true) {
        auth()->guard('admin')->check() => 'admin-layout',
        auth()->check() => 'user-layout',
        default => 'guest-layout'
    };
@endphp

<x-dynamic-component :component="$layout">
    @auth()
        <!-- Контент для авторизованных -->
        @if(auth()->user()->subscribed())
            <x-catalog.premium-content/>
        @else
            <x-catalog.guest-content/>
        @endif
    @else
        <!-- Контент для гостей -->
        <x-catalog.guest-content/>
    @endauth
</x-dynamic-component>




