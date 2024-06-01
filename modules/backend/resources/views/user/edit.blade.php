@extends('backend::base')
@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Edit User</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-user')}}">Users</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Edit
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                {{-- modal --}}
                @include('backend::user.modal.modal-cropped')
                @include('backend::user.modal.modal-change-password')
                {{-- end modal --}}
                <div class="row clearfix">
                    <div class="col-12 mb-30">
                        @include('backend::user.table.table-edit')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

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
        
    {{-- js action function --}}
    <script>
        deletedUser();
        function deletedUser() {
            $(document).on('click', '#delete-user', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.html) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'User deleted successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        window.location.href = '/admin/users';
                                    });
                                    initializeAll()
                                }
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

        lockUser();
        function lockUser() {
            $(document).on('click', '#lock-user', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var iconClass = $(this).find('i').attr('class');

                var action = (iconClass.includes('dw-padlock1')) ? 'lock' : 'unlock';
                var titleText = (action == 'lock') ? 'Lock' : 'Unlock';
                var confirmationText = (action == 'lock') ? 'This user will be locked!' : 'This user will be unlocked!';

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
                            type: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.html) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'User ' + titleText.toLowerCase() + 'ed successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    location.reload();
                                    initializeAll()
                                }
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
    </script>

    {{-- js change password --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password').forEach(item => {
                item.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const targetInput = document.getElementById(targetId);
                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        this.classList.remove('fa-eye');
                        this.classList.add('fa-eye-slash');
                    } else {
                        targetInput.type = 'password';
                        this.classList.remove('fa-eye-slash');
                        this.classList.add('fa-eye');
                    }
                });
            });
    
            $('#change-password').click(function(e) {
                e.preventDefault();
                $('#myModal').modal('show');
            });
    
            $('#passwordForm').on('submit', function(e) {
                e.preventDefault();
                var password = $('#password').val();
                var passwordConfirmation = $('#password_confirmation').val();

                if (password !== passwordConfirmation) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: 'Passwords do not match.',
                        confirmButtonText: 'Close'
                    });
                } else {
                    $.ajax({
                        url: $(this).attr('action'),
                        type: $(this).attr('method'),
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#passwordForm')[0].reset();
                            $('#myModal').modal('hide');
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Password changed successfully',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(response) {
                            let errorMessages = 'An error occurred. Please try again.';
                            if (response.responseJSON && response.responseJSON.errors) {
                                errorMessages = Object.values(response.responseJSON.errors).join('<br>');
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: errorMessages,
                                confirmButtonText: 'Close'
                            });
                        }
                    });
                }
            });
        });
    </script>

    {{-- js edit user --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const originalFormData = new FormData(document.getElementById('userForm'));
            const saveButton = document.getElementById('saveButton');
    
            document.getElementById('userForm').addEventListener('input', function() {
                const currentFormData = new FormData(this);
                let formChanged = false;
    
                for (let key of originalFormData.keys()) {
                    if (originalFormData.get(key) !== currentFormData.get(key)) {
                        formChanged = true;
                        break;
                    }
                }
    
                saveButton.style.display = formChanged ? 'inline-block' : 'none';
            });
    
            // JS address
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
    
            // JS form submission
            $('#userForm').on('submit', function (e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                var method = form.attr('method');
                var formData = form.serialize();
    
                $.ajax({
                    url: url,
                    type: method,
                    data: formData,
                    success: function (response) {
                        if (response.html) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'User added successfully',
                                showConfirmButton: false,
                                timer: 1500
                            });
                                // $('#table-user').html(response.html);
                                // $('#userForm')[0].reset();
                                // $('#errorMessages').empty();
                                // initializeAll()
                                location.reload();

                        }
                    },
                    error: function (xhr, status, error) {
                        var errors = xhr.responseJSON ? xhr.responseJSON.errors : null;
                        var errorMessages = '';
    
                        if (errors) {
                            $.each(errors, function (key, value) {
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
    
@endsection