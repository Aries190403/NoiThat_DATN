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
            $('.openModalEdit').click(function(e) {
                e.preventDefault();
                var materialId = $(this).data('material-id');
                var url = $(this).attr('href');
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
@endsection