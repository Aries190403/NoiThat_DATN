@extends('frontend::main')
@section('content')
    <!-- ========================  Main header ======================== -->

    <section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Checkout</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="index.html"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="checkout-1.html">Cart items</a></li>
                    <li><a href="checkout-2.html">Delivery</a></li>
                    <li><a href="checkout-3.html">Payment</a></li>
                    <li><a href="checkout-4.html">Receipt</a></li>
                </ol>
            </div>
        </header>
    </section>

    <!-- ========================  Checkout ======================== -->

    <div class="step-wrapper">
        <div class="container">

            <div class="stepper">
                <ul class="row">
                    <li class="col-md-3 active">
                        <span data-text="Cart items"></span>
                    </li>
                    <li class="col-md-3">
                        <span data-text="Delivery"></span>
                    </li>
                    <li class="col-md-3">
                        <span data-text="Payment"></span>
                    </li>
                    <li class="col-md-3">
                        <span data-text="Receipt"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <section class="checkout">

        <div class="container">

            <header class="hidden">
                <h3 class="h3 title">Checkout - Step 1</h3>
            </header>

            <!-- ========================  Cart wrapper ======================== -->

            <div class="cart-wrapper">
                <!--cart header -->
                <div class="cart-block cart-block-header clearfix">
                    <div><span>Product</span></div>
                    <div><span>&nbsp;</span></div>
                    <div><span>Quantity</span></div>
                    <div class="text-right"><span>Price</span></div>
                </div>

                <!--cart items-->
                <div class="clearfix">
                    <div id="notification" style="display: none; color: green;"></div>
                    <div id="error-notification" style="display: none; color: red;"></div>
                    @foreach ($cart as $c)
                        <div class="cartItemCheck">
                            <div class="cart-block cart-block-item clearfix" data-id="{{ $c->id }}">
                                <div class="image">
                                    @php
                                        $contentArray = json_decode($c->content, true);
                                        $imgThumbnail =
                                            $contentArray['imgThumbnail'] ?? 'frontend/assets/images/product-1.png';
                                    @endphp
                                    <a href="/productdetail/{{ $c->id }}">
                                        <img src="{{ asset($imgThumbnail) }}" alt="" />
                                    </a>
                                </div>
                                <div class="title">
                                    <div class="h4"><a href="/productdetail/{{ $c->id }}">{{ $c->name }}</a>
                                    </div>
                                    {{-- <div>Green corner</div> --}}
                                </div>
                                <div class="quantity">
                                    <input type="hidden" value="{{ $c->quantity }}" class="form-control form-quantity"
                                        min="1" max="3" data-price="{{ $c->price }}"
                                        data-sale="{{ $c->sale_percentage ?? 0 }}" oninput="updateCartItem(this)">
                                    </input>
                                    <Label>{{ $c->quantity }}</Label>
                                </div>
                                <div class="price">
                                    @if (isset($c->sale_percentage))
                                        <span class="final h3">$
                                            {{ $c->price - $c->price * ($c->sale_percentage * 0.01) }}</span>
                                        <span class="discount">$ {{ $c->price }}</span>
                                    @else
                                        <span class="final h3">$ {{ $c->price }}</span>
                                    @endif
                                </div>
                                {{-- <span class="icon icon-cross icon-delete" data-id="{{ $c->id }}"></span> --}}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!--cart prices -->
                <div class="clearfix">
                    <div class="cart-block cart-block-footer clearfix">
                        <div><strong>VAT</strong></div>
                        <div><span id="vatprice">$ 0.00</span></div>
                    </div>
                </div>

                <!--cart final price -->
                <div class="clearfix">
                    <div class="cart-block cart-block-footer cart-block-footer-price clearfix">
                        <div>
                            {{-- <span class="checkbox">
                                    <input type="checkbox" id="couponCodeID"> --}}
                            <form action="/checkcoupon" method="post">
                                {{-- <label for="couponCodeID">Promo code</label> --}}
                                <input id="couponCodeID" type="text" class="form-control" value=""
                                    placeholder="Enter your coupon code" required style="width: 150px;" />
                                <button type="submit" class="form-control">Check</button>
                            </form>
                            {{-- </span> --}}
                        </div>
                        <div>
                            <div class="h2 title" id="totalprice">$ 0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Cart navigation -->
                <div class="clearfix">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="/shop" class="btn btn-clean-dark"><span class="icon icon-chevron-left"></span> Shop
                                more</a>
                        </div>
                        <div class="col-xs-6 text-right">
                            <a href="/checkout-2" class="btn btn-main"><span class="icon icon-cart"></span> Proceed to
                                delivery</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
            <script>
                $(document).ready(function() {
                    function updateCart() {
                        var total = 0;
                        var vatRate = 0.005; // Example VAT rate (10%)

                        $('.cartItemCheck').each(function(index) {
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
                        $('#vatprice').text('$' + vat.toFixed(2));

                        // Update Total
                        var totalPrice = total + vat;
                        $('#totalprice').text('$' + totalPrice.toFixed(2));
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
                document.addEventListener("DOMContentLoaded", function() {
                            // Bắt sự kiện khi người dùng nhấn vào biểu tượng xóa
                            document.querySelectorAll('.icon-delete').forEach(function(icon) {
                                icon.addEventListener('click', function() {
                                    let productId = icon.getAttribute('data-id');

                                    // Gửi yêu cầu AJAX để xóa sản phẩm
                                    deleteProduct(productId);
                                });
                            });

                            // Hàm xử lý xóa sản phẩm bằng AJAX
                            function deleteProduct(productId) {
                                // Tạo đối tượng XMLHttpRequest
                                let xhr = new XMLHttpRequest();
                                let url = '/delete-product'; // Đường dẫn tới route xử lý xóa sản phẩm

                                // Thiết lập phương thức và URL
                                xhr.open('POST', url, true);
                                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                                // Xử lý kết quả trả về từ máy chủ
                                xhr.onload = function() {
                                    if (xhr.status === 200) {
                                        // Xử lý khi xóa thành công (cập nhật giao diện, v.v.)
                                        console.log('Product deleted successfully');
                                        // Cập nhật lại giao diện sau khi xóa (nếu cần)
                                        // Ví dụ: remove sản phẩm khỏi giao diện ngay sau khi xóa
                                        let cartItem = document.querySelector(`.cart-block-item[data-id="${productId}"]`);
                                        if (cartItem) {
                                            cartItem.remove();
                                        }
                                        // Cập nhật tổng tiền
                                        updateCart();
                                    } else {
                                        console.error('Error deleting product');
                                    }
                                };

                                // Gửi yêu cầu AJAX
                                xhr.send('id=' + productId);
                            }
            </script>
    </section>
@endsection
