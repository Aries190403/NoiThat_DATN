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
    
            $('.openModalView').on('click', function(e) {
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
                        // $('#supplierCity').val(data.address.city).change();
                        // $('#supplierDistrict').val(data.address.district).change();
                        // $('#supplierWard').val(data.address.ward).change();
                        $('#supplier-description').val(data.supplier.description);
                        toggleEditSave(false);
                        $('#supplierModal').modal('show');
                        console.log(data.address.city, data.address.district, data.address.ward);
                    },
                    error: function() {
                        alert('Đã xảy ra lỗi, vui lòng thử lại sau');
                    }
                });
            });    
            $('#edit-save-btn').on('click', function() {
                if ($(this).text() === 'Edit') {
                    toggleEditSave(true); // Bật chế độ chỉnh sửa
                } else {
                    // Lưu thay đổi
                    var url = '{{ route("admin-supplier-edit", ":id") }}';
                    url = url.replace(':id', supplierId);
    
                    var data = {
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
                            toggleEditSave(false); // Vô hiệu hóa các trường sau khi lưu
                            alert('Thông tin nhà cung cấp đã được cập nhật thành công');
                        },
                        error: function() {
                            alert('Đã xảy ra lỗi, vui lòng thử lại sau');
                        }
                    });
                }
            });
        });
    </script>


@endsection