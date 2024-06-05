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
                            <h4>Categories</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Categories
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::Category.table.table-category')
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            function attachIconSelectionHandlers(modal) {
            $(modal).find('#show-icon-grid').on('click', function() {
                $(modal).find('#icon-grid').show();
            });

            $(modal).find('.icon-cell').on('click', function() {
                $(modal).find('.icon-cell').removeClass('selected');
                $(this).addClass('selected');
                var iconClass = $(this).data('icon');
                $(modal).find('#selected-icon').val(iconClass);
                $(modal).find('#icon-grid').hide();
                
                // Display the selected icon
                $(modal).find('#selected-icon-display').html('<i class="f-icon ' + iconClass + '"></i>');
            });
        }

        $('#bd-example-modal-lg').on('shown.bs.modal', function() {
            attachIconSelectionHandlers(this);
        });

        $('#modalEdit').on('shown.bs.modal', function() {
            attachIconSelectionHandlers(this);
        });
    });
    </script>
    <script>
      $(document).ready(function() {
        $('.openModalEdit').click(function(e) {
            e.preventDefault();
            var categoryId = $(this).data('category-id');
            var url = $(this).attr('href');
            
            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {
                    var content = JSON.parse(data.content);
                    $('#modalEdit input[name="name"]').val(data.name);
                    $('#modalEdit select[name="type"]').val(data.type);
                    $('#selected-icon-display').html('<i class="f-icon ' + content.icon + '"></i>');
                    $('#edit_category_form').attr('action', '/admin/categories/update/' + categoryId);
                    $('#modalEdit').modal('show');
                }
            });
        });
    });

    </script>
@endsection