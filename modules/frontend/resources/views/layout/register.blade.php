@extends('frontend::main')
@section('content')
    <section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Customer page</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="/register">Register</a></li>
                </ol>
            </div>
        </header>
    </section>

    <!-- ========================  Login & register ======================== -->

    <section class="login-wrapper login-wrapper-page">
        <div class="container">

            <div class="row">

                <!-- === left content === -->

                <div class="col-md-6 col-md-offset-3">

                    <!-- === login-wrapper === -->

                    <div class="login-wrapper">

                        <div class="white-block">


                            <!--signup-->

                            <div class="login-block login-block-signup">

                                <div class="h4">Register now <a href="/login"
                                        class="btn btn-main btn-xs btn-login pull-right">Log in</a></div>

                                <hr />

                                <div class="row">
                                    <form action="/register" method="post">
                                        @csrf

                                        <div class="row">
                                            @if ($errors->any())
                                                <div class="alert alert-danger">
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" value="{{ old('name') }}" class="form-control"
                                                        placeholder="Name: *" required name="name">
                                                    <input type="hidden" value="USER" class="form-control"
                                                        name="role">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" value="{{ old('email') }}" class="form-control"
                                                        placeholder="Email: *" name="email" required>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Enter your password: *" required />

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password_confirmation"
                                                        placeholder="Confirm password: *" required>

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="phone"
                                                        placeholder="Your phone: *" required maxlength="10" pattern="\d{10}"
                                                        oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                                                        name="phone" value="{{ old('phone') }}" />

                                                </div>
                                            </div>
                                            {{-- <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="OTP: *"
                                                        name="otp" required value="{{ old('otp') }}">

                                                </div>
                                            </div> --}}

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="form-group cssselect" id="City" name="City"
                                                        required>
                                                        <option value="" disabled selected>City: *</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city['code'] }}">
                                                                {{ $city['name_with_type'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="form-group cssselect" id="District" name="District"
                                                        required disabled>
                                                        <option value="" disabled selected>District: *</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <select class="form-group cssselect" id="Ward" name="Ward"
                                                        required disabled>
                                                        <option value="" disabled selected>Ward: *</option>
                                                    </select>
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
                                                    <input type="text" class="form-control" placeholder="Street: *"
                                                        name="street" required value="{{ old('street') }}">

                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-main btn-block">Create
                                                    account</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div> <!--/signup-->
                        </div>
                    </div> <!--/login-wrapper-->
                </div> <!--/col-md-6-->

            </div>

        </div>
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
