        <!-- ======================== Navigation ======================== -->

        <nav class="navbar-fixed">

            <div class="container">

                <!-- ==========  Top navigation ========== -->

                <div class="navigation navigation-top clearfix">
                    <ul>
                        <!--add active class for current page-->

                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>

                        <!--Currency selector-->

                        <!-- <li class="nav-settings">
                            <a href="javascript:void(0);" class="nav-settings-value"> USD $</a>
                            <ul class="nav-settings-list">
                                <li>USD $</li>
                                <li>EUR €</li>
                                <li>CHF Fr.</li>
                                <li>GBP £</li>
                            </ul>
                        </li> -->

                        <!--Language selector-->

                        <!-- <li class="nav-settings">
                            <a href="javascript:void(0);" class="nav-settings-value"> ENG</a>
                            <ul class="nav-settings-list">
                                <li>ENG</li>
                                <li>GER</li>
                                <li>لعربية</li>
                                <li>עִבְרִית</li>
                            </ul>
                        </li> -->
                        <li><a href="javascript:void(0);" class="open-login">
                                @if(Auth::check())
                                <i>Hi, {{Auth::user()->name}} !</i>
                                @else
                                <i class="icon icon-user"></i>
                                @endif
                            </a></li>
                        <li><a href="javascript:void(0);" class="open-search"><i class="icon icon-magnifier"></i></a></li>
                        <li><a href="javascript:void(0);" class="open-cart"><i class="icon icon-cart"></i> <span>{{count((array)Session('cart'))}}</span></a></li>
                    </ul>
                </div> <!--/navigation-top-->

                <!-- ==========  Main navigation ========== -->

                <div class="navigation navigation-main">

                    <!-- Setup your logo here-->

                    <a href="/" class="logo"><img src="{{ asset('frontend/assets/images/logo.png')}}" alt="" /></a>

                    <!-- Mobile toggle menu -->

                    <a href="#" class="open-menu"><i class="icon icon-menu"></i></a>

                    <!-- Convertible menu (mobile/desktop)-->

                    <div class="floating-menu">

                        <!-- Mobile toggle menu trigger-->

                        <div class="close-menu-wrapper">
                            <span class="close-menu"><i class="icon icon-cross"></i></span>
                        </div>

                        <ul>
                            <li><a href="/">Home</a></li>

                            <!-- Single dropdown-->

                            <li>
                                <a href="/shop">Shop <span class="open-dropdown"></span></a>
                            </li>

                            <!-- Furniture icons in dropdown-->

                            <li>
                                <a href="category.html"> Product Category <span class="open-dropdown"><i class="fa fa-angle-down"></i></span></a>
                                <div class="navbar-dropdown">
                                    <div class="navbar-box">

                                        <!-- box-1 (left-side)-->

                                        <div class="box-1">
                                            <div class="image">
                                                <img src="{{ asset('frontend/assets/images/blog-2.jpg')}}" alt="Lorem ipsum" />
                                            </div>
                                            <div class="box">
                                                <div class="h2">Best ideas</div>
                                                <div class="clearfix">
                                                    <p>Homes that differ in terms of style, concept and architectural solutions have been furnished by Furniture Factory. These spaces tell of an international lifestyle that expresses modernity, research and a creative spirit.</p>
                                                    <a class="btn btn-clean btn-big" href="/shop">Explore</a>
                                                </div>
                                            </div>
                                        </div> <!--/box-1-->

                                        <!-- box-2 (right-side)-->

                                        <div class="box-2">
                                            <div class="clearfix categories">
                                                <div class="row">

                                                    <!--icon item-->

                                                    <!-- <div class="col-sm-3 col-xs-6">
                                                        <a href="javascript:void(0);">
                                                            <figure>
                                                                <i class="f-icon f-icon-sofa"></i>
                                                                <figcaption>Sofa</figcaption>
                                                            </figure>
                                                        </a>
                                                    </div> -->
                                                    @foreach($globalCategory as $c)
                                                    <div class="col-sm-3 col-xs-6">
                                                        <a href="/categorry/{{$c->id}}">
                                                            @php
                                                            $icon=json_decode($c->content, true);
                                                            @endphp
                                                            <figure>
                                                                <i class="f-icon {{$icon['icon']}}"></i>
                                                                <figcaption>{{$c->name}}</figcaption>
                                                            </figure>
                                                        </a>
                                                    </div>

                                                    @endforeach
                                                </div> <!--/row-->
                                            </div> <!--/categories-->
                                        </div> <!--/box-2-->
                                    </div> <!--/navbar-box-->
                                </div> <!--/navbar-dropdown-->
                            </li>

                            <li>
                                <a href="/">Pages <span class="open-dropdown"><i class="fa fa-angle-down"></i></span></a>
                                <div class="navbar-dropdown">
                                    <div class="navbar-box">

                                        <!-- box-1 (left-side)-->

                                        <div class="box-1">
                                            <div class="box">
                                                <div class="h2">Find your inspiration</div>
                                                <div class="clearfix">
                                                    <p>Homes that differ in terms of style, concept and architectural solutions have been furnished by Furniture Factory. These spaces tell of an international lifestyle that expresses modernity, research and a creative spirit.</p>
                                                    <a class="btn btn-clean btn-big" href="/shop">Shop now</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- box-2 (right-side)-->

                                        <div class="box-2">
                                            <div class="box clearfix">
                                                <div class="row">
                                                    <!-- <div class="col-md-4">
                                                        <ul>
                                                            <li class="label">Homepage</li>
                                                            <li><a href="index.html">Home - Slider</a></li>
                                                            <li><a href="index-2.html">Home - Tabsy gallery</a></li>
                                                            <li><a href="index-3.html">Home - Slider full screen</a></li>
                                                            <li><a href="index-4.html">Home - Info icons</a></li>
                                                            <li><a href="index-xmas.html">Home - Xmas</a></li>
                                                            <li><a href="index-rtl.html">Home - RTL <span class="label label-warning">New</span></a></li>
                                                            <li><a href="index-5.html">Onepage</a></li>
                                                            <li><a href="index-6.html">Onepage - Filters <span class="label label-warning">Isotope</span></a></li>
                                                        </ul>
                                                    </div> -->
                                                    <div class="col-md-6">
                                                        <ul>
                                                            <li class="label"><a href="/about">About us</a></li>
                                                            <!-- <li class="label">Blog</li> -->
                                                            <!-- <li><a href="blog-list.html">Blog list</a></li>
                                                            <li><a href="blog-grid-fullpage.html">Blog fullpage</a></li>
                                                            <li><a href="ideas.html">Blog ideas</a></li>
                                                            <li><a href="article.html">Blog article</a></li> -->
                                                        </ul>
                                                        <br>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <ul>
                                                            <li class="label"><a href="/blog">Blogs <span class="label label-warning">New</span></a></li>
                                                            <!-- <li class="label">Blog</li> -->
                                                            <!-- <li><a href="blog-list.html">Blog list</a></li>
                                                            <li><a href="blog-grid-fullpage.html">Blog fullpage</a></li>
                                                            <li><a href="ideas.html">Blog ideas</a></li>
                                                            <li><a href="article.html">Blog article</a></li> -->
                                                        </ul>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <ul>
                                                            <!-- <li class="label">Pages</li> -->
                                                            <li class="label"><a href="/contact">Contact us</a></li>
                                                            <!-- <li><a href="/login">Login & Register <span class="label label-warning">New</span></a> </li> -->
                                                        </ul>
                                                        <br>
                                                        <!-- <ul>
                                                            <li class="label">Extras</li>
                                                            <li><a href="shortcodes.html">Shortcodes</a></li>
                                                            <li><a href="email-receipt.html">Email template <span class="label label-warning">New</span></a></li>
                                                            <li><a href="404.html">Not found 404 <span class="label label-warning">New</span></a></li>
                                                        </ul> -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <ul>
                                                            <!-- <li class="label">Blog</li> -->
                                                            <li class="label"><a href="/login">Login & Register
                                                                    <!-- <span class="label label-warning">New</span> -->
                                                                </a> </li>
                                                            <!-- <li><a href="blog-list.html">Blog list</a></li>
                                                            <li><a href="blog-grid-fullpage.html">Blog fullpage</a></li>
                                                            <li><a href="ideas.html">Blog ideas</a></li>
                                                            <li><a href="article.html">Blog article</a></li> -->
                                                        </ul>
                                                    </div>
                                                </div> <!--/row-->
                                            </div> <!--/box-->
                                        </div> <!--/box-2-->
                                    </div> <!--/navbar-box-->
                                </div> <!--/navbar-dropdown-->
                            </li>

                            <!-- Mega menu dropdown -->
                            {{--
                            <li>
                                <a href="#">Megamenu <span class="open-dropdown"><i class="fa fa-angle-down"></i></span></a>
                                <div class="navbar-dropdown">
                                    <div class="navbar-box">
                                        <div class="box-2">
                                            <div class="box clearfix">
                                                <div class="row">
                                                    <div class="clearfix">
                                                        <div class="col-md-3">
                                                            <ul>
                                                                <li class="label">Seating</li>
                                                                <li><a href="javascript:void(0);">Benches</a></li>
                                                                <li><a href="javascript:void(0);">Submenu <span class="label label-warning">New</span></a></li>
                                                                <li><a href="javascript:void(0);">Chaises</a></li>
                                                                <li><a href="javascript:void(0);">Recliners</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul>
                                                                <li class="label">Storage</li>
                                                                <li><a href="javascript:void(0);">Bockcases</a></li>
                                                                <li><a href="javascript:void(0);">Closets</a></li>
                                                                <li><a href="javascript:void(0);">Wardrobes</a></li>
                                                                <li><a href="javascript:void(0);">Dressers <span class="label label-success">Trending</span></a></li>
                                                                <li><a href="javascript:void(0);">Sideboards </a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul>
                                                                <li class="label">Tables</li>
                                                                <li><a href="javascript:void(0);">Consoles</a></li>
                                                                <li><a href="javascript:void(0);">Desks</a></li>
                                                                <li><a href="javascript:void(0);">Dining tables</a></li>
                                                                <li><a href="javascript:void(0);">Occasional tables</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul>
                                                                <li class="label">Chairs</li>
                                                                <li><a href="javascript:void(0);">Dining Chairs</a></li>
                                                                <li><a href="javascript:void(0);">Office Chairs</a></li>
                                                                <li><a href="javascript:void(0);">Lounge Chairs <span class="label label-warning">Offer</span></a></li>
                                                                <li><a href="javascript:void(0);">Stools</a></li>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix">
                                                        <div class="col-md-3">
                                                            <ul>
                                                                <li class="label">Kitchen</li>
                                                                <li><a href="javascript:void(0);">Kitchen types</a></li>
                                                                <li><a href="javascript:void(0);">Kitchen elements <span class="label label-info">50%</span></a></li>
                                                                <li><a href="javascript:void(0);">Bars</a></li>
                                                                <li><a href="javascript:void(0);">Wall decoration</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul>
                                                                <li class="label">Accessories</li>
                                                                <li><a href="javascript:void(0);">Coat Racks</a></li>
                                                                <li><a href="javascript:void(0);">Lazy bags <span class="label label-success">Info</span></a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul>
                                                                <li class="label">Beds</li>
                                                                <li><a href="javascript:void(0);">Beds</a></li>
                                                                <li><a href="javascript:void(0);">Sofabeds</a></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul>
                                                                <li class="label">Entertainment</li>
                                                                <li><a href="javascript:void(0);">Wall units <span class="label label-warning">Popular</span></a></li>
                                                                <li><a href="javascript:void(0);">Media sets</a></li>
                                                                <li><a href="javascript:void(0);">Decoration</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!--/box-->
                                        </div> <!--/box-2-->
                                    </div> <!--/navbar-box-->
                                </div> <!--/navbar-dropdown-->
                            </li>
                            <!-- Simple menu link-->

                            <li><a href="shortcodes.html">Shortcodes</a></li>
                            --}}
                        </ul>
                    </div> <!--/floating-menu-->
                </div> <!--/navigation-main-->

                <!-- ==========  Search wrapper ========== -->

                <div class="search-wrapper">

                    <!-- Search form -->
                    <input class="form-control" placeholder="Search..." />
                    <button class="btn btn-main btn-search">Go!</button>

                    <!-- Search results - live search -->
                    <div class="search-results">
                        <div class="search-result-items">
                            <div class="title h4">Products <a href="#" class="btn btn-clean-dark btn-xs">View all</a></div>
                            <ul>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Green corner</span> <span class="category">Sofa</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Laura</span> <span class="category">Armchairs</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Nude</span> <span class="category">Dining tables</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Aurora</span> <span class="category">Nightstands</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Dining set</span> <span class="category">Kitchen</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Seat chair</span> <span class="category">Bar sets</span></a></li>
                            </ul>
                        </div> <!--/search-result-items-->
                        <div class="search-result-items">
                            <div class="title h4">Blog <a href="#" class="btn btn-clean-dark btn-xs">View all</a></div>
                            <ul>
                                <li><a href="#"><span class="id">01 Jan</span> <span class="name">Creating the Perfect Gallery Wall </span> <span class="category">Interior ideas</span></a></li>
                                <li><a href="#"><span class="id">12 Jan</span> <span class="name">Making the Most Out of Your Kids Old Bedroom</span> <span class="category">Interior ideas</span></a></li>
                                <li><a href="#"><span class="id">28 Dec</span> <span class="name">Have a look at our new projects!</span> <span class="category">Modern design</span></a></li>
                                <li><a href="#"><span class="id">31 Sep</span> <span class="name">Decorating When You're Starting Out or Starting Over</span> <span class="category">Best of 2017</span></a></li>
                                <li><a href="#"><span class="id">22 Sep</span> <span class="name">The 3 Tricks that Quickly Became Rules</span> <span class="category">Tips for you</span></a></li>
                            </ul>
                        </div> <!--/search-result-items-->
                    </div> <!--/search-results-->
                </div>

                <!-- ==========  Login wrapper ========== -->

                <div class="login-wrapper">
                    @auth
                    <!-- User is authenticated, show profile section -->
                    <div class="h4">Settings</div>
                    <div class="form-group">
                        <a href="/profile" class="open-popup">
                            <h6>Your profile</h6>
                        </a>
                        <a href="/userorderlist" class="open-popup">
                            <h6>Your orders</h6>
                        </a>
                        @if(Auth::check() && Auth::user()->role=="ROLE_SUPER_ADMIN")
                        <a href="/dashboard" class="open-popup">
                            <h6>Admin dashboard</h6>
                        </a>
                        @endif
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="btn btn-block btn-main">Log out</button>
                        </form>
                    </div>
                    @endauth
                    @guest
                    <!-- User is not authenticated, show login form -->
                    <form action="/login" method="POST">
                        @csrf
                        <div class="h4">Sign in</div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                        </div>

                        <div class="form-group">
                            <a href="/forgotpassword" class="open-popup">Forgot password?</a>
                            <a href="/register" class="open-popup">Don't have an account?</a>
                        </div>
                        <button type="submit" class="btn btn-block btn-main">Submit</button>
                    </form>
                    @endguest

                </div>

                <!-- ==========  Cart wrapper ========== -->

                <div class="cart-wrapper">
                    <div class="checkout">
                        <div class="clearfix">

                            <!--cart item-->

                            <div class="row">
                                @php
                                $total = 0; // Tổng tiền hàng
                                $taxRate = 0.02; // Tỷ lệ thuế 2%

                                // Tính toán tổng tiền và thuế
                                if(Session::has('cart') && count(Session::get('cart')) > 0) {
                                foreach(Session::get('cart') as $item) {
                                // Tính tổng tiền cho từng sản phẩm
                                $subtotal = $item['price'] * $item['quantity'];
                                // Kiểm tra giảm giá
                                if(isset($item['sale_percentage'])) {
                                $subtotal -= $item['price'] * $item['sale_percentage'] * 0.01;
                                }
                                // Cộng vào tổng tiền hàng
                                $total += $subtotal;
                                }
                                }

                                // Tính tiền thuế và tổng tiền cuối cùng
                                $tax = $total * $taxRate;
                                $totalWithTax = $total + $tax;
                                @endphp

                                @if(Session::has('cart') && count(Session::get('cart')) > 0)
                                @foreach(Session::get('cart') as $item)
                                <div class="cart-block cart-block-item clearfix" data-id="{{$item['id']}}">
                                    <div class="image">
                                        <a href="/productdetail/{{$item['id']}}"><img src="{{ asset($item['image']) }}" width="640" alt="" /></a>
                                    </div>
                                    <div class="title">
                                        <div><a href="/productdetail/{{$item['id']}}">{{$item['name']}}</a></div>
                                    </div>
                                    <div class="quantity">
                                        <input type="number" value="{{$item['quantity']}}" class="form-control form-quantity" data-id="{{$item['id']}}" />
                                    </div>
                                    <div class="price">
                                        @if(isset($item['sale_percentage']))
                                        <span class="discount">$ {{$item['price']}}</span>
                                        <span class="final">$ {{$item['price'] - $item['price'] * $item['sale_percentage'] * 0.01}}</span>
                                        @else
                                        <br>
                                        <span class="final">$ {{$item['price']}}</span>
                                        @endif
                                    </div>
                                    <span class="icon icon-cross icon-delete"></span>
                                </div>
                                @endforeach
                                @else
                                <div>No items in cart</div>
                                @endif

                                <hr />

                                <!-- Cart prices -->

                                <div class="clearfix">
                                    <div class="cart-block cart-block-footer clearfix">
                                        <div>
                                            <strong>VAT (2%)</strong>
                                        </div>
                                        <div class="tax-amount">
                                            <span>$ {{ number_format($tax, 2) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <!-- Cart final price -->

                                <div class="clearfix">
                                    <div class="cart-block cart-block-footer clearfix">
                                        <div>
                                            <strong>Total</strong>
                                        </div>
                                        <div class="total-amount">
                                            <div class="h4 title">$ {{ number_format($totalWithTax, 2) }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cart navigation -->

                                <div class="cart-block-buttons clearfix">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <a href="/shop" class="btn btn-clean-dark">Continue shopping</a>
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <a href="/checkout" class="btn btn-main"><span class="icon icon-cart"></span> Checkout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!--/checkout-->
                    </div> <!--/cart-wrapper-->
                </div> <!--/container-->
        </nav>

        <!-- ========================  Header content ======================== -->
        {{--
        <section class="header-content">

            <div class="owl-slider">

                <!-- === slide item === -->

                <div class="item" style="background-image:url(assets/images/gallery-1.jpg)">
                    <div class="box">
                        <div class="container">
                            <h2 class="title animated h1" data-animation="fadeInDown">Modern furniture theme</h2>
                            <div class="animated" data-animation="fadeInUp">
                                Modern & powerfull template. <br /> Clean design & reponsive
                                layout. Google fonts integration
                            </div>
                            <div class="animated" data-animation="fadeInUp">
                                <a href="https://themeforest.net/item/mobel-furniture-website-template/20382155" target="_blank" class="btn btn-main" ><i class="icon icon-cart"></i> Buy this template</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- === slide item === -->

                <div class="item" style="background-image:url(assets/images/gallery-2.jpg)">
                    <div class="box">
                        <div class="container">
                            <h2 class="title animated h1" data-animation="fadeInDown">Mobile ready!</h2>
                            <div class="animated" data-animation="fadeInUp">Unlimited Choices. Unbeatable Prices. Free Shipping.</div>
                            <div class="animated" data-animation="fadeInUp">Furniture category icon fonts!</div>
                            <div class="animated" data-animation="fadeInUp">
                                <a href="category.html" class="btn btn-clean">Get insipred</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- === slide item === -->

                <div class="item" style="background-image:url(assets/images/gallery-3.jpg)">
                    <div class="box">
                        <div class="container">
                            <h2 class="title animated h1" data-animation="fadeInDown">
                                Very Animate.css Friend.
                            </h2>
                            <div class="desc animated" data-animation="fadeInUp">
                                Combine with animate.css. Or just use your own!.
                            </div>
                            <div class="desc animated" data-animation="fadeInUp">
                                Bunch of typography effects.
                            </div>
                            <div class="animated" data-animation="fadeInUp">
                                <a href="https://themeforest.net/item/mobel-furniture-website-template/20382155" target="_blank" class="btn btn-clean">Buy this template</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!--/owl-slider-->
        </section> --}}