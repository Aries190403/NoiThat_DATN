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
                            <h4>Products</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Products
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::product.table.table-product')
            @include('backend::product.modal.modal-import-products')
        </div>
    </div>
</div>
@endsection
@section('script')
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
                                    if (xhr.status === 400) {
                                        Swal.fire(
                                            'Cannot Delete!',
                                            xhr.responseJSON.error,
                                            'error'
                                        );
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            'An error occurred while processing your request.',
                                            'error'
                                        );
                                    }
                                }
                            });
                        }
                    });
                });
            }
            initializeEventListeners();
        });
    </script>

    {{-- nhập hàng  --}}
    <script>
        $(document).ready(function(){
            $(document).on('click', '.openModal', function(e) {
                e.preventDefault();
                var productId = $(this).data('id');
                var actionUrl = '{{ route("admin-product-importing", ["id" => ":id"]) }}';
                actionUrl = actionUrl.replace(':id', productId);
                $('#quantityForm').attr('action', actionUrl);
                $('#myModal').modal('show');
            });
    
            $('#quantityForm').submit(function(e){
                e.preventDefault();
    
                var form = $(this);
                var url = form.attr('action');
                var formData = form.serialize();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    success: function(response){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Importing successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#myModal').modal('hide');
                        form[0].reset();
                    },
                    error: function(xhr){
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '';
                        $.each(errors, function(key, value){
                            errorMessages += value + '<br>';
                        });
                        $('#errorMessages').html(errorMessages);
                    }
                });
            });
        });
    </script>

    {{-- nhập nhiều hàng --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.product-card', function(e) {
                var checkbox = $(this).find('.product-checkbox');
                var quantityInput = $(this).find('.product-quantity');
                
                if (!$(e.target).is(checkbox) && !$(e.target).is(quantityInput)) {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
    
                if (checkbox.prop('checked')) {
                    $(this).addClass('selected-card');
                    quantityInput.show();
                } else {
                    $(this).removeClass('selected-card');
                    quantityInput.hide().val('');
                }
            });
    
            $(document).on('click', '.product-quantity', function(e) {
                e.stopPropagation();
            });
    
            $('.product-quantity').hide();
    
            $('#importGoodsForm').on('submit', function(e) {
                e.preventDefault();
    
                var selectedProducts = [];
                $('.product-checkbox:checked').each(function() {
                    var productId = $(this).val();
                    var quantityInput = $(this).siblings('.product-quantity');
                    var quantity = quantityInput.val();
                    
                    if (quantity) {
                        selectedProducts.push({ id: productId, quantity: quantity });
                    } else {
                        quantityInput.css('border', '1px solid red');
                    }
                });
    
                if (selectedProducts.length === 0) {
                    Swal.fire(
                        'Error!',
                        'Please select at least one product and enter its quantity.',
                        'error'
                    );
                    return;
                }

                var supplierValue = $('#supplier').val();

                var data = {
                    _token: $('input[name=_token]').val(),
                    supplier: supplierValue,
                    products: selectedProducts
                };
    
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: JSON.stringify(data),
                    // data: $(this).serialize(),
                    contentType: 'application/json',
                    success: function(response) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'Importing successfully',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#importGoodsForm')[0].reset();
                        $('.product-checkbox').prop('checked', false);
                        $('.product-quantity').hide().val('');
                        $('.product-card').removeClass('selected-card');
                        $('#importGoodsModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'An error occurred. Please try again later.',
                            'error'
                        );
                    }
                });
            });
    
            $('#productSearch').on('input', function() {
                var searchTerm = $(this).val().toLowerCase();
                $('.product-card-container').each(function() {
                    var productName = $(this).find('.product-details span').text().toLowerCase();
                    if (productName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
    
            $(document).on('change', '.product-checkbox', function() {
                var card = $(this).closest('.product-card');
                if ($(this).is(':checked')) {
                    card.addClass('selected-card');
                    $(this).siblings('.product-quantity').show();
                } else {
                    card.removeClass('selected-card');
                    $(this).siblings('.product-quantity').hide().val('');
                }
            });
        });
    </script>
    
    

@endsection