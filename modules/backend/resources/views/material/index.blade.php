@extends('backend::base')
@section('content')
<div id="list-table-material">
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Materials</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin-dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin-product-index')}}">Products</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Materials
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::material.table.table')
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.openModalEdit', function(e) {
                e.preventDefault();
                var materialId = $(this).data('material-id');
                var url = $(this).data('url');
                console.log(url, materialId);
                
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        // Populate modal fields with material data
                        $('#modalEdit input[name="name"]').val(data.name);
                        $('#modalEdit select[name="color"]').val(data.color);
                        $('#modalEdit select[name="type"]').val(data.type);
                        $('#modalEdit textarea[name="description"]').val(data.description);
                        $('#edit_material_form').attr('action', '/admin/material/update/' + materialId);
                        $('#modalEdit').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching material data:', error);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#delete-category', function(e) {
                e.preventDefault();

                var categoryId = $(this).data('id');
                var deleteUrl = '{{ route("admin-material-deleted", ":id") }}';
                deleteUrl = deleteUrl.replace(':id', categoryId);

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
                            type: 'GET',
                            url: deleteUrl,
                            success: function(response) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'material deleted successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                Swal.fire(
                                    'Error!',
                                    'Please try again later.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection