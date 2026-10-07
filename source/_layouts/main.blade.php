<!DOCTYPE html>
<html lang="{{ $page->language ?? 'zh-Hant' }}">
<head>
    @include('_components.head')
    @stack('head')
</head>
<body class="bg-white text-main1 font-sans antialiased selection:bg-main1 selection:text-white flex flex-col min-h-screen overflow-x-hidden">
    @include('_components.nav')

    <div class="flex-grow">
        @yield('body')
    </div>

    @include('_components.footer')

    @stack('scripts')
</body>
</html>
