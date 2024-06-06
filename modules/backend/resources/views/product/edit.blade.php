@extends('backend::base')
@section('content')
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="title">
                                <h4>Edit Product</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-dashboard')}}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{route('admin-product-index')}}">Product</a>
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
                @include('backend::product.modal.modal-imgThumbnail')
                {{-- end modal --}}
                <div class="row clearfix">
                    <div class="col-12 mb-30">
                        @include('backend::product.table.table-edit')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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

        document.getElementById('confirmUpload').addEventListener('click', function() {
            const fileInput = document.getElementById('imageInput');
            const file = fileInput.files[0];
            if (file) {
                const formData = new FormData();
                formData.append('image', file);
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
                });
            }
        });

        $('#imagePreviewModal').on('hidden.bs.modal', function() {
            document.getElementById('previewImage').src = '';
            document.getElementById('imageInput').value = '';
        });

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('productForm');
            const saveButton = document.getElementById('saveButton');
            let originalFormData = new FormData();

            function initializeOriginalFormData() {
                originalFormData = new FormData();
                form.querySelectorAll('input, select, textarea').forEach(function (element) {
                    originalFormData.append(element.name, element.value);
                });
            }

            function checkFormChanges() {
                const currentFormData = new FormData(form);
                let formChanged = false;

                for (let key of originalFormData.keys()) {
                    if (originalFormData.get(key) !== currentFormData.get(key)) {
                        formChanged = true;
                        break;
                    }
                }

                saveButton.style.display = formChanged ? 'inline-block' : 'none';
            }

            form.addEventListener('input', checkFormChanges);
            form.addEventListener('change', checkFormChanges);

            initializeOriginalFormData();

            $('#productForm').on('submit', function (e) {
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
                        if (response.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Product updated successfully',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.message || 'An unknown error occurred. Please try again.',
                                confirmButtonText: 'Close'
                            });
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