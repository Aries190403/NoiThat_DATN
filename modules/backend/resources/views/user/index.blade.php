@extends('backend::base')
@section('content')
<div id="list-table-user">
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Users</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Users
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::user.table.table-add')
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    jQuery(document).ready(function () {
        submitForm();
        function submitForm() {
            $('#kt_modal_user_form').on('submit', function (e) {
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
                            $('#list-table-user').html(response.html);
                            $('#kt_modal_user_form')[0].reset();
                            $('#errorMessages').empty();
                            $('#bd-example-modal-lg').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            initializeAll()
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
        }

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
                                    });
                                    $('#list-table-user').html(response.html);
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
                                    $('#list-table-user').html(response.html);
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

<script>
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
</script>
@endsection

