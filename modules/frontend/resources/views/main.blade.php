<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend::elements.head')
</head>
<body>
    <div class="wrapper">
        @include('frontend::elements.header')

        @yield('content')

        @include('frontend::elements.footer')
    </div>
</body>
</html>