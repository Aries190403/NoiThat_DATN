@extends('frontend::main')
@section('content')
    <!-- ========================  Header content ======================== -->

    <section class="header-content">

        <div class="owl-slider">

            <!-- === slide item === -->

            <div class="item" style="background-image:url({{ asset('frontend/assets/images/gallery-1.jpg)') }}">
                <div class="box">
                    <div class="container">
                        <h2 class="title animated h1" data-animation="fadeInDown">Modern furniture theme</h2>
                        <div class="animated" data-animation="fadeInUp">
                            Modern & powerfull template. <br /> Clean design & reponsive
                            layout. Google fonts integration
                        </div>
                        <div class="animated" data-animation="fadeInUp">
                            <a href="https://themeforest.net/item/mobel-furniture-website-template/20382155" target="_blank"
                                class="btn btn-main"><i class="icon icon-cart"></i> Buy this template</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- === slide item === -->

            <div class="item" style="background-image:url({{ asset('frontend/assets/images/gallery-2.jpg)') }}">
                <div class="box">
                    <div class="container">
                        <h2 class="title animated h1" data-animation="fadeInDown">Mobile ready!</h2>
                        <div class="animated" data-animation="fadeInUp">Unlimited Choices. Unbeatable Prices. Free Shipping.
                        </div>
                        <div class="animated" data-animation="fadeInUp">Furniture category icon fonts!</div>
                        <div class="animated" data-animation="fadeInUp">
                            <a href="category.html" class="btn btn-clean">Get insipred</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- === slide item === -->

            <div class="item" style="background-image:url({{ asset('frontend/assets/images/gallery-3.jpg)') }}">
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
                            <a href="https://themeforest.net/item/mobel-furniture-website-template/20382155" target="_blank"
                                class="btn btn-clean">Buy this template</a>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!--/owl-slider-->
    </section>

    <!-- ========================  Icons slider ======================== -->

    <section class="owl-icons-wrapper owl-icons-frontpage">

        <!-- === header === -->

        <header class="hidden">
            <h2>Product categories</h2>
        </header>

        <div class="container">

            <div class="owl-icons">
                <!-- === icon item === -->

                <!-- <a href="#">
                                                                                                                                                                                                                                                                    <figure>
                                                                                                                                                                                                                                                                        <i class="f-icon f-icon-accessories"></i>
                                                                                                                                                                                                                                                                        <figcaption>Accessories</figcaption>
                                                                                                                                                                                                                                                                    </figure>
                                                                                                                                                                                                                                                                </a> -->
                @foreach ($globalCategory as $c)
                    <a href="/category/{{ $c->id }}">
                        @php
                            $icon = json_decode($c->content, true);
                        @endphp
                        <figure>
                            <i class="f-icon {{ $icon['icon'] }}"></i>
                            <figcaption>{{ $c->name }}</figcaption>
                        </figure>
                    </a>
                @endforeach

            </div> <!--/owl-icons-->
        </div> <!--/container-->
    </section>

    <!-- ========================  Products widget ======================== -->

    <section class="products">

        <div class="container">

            <!-- === header title === -->

            <header>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8 text-center">
                        <h2 class="title">New products</h2>
                        <div class="text">
                            <p>Check out our latest products</p>
                        </div>
                    </div>
                </div>
            </header>

            <div class="row">

                <!-- === product-item === -->

                <!-- <div class="col-md-4 col-xs-6">
                                                                                                                                                                                                                                                                    <article>
                                                                                                                                                                                                                                                                        <div class="info">
                                                                                                                                                                                                                                                                            <span class="add-favorite">
                                                                                                                                                                                                                                                                                <a href="javascript:void(0);" data-title="Add to favorites" data-title-added="Added to favorites list"><i class="icon icon-heart"></i></a>
                                                                                                                                                                                                                                                                            </span>
                                                                                                                                                                                                                                                                            <span>
                                                                                                                                                                                                                                                                                <a href="#productid1" class="mfp-open" data-title="Quick wiew"><i class="icon icon-eye"></i></a>
                                                                                                                                                                                                                                                                            </span>
                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                        <div class="btn btn-add">
                                                                                                                                                                                                                                                                            <i class="icon icon-cart"></i>
                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                        <div class="figure-grid">
                                                                                                                                                                                                                                                                            <span class="label label-warning">New</span>
                                                                                                                                                                                                                                                                            <div class="image">
                                                                                                                                                                                                                                                                                <a href="#productid1" class="mfp-open">
                                                                                                                                                                                                                                                                                    <img src="" alt="" width="360" />
                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                            <div class="text">
                                                                                                                                                                                                                                                                                <h2 class="title h4"><a href="product.html">Nude</a></h2>
                                                                                                                                                                                                                                                                                <sup>$ 2999,-</sup>
                                                                                                                                                                                                                                                                                <span class="description clearfix">Gubergren amet dolor ea diam takimata consetetur facilisis blandit et aliquyam lorem ea duo labore diam sit et consetetur nulla</span>
                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                    </article>
                                                                                                                                                                                                                                                                </div> -->

                <!-- === product-item === -->
                @php
                    if (isset($favorites)) {
                        foreach ($favorites as $item) {
                            $fas[] = $item->id;
                        }
                    }
                @endphp

                @foreach ($data as $dt)
                    <div class="col-md-4 col-xs-6">
                        <article>
                            <div class="info">
                                @if (isset($favorites) && isset($fas))
                                    @if (in_array($dt->product_id, $fas))
                                        <span class="add-favorite">
                                            <a href="/addfavorite/{{ $dt->product_id }}"
                                                data-title="Remove to favorites list" style="background-color: #e71d36;">
                                                <i class="icon icon-heart" style="background-color: #e71d36;"></i>
                                            </a>
                                        </span>
                                    @else
                                        <span class="add-favorite">
                                            <a href="/addfavorite/{{ $dt->product_id }}" data-title="Add to favorites"
                                                data-title-added="Added to favorites list">
                                                <i class="icon icon-heart"></i>
                                            </a>
                                        </span>
                                    @endif
                                @else
                                    <span class="add-favorite">
                                        <a href="/addfavorite/{{ $dt->product_id }}" data-title="Add to favorites"
                                            data-title-added="Added to favorites list">
                                            <i class="icon icon-heart"></i>
                                        </a>
                                    </span>
                                @endif
                                <span>
                                    <a href="#productid{{ $dt->product_id }}" class="mfp-open" data-title="Quick wiew"><i
                                            class="icon icon-eye"></i></a>
                                </span>
                            </div>
                            {{-- <div class="btn btn-add">
                                <a href="#add{{ $dt->product_id }}" class="mfp-open"><i class="icon icon-cart">
                                    </i></a>
                            </div> --}}
                            <a href="#add{{ $dt->product_id }}" class="btn btn-add mfp-open"><i class="icon icon-cart">
                                </i></a>
                            <div class="figure-grid">
                                <span class="label label-warning">New</span>
                                @if (isset($dt->sale_percentage))
                                    <span style="margin-left: 40px;"
                                        class="label label-info">-{{ $dt->sale_percentage }}%</span>
                                @endif
                                <div class="image">
                                    @php
                                        // Giải mã chuỗi JSON thành mảng
                                        $contentArray = json_decode($dt->product_content, true);

                                        // Lấy đường dẫn hình ảnh từ mảng
                                        $imgThumbnail =
                                            $contentArray['imgThumbnail'] ?? 'frontend/assets/images/product-1.png';
                                    @endphp
                                    <a href="/productdetail/{{ $dt->product_id }}">
                                        <img src="{{ asset($imgThumbnail) }}" alt="" width="360" />
                                    </a>
                                </div>
                                <div class="text">
                                    <h2 class="title h4"><a
                                            href="#productid{{ $dt->product_id }}">{{ $dt->product_name }}</a></h2>
                                    <sup>$ {{ $dt->product_price }}</sup>
                                    <span class="description clearfix">{{ $dt->product_description }}</span>
                                </div>
                            </div>
                        </article>
                    </div>
                    <!-- ========================  Product info popup - quick view ======================== -->

                    <div class="popup-main mfp-hide" id="productid{{ $dt->product_id }}">

                        <!-- === product popup === -->

                        <div class="product">

                            <!-- === popup-title === -->

                            <div class="popup-title">
                                <div class="h1 title">{{ $dt->product_name }} <small>{{ $dt->category_name }}</small>
                                </div>
                            </div>

                            <!-- === product gallery === -->
                            <div class="owl-product-gallery">
                                <img src="{{ asset($imgThumbnail) }}" alt="" width="640" />
                                @if (isset($dt->images))
                                    @php
                                        // Lấy danh sách hình ảnh từ mảng
                                        $images = explode(',', $dt->images);
                                    @endphp
                                    @foreach ($images as $image)
                                        <img src="{{ asset($image) }}" alt="" width="640" />
                                    @endforeach
                                @endif
                            </div>

                            <!-- === product-popup-info === -->

                            <div class="popup-content">
                                <div class="product-info-wrapper">
                                    <div class="row">

                                        <!-- === left-column === -->

                                        <div class="col-sm-6">
                                            <!-- <div class="info-box">
                                                                                                                                                                                                                                                                                                    <strong>Maifacturer</strong>
                                                                                                                                                                                                                                                                                                    <span>Brand name</span>
                                                                                                                                                                                                                                                                                                </div> -->
                                            <div class="info-box">
                                                <strong>Materials</strong>
                                                <span>{{ $dt->materials_type }}</span>
                                            </div>
                                            <div class="info-box">
                                                <strong>Availability</strong>
                                                @if ($dt->total_stock > 0)
                                                    <span><i class="fa fa-check-square-o"></i> in stock</span>
                                                @else
                                                    <span><i class="fa fa-square-o"></i> out of stock</span>
                                                @endif
                                            </div>

                                        </div>

                                        <!-- === right-column === -->

                                        <div class="col-sm-6">
                                            <div class="info-box">
                                                <strong>Color</strong>
                                                @php
                                                    // Chuyển màu sắc thành chữ thường
                                                    $colorClass = strtolower($dt->materials_color);
                                                @endphp
                                                <span>
                                                    <div
                                                        style="background-color:{{ $colorClass }}; width: 25px; height:25px;">
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="info-box">
                                                <strong>Size</strong>
                                                @php
                                                    $rawString = $dt->product_content;

                                                    // Giải mã chuỗi JSON thành mảng
                                                    $contentArray = json_decode($rawString, true);

                                                    // Lấy kích thước từ mảng
                                                    $size = $contentArray['size'] ?? null;

                                                    // Khởi tạo mảng mới để chứa các chuỗi định dạng 'height x length x width'
                                                    $formattedArray = [];

                                                    if ($size) {
                                                        // Chuyển đổi định dạng
                                                        $formattedArray[] = "{$size['height']}x{$size['length']}x{$size['width']}";
                                                    }
                                                @endphp

                                                <span class="">
                                                    @foreach ($formattedArray as $formattedDimension)
                                                        <div class="color-btn color-btn-biege size12345">
                                                            {{ $formattedDimension }}</div>
                                                    @endforeach
                                                </span>
                                            </div>

                                        </div>

                                    </div><!--/row-->
                                </div> <!--/product-info-wrapper-->
                            </div><!--/popup-content-->
                            <!-- === product-popup-footer === -->

                            <div class="popup-table">
                                <div class="popup-cell">
                                    <div class="price">
                                        @if (isset($dt->sale_percentage))
                                            <span class="h3">$
                                                {{ $dt->product_price - $dt->product_price * ($dt->sale_percentage * 0.01) }}
                                                <small>$ {{ $dt->product_price }}</small></span>
                                        @else
                                            <span class="h3">$ {{ $dt->product_price }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="popup-cell">
                                    <div class="popup-buttons">
                                        <a href="/productdetail/{{ $dt->product_id }}"><span
                                                class="icon icon-eye"></span> <span class="hidden-xs">View more</span></a>
                                        <a href="/buynow/{{ $dt->product_id }}"><span class="icon icon-cart"></span>
                                            <span class="hidden-xs">Buy Now</span></a>
                                    </div>
                                </div>
                            </div>

                        </div> <!--/product-->
                    </div> <!--popup-main-->

                    <!-- ========================  Product add info popup - quick view ======================== -->
                    <div class="popup-main mfp-hide" id="add{{ $dt->product_id }}">

                        <!-- === product popup === -->

                        <div class="product">

                            <!-- === popup-title === -->

                            <div class="popup-title">
                                <div class="h1 title">{{ $dt->product_name }} <small>{{ $dt->category_name }}</small>
                                </div>
                            </div>

                            <!-- === product gallery === -->
                            <div class="owl-product-gallery">
                                <img src="{{ asset($imgThumbnail) }}" alt="" width="640" />
                                @if (isset($dt->images))
                                    @php
                                        // Lấy danh sách hình ảnh từ mảng
                                        $images = explode(',', $dt->images);
                                    @endphp
                                    @foreach ($images as $image)
                                        <img src="{{ asset($image) }}" alt="" width="640" />
                                    @endforeach
                                @endif
                            </div>

                            <!-- === product-popup-info === -->

                            <div class="popup-content">
                                <div class="product-info-wrapper">
                                    <div class="row">

                                        <!-- === left-column === -->

                                        <div class="col-sm-6">
                                            <!-- <div class="info-box">
                                                                                                                                                                                                                                                                                                    <strong>Maifacturer</strong>
                                                                                                                                                                                                                                                                                                    <span>Brand name</span>
                                                                                                                                                                                                                                                                                                </div> -->
                                            <div class="info-box">
                                                <strong>Materials</strong>
                                                <span>{{ $dt->materials_type }}</span>
                                            </div>
                                            <div class="info-box">
                                                <strong>Availability</strong>
                                                @if ($dt->total_stock > 0)
                                                    <span><i class="fa fa-check-square-o"></i> in stock</span>
                                                @else
                                                    <span><i class="fa fa-square-o"></i> out of stock</span>
                                                @endif
                                            </div>

                                        </div>

                                        <!-- === right-column === -->

                                        <div class="col-sm-6">
                                            <div class="info-box">
                                                <strong>Color</strong>
                                                @php
                                                    // Chuyển màu sắc thành chữ thường
                                                    $colorClass = strtolower($dt->materials_color);
                                                @endphp
                                                <span>
                                                    <div
                                                        style="background-color:{{ $colorClass }}; width: 25px; height:25px;">
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="info-box">
                                                <strong>Size</strong>
                                                @php
                                                    $rawString = $dt->product_content;

                                                    // Giải mã chuỗi JSON thành mảng
                                                    $contentArray = json_decode($rawString, true);

                                                    // Lấy kích thước từ mảng
                                                    $size = $contentArray['size'] ?? null;

                                                    // Khởi tạo mảng mới để chứa các chuỗi định dạng 'height x length x width'
                                                    $formattedArray = [];

                                                    if ($size) {
                                                        // Chuyển đổi định dạng
                                                        $formattedArray[] = "{$size['height']}x{$size['length']}x{$size['width']}";
                                                    }
                                                @endphp

                                                <span class="">
                                                    @foreach ($formattedArray as $formattedDimension)
                                                        <div class="color-btn color-btn-biege size12345">
                                                            {{ $formattedDimension }}</div>
                                                    @endforeach
                                                </span>
                                            </div>

                                        </div>

                                    </div><!--/row-->
                                </div> <!--/product-info-wrapper-->
                            </div><!--/popup-content-->
                            <!-- === product-popup-footer === -->

                            <div class="popup-table">
                                <div class="popup-cell">
                                    <div class="price">
                                        @if (isset($dt->sale_percentage))
                                            <span class="h3">$
                                                {{ $dt->product_price - $dt->product_price * ($dt->sale_percentage * 0.01) }}
                                                <small>$ {{ $dt->product_price }}</small></span>
                                        @else
                                            <span class="h3">$ {{ $dt->product_price }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="popup-cell">
                                    <div class="popup-buttons">
                                        <a href="/add/{{ $dt->product_id }}"><span class="icon icon-cart"></span> <span
                                                class="hidden-xs">Add to cart</span></a>

                                        <a href="/buynow/{{ $dt->product_id }}"span class="icon icon-cart"></span> <span
                                                class="hidden-xs">Buy Now</span></a>
                                    </div>
                                </div>
                            </div>

                        </div> <!--/product-->
                    </div> <!--popup-main-->
                @endforeach

            </div> <!--/row-->
            <!-- === button more === -->

            <div class="wrapper-more">
                <a href="/shop" class="btn btn-main">View store</a>
            </div>

        </div> <!--/container-->
    </section>

    <!-- ========================  Stretcher widget ======================== -->

    <section class="stretcher-wrapper">

        <!-- === stretcher header === -->

        <header class="hidden">
            <!--remove class 'hidden'' to show section header -->
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-2 col-md-8 text-center">
                        <h1 class="h2 title">Popular categories</h1>
                        <div class="text">
                            <p>
                                Whether you are changing your home, or moving into a new one, you will find a huge selection
                                of quality living room furniture,
                                bedroom furniture, dining room furniture and the best value at Furniture factory
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- === stretcher === -->

        <ul class="stretcher">

            <!-- === stretcher item === -->

            <li class="stretcher-item"
                style="background-image:url({{ asset('frontend/assets/images/gallery-1.jpg);') }}">
                <!--logo-item-->
                <div class="stretcher-logo">
                    <div class="text">
                        <span class="f-icon f-icon-bedroom"></span>
                        <span class="text-intro">Bedroom</span>
                    </div>
                </div>
                <!--main text-->
                <figure>
                    <h4>Modern furnishing projects</h4>
                    <figcaption>New furnishing ideas</figcaption>
                </figure>
                <!--anchor-->
                <a href="#">Anchor link</a>
            </li>

            <!-- === stretcher item === -->

            <li class="stretcher-item"
                style="background-image:url({{ asset('frontend/assets/images/gallery-2.jpg);') }}">
                <!--logo-item-->
                <div class="stretcher-logo">
                    <div class="text">
                        <span class="f-icon f-icon-sofa"></span>
                        <span class="text-intro">Living room</span>
                    </div>
                </div>
                <!--main text-->
                <figure>
                    <h4>Furnishing and complements</h4>
                    <figcaption>Discover the design table collection</figcaption>
                </figure>
                <!--anchor-->
                <a href="#">Anchor link</a>
            </li>

            <!-- === stretcher item === -->

            <li class="stretcher-item"
                style="background-image:url({{ asset('frontend/assets/images/gallery-3.jpg);') }}">
                <!--logo-item-->
                <div class="stretcher-logo">
                    <div class="text">
                        <span class="f-icon f-icon-office"></span>
                        <span class="text-intro">Office</span>
                    </div>
                </div>
                <!--main text-->
                <figure>
                    <h4>Which is Best for Your Home</h4>
                    <figcaption>Wardrobes vs Walk-In Closets</figcaption>
                </figure>
                <!--anchor-->
                <a href="#">Anchor link</a>
            </li>

            <!-- === stretcher item === -->

            <li class="stretcher-item"
                style="background-image:url({{ asset('frontend/assets/images/gallery-4.jpg);') }}">
                <!--logo-item-->
                <div class="stretcher-logo">
                    <div class="text">
                        <span class="f-icon f-icon-bathroom"></span>
                        <span class="text-intro">Bathroom</span>
                    </div>
                </div>
                <!--main text-->
                <figure>
                    <h4>Keeping Things Minimal</h4>
                    <figcaption>Creating Your Very Own Bathroom</figcaption>
                </figure>
                <!--anchor-->
                <a href="#">Anchor link</a>
            </li>

            <!-- === stretcher item more=== -->

            <li class="stretcher-item more">
                <div class="more-icon">
                    <span data-title-show="Show more" data-title-hide="+"></span>
                </div>
                <a href="#"></a>
            </li>

        </ul>
    </section>

    <!-- ========================  Blog Block ======================== -->
    {{--
<section class="blog blog-block">

    <div class="container">

        <!-- === blog header === -->

        <header>
            <div class="row">
                <div class="col-md-offset-2 col-md-8 text-center">
                    <h2 class="title">Interior ideas</h2>
                    <div class="text">
                        <p>Keeping things minimal</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="row">

            <!-- === blog item === -->

            <div class="col-sm-4">
                <article>
                    <a href="article.html">
                        <div class="image">
                            <img src="{{ asset('frontend/assets/images/project-1.jpg')}}" alt="" />
</div>
<div class="entry entry-block">
    <div class="date">28 Mart 2017</div>
    <div class="title">
        <h2 class="h3">Creating the Perfect Gallery Wall </h2>
    </div>
    <div class="description">
        <p>
            You’ve finally reached this point in your life- you’ve bought your first home, moved
            into your very own apartment, moved out of the dorm room or you’re finally downsizing
            after all of your kids have left the nest.
        </p>
    </div>
</div>
<div class="show-more">
    <span class="btn btn-main btn-block">Read more</span>
</div>
</a>
</article>
</div>

<!-- === blog item === -->

<div class="col-sm-4">
    <article>
        <a href="article.html">
            <div class="image">
                <img src="{{ asset('frontend/assets/images/project-2.jpg')}}" alt="" />
            </div>
            <div class="entry entry-block">
                <div class="date">25 Mart 2017</div>
                <div class="title">
                    <h2 class="h3">Making the Most Out of Your Kids Old Bedroom</h2>
                </div>
                <div class="description">
                    <p>
                        You’ve finally reached this point in your life- you’ve bought your first home, moved
                        into your very own apartment, moved out of the dorm room or you’re finally downsizing
                        after all of your kids have left the nest.
                    </p>
                </div>
            </div>
            <div class="show-more">
                <span class="btn btn-main btn-block">Read more</span>
            </div>
        </a>
    </article>
</div>

<!-- === blog item === -->

<div class="col-sm-4">
    <article>
        <a href="article.html">
            <div class="image">
                <img src="{{ asset('frontend/assets/images/project-3.jpg')}}" alt="" />
            </div>
            <div class="entry entry-block">
                <div class="date">28 Mart 2017</div>
                <div class="title">
                    <h2 class="h3">Have a look at our new projects!</h2>
                </div>
                <div class="description">
                    <p>
                        You’ve finally reached this point in your life- you’ve bought your first home, moved
                        into your very own apartment, moved out of the dorm room or you’re finally downsizing
                        after all of your kids have left the nest.
                    </p>
                </div>
            </div>
            <div class="show-more">
                <span class="btn btn-main btn-block">Read more</span>
            </div>
        </a>
    </article>
</div>

</div> <!--/row-->
<!-- === button more === -->

<div class="wrapper-more">
    <a href="ideas.html" class="btn btn-main">View all posts</a>
</div>

</div> <!--/container-->
</section>
--}}
    <!-- ========================  Banner ======================== -->

    <!-- <section class="banner" style="background-image:url({{ asset('frontend/assets/images/gallery-4.jpg)') }}">
                                                                                                                                                                                                                                                        <div class="container">
                                                                                                                                                                                                                                                            <div class="row">
                                                                                                                                                                                                                                                                <div class="col-md-offset-2 col-md-8 text-center">
                                                                                                                                                                                                                                                                    <h2 class="title">Our story</h2>
                                                                                                                                                                                                                                                                    <p>
                                                                                                                                                                                                                                                                        We believe in creativity as one of the major forces of progress. With this idea, we traveled throughout Italy to find exceptional
                                                                                                                                                                                                                                                                        artisans and bring their unique handcrafted objects to connoisseurs everywhere.
                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                    <p><a href="about.html" class="btn btn-clean">Read full story</a></p>
                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                    </section> -->

    <!-- ========================  Blog ======================== -->

    <section class="blog">

        <div class="container">

            <!-- === blog header === -->

            <header>
                <div class="row">
                    <div class="col-md-offset-2 col-md-8 text-center">
                        <h1 class="h2 title">Blog</h1>
                        <div class="text">
                            <p>Latest news from the blog</p>
                        </div>
                    </div>
                </div>
            </header>

            <div class="row">

                <!-- === blog item === -->

                <div class="col-sm-4">
                    <article>
                        <a href="article.html">
                            <div class="image"
                                style="background-image:url({{ asset('frontend/assets/images/blog-1.jpg)') }}">
                                <img src="{{ asset('frontend/assets/images/blog-1.jpg') }}" alt="" />
                            </div>
                            <div class="entry entry-table">
                                <div class="date-wrapper">
                                    <div class="date">
                                        <span>MAR</span>
                                        <strong>08</strong>
                                        <span>2017</span>
                                    </div>
                                </div>
                                <div class="title">
                                    <h2 class="h5">The 3 Tricks that Quickly Became Rules</h2>
                                </div>
                            </div>
                            <div class="show-more">
                                <span class="btn btn-main btn-block">Read more</span>
                            </div>
                        </a>
                    </article>
                </div>

                <!-- === blog item === -->

                <div class="col-sm-4">
                    <article>
                        <a href="article.html">
                            <div class="image"
                                style="background-image:url({{ asset('frontend/assets/images/blog-2.jpg)') }}">
                                <img src="{{ asset('frontend/assets/images/blog-1.jpg') }}" alt="" />
                            </div>
                            <div class="entry entry-table">
                                <div class="date-wrapper">
                                    <div class="date">
                                        <span>MAR</span>
                                        <strong>03</strong>
                                        <span>2017</span>
                                    </div>
                                </div>
                                <div class="title">
                                    <h2 class="h5">Decorating When You're Starting Out or Starting Over</h2>
                                </div>
                            </div>
                            <div class="show-more">
                                <span class="btn btn-main btn-block">Read more</span>
                            </div>
                        </a>
                    </article>
                </div>

                <!-- === blog item === -->

                <div class="col-sm-4">
                    <article>
                        <a href="article.html">
                            <div class="image"
                                style="background-image:url({{ asset('frontend/assets/images/blog-8.jpg)') }}">
                                <img src="{{ asset('frontend/assets/images/blog-8.jpg') }}" alt="" />
                            </div>
                            <div class="entry entry-table">
                                <div class="date-wrapper">
                                    <div class="date">
                                        <span>MAR</span>
                                        <strong>01</strong>
                                        <span>2017</span>
                                    </div>
                                </div>
                                <div class="title">
                                    <h2 class="h5">What does your favorite dining chair say about you?</h2>
                                </div>
                            </div>
                            <div class="show-more">
                                <span class="btn btn-main btn-block">Read more</span>
                            </div>
                        </a>
                    </article>
                </div>

            </div> <!--/row-->
            <!-- === button more === -->

            <div class="wrapper-more">
                <a href="/blog" class="btn btn-main">View all posts</a>
            </div>

        </div> <!--/container-->
    </section>

    <!-- ========================  Instagram ======================== -->

    <section class="instagram">

        <!-- === instagram header === -->

        <header>
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-2 col-md-8 text-center">
                        <h2 class="h2 title">Follow us <i class="fa fa-instagram fa-2x"></i> Instagram </h2>
                        <div class="text">
                            <p>@InstaFurnitureFactory</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- === instagram gallery === -->

        <div class="gallery clearfix">
            <a class="item" href="#">
                <img src="{{ asset('frontend/assets/images/square-1.jpg') }}" alt="Alternate Text" />
            </a>
            <a class="item" href="#">
                <img src="{{ asset('frontend/assets/images/square-2.jpg') }}" alt="Alternate Text" />
            </a>
            <a class="item" href="#">
                <img src="{{ asset('frontend/assets/images/square-3.jpg') }}" alt="Alternate Text" />
            </a>
            <a class="item" href="#">
                <img src="{{ asset('frontend/assets/images/square-4.jpg') }}" alt="Alternate Text" />
            </a>
            <a class="item" href="#">
                <img src="{{ asset('frontend/assets/images/square-5.jpg') }}" alt="Alternate Text" />
            </a>
            <a class="item" href="#">
                <img src="{{ asset('frontend/assets/images/square-6.jpg') }}" alt="Alternate Text" />
            </a>

        </div> <!--/gallery-->

    </section>
@endsection
