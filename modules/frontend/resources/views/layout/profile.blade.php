@extends('frontend::main')
@section('content')
    <section class="main-header" style="background-image:url(assets/images/gallery-2.jpg)">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Customer page</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="#">Profile</a></li>
                </ol>
            </div>
        </header>
    </section>
    <section style="background-color: #eeeeee;">
        <div class="container" style="background-color: white;">
            <div class="col-md-12" style="margin: 15px 0 15px 0">
                <div class="col-md-5">
                    <div style="display: flex;
    justify-content: center;">
                        <div style="width: 60%">
                            <img src="{{ asset('backend/src/images/avatar-clone.svg') }}" class="avatar-user"
                                width="100%">
                        </div>
                    </div>
                    <div style="display: flex;
    justify-content: center;">
                        <button style="margin: 15px" class="btn btn-default">Update Image</button>
                        <a href="/editpassword" style="margin: 15px" class="btn btn-default">Change Password</a>
                    </div>
                </div>
                <div class="col-md-7" style="    margin-top: 28px;">
                    <div class="row">
                        <form action="/profile" method="post">
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
                                        <input type="text" value="{{ $user->name }}" class="form-control"
                                            placeholder="Name: *" required name="name">
                                        <input type="hidden" value="USER" class="form-control" name="role">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" value="{{ $user->email }}" class="form-control"
                                            placeholder="Email: *" name="email" readonly>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="phone"
                                            placeholder="Your phone: *" required maxlength="10" pattern="\d{10}"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'');" name="phone"
                                            value="{{ $user->phone }}" />

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
                                        <select class="form-group cssselect" id="City" name="City" required>
                                            <option value="{{ isset($user->address->city) ? $user->address->city : '' }}"
                                                selected>{{ isset($user->address->city) ? $user->address->city : '' }}
                                            </option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city['code'] }}">{{ $city['name_with_type'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-group cssselect" id="District" name="District" required
                                            disabled>
                                            <option
                                                value="{{ isset($user->address->district) ? $user->address->district : '' }}"
                                                selected>
                                                {{ isset($user->address->district) ? $user->address->district : '' }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select class="form-group cssselect" id="Ward" name="Ward" required
                                            disabled>
                                            <option value="{{ isset($user->address->ward) ? $user->address->ward : '' }}"
                                                selected>{{ isset($user->address->ward) ? $user->address->ward : '' }}
                                            </option>
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
                                        <input type="text" class="form-control" placeholder="Street: *" name="street"
                                            required value="{{ $user->address->street }}">

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-info btn-block">Update
                                        account</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
