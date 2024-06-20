@extends('frontend::main')
@section('content')
<section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
    <header>
        <div class="container text-center">
            <h2 class="h2 title">Customer page</h2>
            <ol class="breadcrumb breadcrumb-inverted">
                <li><a href="/"><span class="icon icon-home"></span></a></li>
                <li><a class="active" href="/register">Register</a></li>
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


                        <!--signup-->

                        <div class="login-block login-block-signup">

                            <div class="h4">Register now <a href="/login" class="btn btn-main btn-xs btn-login pull-right">Log in</a></div>

                            <hr />

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control" placeholder="First name: *">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control" placeholder="Last name: *">
                                    </div>
                                </div>

                                <div class="col-md-12">

                                    <div class="form-group">
                                        <input type="text" value="" class="form-control" placeholder="Company name:">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control" placeholder="Zip code: *">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control" placeholder="City: *">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control" placeholder="Email: *">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="" class="form-control" placeholder="Phone: *">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <hr />
                                    <span class="checkbox">
                                        <input type="checkbox" id="checkBoxId1">
                                        <label for="checkBoxId1">I have read and accepted the <a href="#">terms</a>, as well as read and understood our terms of <a href="#">business contidions</a></label>
                                    </span>
                                    <span class="checkbox">
                                        <input type="checkbox" id="checkBoxId2">
                                        <label for="checkBoxId2">Subscribe to exciting newsletters and great tips</label>
                                    </span>
                                    <hr />
                                </div>

                                <div class="col-md-12">
                                    <a href="#" class="btn btn-main btn-block">Create account</a>
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