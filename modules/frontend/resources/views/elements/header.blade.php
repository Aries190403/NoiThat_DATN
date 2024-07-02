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
                                @if (Auth::check())
                                    <i>Hi, {{ Auth::user()->name }} !</i>
                                @else
                                    <i class="icon icon-user"></i>
                                @endif
                            </a></li>
                        <li><a href="javascript:void(0);" class="open-search"><i class="icon icon-magnifier"></i></a>
                        </li>
                        <li><a href="javascript:void(0);" class="open-cart"><i class="icon icon-cart"></i>
                                @if (isset($globalCart))
                                    <span>{{ count((array) $globalCart) }}</span>
                                @else
                                    <span>0</span>
                                @endif
                            </a></li>
                    </ul>
                </div> <!--/navigation-top-->

                <!-- ==========  Main navigation ========== -->

                <div class="navigation navigation-main">

                    <!-- Setup your logo here-->

                    <a href="/" class="logo"><img src="{{ asset('frontend/assets/images/logo.png') }}"
                            alt="" /></a>

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

                            <li id="li_hover">
                                <a href="/"> Product Category <span class="open-dropdown"><i
                                            class="fa fa-angle-down"></i></span></a>
                                <div class="navbar-dropdown">
                                    <div class="navbar-box">

                                        <!-- box-1 (left-side)-->

                                        <div class="box-1">
                                            <div class="image">
                                                <img src="{{ asset('frontend/assets/images/blog-2.jpg') }}"
                                                    alt="Lorem ipsum" />
                                            </div>
                                            <div class="box">
                                                <div class="h2">Mobel</div>
                                                <div class="clearfix">
                                                    <p>Let us know what you're looking for. We will support you.</p>
                                                    {{-- <a class="btn btn-clean btn-big" href="/shop">Explore</a> --}}
                                                </div>
                                            </div>
                                        </div> <!--/box-1-->

                                        <!-- box-2 (right-side)-->

                                        <div class="box-2">
                                            <div class="clearfix categories"
                                                style="overflow-y: auto; max-height: 450px;">
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
                                                    @foreach ($globalCategory as $c)
                                                        <div class="col-sm-3 col-xs-6">
                                                            <a class="categorySearch categoryHeader"
                                                                id="{{ $c->id }}">
                                                                @php
                                                                    $icon = json_decode($c->content, true);
                                                                @endphp
                                                                <figure>
                                                                    <i class="f-icon {{ $icon['icon'] }}"></i>
                                                                    <figcaption>{{ $c->name }}</figcaption>
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
                                <a href="/blog">Blogs</a>
                                {{-- <div class="navbar-dropdown">
                                    <div class="navbar-box">

                                        <!-- box-1 (left-side)-->

                                        <div class="box-1">
                                            <div class="box">
                                                <div class="h2">Find your inspiration</div>
                                                <div class="clearfix">
                                                    <p>Homes that differ in terms of style, concept and architectural
                                                        solutions have been furnished by Furniture Factory. These spaces
                                                        tell of an international lifestyle that expresses modernity,
                                                        research and a creative spirit.</p>
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
                                                            <li class="label"><a href="/blog">Blogs <span
                                                                        class="label label-warning">New</span></a></li>
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
                                </div> <!--/navbar-dropdown--> --}}
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
                    <button id="btnSearch" class="btn btn-main btn-search">X</button>
                    <input id='search' class="form-control" placeholder="Type name product..." />
                    <div class="search-results">
                        {{-- <div class="search-result-items">
                            <div class="title h4">Products <a href="/shop" class="btn btn-clean-dark btn-xs">View
                                    all</a></div>
                            <ul>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Green
                                            corner</span> <span class="category">Sofa</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span
                                            class="name">Laura</span> <span class="category">Armchairs</span></a>
                                </li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Nude</span>
                                        <span class="category">Dining tables</span></a>
                                </li>
                                <li><a href="#"><span class="id">42563</span> <span
                                            class="name">Aurora</span> <span class="category">Nightstands</span></a>
                                </li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Dining
                                            set</span> <span class="category">Kitchen</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Seat
                                            chair</span> <span class="category">Bar sets</span></a></li>
                            </ul>
                        </div>
                        <div class="search-results"> --}}
                        <div class="search-result-items">
                            <div class="title h4">Products <a href="/shop" class="btn btn-clean-dark btn-xs">View
                                    all</a></div>
                            <ul id="results-list">
                                <!-- Search results will be appended here -->
                            </ul>
                        </div>
                    </div>
                    <!-- Search results - live search -->
                    {{-- <div class="search-results">
                        <div class="search-result-items">
                            <div class="title h4">Products <a href="#" class="btn btn-clean-dark btn-xs">View
                                    all</a></div>
                            <ul>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Green
                                            corner</span> <span class="category">Sofa</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span
                                            class="name">Laura</span> <span class="category">Armchairs</span></a>
                                </li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Nude</span>
                                        <span class="category">Dining tables</span></a>
                                </li>
                                <li><a href="#"><span class="id">42563</span> <span
                                            class="name">Aurora</span> <span class="category">Nightstands</span></a>
                                </li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Dining
                                            set</span> <span class="category">Kitchen</span></a></li>
                                <li><a href="#"><span class="id">42563</span> <span class="name">Seat
                                            chair</span> <span class="category">Bar sets</span></a></li>
                            </ul>
                        </div> <!--/search-result-items-->
                        <div class="search-result-items">
                            <div class="title h4">Blog <a href="#" class="btn btn-clean-dark btn-xs">View
                                    all</a></div>
                            <ul>
                                <li><a href="#"><span class="id">01 Jan</span> <span
                                            class="name">Creating the Perfect Gallery Wall </span> <span
                                            class="category">Interior ideas</span></a></li>
                                <li><a href="#"><span class="id">12 Jan</span> <span class="name">Making
                                            the Most Out of Your Kids Old Bedroom</span> <span
                                            class="category">Interior ideas</span></a></li>
                                <li><a href="#"><span class="id">28 Dec</span> <span class="name">Have a
                                            look at our new projects!</span> <span class="category">Modern
                                            design</span></a></li>
                                <li><a href="#"><span class="id">31 Sep</span> <span
                                            class="name">Decorating When You're Starting Out or Starting Over</span>
                                        <span class="category">Best of 2017</span></a></li>
                                <li><a href="#"><span class="id">22 Sep</span> <span class="name">The 3
                                            Tricks that Quickly Became Rules</span> <span class="category">Tips for
                                            you</span></a></li>
                            </ul>
                        </div> <!--/search-result-items-->
                    </div> <!--/search-results--> --}}
                </div>

                <script>
                    $(document).ready(function() {
                        let timeout = null;

                        $('#search').on('input', function() {
                            clearTimeout(timeout);
                            const query = $(this).val();

                            timeout = setTimeout(function() {
                                if (query.length > 0) {
                                    searchProducts(query);
                                } else {
                                    $('#results-list').empty();
                                }
                            }, 1000);
                        });
                        $('#search').on('keypress', function(e) {
                            if (e.which == 13) { // Enter key pressed
                                clearTimeout(timeout);
                                const query = $(this).val();
                                if (query.length > 0) {
                                    searchProducts(query);
                                } else {
                                    $('#results-list').empty();
                                }
                            }
                        });

                        $('#btnSearch').on('click', function(e) {
                            $('#search').val('');
                            $('#results-list').empty();
                        });

                        function searchProducts(query) {
                            $.ajax({
                                url: '/search',
                                method: 'GET',
                                data: {
                                    query: query
                                },
                                success: function(data) {
                                    $('#results-list').empty();
                                    if (data.length > 0) {
                                        data.forEach(function(product) {
                                            $('#results-list').append(
                                                `<li>
                                <a href="/productdetail/${product.id}"><span class="id"></span> <span class="name">${product.name}</span> <span class="category">${product.name}</span></a>
                            </li>`
                                            );
                                        });
                                    } else {
                                        $('#results-list').append('<li>No products found !</li>');

                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Search error:', error);
                                    $('#results-list').append('<li>No products found !</li>');
                                }
                            });
                        }
                    });
                </script>

                <!-- ==========  Login wrapper ========== -->

                <div class="login-wrapper">
                    @auth
                        <!-- User is authenticated, show profile section -->
                        <div class="h4">Settings</div>
                        <div class="form-group">
                            @if (Auth::check() && Auth::user()->role == 'USER')
                                <a href="/profile" class="open-popup">
                                    <h6>Your profile</h6>
                                </a>
                                {{-- <a href="/editpassword" class="open-popup">
                                <h6>Editpassword</h6>
                            </a> --}}
                                <a href="/userfavorite" class="open-popup">
                                    <h6>Your Favorites</h6>
                                </a>
                                <a href="/userorderlist" class="open-popup">
                                    <h6>Your orders</h6>
                                </a>
                            @endif
                            @if (Auth::check() && Auth::user()->role == 'ROLE_SUPER_ADMIN')
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
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1"
                                    placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                    placeholder="Password" required>
                            </div>

                            <div class="form-group">
                                {{-- <a href="/forgotpassword" class="open-popup">Forgot password?</a> --}}
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

                                @if (isset($globalCart) && $globalCart)
                                    {{-- @dump($globalCart) --}}
                                    <div class="cart-items-container">
                                        @foreach ($globalCart as $cartItem)
                                            <div class="cartItem">
                                                <div class="cart-block cart-block-item clearfix">
                                                    <div class="image">
                                                        @php
                                                            // Decode the JSON string into an array
                                                            $contentArray = json_decode($cartItem['content'], true);
                                                            // Get the image path from the array, fallback to a default image if not set
                                                            $imgThumbnail =
                                                                $contentArray['imgThumbnail'] ??
                                                                'frontend/assets/images/product-1.png';
                                                        @endphp
                                                        <img src="{{ asset($imgThumbnail) }}" alt=""
                                                            width="360" />
                                                    </div>
                                                    <div class="title">
                                                        <div>{{ $cartItem['name'] }}</div>
                                                    </div>
                                                    <div class="quantity">
                                                        <input type="number" value="{{ $cartItem['quantity'] }}"
                                                            class="form-control form-quantity" min="1"
                                                            max="3" data-price="{{ $cartItem['price'] }}"
                                                            data-sale="{{ $cartItem['sale_percentage'] ?? 0 }}"
                                                            data-id="{{ $cartItem['id'] }}" onkeydown="return false"
                                                            name="quantitytest" />
                                                    </div>




                                                    <div class="price">
                                                        @if (isset($cartItem['sale_percentage']))
                                                            <span class="final">$
                                                                {{ $cartItem['price'] - $cartItem['price'] * ($cartItem['sale_percentage'] * 0.01) }}</span>
                                                            <span class="discount">$
                                                                {{ $cartItem['price'] }}</span>
                                                        @else
                                                            <span class="final">$ {{ $cartItem['price'] }}</span>
                                                        @endif
                                                    </div>

                                                    <a href="/cart/delete/{{ $cartItem->id }}"
                                                        class="icon icon-cross icon-delete"></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <!--cart prices -->
                                    {{-- <div class="clearfix">
                                        <div class="cart-block cart-block-footer clearfix">
                                            <div>
                                                <strong>VAT</strong>
                                            </div>
                                            <div>
                                                <span id="vat">$0.00</span>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- <hr /> --}}
                                    <!--cart final price -->
                                    <div class="clearfix">
                                        <div class="cart-block cart-block-footer clearfix">
                                            <div>
                                                <strong>Total</strong>
                                            </div>
                                            <div>
                                                <div class="h4 title" id="total-price">$0.00</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--cart navigation -->
                                    <div class="cart-block-buttons clearfix">
                                        <div class="row">
                                            <div class="col-xs-6 text-right">
                                                <a href="/viewcart" class="btn btn-main"><span
                                                        class="icon icon-cart"></span> Checkout</a>
                                            </div>
                                            <div class="col-xs-6">
                                                <a href="/shop" class="btn btn-clean-dark">Continue shopping</a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p>Your cart is empty.</p>
                                @endif
                            </div>
                            <script>
                                $(document).ready(function() {
                                    function updateCart() {
                                        var total = 0;
                                        var vatRate = 0; // Example VAT rate (10%)

                                        $('.cartItem').each(function(index) {
                                            // console.log("Item index:", index);

                                            var quantity = parseInt($(this).find('.form-quantity').val());
                                            var price = parseFloat($(this).find('.form-quantity').data('price'));
                                            var salePercentage = parseFloat($(this).find('.form-quantity').data('sale'));

                                            var finalPrice = price; // Start with base price

                                            if (salePercentage > 0) {
                                                finalPrice = price - (price * (salePercentage / 100));
                                            }

                                            var subtotal = finalPrice * quantity;
                                            total += subtotal;

                                            // Update displayed price
                                            $(this).find('.price .final').text('$' + finalPrice);
                                        });

                                        // Update VAT
                                        var vat = total * vatRate;
                                        $('#vat').text('$' + vat.toFixed(2));

                                        // Update Total
                                        var totalPrice = total + vat;
                                        $('#total-price').text('$' + totalPrice.toFixed(2));
                                    }

                                    // Initial calculation on page load
                                    updateCart();

                                    // Event listener for quantity change
                                    $('.form-quantity').on('input', function() {
                                        updateCart();
                                    });
                                });
                            </script>
                            <script>
                                $(document).ready(function() {
                                    $('.form-quantity').on('change', function() {
                                        const quantity = $(this).val();
                                        const cartItemId = $(this).data('id');
                                        $.ajax({
                                            url: `/cart/update-quantity/${cartItemId}/${quantity}`,
                                            type: 'post',
                                            dataType: 'json',
                                            data: {
                                                _token: '{{ csrf_token() }}'
                                            },
                                            success: function(data) {
                                                console.log("success");
                                            },
                                            error: function(error) {
                                                console.error('Error:', error);
                                            }
                                        });
                                    });
                                });
                            </script>

                            <script>
                                $('.categoryHeader').on('click', function() {
                                    // Hành động khi click vào phần tử
                                    // alert(window.location.href);
                                    if (!window.location.href.includes('/shop')) window.location.href = '/shop';
                                });
                            </script>
                        </div>
                    </div> <!--/cart-wrapper-->
                </div> <!--/container-->
        </nav>
