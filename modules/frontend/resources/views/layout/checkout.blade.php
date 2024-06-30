@extends('frontend::main')
@section('content')
    <!-- ========================  Main header ======================== -->

    <section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Checkout</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="/checkout">Cart items</a></li>
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
                {{-- <div class="clearfix">
                    <div class="cart-block cart-block-footer clearfix">
                        <div><strong>VAT</strong></div>
                        <div><span id="vatprice">$ 0.00</span></div>
                    </div>
                </div> --}}

                <!--cart final price -->
                <div class="clearfix">
                    <div class="cart-block cart-block-footer cart-block-footer-price clearfix">
                        <div>
                            {{-- <span class="checkbox">
                                    <input type="checkbox" id="couponCodeID"> --}}
                            <form id="couponForm" action="{{ route('user-check-coupon') }}" method="get">
                                {{-- <label for="couponCodeID">Promo code</label> --}}
                                <input id="couponCodeID" type="text" class="form-control" name="code"
                                    placeholder="Enter your coupon code" required style="width: 150px;" />
                                <button type="submit" class="form-control btn btn-main" style="width: 150px;">Add</button>
                            </form>
                            {{-- </span> --}}
                        </div>
                        <div>
                            <h5 id="originalPrice" style="display: none;">giá gốc $0.00</h5>
                            <h5 id="discountPrice" style="color: crimson; display: none;">giảm giá - $0.00</h5>
                            <div class="h2 title" id="totalprice">$0.00</div>
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
                            <a href="/checkout-2" id="checkout-coupon" class="btn btn-main"><span
                                    class="icon icon-cart"></span> Proceed to
                                delivery</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- js cập nhật số tiền và add voucher --}}
            <script>
                $(document).ready(function() {
                    function updateCart(discountAmount = 0, percentDiscount = 0) {
                        var total = 0;
                        var vatRate = 0; // Example VAT rate (0.5%)

                        $('.cartItemCheck').each(function(index) {
                            var quantity = parseInt($(this).find('.form-quantity').val());
                            var price = parseFloat($(this).find('.form-quantity').data('price'));
                            var salePercentage = parseFloat($(this).find('.form-quantity').data('sale'));

                            var finalPrice = price; // Start with base price

                            if (salePercentage > 0) {
                                finalPrice = price - (price * (salePercentage / 100));
                            }

                            var subtotal = finalPrice * quantity;
                            total += subtotal;

                            $(this).find('.price .final').text('$' + finalPrice.toFixed(2));
                        });

                        var vat = total * vatRate;
                        $('#vatprice').text('$' + vat.toFixed(2));

                        var moneydiscount = total * (percentDiscount / 100);
                        var totalPrice = total + vat - moneydiscount;
                        var giamgia = moneydiscount;

                        if (moneydiscount > discountAmount) {
                            totalPrice = total - discountAmount;
                            giamgia = discountAmount;
                        }

                        console.log(percentDiscount, discountAmount);
                        $('#totalprice').text('$' + totalPrice.toFixed(2));

                        if (discountAmount > 0) {
                            $('#originalPrice').text('$' + total.toFixed(2)).show();
                            $('#discountPrice').text('- $' + giamgia.toFixed(2)).show();
                        }
                    }

                    updateCart();

                    $('#couponForm').on('submit', function(event) {
                        event.preventDefault();
                        var code = $('#couponCodeID').val();

                        $.ajax({
                            url: $(this).attr('action'),
                            type: 'get',
                            data: {
                                code: code
                            },
                            success: function(response) {
                                if (response.coupon) {
                                    var discount = response.coupon.discount_money;
                                    var percentDiscount = response.coupon.discount;
                                    updateCart(discount, percentDiscount);
                                } else {
                                    // alert(response.error || 'Voucher is expired or incorrect');
                                    $(document).ready(function() {
                                        $.toast({
                                            heading: 'Notification !',
                                            text: "Voucher is expired or incorrect",
                                            showHideTransition: 'slide', // It can be plain, fade or slide
                                            icon: 'error',
                                            hideAfter: 4000, // `false` to make it sticky or time in milliseconds to hide after
                                            position: 'top-center',
                                            stack: false, // Ensure that toasts stack properly
                                            loaderBg: 'white', // Background color of the toast loader
                                            bgColor: '#ff0000', // Background color of the toast
                                            textColor: 'white', // Text color
                                        });
                                    });
                                }
                            },
                            error: function() {
                                $.toast({
                                    heading: 'Notification !',
                                    text: "Voucher is expired or incorrect",
                                    showHideTransition: 'slide', // It can be plain, fade or slide
                                    icon: 'error',
                                    hideAfter: 4000, // `false` to make it sticky or time in milliseconds to hide after
                                    position: 'top-center',
                                    stack: false, // Ensure that toasts stack properly
                                    loaderBg: 'white', // Background color of the toast loader
                                    bgColor: '#ff0000', // Background color of the toast
                                    textColor: 'white', // Text color
                                });
                            }
                        });
                    });

                    $('.form-quantity').on('input', function() {
                        updateCart();
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                            function send(discountAmount = 0, percentDiscount = 0) {

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
