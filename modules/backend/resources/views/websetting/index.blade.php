@extends('backend::base')
@section('content')
    <div id="list-table-setting">
        <div class="mobile-menu-overlay"></div>
        <div class="main-container">
            <div class="xs-pd-20-10 pd-ltr-20">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Setting</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin-dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Setting
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                @include('backend::websetting.table.table-index')
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const settings = @json($settings);
            $('#bd-example-modal-lg').on('show.bs.modal', function (event) {
                document.getElementById('phone').value = settings.phone;
                document.getElementById('email').value = settings.email;
                document.getElementById('address').value = settings.address;
                document.getElementById('open_time').value = settings.open_time;
                document.getElementById('close_time').value = settings.close_time;
                document.getElementById('facebook_link').value = settings.facebook_link;
                document.getElementById('youtube_link').value = settings.youtube_link;
            });
        });
    </script>

    {{-- js dopped image --}}
    <script>
        let cropper;

        $(document).ready(function() {
            $('#uploadImageLink').click(function(e) {
                e.preventDefault();
                $('#imageInput').click();
            });

            $('#imageInput').change(function(e) {
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
                    aspectRatio: 16 / 9,
                    viewMode: 2
                });
            });

            $('#imagePreviewModal').on('hidden.bs.modal', function() {
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
                $('#previewImage').attr('src', '');
                $('#imageInput').val('');
                $('#title').val('');
                $('#subtitle').val('');
                $('#url').val('');
            });

            $('#confirmUpload').click(function() {
                if (cropper) {
                    cropper.getCroppedCanvas().toBlob(function(blob) {
                        const formData = new FormData();
                        formData.append('image', blob, 'cropped.jpg');
                        formData.append('title', $('#title').val());
                        formData.append('subtitle', $('#subtitle').val());
                        formData.append('url', $('#url').val());

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
                            location.reload(); // Reload the page after successful upload
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
        });
    </script>

    {{-- js edit config --}}
    <script>
        $(document).ready(function() {
            $('.editImageLink').click(function(e) {
                e.preventDefault();
                var index = $(this).data('index');
                var title = $(this).data('title');
                var subtitle = $(this).data('subtitle');
                var url = $(this).data('url');
    
                $('#editIndex').val(index);
                $('#editTitle').val(title);
                $('#editSubtitle').val(subtitle);
                $('#editURL').val(url);
    
                $('#editImageModal').modal('show');
            });
    
            $('#saveEdit').click(function() {
                var index = $('#editIndex').val();
                var title = $('#editTitle').val();
                var subtitle = $('#editSubtitle').val();
                var url = $('#editURL').val();
    
                $.ajax({
                    type: 'POST',
                    url: '{{ route("admin-setting-editImage") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        index: index,
                        title: title,
                        subtitle: subtitle,
                        url: url
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#editImageModal').modal('hide');
                            location.reload(); // Reload the page to see the changes
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while saving the changes.');
                    }
                });
            });
        });
    </script>    

    {{-- delete --}}
    <script>
        $(document).ready(function() {
            $('.editImageLink').click(function(e) {
                e.preventDefault();
                var index = $(this).data('index');
                var title = $(this).data('title');
                var subtitle = $(this).data('subtitle');
                var url = $(this).data('url');
    
                $('#editIndex').val(index);
                $('#editTitle').val(title);
                $('#editSubtitle').val(subtitle);
                $('#editURL').val(url);
    
                $('#editImageModal').modal('show');
            });
    
            $('.deleteImageLink').click(function(e) {
                e.preventDefault();
                var index = $(this).data('index');

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
                            type: 'POST',
                            url: '{{ route("admin-setting-deleteImage") }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                index: index
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Image deleted successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'An error occurred while deleting the image.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
    
            $('#saveEdit').click(function() {
                var index = $('#editIndex').val();
                var title = $('#editTitle').val();
                var subtitle = $('#editSubtitle').val();
                var url = $('#editURL').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("admin-setting-editImage") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        index: index,
                        title: title,
                        subtitle: subtitle,
                        url: url
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Image updated successfully',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'An error occurred while updating the image.',
                            'error'
                        );
                    }
                });
            });
        });
    </script>
    
@endsection
