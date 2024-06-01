<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend::elements.head')
</head>
<body> <!--class="animsition" -->

    <!-- Header -->
    @include('backend::elements.header')

    @include('backend::elements.sidebar')

    @yield('content')

    <!-- footer -->
    @include('backend::elements.footer')

    @yield('script')
</body>
</html>