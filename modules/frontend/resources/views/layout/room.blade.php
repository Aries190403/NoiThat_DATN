@extends('frontend::main')
@section('content')
    <section class="main-header" style="background-image:url({{ asset($imgThumbnail) }}">
        <header>
            <div class="container">
                <h1 class="h2 title">Shop</h1>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="" href="/shop">Product</a></li>
                    <li><a class="active" href="#">Room</a></li>
                </ol>
            </div>
        </header>
    </section>

    <!-- ========================  Icons slider ======================== -->

    <section class="owl-icons-wrapper">

        <!-- === header === -->

        <header class="hidden">
            <h2>Product categories</h2>
        </header>

        <div class="container">

            {{-- <div class="owl-icons">
                @foreach ($roomCategory as $c)
                    <a class="categoryroomSearch" id="{{ $c->id }}">
                        @php
                            $icon = json_decode($c->content, true);
                        @endphp
                        <figure>
                            <i class="f-icon {{ $icon['icon'] }}"></i>
                            <figcaption>{{ $c->name }}</figcaption>
                        </figure>
                    </a>
                @endforeach
            </div> <!--/owl-icons--> --}}
        </div> <!--/container-->
    </section>

    <!-- ======================== Products ======================== -->

    <section class="products">
        <div class="container">

            <header class="hidden">
                <h3 class="h3 title">Product category grid</h3>
            </header>

            <div class="row">

                <!-- === product-filters === -->

                <div class="col-md-3 col-xs-12">
                    <div class="filters">
                        <!--Price-->
                        <div class="filter-box active">
                            <div class="title">Price</div>
                            <div class="filter-content">
                                <div class="price-filter">
                                    <input type="text" id="range-price-slider" value="" name="range" />
                                </div>
                            </div>
                        </div>

                        <div class="toggle-filters-close btn btn-main" id="Updateroomsearch">
                            Update search
                        </div>
                    </div> <!--/filters-->
                </div>

                <!--product items-->

                <div class="col-md-9 col-xs-12">

                    <div class="row">
                        @php
                            if (isset($favorites)) {
                                foreach ($favorites as $item) {
                                    $fas[] = $item->id;
                                }
                            }
                        @endphp
                        <div id="product-list">
                            @if (isset($data))
                                @foreach ($data as $dt)
                                    <div class="col-md-6 col-xs-6">
                                        @dump($dt->id)

                                        <article>
                                            <div class="info">

                                                @if (isset($favorites) && isset($fas))
                                                    @if (in_array($dt->id, $fas))
                                                        <span class="add-favorite">
                                                            <a href="/addfavorite/{{ $dt->id }}"
                                                                data-title="Remove to favorites list"
                                                                style="background-color: #e71d36;">
                                                                <i class="icon icon-heart"
                                                                    style="background-color: #e71d36;"></i>
                                                            </a>
                                                        </span>
                                                    @else
                                                        <span class="add-favorite">
                                                            <a href="/addfavorite/{{ $dt->id }}"
                                                                data-title="Add to favorites"
                                                                data-title-added="Added to favorites list">
                                                                <i class="icon icon-heart"></i>
                                                            </a>
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="add-favorite">
                                                        <a href="/addfavorite/{{ $dt->id }}"
                                                            data-title="Add to favorites"
                                                            data-title-added="Added to favorites list">
                                                            <i class="icon icon-heart"></i>
                                                        </a>
                                                    </span>
                                                @endif

                                                {{-- <span>
                                                <a href="#productid{{ $dt->id }}" class="mfp-open"
                                                    data-title="Quick wiew"><i class="icon icon-eye"></i></a>
                                            </span> --}}
                                            </div>
                                            <a href="/add/{{ $dt->id }}" class="btn btn-add mfp-open"><i
                                                    class="icon icon-cart">
                                                </i></a>
                                            </a>
                                            <div class="figure-grid">
                                                @if (isset($dt->sale_percentage))
                                                    <span class="label label-info">-{{ $dt->sale_percentage }}%</span>
                                                @endif
                                                <div class="image">
                                                    @php
                                                        // Giải mã chuỗi JSON thành mảng
                                                        $contentArray = json_decode($dt->content, true);

                                                        // Lấy đường dẫn hình ảnh từ mảng
                                                        $imgThumbnail =
                                                            $contentArray['imgThumbnail'] ??
                                                            'frontend/assets/images/product-1.png';
                                                    @endphp
                                                    <a href="/productdetail/{{ $dt->id }}">
                                                        <img src="{{ asset($imgThumbnail) }}" alt=""
                                                            width="360" />
                                                    </a>
                                                </div>
                                                <div class="text">
                                                    <h2 class="title h4"><a
                                                            href="/productdetail/{{ $dt->id }}">{{ $dt->name }}</a>
                                                    </h2>
                                                    @if (isset($dt->sale_percentage))
                                                        <sub>$ {{ $dt->price }}</sub>
                                                        <sup>$
                                                            {{ $dt->price - $dt->price * ($dt->sale_percentage * 0.01) }}</sup>
                                                    @else
                                                        <sub style="text-decoration: none;">$ {{ $dt->price }}</sub>
                                                    @endif

                                                    <span class="description clearfix">{{ $dt->description }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div> <!--/product items-->

            </div><!--/row-->

        </div><!--/container-->
    </section>
    <script>
        document.getElementById('Updatesearch').addEventListener('click', function() {
            fetchProducts(); // Tải trang đầu tiên khi cập nhật bộ lọc
        });

        function fetchProducts() {
            let selectedPrice = document.getElementById('range-price-slider').value;
            // Lấy đường dẫn URL hiện tại
            var currentUrl = window.location.href;

            // Tách phần path của URL
            var path = window.location.pathname;

            // Tách các phần của đường dẫn
            var parts = path.split('/');

            // Lấy giá trị tham số id
            var roomId = parts[parts.length - 1];

            fetch(`/filter-roomproducts/${roomId}`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        price: selectedPrice,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.products.data.length === 0) {
                        // alert('No products found matching the selected criteria.');
                        document.getElementById('product-list').innerHTML = `
                        <div class=row>
                        <h4 style="text-align:center;">No products found matching the selected criteria.</h4></div>`;
                    } else {
                        updateProductList(data.products.data); // Cập nhật danh sách sản phẩm
                    }
                })
                .catch(error => console.error('Error:', error, selectedPrice, selectedType, selectedMaterial));
        }

        function updateProductList(products) {
            let productListContainer = document.getElementById('product-list');
            productListContainer.innerHTML = '';

            products.forEach((product, index) => {
                // Create product item container
                let productItem = document.createElement('div');
                productItem.className = 'col-md-6 col-xs-6';
                // console.log(product.content, "kkk");
                let contentArray = JSON.parse(product.content);
                let baseAssetPath = "{{ asset('') }}";

                // Đường dẫn ảnh
                let img = contentArray.imgThumbnail || 'frontend/assets/images/product-1.png';
                let imgSrc = baseAssetPath + img;

                // Thêm vào HTML

                // Construct product item HTML
                productItem.innerHTML = `
        <article>
            <div class="info">
                ${ product.favorites ?
                    `<span class="add-favorite">
                                                                                                                                                                                                                                                                                                            <a href="/removefavorite/${product.id}" data-title="Remove to favorites list" style="background-color: #e71d36;">
                                                                                                                                                                                                                                                                                                                <i class="icon icon-heart" style="background-color: #e71d36;"></i>
                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                        </span>` :
                    `<span class="add-favorite">
                                                                                                                                                                                                                                                                                                            <a href="/addfavorite/${product.id}" data-title="Add to favorites" data-title-added="Added to favorites list">
                                                                                                                                                                                                                                                                                                                <i class="icon icon-heart"></i>
                                                                                                                                                                                                                                                                                                            </a>
                                                                                                                                                                                                                                                                                                        </span>`
                }
            </div>
            <a href="/add/${product.id}" class="btn btn-add mfp-open"><i class="icon icon-cart"></i></a>
            <div class="figure-grid">
                ${ product.sale_percentage ?
                    `<span class="label label-info">-${product.sale_percentage}%</span>` :
                    ''
                }
                <div class="image">

                    <a href="/productdetail/${product.id}">
                        <img id="product-image-${index}" alt="" width="360" />
                    </a>
                </div>
                <div class="text">
                    <h2 class="title h4"><a href="#productid${product.id}">${product.name}</a></h2>
                    ${ product.sale_percentage ?
                        `<sub>$ ${product.price}</sub>
                                                                                                                                                                                                                                                                                                            <sup>$ ${product.price - (product.price * (product.sale_percentage * 0.01))}</sup>` :
                        `<sub style="text-decoration: none;">$ ${product.price}</sub>`
                    }
                    <span class="description clearfix">${product.description ? product.description : ''}</span>
                </div>
            </div>
        </article>`;

                // Append elements to the container
                productListContainer.appendChild(productItem);
                let imgElement = document.getElementById(`product-image-${index}`);
                if (imgElement) {
                    imgElement.src = imgSrc;
                } else {
                    console.error(`Element with ID 'product-image-${index}' not found.`);
                }
            });

        }
    </script>
@endsection
