@extends('frontend::main')
@section('content')
<!-- ========================  Main header ======================== -->

<section class="main-header" style="background-image:url({{ asset('frontend/assets/images/gallery-2.jpg)')}}">
    <header>
        <div class="container">
            <h1 class="h2 title">Blog</h1>
            <ol class="breadcrumb breadcrumb-inverted">
                <li><a href="index.html"><span class="icon icon-home"></span></a></li>
                <li><a href="blog-1.html">Blog</a></li>
                <li><a class="active" href="blog-1.html">Popular stories</a></li>
            </ol>
        </div>
    </header>
</section>
<!-- ========================  Blog ======================== -->

<section class="blog">

    <div class="container">

        <div class="pre-header">
            <div>
                <h2 class="h3 title">
                    Papular stories
                </h2>
            </div>
            <div>
                <div class="sort-bar pull-right">
                    <div class="sort-results">
                        <!--Items counter-->
                        <span>Showing all <strong>50</strong> of <strong>3,250</strong> items</span>
                        <!--Showing result per page-->
                        <select>
                            <option value="1">10</option>
                            <option value="2">50</option>
                            <option value="3">100</option>
                            <option value="4">All</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-1.jpg)')}}">
                            <img src="assets/images/blog-1.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">The 3 Tricks that Quickly Became Rules</h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-2.jpg)')}}">
                            <img src="assets/images/blog-2.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">Decorating When You're Starting Out or Starting Over</h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-3.jpg)')}}">
                            <img src="assets/images/blog-3.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">What does your favorite dining chair say about you?</h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-4.jpg)')}}">
                            <img src="assets/images/blog-4.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">Have a look at our new projects!</h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-5.jpg)')}}">
                            <img src="assets/images/blog-5.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">Extending Your Living Area</h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-6.jpg)')}}">
                            <img src="assets/images/blog-6.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">Falling into the new Season </h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-7.jpg)')}}">
                            <img src="assets/images/blog-7.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">Creating the Perfect Gallery Wall </h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-8.jpg)')}}">
                            <img src="assets/images/blog-8.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">Making the Most Out of Your Kids Old Bedroom</h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

            <!-- === blog-item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image" style="background-image:url({{ asset('frontend/assets/images/blog-9.jpg)')}}">
                            <img src="assets/images/blog-9.jpg" alt="" />
                        </div>
                        <div class="entry entry-table">
                            <div class="date-wrapper">
                                <div class="date">
                                    <span>MAR</span>
                                    <strong>05</strong>
                                    <span>2017</span>
                                </div>
                            </div>
                            <div class="title">
                                <h2 class="h5">4 Products to Warm Up Your Winter</h2>
                            </div>
                        </div>
                    </a>
                </article>
            </div>

        </div> <!--/row-->
        <!-- === pagination === -->

        <div class="pagination-wrapper">
            <ul class="pagination">
                <li>
                    <a href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="active"><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li>
                    <a href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div> <!--/pagination-->

    </div><!--/container-->
</section>
@endsection