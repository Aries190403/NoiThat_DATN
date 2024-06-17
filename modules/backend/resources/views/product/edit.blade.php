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

    <script>
        $(document).ready(function() {
            $('#add_product_detail_form').submit(function(e) {
                e.preventDefault();

                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#modalAddProductDetail').modal('hide');
                        form[0].reset();
                        alert('Product detail added successfully!');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding product detail:', error);
                        $('#errorMessages').text('An error occurred while adding the product detail. Please try again.');
                    }
                });
            });
        });

    </script>

    {{-- js img --}}
    <script>
        Dropzone.autoDiscover = false;
        $(".dropzone").dropzone({
            addRemoveLinks: true,
            removedfile: function (file) {
                var name = file.name;
                var _ref;
                return (_ref = file.previewElement) != null
                    ? _ref.parentNode.removeChild(file.previewElement)
                    : void 0;
            },
        });
    </script>

    {{-- js imgs --}}
    <script>
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#my-awesome-dropzone", {
            url: document.querySelector("#my-awesome-dropzone").getAttribute("action"),
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function (file, response) {
                console.log("Successfully uploaded:", response);
            },
            error: function (file, response) {
                console.error("Upload error:", response);
            },
        });
    </script>

    {{-- js del img  --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete-image', function(e) {
                e.preventDefault();
    
                var url = $(this).data('url');
                var imageId = $(this).data('id');
                var imageItem = $(this).closest('.image-item');
    
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
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            type: 'POST',
                            url: url,
                            data: { id: imageId },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Image deleted successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    imageItem.remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        'Failed to delete the image.',
                                        'error'
                                    );
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
        });
    </script>

    {{-- lock product --}}
    <script>
        jQuery(document).ready(function () {
            lockProduct();
            function lockProduct() {
                $(document).on('click', '#lock-product', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    var iconClass = $(this).find('i').attr('class');

                    var action = (iconClass.includes('dw-padlock1')) ? 'lock' : 'unlock';
                    var titleText = (action == 'lock') ? 'Lock' : 'Unlock';
                    var confirmationText = (action == 'lock') ? 'This product will be locked!' : 'This product will be unlocked!';

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
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'product ' + titleText.toLowerCase() + 'ed successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    location.reload();
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

            deletedProduct();
            function deletedProduct() {
                $(document).on('click', '#delete-product', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel',
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Product deleted successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    window.location.href = "{{ route('admin-product-index') }}";
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
            initializeEventListeners();
        });
    </script>


@endsection