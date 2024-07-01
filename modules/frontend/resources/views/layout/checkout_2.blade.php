@extends('frontend::main')
@section('content')
    <!-- ========================  Main header ======================== -->

    <section class="main-header" style="background-image:url({{ asset('frontend/assets/images/gallery-2.jpg)') }}">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Checkout</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a href="/viewcart">Cart items</a></li>
                    <li><a class="active" href="/checkout-2">Delivery</a></li>

                    <li><a href="#">Receipt</a></li>
                </ol>
            </div>
        </header>
    </section>

    <!-- ========================  Step wrapper ======================== -->

    <div class="step-wrapper">
        <div class="container">

            <div class="stepper">
                <ul class="row">
                    <li class="col-md-4 active">
                        <span data-text="Cart items"></span>
                    </li>
                    <li class="col-md-4 active">
                        <span data-text="Delivery"></span>
                    </li>
                    <li class="col-md-4">
                        <span data-text="Receipt"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- ========================  Checkout ======================== -->

    <section class="checkout">
        <form action="/checkout-3" method="post">
            @csrf
            <div class="container">

                <header class="hidden">
                    <h3 class="h3 title">Checkout - Step 2</h3>
                </header>

                <!-- ========================  Cart navigation ======================== -->
                <div class="clearfix">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="/viewcart" class="btn btn-clean-dark"><span class="icon icon-chevron-left"></span>
                                Back to cart</a>
                        </div>
                        <div class="col-xs-6 text-right">
                            <button type="submit" class="btn btn-main"><span class="icon icon-cart"></span> Go to
                                payment</button>
                        </div>
                    </div>
                </div>

                <!-- ========================  Delivery ======================== -->

                <div class="cart-wrapper">

                    <div class="note-block">
                        <div class="row">

                            <!-- === left content === -->

                            <div class="col-md-6">

                                <!-- === login-wrapper === -->

                                <div class="login-wrapper">

                                    <div class="white-block">

                                        <div class="login-block login-block-signup">

                                            <div class="h4">shipping information</div>

                                            <hr />

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" value="{{ $user->name }}"
                                                            class="form-control" placeholder="Name: *" required
                                                            name="name">
                                                        <input type="hidden" value="USER" class="form-control"
                                                            name="role">
                                                        <input class="form-control" type="hidden"
                                                            value="{{ $totalPrice }}" name="totalPrice">
                                                        <input class="form-control" type="hidden"
                                                            value="{{ $discountMoney }}" name="discountMoney">
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" value="{{ $user->email }}" class="form-control"
                                                        placeholder="Email: *" name="email" readonly>

                                                </div>
                                            </div> --}}

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="phone"
                                                            placeholder="Your phone: *" required maxlength="10"
                                                            pattern="\d{10}"
                                                            oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                                            name="phone" value="{{ $user->phone }}" />

                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="OTP: *"
                                                        name="otp" required value="{{ old('otp') }}">

                                                </div>
                                            </div> --}}
                                                <div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select class="form-group cssselect" id="City"
                                                                name="City" required>
                                                                <option
                                                                    value="{{ isset($user->address->city) ? $user->address->city : '' }}"
                                                                    selected>
                                                                    {{ isset($user->address->city) ? $user->address->city : '' }}
                                                                </option>
                                                                @foreach ($cities as $city)
                                                                    <option value="{{ $city['code'] }}">
                                                                        {{ $city['name_with_type'] }}</option>
                                                                @endforeach
                                                            </select>
                                                            {{-- <input type="hidden" name="city"
                                                            value="{{ isset($user->address->city) ? $user->address->city : '' }}"> --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select class="form-group cssselect" id="District"
                                                                name="District" required disabled>
                                                                <option
                                                                    value="{{ isset($user->address->district) ? $user->address->district : '' }}"
                                                                    selected>
                                                                    {{ isset($user->address->district) ? $user->address->district : '' }}
                                                                </option>
                                                            </select>
                                                            <input type="hidden" class="form-control" name="district"
                                                                value="{{ isset($user->address->district) ? $user->address->district : '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <select class="form-group cssselect" id="Ward"
                                                                name="Ward" required disabled>
                                                                <option
                                                                    value="{{ isset($user->address->ward) ? $user->address->ward : '' }}"
                                                                    selected>
                                                                    {{ isset($user->address->ward) ? $user->address->ward : '' }}
                                                                </option>
                                                            </select>
                                                            <input type="hidden" name="ward"
                                                                value="{{ isset($user->address->ward) ? $user->address->ward : '' }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Ward: *"
                                                        name="ward" value="{{ old('ward') }}">
                                                </div>
                                            </div> --}}

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                            placeholder="Street: *" name="street" required
                                                            value="{{ $user->address->street }}">

                                                    </div>
                                                </div>

                                            </div>
                                        </div> <!--/signup-->
                                    </div>
                                </div> <!--/login-wrapper-->
                            </div> <!--/col-md-6-->
                            <!-- === right content === -->

                            <div class="col-md-6">

                                <div class="white-block">

                                    <div class="h4">Choose delivery</div>

                                    <hr />
                                    <span class="checkbox">
                                        <input type="radio" id="deliveryId1" name="Delivery" checked value="Delivery">
                                        <label for="deliveryId1">Delivery 3-7 Days - <strong>Free</strong></label>
                                    </span>

                                    <span class="checkbox">
                                        <input type="radio" id="deliveryId2" name="Delivery" value="Store">
                                        <label for="deliveryId2">Pick up in the store - <strong>Free</strong></label>
                                    </span>

                                    <hr />
                                    <div class="h4">Choose payment</div>

                                    <hr />
                                    <span class="checkbox">
                                        <input type="radio" id="paymentID1" name="paymentOption" value="COD"
                                            checked="checked">
                                        <label for="paymentID1">
                                            <strong>COD</strong> <br />
                                            <small></small>
                                        </label>
                                    </span>

                                    <span class="checkbox">
                                        <input type="radio" id="paymentID2" value="VNPAY" name="paymentOption">
                                        <label for="paymentID2">
                                            <strong>VN PAY</strong> <br />
                                            <small></small>
                                        </label>
                                    </span>

                                    <hr />

                                    {{-- <div class="clearfix">
                                    <p>A frequently overlooked, powerful fulfillment option is offering local pick-up. If
                                        you have a physical location and can allow your customers to forgo paying shipping
                                        costs altogether, you should!</p>
                                    <p><strong>Benefits:</strong></p>
                                    <ul>
                                        <li>Avoid both shipping and packaging costs</li>
                                        <li>Develop a face-to-face relationship with your customers</li>
                                        <li>Potential for additional purchases while customers are at your store</li>
                                    </ul>
                                    <p><strong>Challenges:</strong></p>
                                    <ul>
                                        <li>Limited business hours can sometimes make it difficult to coordinate pickup</li>
                                        <li>Shoppers who cross state lines or ZIP codes may not know the sales tax rates in
                                            your area</li>
                                    </ul>
                                </div> --}}
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- ========================  Cart wrapper ======================== -->

                <div class="cart-wrapper">
                    <!--cart header -->

                    <div class="cart-block cart-block-header clearfix">
                        <div>
                            <span>Product</span>
                        </div>
                        <div>
                            <span>&nbsp;</span>
                        </div>
                        <div>
                            <span>Quantity</span>
                        </div>
                        <div class="text-right">
                            <span>Price</span>
                        </div>
                    </div>

                    <!--cart items-->

                    <div class="clearfix">
                        @foreach ($items as $c)
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
                                        <div class="h4"><a
                                                href="/productdetail/{{ $c->id }}">{{ $c->name }}</a>
                                        </div>
                                        {{-- <div>Green corner</div> --}}
                                    </div>
                                    <div class="quantity">
                                        <input type="hidden" value="{{ $c->quantity }}"
                                            class="form-control form-quantity" min="1" max="3"
                                            data-price="{{ $c->price }}" data-sale="{{ $c->sale_percentage ?? 0 }}"
                                            oninput="updateCartItem(this)">
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

                        <!--cart prices -->

                        <div class="clearfix">
                            <div class="cart-block cart-block-footer clearfix">
                                <div>
                                    <strong>Total</strong>
                                </div>
                                <div>
                                    <span>$ {{ $totalPrice }}</span>
                                </div>
                            </div>
                            <div class="cart-block cart-block-footer clearfix">
                                @if (isset($discountprecent))
                                    <div>
                                        <strong>Discount </strong>
                                    </div>
                                    <div>
                                        <span> - $ {{ $discountMoney }}</span>
                                    </div>
                                @else
                                    <div>
                                        <strong>Discount</strong>
                                    </div>
                                    <div>
                                        <span> 0</span>
                                    </div>
                                @endif
                            </div>

                            <div class="cart-block cart-block-footer clearfix">
                                <div>
                                    <strong>Shipping</strong>
                                </div>
                                <div>
                                    <span>Free</span>
                                </div>
                            </div>
                        </div>

                        <!--cart final price -->

                        <div class="clearfix">
                            <div class="cart-block cart-block-footer clearfix">
                                <div>
                                    <strong class="h4">Final price</strong>
                                </div>
                                <div>
                                    <div class="h4 title">$ {{ $finalPrice }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ========================  Cart navigation ======================== -->

                    <div class="clearfix">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="viewcart" class="btn btn-clean-dark"><span
                                        class="icon icon-chevron-left"></span>
                                    Back to cart</a>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button type="submit" class="btn btn-main"><span class="icon icon-cart"></span> Go
                                    to
                                    payment</button>
                            </div>
                        </div>
                    </div>


                </div> <!--/container-->
        </form>
    </section>
    <script>
        jQuery(document).ready(function() {

            function initializeEventListeners() {
                const citySelect = document.getElementById('City');
                const districtSelect = document.getElementById('District');
                const wardSelect = document.getElementById('Ward');

                citySelect.addEventListener('change', handleCityChange);
                districtSelect.addEventListener('change', handleDistrictChange);
            }

            function handleCityChange() {
                const cityCode = this.value;
                fetchDistricts(cityCode);
            }

            function handleDistrictChange() {
                const districtCode = this.value;
                fetchWards(districtCode);
            }

            function fetchDistricts(cityCode) {
                const districtSelect = document.getElementById('District');
                const wardSelect = document.getElementById('Ward');
                resetDropdown(districtSelect, 'District');
                resetDropdown(wardSelect, 'Ward');

                fetch(`/admin/districts/${cityCode}`)
                    .then(response => response.json())
                    .then(data => {
                        districtSelect.disabled = false;
                        data.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.code;
                            option.textContent = district.name_with_type;
                            districtSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching districts:', error));
            }

            function fetchWards(districtCode) {
                const wardSelect = document.getElementById('Ward');
                resetDropdown(wardSelect, 'Ward');

                fetch(`/admin/wards/${districtCode}`)
                    .then(response => response.json())
                    .then(data => {
                        wardSelect.disabled = false;
                        data.forEach(ward => {
                            const option = document.createElement('option');
                            option.value = ward.code;
                            option.textContent = ward.name_with_type;
                            wardSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching wards:', error));
            }

            function resetDropdown(dropdown, placeholderText) {
                dropdown.innerHTML = `<option value="" disabled selected>${placeholderText}</option>`;
                dropdown.disabled = true;
            }

            initializeEventListeners();
        });
    </script>
@endsection
