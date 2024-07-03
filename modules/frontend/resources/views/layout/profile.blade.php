@extends('frontend::main')
@section('content')
    <section class="main-header" style="background-image:url({{ asset('frontend/assets/images/gallery-2.jpg)') }}">
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
                            @if (isset($user->picture->image))
                                {{-- @dump($user->picture->image) --}}
                                <img src="{{ asset($user->picture->image) }}" class="avatar-user" width="100%">
                            @else
                                <img src="{{ asset('backend/src/images/avatar-clone.svg') }}" class="avatar-user"
                                    width="100%">
                            @endif

                        </div>
                    </div>
                    <div style="display: flex;
    justify-content: center;">
                        <form id="uploadForm" method="POST" action="/uploadAvatar/{{ Auth::user()->id }}"
                            enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="YOUR_CSRF_TOKEN">
                            {{-- <a href="#" class="edit-avatar" id="uploadImageLink"><i class="icon-copy dw dw-pencil-1"
                                    style="color: red"></i>sss</a> --}}
                            <a id="uploadImageLink" style="margin: 15px" class="btn btn-default">Update Image</a>
                            {{-- <a href="#" id="uploadImageLink">Upload Image</a> --}}
                            <input type="file" id="imageInput" name="image" style="display: none;">
                        </form>
                        {{-- <a id="uploadImageLink" style="margin: 15px" class="btn btn-default">Update Image</a> --}}
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
            @include('frontend::layout.modal.modal-cropped')

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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JavaScript -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/cropperjs"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var uploadImageLink = document.getElementById('uploadImageLink');
            var imageInput = document.getElementById('imageInput');
            var previewImage = document.getElementById('previewImage');
            var imagePreviewModal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            var confirmUpload = document.getElementById('confirmUpload');
            var uploadForm = document.getElementById('uploadForm');
            var cropper;

            uploadImageLink.addEventListener('click', function() {
                imageInput.click();
            });

            imageInput.addEventListener('change', function(event) {
                var file = event.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreviewModal.show();

                        // Destroy the old cropper instance if exists
                        if (cropper) {
                            cropper.destroy();
                        }

                        // Initialize the cropper
                        cropper = new Cropper(previewImage, {
                            aspectRatio: 1,
                            viewMode: 1,
                            autoCropArea: 1
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });

            confirmUpload.addEventListener('click', function() {
                var canvas = cropper.getCroppedCanvas({
                    width: 400,
                    height: 400,
                });

                canvas.toBlob(function(blob) {
                    if (blob) {
                        var formData = new FormData(uploadForm);
                        formData.append('croppedImage', blob);

                        fetch(uploadForm.action, {
                                method: uploadForm.method,
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'input[name="_token"]').value
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    location.reload(); // Go back to the previous page
                                } else {
                                    alert(data.message);
                                }
                                imagePreviewModal.hide();
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while uploading the image.');
                                imagePreviewModal.hide();
                            });
                    } else {
                        console.error('Blob is null.');
                    }
                }, 'image/jpeg');
            });
        });
    </script>
@endsection
