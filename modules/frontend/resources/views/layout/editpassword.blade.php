@extends('frontend::main')
@section('content')
    <section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Customer page</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="#">Edit password</a></li>
                </ol>
            </div>
        </header>
    </section>
    <section class="login-wrapper login-wrapper-page">
        <div class="container">

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

                                <div class="h4">Edit pasword</div>

                                <hr />

                                <div class="row">
                                    <form action="/editpassword" method="post">
                                        @csrf
                                        <div class="col-md-12">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li style="color: red;">{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                <script>
                                                    $(document).ready(function() {
                                                        setTimeout(function() {
                                                            $('.alert-danger').fadeOut();
                                                        }, 4000);
                                                    });
                                                </script> --}}
                                            @endif
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="old_password"
                                                    name="old_password" placeholder="Enter old password: *" required />

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Enter new password: *" required />

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password_confirmation"
                                                    placeholder="Confirm password: *" required>

                                            </div>
                                        </div>

                                        <div class="col-xs-6 text-right">
                                            <button type="submit" class="btn btn-block btn-main">Update pasword</button>
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
@endsection
