<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend::elements.head')
    <style>
        .jq-toast-wrap {
            z-index: 9999 !important;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        @include('frontend::elements.header')

        @yield('content')

        @include('frontend::elements.footer')
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    @if(Session::has('ok'))
    <script>
        $(document).ready(function() {
            $.toast({
                heading: 'Notification !',
                text: "{{ Session::get('ok') }}",
                showHideTransition: 'slide', // It can be plain, fade or slide
                icon: 'success',
                hideAfter: 4000, // `false` to make it sticky or time in milliseconds to hide after
                position: 'top-center',
                loaderBg: '#00ff00', // Background color of the toast loader
                bgColor: '#0000ff', // Background color of the toast
                textColor: 'white', // Text color
                afterShown: function() {
                    // Set z-index to ensure the toast appears on top
                    $('.jq-toast-wrap').css('z-index', 9999);
                }
            });
        });
    </script>
    @endif
    @if(Session::has('no'))
    <script>
        $(document).ready(function() {
            $.toast({
                heading: 'Notification !',
                text: "{{ Session::get('no') }}",
                showHideTransition: 'slide', // It can be plain, fade or slide
                icon: 'error',
                hideAfter: 4000, // `false` to make it sticky or time in milliseconds to hide after
                position: 'top-center',
                stack: false, // Ensure that toasts stack properly
                loaderBg: '#ff6849', // Background color of the toast loader
                bgColor: '#ff0000', // Background color of the toast
                textColor: 'white', // Text color
            });
        });
        $document.addEventListener('click', function(event) {
            const target = event.target;
            // Kiểm tra nếu người dùng click ra ngoài cart-wrapper
            if (!cartWrapper.contains(target) && target !== toggleButton) {
                cartWrapper.classList.remove('open');
            }
        });
    </script>
    @endif
</body>

</html>