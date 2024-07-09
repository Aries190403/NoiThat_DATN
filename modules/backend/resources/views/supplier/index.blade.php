@extends('backend::base')
@section('content')
<div id="list-table-supplier">
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Suppliers</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Suppliers
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::supplier.table.table-supplier')
        </div>
    </div>
</div>
@endsection
@section('script')

    {{-- js add --}}
    <script>
        $(document).ready(function() {
            $('#kt_modal_supplier_form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Supplier added successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.href = '{{ route('admin-supplier-index') }}';
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                        var errorMessages = '';

                        if (errors) {
                            $.each(errors, function(key, value) {
                                errorMessages += '<p>' + value[0] + '</p>';
                            });
                            $('#errorMessages').html(errorMessages);
                        } else {
                            $('#errorMessages').html('<p>An unknown error occurred. Please try again.</p>');
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            html: errorMessages,
                            confirmButtonText: 'Close'
                        });
                    }
                });
            });
        });
    </script>

    {{-- js address --}}
    <script>
        jQuery(document).ready(function () {
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

    {{-- js address edit --}}
    <script>
        jQuery(document).ready(function () {
            function initializeEventListeners() {
                const citySelect = document.querySelector('.city-select');
                const districtSelect = document.querySelector('.district-select');
                const wardSelect = document.querySelector('.ward-select');

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
                const districtSelect = document.querySelector('.district-select');
                const wardSelect = document.querySelector('.ward-select');
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
                const wardSelect = document.querySelector('.ward-select');
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

    {{-- js view --}}
    <script>
        $(document).ready(function() {
            let supplierId = null; // Biến để lưu ID của nhà cung cấp
    
            function toggleEditSave(isEdit) {
                $('#supplierModal .form-control').prop('disabled', !isEdit);
                $('#edit-save-btn').text(isEdit ? 'Save' : 'Edit');
            }
    
            $(document).on('click', '.openModalView', function(e) {
                e.preventDefault();
    
                supplierId = $(this).data('supplier-id');
                var url = '{{ route("admin-supplier-infor", ":id") }}';
                url = url.replace(':id', supplierId);
    
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        supplierId = data.supplier.id; // Lưu ID của nhà cung cấp
                        var avatarSrc = data.avatar && data.avatar.image ? data.avatar.image : "backend/src/images/no-image.svg";
                        var fullAvatarSrc = "{{ asset('') }}" + avatarSrc;
                        $('#supplier-avatar').attr('src', fullAvatarSrc);
                        $('#supplier-name').val(data.supplier.name);
                        $('#supplier-email').val(data.supplier.email);
                        $('#supplier-phone').val(data.supplier.phone);
                        $('#supplier-street').val(data.address.street);
                        $('#cityPlaceholder').text(data.address.city);
                        $('#districtPlaceholder').text(data.address.district);
                        $('#wardPlaceholder').text(data.address.ward);
                        $('#supplier-description').val(data.supplier.description);
                        toggleEditSave(false);
                        $('#supplierModal').modal('show');
                    },
                    error: function() {
                        alert('Đã xảy ra lỗi, vui lòng thử lại sau');
                    }
                });
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#edit-save-btn').on('click', function() {
                if ($(this).text() === 'Edit') {
                    toggleEditSave(true);
                } else {
                    // Lưu thay đổi
                    var url = '{{ route("admin-supplier-edit", ":id") }}';
                    url = url.replace(':id', supplierId);
    
                    var data = {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        name: $('#supplier-name').val(),
                        email: $('#supplier-email').val(),
                        phone: $('#supplier-phone').val(),
                        street: $('#supplier-street').val(),
                        city: $('#supplierCity').val(),
                        district: $('#supplierDistrict').val(),
                        ward: $('#supplierWard').val(),
                        description: $('#supplier-description').val()
                    };
    
                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            toggleEditSave(false);
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'User deleted successfully',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            window.location.href = '{{ route('admin-supplier-index') }}';
                        },
                        error: function(xhr, status, error) {
                            let errorMessage = 'An error occurred while processing your request.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }
                            Swal.fire(
                                'Error!',
                                errorMessage,
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>

    {{-- js state --}}
    <script>
        $(document).ready(function () {
            locksupplier();
            function locksupplier() {
                $(document).on('click', '#lock-supplier', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    var iconClass = $(this).find('i').attr('class');

                    var action = (iconClass.includes('dw-padlock1')) ? 'lock' : 'unlock';
                    var titleText = (action == 'lock') ? 'Lock' : 'Unlock';
                    var confirmationText = (action == 'lock') ? 'This supplier will be locked!' : 'This supplier will be unlocked!';

                    Swal.fire({
                        title: 'Are you sure?',
                        text: confirmationText,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, ' + titleText + ' it!',
                        cancelButtonText: 'No, cancel!',
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'Post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'supplier ' + titleText.toLowerCase() + 'ed successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    window.location.href = '{{ route('admin-supplier-index') }}';
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while processing your request.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            }
        });
    </script>

    {{-- js dopped image --}}
    <script>
        let cropper;
        document.getElementById('uploadImageLink').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('imageInput').click();
        });

        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const image = document.getElementById('previewImage');
                    image.src = e.target.result;
                    $('#imagePreviewModal').modal('show');
                };
                reader.readAsDataURL(file);
            }
        });

        $('#imagePreviewModal').on('shown.bs.modal', function() {
            const image = document.getElementById('previewImage');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1
            });
        });

        $('#imagePreviewModal').on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            document.getElementById('previewImage').src = '';
            document.getElementById('imageInput').value = '';
        });

        document.getElementById('confirmUpload').addEventListener('click', function() {
            if (cropper) {
                cropper.getCroppedCanvas().toBlob((blob) => {
                    const formData = new FormData();
                    formData.append('image', blob, 'cropped.jpg');
                    const form = document.getElementById('uploadForm');
                    const url = form.action;

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { throw new Error(text) });
                        }
                        return response.json();
                    })
                    .then(data => {
                        $('#imagePreviewModal').modal('hide');
                        if (cropper) {
                            cropper.destroy();
                            cropper = null;
                        }
                        location.reload();
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: error.message,
                            confirmButtonText: 'Close'
                        });
                        $('#imagePreviewModal').modal('hide');
                        if (cropper) {
                            cropper.destroy();
                            cropper = null;
                        }
                    });
                });
            }
        });

    </script>


@endsection