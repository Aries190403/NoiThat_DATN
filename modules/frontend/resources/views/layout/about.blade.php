@extends('frontend::main')
@section('content')
<!-- ========================  Main header ======================== -->

<section class="main-header main-header-blog" style="background-image:url({{ asset('frontend/assets/images/gallery-1.jpg')}}">
    <header>
        <div class="container text-center">
            <h2 class="h2 title">Our story</h2>
            <p class="subtitle">A bit of history</p>
        </div>
    </header>
</section>

<!-- ================== Intro section default ================== -->

<section class="our-team">
    <div class="container">

        <!-- === Our team header === -->

        <div class="row">
            <div class="col-md-offset-2 col-md-8 text-center">
                <h1 class="h2 title">Meet our team</h1>
                <div class="text">
                    <p>Our architects and designers constantly and carefully monitor the environment, they accept and develop changes, research fashion and architectural, as well as sociological, changes and transform them into unique design.</p>
                </div>
            </div>
        </div>

        <!-- === Our team === -->

        <div class="team">

            <div class="row">

                <!-- === team member === -->

                <div class="col-sm-3">
                    <article>
                        <div class="details details-text">
                            <div class="inner">
                                <h3 class="title">Lea Nils</h3>
                                <h6 class="title">Director</h6>
                            </div>
                        </div>
                        <div class="image">
                            <img src="{{ asset('frontend/assets/images/user-5.jpg')}}" alt="" />
                        </div>
                        <div class="details details-social">
                            <div class="inner">
                                <a href="#"><i class="fa fa-phone"></i></a>
                                <a href="#"><i class="fa fa-envelope"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- === team member === -->

                <div class="col-sm-3">
                    <article>
                        <div class="details details-text">
                            <div class="inner">
                                <h3 class="title">Nora Star</h3>
                                <h6 class="title">Architect</h6>
                            </div>
                        </div>
                        <div class="image">
                            <img src="{{ asset('frontend/assets/images/user-4.jpg')}}" alt="" />
                        </div>
                        <div class="details details-social">
                            <div class="inner">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- === team member === -->

                <div class="col-sm-3">
                    <article>
                        <div class="details details-text">
                            <div class="inner">
                                <h3 class="title">Jenna Hale</h3>
                                <h6 class="title">Quality director</h6>
                            </div>
                        </div>
                        <div class="image">
                            <img src="{{ asset('frontend/assets/images/user-3.jpg')}}" alt="" />
                        </div>
                        <div class="details details-social">
                            <div class="inner">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </article>
                </div>

                <!-- === team member === -->

                <div class="col-sm-3">
                    <article>
                        <div class="details details-text">
                            <div class="inner">
                                <h3 class="title">Glen Jordan</h3>
                                <h6 class="title">Supervisor</h6>
                            </div>
                        </div>
                        <div class="image">
                            <img src="{{ asset('frontend/assets/images/user-4.jpg')}}" alt="" />
                        </div>
                        <div class="details details-social">
                            <div class="inner">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </article>
                </div>

            </div> <!--/row-->
            <!-- === button more === -->

            <div class="wrapper-more">
                <a href="/contact" class="btn btn-clean-dark">Contact us</a>
            </div>
        </div> <!--/team-->
    </div>
</section>
<!-- ========================  History ======================== -->

<section class="history">
    <div class="container">

        <!-- === History header === -->

        <header>
            <div class="row">
                <div class="col-md-offset-2 col-md-8 text-center">
                    <h1 class="h2 title">A bit of history</h1>
                    <div class="text">
                        <p>Our architects and designers constantly and carefully monitor the environment, they accept and develop changes, research fashion and architectural, as well as sociological, changes and transform them into unique design.</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- === row item === -->

        <div class="row row-block">
            <div class="col-md-5 history-image" style="background-image:url({{ asset('frontend/assets/images/blog-3.jpg')}}">
                <div class="history-title">
                    <h2 class="title">1930</h2>
                    <p>The begining</p>
                </div>
            </div>
            <div class="col-md-7 history-desc">
                <div class="h5 title">This is how it's began</div>
                <p>
                    Bust master shore what the sainted store tell stood sitting word thy
                    unbrokenquit tossed more beguiling to rare stood take.
                    Sent that maiden entrance door the and i to if me entrance the startled
                    yore the sainted velvet raven still bird cushioned more then quoth and just a lenore back
                </p>
                <p>
                    Leave till the and let nameless lenore the followed or shorn wide mystery quoth agreeing
                    the lore myself soul its nevermore lenore mortals this the still plainly thereat on thinking
                    the door above a have of hesitating longer i and that as mefilled now lord marvelled me i of be.
                </p>
            </div>
        </div>

        <!-- === row item === -->
        <div class="row row-block">
            <div class="col-md-5 history-image" style="background-image:url({{ asset('frontend/assets/images/blog-4.jpg')}}">
                <div class="history-title">
                    <h2 class="title">1935</h2>
                    <p>Firs 5 years</p>
                </div>
            </div>
            <div class="col-md-7 history-desc">
                <div class="h5 title">Love at the first sight</div>
                <p>
                    Bust master shore what the sainted store tell stood sitting word thy
                    unbrokenquit tossed more beguiling to rare stood take.
                    Sent that maiden entrance door the and i to if me entrance the startled
                    yore the sainted velvet raven still bird cushioned more then quoth and just a lenore back
                </p>
            </div>
        </div>

        <!-- === row item === -->
        <div class="row row-block">
            <div class="col-md-5 history-image" style="background-image:url({{ asset('frontend/assets/images/blog-5.jpg')}}">
                <div class="history-title">
                    <h2 class="title">1940</h2>
                    <p>Furniture color palette</p>
                </div>
            </div>
            <div class="col-md-7 history-desc">
                <div class="h5 title">There are designers out there</div>
                <p>
                    Bust master shore what the sainted store tell stood sitting word thy
                    unbrokenquit tossed more beguiling to rare stood take.
                    Sent that maiden entrance door the and i to if me entrance the startled
                    yore the sainted velvet raven still bird cushioned more then quoth and just a lenore back
                </p>
                <p>
                    Leave till the and let nameless lenore the followed or shorn wide mystery quoth agreeing
                    the lore myself soul its nevermore lenore mortals this the still plainly thereat on thinking
                    the door above a have of hesitating longer i and that as mefilled now lord marvelled me i of be.
                </p>
            </div>
        </div>

        <!-- === row item === -->
        <div class="row row-block">
            <div class="col-md-5 history-image" style="background-image:url({{ asset('frontend/assets/images/blog-6.jpg')}}">
                <div class="history-title">
                    <h2 class="title">1950</h2>
                    <p>Employer of the year</p>
                </div>
            </div>
            <div class="col-md-7 history-desc">
                <div class="h5 title">We love our employees</div>
                <p>
                    Bust master shore what the sainted store tell stood sitting word thy
                    unbrokenquit tossed more beguiling to rare stood take.
                    Sent that maiden entrance door the and i to if me entrance the startled
                    yore the sainted velvet raven still bird cushioned more then quoth and just a lenore back
                </p>
                <p>
                    Leave till the and let nameless lenore the followed or shorn wide mystery quoth agreeing
                    the lore myself soul its nevermore lenore mortals this the still plainly thereat on thinking
                    the door above a have of hesitating longer i and that as mefilled now lord marvelled me i of be.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection