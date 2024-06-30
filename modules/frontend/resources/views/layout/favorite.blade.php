@extends('frontend::main')
@section('content')
    <section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Customer page</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="#">Favorite</a></li>
                </ol>
            </div>
        </header>
    </section>
    <section class="products">

        <div class="container">

            <!-- === header title === -->



            <div class="row">

                <!-- === product-item === -->
                @php
                    $data = $favorites;
                @endphp
                @if ($data)
                    @foreach ($data as $dt)
                        <div class="col-md-4 col-xs-6">
                            <article>
                                <div class="info">
                                    <span class="add-favorite">
                                        <a href="/addfavorite/{{ $dt->id }}" data-title="Remove to favorites list"
                                            style="background-color: #e71d36;"><i class="icon icon-heart"
                                                style="background-color: #e71d36;"></i></a>
                                    </span>
                                    {{-- <span>
                                    <a href="#productid{{ $dt->id }}" class="mfp-open" data-title="Quick wiew"><i
                                            class="icon icon-eye"></i></a>
                                </span> --}}
                                </div>
                                <div class="btn btn-add">
                                    <a href="/add/{{ $dt->id }}"><i class="icon icon-cart">
                                        </i>
                                </div>
                                <div class="figure-grid">
                                    {{-- <span class="label label-warning">New</span> --}}
                                    <div class="image">
                                        @php
                                            // Giải mã chuỗi JSON thành mảng
                                            $contentArray = json_decode($dt->content, true);

                                            // Lấy đường dẫn hình ảnh từ mảng
                                            $imgThumbnail =
                                                $contentArray['imgThumbnail'] ?? 'frontend/assets/images/product-1.png';
                                        @endphp
                                        <a href="/productdetail/{{ $dt->id }}">
                                            <img src="{{ asset($imgThumbnail) }}" alt="" width="360" />
                                        </a>
                                    </div>
                                    <div class="text">
                                        <h2 class="title h4"><a
                                                href="/productdetail/{{ $dt->id }}">{{ $dt->name }}</a>
                                        </h2>
                                        <sup>$ {{ $dt->price }}</sup>
                                        <span class="description clearfix">{{ $dt->description }}</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                        <!-- ========================  Product info popup - quick view ======================== -->
                    @endforeach
                @endif

            </div> <!--/row-->
            <!-- === button more === -->

            <div class="wrapper-more">
                <a href="/shop" class="btn btn-main">View store</a>
            </div>

        </div> <!--/container-->
    </section>
@endsection
