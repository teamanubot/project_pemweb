<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('components.partials.head')

<body>

<!-- navigation -->
@hasSection('nav')
    @yield('nav')
@else
    @include('components.partials.nav') {{-- Navbar default --}}
@endif
<!-- /navigation -->

{{ $slot }}

@include('components.partials.footer')
@include('components.partials.script')
</body>
</html>