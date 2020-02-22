<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('tools._head')
    <title>@yield('title','title')</title>
</head>
<body>
<div id="app" class="container v-cloak">
    <header class="row">
        @include('tools._header')
    </header>
    <div id="main" class="row">
        @yield('content')
    </div>
    <footer class="row">
        @include('tools._footer')
    </footer>
</div>
</body>
</html>
