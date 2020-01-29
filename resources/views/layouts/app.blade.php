<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- Head -->
    @include('includes.head')

    <!-- Body -->
    <body>
        <div id="app">
            <!-- Page Nav -->
            @include('includes.nav')

            <main class="py-4">
                @yield('content')
            </main>
        </div>
    </body>
</html>
