@include('layouts.fraction.head')

<body>
    <div id="app">
        @include('components.theme')
        @include('layouts.fraction.navbar')
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
    @yield('footScript')
</body>

</html>
