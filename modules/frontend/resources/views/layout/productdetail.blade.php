@extends('frontend::main')
@section('content')
<!-- ========================  Main header ======================== -->

<section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
    <header>
        <div class="container">
            <h1 class="h2 title">{{$data->product_name}}</h1>
            <ol class="breadcrumb breadcrumb-inverted">
                <li><a href="/"><span class="icon icon-home"></span></a></li>
                <li><a href="/shop">Shop</a></li>
                <li><a class="active" href="/shop">Product overview</a></li>
            </ol>
        </div>
    </header>
</section>

<!-- ========================  Product ======================== -->
<section class="product">
    <div class="main">
        <div class="container">
            <div class="row product-flex">

                <!-- product flex is used only for mobile order -->
                <!-- on mobile 'product-flex-info' goes bellow gallery 'product-flex-gallery' -->

                <div class="col-md-4 col-sm-12 product-flex-info">
                    <div class="clearfix">

                        <!-- === product-title === -->

                        <h1 class="title" data-title="{{$data->category_name}}">{{$data->product_name}}
                            <!-- <small>La Linea de Lucco</small> -->
                        </h1>

                        <div class="clearfix">

                            <!-- === price wrapper === -->

                            <div class="price">
                                @if(isset($data->sale_percentage))
                                <span class="h3">$ {{$data->product_price-$data->product_price*($data->sale_percentage*0.01)}} <small>$ {{$data->product_price}}</small></span>
                                @else
                                <span class="h3">$ {{$data->product_price}}</span>
                                @endif
                            </div>
                            <hr />

                            <!-- === info-box === -->

                            <!-- <div class="info-box">
                                <span><strong>Maifacturer</strong></span>
                                <span>Brand name</span>
                            </div> -->

                            <!-- === info-box === -->

                            <div class="info-box">
                                <span><strong>Materials</strong></span>
                                <span>{{$data->materials_type}}</span>
                            </div>

                            <!-- === info-box === -->

                            <div class="info-box">
                                <span><strong>Availability</strong></span>
                                @if($data->total_stock > 0)
                                <span><i class="fa fa-check-square-o"></i> In stock({{$data->total_stock}})</span>
                                @else
                                <span><i class="fa fa-square-o"></i> Out of stock</span>
                                @endif
                            </div>

                            <hr />

                            <!-- <div class="info-box info-box-addto added">
                                <span><strong>Favourites</strong></span>
                                <span>
                                    <i class="add"><i class="fa fa-heart-o"></i> Add to favorites</i>
                                    <i class="added"><i class="fa fa-heart"></i> Remove from favorites</i>
                                </span>
                            </div> -->

                            <div class="info-box info-box-addto">
                                <span><strong>Wishlist</strong></span>
                                <span>
                                    <i class="add"><i class="fa fa-eye-slash"></i> Add to Watch list</i>
                                    <i class="added"><i class="fa fa-eye"></i> Remove from Watch list</i>
                                </span>
                            </div>

                            <!-- <div class="info-box info-box-addto">
                                <span><strong>Collection</strong></span>
                                <span>
                                    <i class="add"><i class="fa fa-star-o"></i> Add to Collection</i>
                                    <i class="added"><i class="fa fa-star"></i> Remove from Collection</i>
                                </span>
                            </div> -->

                            <hr />

                            <!-- === info-box === -->

                            <div class="info-box">
                                <span><strong>Colors</strong></span>
                                @php
                                // Chuyển màu sắc thành chữ thường
                                $colorClass = strtolower($data->materials_color);
                                @endphp
                                <span>
                                    <div style="background-color:{{$colorClass}}; width: 25px; height:25px;"></div>
                                </span>
                            </div>

                            <!-- === info-box === -->

                            <div class="info-box">
                                <span><strong>Choose size</strong></span>
                                @php
                                $rawString = $data->product_content;

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

                                <div class="product-colors clearfix">
                                    @foreach ($formattedArray as $formattedDimension)
                                    <span class="color-btn color-btn-biege size12345">{{ $formattedDimension }}</span>
                                    @endforeach
                                </div>
                            </div>

                        </div> <!--/clearfix-->
                    </div> <!--/product-info-wrapper-->
                </div> <!--/col-md-4-->
                <!-- === product item gallery === -->

                <div class="col-md-8 col-sm-12 product-flex-gallery">

                    <!-- === add to cart === -->

                    <button type="submit" class="btn btn-buy" data-text="Buy"></button>
                    <button type="submit" class="btn btn-add" data-text="Add"><span class="icon icon-cart"></span></button>


                    <!-- === product gallery === -->

                    <div class="owl-product-gallery open-popup-gallery">
                        <!-- <a href="{{ asset('frontend/assets/images/product-1.png')}}"><img src="{{ asset('frontend/assets/images/product-1.png')}}" alt="" height="500" /></a> -->
                        @php
                        // Giải mã chuỗi JSON thành mảng
                        $contentArray = json_decode($data->product_content, true);

                        // Lấy đường dẫn hình ảnh từ mảng
                        $imgThumbnail = $contentArray['imgThumbnail'] ?? 'frontend/assets/images/product-1.png';
                        @endphp
                        <a href="{{ asset($imgThumbnail)}}"><img src="{{ asset($imgThumbnail)}}" alt="" height="500" /></a>
                        @if(isset($data->images))
                        @php
                        // Lấy danh sách hình ảnh từ mảng
                        $images = explode(',', $data->images);
                        @endphp
                        @foreach($images as $image)
                        <a href="{{ asset($image)}}"><img src="{{ asset($image)}}" alt="" height="500" /></a>
                        @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- === product-info === -->

    <div class="info">
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <ul class="nav nav-tabs" role="tablist">
                        <!-- <li role="presentation" class="active">
                <a href="#designer" aria-controls="designer" role="tab" data-toggle="tab">
                    <i class="icon icon-user"></i>
                    <span>Collection</span>
                </a>
            </li> -->
                        <li role="presentation" class="active">
                            <a href="#design" aria-controls="design" role="tab" data-toggle="tab">
                                <i class="icon icon-sort-alpha-asc"></i>
                                <span>Specification</span>
                            </a>
                        </li>
                        <li role="presentation">
                            <a href="#comment" aria-controls="comment" role="tab" data-toggle="tab">
                                <i class="icon icon-thumbs-up"></i>
                                <span>Comment</span>
                            </a>
                        </li>
                    </ul>

                    <!-- === tab-panes === -->

                    <div class="tab-content">
                        {{--
                        <div role="tabpanel" class="tab-pane active" id="designer">
                            <div class="content">

                                <!-- === designer collection title === -->

                                <h3>Designers collection</h3>

                                <div class="products">
                                    <div class="row">

                                        <!-- === product-item === -->

                                        <div class="col-md-6 col-xs-6">
                                            <article>
                                                <div class="figure-grid">
                                                    <div class="image">
                                                        <a href="#productid1" class="mfp-open">
                                                            <img src="{{ asset('frontend/assets/images/product-1.png')}}" alt="" width="360" />
                        </a>
                    </div>
                    <div class="text">
                        <h4 class="title"><a href="product.html">Green corner</a></h4>
                        <sup>Designer collection</sup>
                        <span class="description clearfix">Gubergren amet dolor ea diam takimata consetetur facilisis blandit et aliquyam lorem ea duo labore diam sit et consetetur nulla</span>
                    </div>
                </div>
                </article>
            </div>

            <!-- === product-item === -->

            <div class="col-md-6 col-xs-6">
                <article>
                    <div class="figure-grid">
                        <div class="image">
                            <a href="#productid1" class="mfp-open">
                                <img src="{{ asset('frontend/assets/images/product-2.png')}}" alt="" width="360" />
                            </a>
                        </div>
                        <div class="text">
                            <h4 class="title"><a href="product.html">Laura</a></h4>
                            <sup>Designer collection</sup>
                            <span class="description clearfix">Gubergren amet dolor ea diam takimata consetetur facilisis blandit et aliquyam lorem ea duo labore diam sit et consetetur nulla</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- === product-item === -->

            <div class="col-md-6 col-xs-6">
                <article>
                    <div class="figure-grid">
                        <div class="image">
                            <a href="#productid1" class="mfp-open">
                                <img src="{{ asset('frontend/assets/images/product-3.png')}}" alt="" width="360" />
                            </a>
                        </div>
                        <div class="text">
                            <h4 class="title"><a href="product.html">Nude</a></h4>
                            <sup>Designer collection</sup>
                            <span class="description clearfix">Gubergren amet dolor ea diam takimata consetetur facilisis blandit et aliquyam lorem ea duo labore diam sit et consetetur nulla</span>
                        </div>
                    </div>
                </article>
            </div>

            <!-- === product-item === -->

            <div class="col-md-6 col-xs-6">
                <article>
                    <div class="figure-grid">
                        <div class="image">
                            <a href="#productid1" class="mfp-open">
                                <img src="{{ asset('frontend/assets/images/product-4.png')}}" alt="" width="360" />
                            </a>
                        </div>
                        <div class="text">
                            <h4 class="title"><a href="product.html">Aurora</a></h4>
                            <sup>Designer collection</sup>
                            <span class="description clearfix">Gubergren amet dolor ea diam takimata consetetur facilisis blandit et aliquyam lorem ea duo labore diam sit et consetetur nulla</span>
                        </div>
                    </div>
                </article>
            </div>

        </div> <!--/row-->
    </div> <!--/products-->
    </div> <!--/content-->
    </div> <!--/tab-pane-->--}}
    <!-- ============ tab #2 ============ -->

    <div role="tabpanel" class="tab-pane-active" id="design">
        <div class="content">
            <div class="row">
                <div class="col-md-4">
                    <!-- <h3>Dimensions</h3> -->
                    <p>
                        <img class="full-image" src="{{ asset('frontend/assets/images/specs.png')}}" alt="Alternate Text" width="350" />
                    </p>
                </div>
                <div class="col-md-8">
                    <h3>Product Description</h3>
                    <p>
                        {{$data->product_description}}
                    </p>
                    <hr />
                    <p>
                        Products are provided by all stores in the system.
                    </p>
                </div>

            </div> <!--/row-->
        </div> <!--/content-->
    </div> <!--/tab-pane-->
    <!-- ============ tab #3 ============ -->

    <div role="tabpanel" class="tab-pane" id="comment">

        <!-- ============ ratings ============ -->

        <div class="content">
            <h3>Comment</h3>

            <div class="row">

                <!-- === comments === -->

                <div class="col-md-12">
                    <div class="comments">

                        <!-- === rating === -->
                        {{--
                        <div class="rating clearfix">
                            <div class="rate-box">
                                <strong>Quality</strong>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>3</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>5</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <span>0</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>2</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>1</span>
                                </div>
                            </div>

                            <!-- rate -->
                            <div class="rate-box">
                                <strong>Design</strong>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <span>3</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <span>5</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <span>0</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>2</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star active"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>1</span>
                                </div>
                            </div>

                            <!-- rate -->
                            <div class="rate-box">
                                <strong>General</strong>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>3</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>5</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>0</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>2</span>
                                </div>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <span>1</span>
                                </div>
                            </div>

                        </div>--}}
                        <div class="rating clearfix"></div>
                        <div class="comment-wrapper">

                            <!-- === comment === -->

                            <div class="comment-block">
                                <div class="comment-user">
                                    <div><img src="{{ asset('frontend/assets/images/user-2.jpg')}}" alt="Alternate Text" width="70" /></div>
                                    <div>
                                        <h5>
                                            <span>John Doe</span>
                                            <span class="pull-right">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                            </span>
                                            <small>03.05.2017</small>
                                        </h5>
                                    </div>
                                </div>

                                <!-- comment description -->

                                <div class="comment-desc">
                                    <p>
                                        In vestibulum tellus ut nunc accumsan eleifend. Donec mattis cursus ligula, id
                                        iaculis dui feugiat nec. Etiam ut ante sed neque lacinia volutpat. Maecenas
                                        ultricies tempus nibh, sit amet facilisis mauris vulputate in. Phasellus
                                        tempor justo et mollis facilisis. Donec placerat at nulla sed suscipit. Praesent
                                        accumsan, sem sit amet euismod ullamcorper, justo sapien cursus nisl, nec
                                        gravida
                                    </p>
                                </div>

                                <!-- comment reply -->

                                <div class="comment-block">
                                    <div class="comment-user">
                                        <div><img src="{{ asset('frontend/assets/images/user-2.jpg')}}" alt="Alternate Text" width="70" /></div>
                                        <div>
                                            <h5>Administrator<small>08.05.2017</small></h5>
                                        </div>
                                    </div>
                                    <div class="comment-desc">
                                        <p>
                                            Curabitur sit amet elit quis tellus tincidunt efficitur. Cras lobortis id
                                            elit eu vehicula. Sed porttitor nulla vitae nisl varius luctus. Quisque
                                            a enim nisl. Maecenas facilisis, felis sed blandit scelerisque, sapien
                                            nisl egestas diam, nec blandit diam ipsum eget dolor. Maecenas ultricies
                                            tempus nibh, sit amet facilisis mauris vulputate in.
                                        </p>
                                    </div>
                                </div>
                                <!--/reply-->
                            </div>

                            <!-- === comment === -->

                            <div class="comment-block">
                                <div class="comment-user">
                                    <div><img src="{{ asset('frontend/assets/images/user-2.jpg')}}" alt="Alternate Text" width="70" /></div>
                                    <div>
                                        <h5>
                                            <span>John Doe</span>
                                            <span class="pull-right">
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star active"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </span>
                                            <small>03.05.2017</small>
                                        </h5>
                                    </div>
                                </div>
                                <div class="comment-desc">
                                    <p>
                                        Cras lobortis id elit eu vehicula. Sed porttitor nulla vitae nisl varius luctus.
                                        Quisque a enim nisl. Maecenas facilisis, felis sed blandit scelerisque, sapien
                                        nisl egestas diam, nec blandit diam ipsum eget dolor. In vestibulum tellus
                                        ut nunc accumsan eleifend. Donec mattis cursus ligula, id iaculis dui feugiat
                                        nec. Etiam ut ante sed neque lacinia volutpat. Maecenas ultricies tempus
                                        nibh, sit amet facilisis mauris vulputate in. Phasellus tempor justo et mollis
                                        facilisis. Donec placerat at nulla sed suscipit. Praesent accumsan, sem sit
                                        amet euismod ullamcorper, justo sapien cursus nisl, nec gravida
                                    </p>
                                </div>
                            </div>

                        </div><!--/comment-wrapper-->

                        <div class="comment-header">
                            <a href="#" class="btn btn-clean-dark">12 comments</a>
                        </div> <!--/comment-header-->
                        <!-- === add comment === -->

                        <div class="comment-add">

                            <div class="comment-reply-message">
                                <div class="h3 title">Leave a Reply </div>
                                <p>Your email address will not be published.</p>
                            </div>

                            <form action="#" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" value="" placeholder="Your Name" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" value="" placeholder="Your Email" />
                                </div>
                                <div class="form-group">
                                    <textarea rows="10" class="form-control" placeholder="Your comment"></textarea>
                                </div>
                                <div class="clearfix text-center">
                                    <a href="#" class="btn btn-main">Add comment</a>
                                </div>
                            </form>

                        </div><!--/comment-add-->
                    </div> <!--/comments-->
                </div>


            </div> <!--/row-->
        </div> <!--/content-->
    </div> <!--/tab-pane-->
    </div> <!--/tab-content-->
    </div>
    </div> <!--/row-->
    </div> <!--/container-->
    </div> <!--/info-->
</section>
@endsection