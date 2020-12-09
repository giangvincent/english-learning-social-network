<html lang="vi">

<head>
    @include('layout.header_meta')
    @include('layout.header_css')
    @yield('header_extend')
</head>

<body class="bg-gray-100 text-sm">

    @yield('body')

    @include('layout.footerJs')
    @yield('footer_extend')
</body>

</html>