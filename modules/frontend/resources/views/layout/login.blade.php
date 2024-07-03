@extends('frontend::main')
@section('content')
    <section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Customer page</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="/login">Login</a></li>
                </ol>
            </div>
        </header>
    </section>

    <!-- ========================  Login & register ======================== -->

    <section class="login-wrapper login-wrapper-page">
        <div class="container">

            <header class="hidden">
                <h3 class="h3 title">Sign in</h3>
            </header>

            <div class="row">

                <!-- === left content === -->

                <div class="col-md-6 col-md-offset-3">

                    <!-- === login-wrapper === -->

                    <div class="login-wrapper">

                        <div class="white-block">

                            <!--signin-->

                            <div class="login-block login-block-signin">
                            </div> <!--/signin-->
                            <!--signup-->

                            <div class="login-block login-block-signup">

                                <div class="h4">Sign in <a href="/register"
                                        class="btn btn-main btn-xs btn-register pull-right">create an account</a></div>

                                <hr />

                                <div class="row">
                                    <form action="/login" method="post">
                                        @csrf
                                        <div class="col-md-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <span style="color: red;">{{ $error }}</span>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                <script>
                                                    $(document).ready(function() {
                                                        setTimeout(function() {
                                                            $('.alert-danger').fadeOut();
                                                        }, 4000);
                                                    });
                                                </script>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="email" value="" name="email" class="form-control"
                                                    placeholder="Email" required="">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="password" value="" name="password" class="form-control"
                                                    placeholder="Password" required="">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            {{-- <span class="checkbox">
                                                 <input type="checkbox" id="checkBoxId3">
                                            <label for="checkBoxId3">Remember me</label>
                                        </span> --}}
                                            {{-- <a class="text-right" href="/forgotpassword">Forgot password ?</a> --}}
                                        </div>

                                        <div class="col-xs-6 text-right">
                                            <button type="submit" class="btn btn-block btn-main">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!--/signup-->
                    </div>
                </div> <!--/login-wrapper-->
            </div> <!--/col-md-6-->

        </div>

        </div>
    </section>
    <script>
        $(document).ready(function() {
            $.toast({
                heading: 'Notification !',
                text: "Login to continue",
                showHideTransition: 'slide', // It can be plain, fade or slide
                icon: 'success',
                hideAfter: 4000, // `false` to make it sticky or time in milliseconds to hide after
                position: 'top-center',
                loaderBg: 'black', // Background color of the toast loader
                bgColor: '#ffc933', // Background color of the toast
                textColor: 'white', // Text color
                afterShown: function() {
                    // Set z-index to ensure the toast appears on top
                    $('.jq-toast-wrap').css('z-index', 9999);
                }
            });
        });
    </script>
@endsection
