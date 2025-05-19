@extends('frontend::main')
@section('content')
    @php
        $slideshowImages = $globalSettings['slideshow_images'] ?? [];
        $backgroundImage = count($slideshowImages) > 0 ? asset($slideshowImages[0]['image']) : asset('frontend/assets/images/gallery-3.jpg');
    @endphp
   <section class="main-header" style="background-image: url('{{ $backgroundImage }}')">
        <header>
            <div class="container">
                <h1 class="h2 title">Shop</h1>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="/shop">Product</a></li>
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

            <div class="owl-icons">
                @foreach ($globalCategory as $c)
                    <a class="categorySearch" id="{{ $c->id }}">
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

                        <!--Type-->
                        <div class="filter-box">
                            <div class="title">
                                Type
                            </div>
                            <div class="filter-content">
                                <span class="checkbox">
                                    <input type="radio" name="radiogroup-type" id="typeIdAll" checked="checked">
                                    <label for="typeIdAll">All <i>({{ count($globalCategory) }})</i></label>
                                </span>
                                @foreach ($globalCategory as $c)
                                    <span class="checkbox">
                                        <input type="radio" name="radiogroup-type" id="typeId{{ $c->id }}">
                                        <label for="typeId{{ $c->id }}">{{ $c->name }} </label>
                                    </span>
                                @endforeach
                                {{-- <span class="checkbox">
                                    <input type="radio" name="radiogroup-type" id="typeId1">
                                    <label for="typeId1">Sofa <i>(20)</i></label>
                                </span> --}}

                            </div>
                        </div> <!--/filter-box-->
                        <!--Material-->
                        <div class="filter-box">
                            <div class="title">
                                Material
                            </div>
                            <div class="filter-content">
                                <span class="checkbox">
                                    <input type="radio" name="radiogroup-material" id="matIdAll" checked>
                                    <label for="matIdAll">All<i>({{ count($globalMaterials) }})</i></label>
                                </span>
                                @foreach ($globalMaterials as $m)
                                    <span class="checkbox">
                                        <input type="radio" name="radiogroup-material" id="matId{{ $m->id }}">
                                        <label for="matId{{ $m->id }}">{{ $m->name }}</label>
                                    </span>
                                @endforeach
                                {{-- <span class="checkbox">
                                    <input type="radio" name="radiogroup-material" id="matId1">
                                    <label for="matId1">Blend <i>(11)</i></label>
                                </span> --}}

                            </div>
                        </div> <!--/filter-box-->
                        <!--close filters on mobile / update filters-->
                        <div class="toggle-filters-close btn btn-main" id="Updatesearch">
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
                            @foreach ($data as $dt)
                                <div class="col-md-6 col-xs-6">

                                    <article>
                                        <div class="info">

                                            @if (isset($favorites) && isset($fas))
                                                @if (in_array($dt->product_id, $fas))
                                                    <span class="add-favorite">
                                                        <a href="/addfavorite/{{ $dt->product_id }}"
                                                            data-title="Remove to favorites list"
                                                            style="background-color: #e71d36;">
                                                            <i class="icon icon-heart"
                                                                style="background-color: #e71d36;"></i>
                                                        </a>
                                                    </span>
                                                @else
                                                    <span class="add-favorite">
                                                        <a href="/addfavorite/{{ $dt->product_id }}"
                                                            data-title="Add to favorites"
                                                            data-title-added="Added to favorites list">
                                                            <i class="icon icon-heart"></i>
                                                        </a>
                                                    </span>
                                                @endif
                                            @else
                                                <span class="add-favorite">
                                                    <a href="/addfavorite/{{ $dt->product_id }}"
                                                        data-title="Add to favorites"
                                                        data-title-added="Added to favorites list">
                                                        <i class="icon icon-heart"></i>
                                                    </a>
                                                </span>
                                            @endif

                                            <span>
                                                <a href="#productid{{ $dt->product_id }}" class="mfp-open"
                                                    data-title="Quick wiew"><i class="icon icon-eye"></i></a>
                                            </span>
                                        </div>
                                        <a href="#add{{ $dt->product_id }}" class="btn btn-add mfp-open"><i
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
                                                    $contentArray = json_decode($dt->product_content, true);

                                                    // Lấy đường dẫn hình ảnh từ mảng
                                                    $imgThumbnail =
                                                        $contentArray['imgThumbnail'] ??
                                                        'frontend/assets/images/product-1.png';
                                                    // Đường dẫn thực tế trên server
                                                    $imagePath = public_path($imgThumbnail);

                                                    // Kiểm tra hình có tồn tại không
                                                    $imgSrc = file_exists($imagePath) ? asset($imgThumbnail) : asset('frontend/assets/images/product-2.png');
                                                @endphp
                                                <a href="/productdetail/{{ $dt->product_slug }}">
                                                    <img src="{{ asset($imgSrc) }}" alt="{{ $dt->product_name }}" width="360" height="auto" loadding="lazy"/>
                                                </a>
                                            </div>
                                            <div class="text">
                                                <h2 class="title h4"><a
                                                        href="#productid{{ $dt->product_id }}">{{ $dt->product_name }}</a>
                                                </h2>
                                                @if (isset($dt->sale_percentage))
                                                    <sub>$ {{ $dt->product_price }}</sub><br>
                                                    <sup>$
                                                        {{ $dt->product_price - $dt->product_price * ($dt->sale_percentage * 0.01) }}</sup>
                                                @else
                                                    <sub style="text-decoration: none;">$ {{ $dt->product_price }}</sub>
                                                @endif

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
                                            <div class="h1 title">{{ $dt->product_name }}
                                                <small>{{ $dt->category_name }}</small>
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
                                                        <span class="h3">$ {{ $dt->product_price }},00</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="popup-cell">
                                                <div class="popup-buttons">
                                                    <a href="/productdetail/{{ $dt->product_slug }}"><span
                                                            class="icon icon-eye"></span> <span class="hidden-xs">View
                                                            more</span></a>
                                                    <a href="/buynow/{{ $dt->product_id }}"><span
                                                            class="icon icon-cart"></span> <span class="hidden-xs">Buy
                                                            Now</span></a>
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
                                            <div class="h1 title">{{ $dt->product_name }}
                                                <small>{{ $dt->category_name }}</small>
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
                                                        <span class="h3">$ {{ $dt->product_price }},00</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="popup-cell">
                                                <div class="popup-buttons">
                                                    <a href="/add/{{ $dt->product_id }}"><span
                                                            class="icon icon-cart"></span><span class="hidden-xs">Add to
                                                            cart</span></a>
                                                    <a href="/buynow/{{ $dt->product_id }}"><span
                                                            class="icon icon-cart"></span><span class="hidden-xs">Buy
                                                            Now</span></a>
                                                </div>
                                            </div>
                                        </div>

                                    </div> <!--/product-->
                                </div> <!--popup-main-->
                            @endforeach
                        </div>
                    </div>
                    <!--Pagination-->
                    <div class="pagination-wrapper" id="pagination">
                        {{ $data->appends(request()->all())->links('frontend::vendor.pagination.custom') }}
                    </div>
                </div> <!--/product items-->

            </div><!--/row-->

        </div><!--/container-->
    </section>
    <script>
        document.getElementById('Updatesearch').addEventListener('click', function() {
            fetchProducts(); // Tải trang đầu tiên khi cập nhật bộ lọc
            document.getElementById('pagination').innerHTML = '';
        });

        function fetchProducts() {
            let selectedPrice = document.getElementById('range-price-slider').value;
            let selectedType = document.querySelector('input[name="radiogroup-type"]:checked').id;
            selectedType = selectedType.replace('typeId', '');
            let selectedMaterial = document.querySelector('input[name="radiogroup-material"]:checked').id;
            selectedMaterial = selectedMaterial.replace('matId', '');
            fetch(`/filter-products`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        price: selectedPrice,
                        type: selectedType,
                        material: selectedMaterial
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
                // console.log(product.product_content, "kkk");
                let contentArray = JSON.parse(product.product_content);
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
                                    <a href="/removefavorite/${product.product_id}" data-title="Remove to favorites list" style="background-color: #e71d36;">
                                        <i class="icon icon-heart" style="background-color: #e71d36;"></i>
                                    </a>
                                </span>` :
                                `<span class="add-favorite">
                                    <a href="/addfavorite/${product.product_id}" data-title="Add to favorites" data-title-added="Added to favorites list">
                                        <i class="icon icon-heart"></i>
                                    </a>
                                </span>`
                            }
                        </div>
                        <a href="/add/${product.product_id}" class="btn btn-add mfp-open"><i class="icon icon-cart"></i></a>
                        <div class="figure-grid">
                            ${ product.sale_percentage ?
                                `<span class="label label-info">-${product.sale_percentage}%</span>` :
                                ''
                            }
                            <div class="image">

                                <a href="/productdetail/${product.product_slug}">
                                    <img id="product-image-${index}" alt="" width="360" height"auto"/>
                                </a>
                            </div>
                            <div class="text">
                                <h2 class="title h4"><a href="#productid${product.product_id}">${product.product_name}</a></h2>
                                ${ product.sale_percentage ?
                                    `<sub>$ ${product.product_price}</sub><br>
                                    <sup>$ ${product.product_price - (product.product_price * (product.sale_percentage * 0.01))}</sup>` :
                                    `<sub style="text-decoration: none;">$ ${product.product_price}</sub>`
                                }
                                <span class="description clearfix">${product.product_description ? product.product_description : ''}</span>
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
    <script>
        // Lấy tất cả các thẻ có class "categorySearch" và thêm sự kiện click
        $('.categorySearch').on('click', function() {
            // Hành động khi click vào phần tử

            fecthCategorys(this.id); // Tải trang đầu tiên khi cập nhật bộ lọc
            document.getElementById('pagination').innerHTML = '';
        });

        function fecthCategorys(id) {
            // console.log(id);

            fetch(`/filter-category`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        type: id,
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
                        updateProduct(data.products.data); // Cập nhật danh sách sản phẩm
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function updateProduct(products) {
            let productListContainer = document.getElementById('product-list');
            productListContainer.innerHTML = '';

            products.forEach((product, index) => {
                // Create product item container
                let productItem = document.createElement('div');
                productItem.className = 'col-md-6 col-xs-6';
                let contentArray = JSON.parse(product.product_content);
                let baseAssetPath = "{{ asset('') }}";

                // Đường dẫn ảnh
                let img = contentArray.imgThumbnail || 'frontend/assets/images/product-1.png';
                let imgSrc = baseAssetPath + img;
                // Construct product item HTML
                productItem.innerHTML = `
                    <article>
                        <div class="info">
                            ${ product.favorites ?
                                `<span class="add-favorite">
                                    <a href="/removefavorite/${product.product_id}" data-title="Remove to favorites list" style="background-color: #e71d36;">
                                        <i class="icon icon-heart" style="background-color: #e71d36;"></i>
                                    </a>
                                </span>` :
                                `<span class="add-favorite">
                                    <a href="/addfavorite/${product.product_id}" data-title="Add to favorites" data-title-added="Added to favorites list">
                                        <i class="icon icon-heart"></i>
                                    </a>
                                </span>`
                            }
                        </div>
                        <a href="/add/${product.product_id}" class="btn btn-add mfp-open"><i class="icon icon-cart"></i></a>
                        <div class="figure-grid">
                            ${ product.sale_percentage ?
                                `<span class="label label-info">-${product.sale_percentage}%</span>` :
                                ''
                            }
                            <div class="image">

                                <a href="/productdetail/${product.product_slug}">
                                    <img id="product-image-${index}" alt="" width="360" height=auto />
                                </a>
                            </div>
                            <div class="text">
                                <h2 class="title h4"><a href="#productid${product.product_id}">${product.product_name}</a></h2>
                                ${ product.sale_percentage ?
                                    `<sub>$ ${product.product_price}</sub><br>
                                    <sup>$ ${product.product_price - (product.product_price * (product.sale_percentage * 0.01))}</sup>` :
                                    `<sub style="text-decoration: none;">$ ${product.product_price}</sub>`
                                }
                                <span class="description clearfix">${product.product_description ? product.product_description : ''}</span>
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
