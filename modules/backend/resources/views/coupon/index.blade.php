@extends('backend::base')
@section('content')
<div id="list-table-coupon">
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Vouchers</h4>
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
                                    Vouchers
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::coupon.table.table-index')
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#kt_modal_coupon_form').on('submit', function (e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    success: function (response) {
                        Swal.fire(
                            'Success!',
                            'Coupon created successfully.',
                            'success'
                        ).then(() => {
                            window.location.href = '{{ route('admin-coupon-index') }}';
                        });
                    },
                    error: function (xhr, status, error) {
                        let errorMessage = 'An error occurred while processing your request.';
                        if (xhr.status === 409) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        Swal.fire(
                            'Error!',
                            errorMessage,
                            'error'
                        );
                    }
                });
            });
            lockCoupon();
            function lockCoupon() {
                $(document).on('click', '#lock-coupon', function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');
                    var iconClass = $(this).find('i').attr('class');

                    var action = (iconClass.includes('dw-padlock1')) ? 'lock' : 'unlock';
                    var titleText = (action == 'lock') ? 'Lock' : 'Unlock';
                    var confirmationText = (action == 'lock') ? 'This coupon will be locked!' : 'This coupon will be unlocked!';

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
                                type: 'Post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'coupon ' + titleText.toLowerCase() + 'ed successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    window.location.href = '{{ route('admin-coupon-index') }}';
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
        });
    </script>
    
    {{-- show view coupon --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.openModalView', function(e) {
                e.preventDefault();
    
                var couponId = $(this).data('coupon-id');
                var url = '{{ route("admin-coupon-view", ":id") }}';
                url = url.replace(':id', couponId);                
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        console.log(data);
                        $('#coupon-user-create').val(data.user_name ? data.user_name : 'N/A');
                        $('#coupon-code').val(data.coupon.code);
                        $('#coupon-limit').val(data.coupon.limit);
                        $('#coupon-count-active').val(data.coupon.count_active);
                        $('#coupon-discount').val(data.coupon.discount);
                        $('#coupon-discount-money').val(data.coupon.discount_money);
                        $('#coupon-downtime').val(moment.utc(data.coupon.downtime).local().format('MMMM D, YYYY h:mm A'));
                        $('#coupon-description').val(data.coupon.description);
                        $('#coupon-status').val(data.coupon.status);
                        $('#couponModal').modal('show');
                    },
                    error: function() {
                        alert('An error occurred, please try again later');
                    }
                });
            });
        });
    </script>

    {{-- js edit coupon --}}
<script>
    $(document).ready(function() {
        var currentCouponId;
        $(document).on('click', '.openModalEdit', function(e) {
            e.preventDefault();
            currentCouponId = $(this).data('coupon-id');
            var url = $(this).attr('href');
            console.log(url);
            
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    let coupon = response.coupon;

                    $('#voucherCode').val(coupon.code);
                    $('#voucherLimit').val(coupon.limit);
                    $('#voucherDiscount').val(coupon.discount);
                    $('#voucherDiscountMoney').val(coupon.discount_money);
                    $('#voucherDate').val(coupon.downtime.split(' ')[0]);
                    $('#voucherTime').val(coupon.downtime.split(' ')[1]);
                    $('#voucherDescription').val(coupon.description);

                    $('#editVoucherModal').modal('show');
                },
                error: function(xhr) {
                    alert('Failed to fetch coupon data.');
                }
            });
        });
        
        $('#editVoucherForm').submit(function(e) {
            e.preventDefault();
            var couponId = currentCouponId;
            console.log(couponId);
            var form = $(this);
            var method = form.attr('method');
            var formData = form.serialize();
            $.ajax({
                url: "{{ route('admin-coupon-update', ['id' => ':couponId']) }}".replace(':couponId', couponId),
                type: method,
                data: formData,
                success: function (response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'coupon change successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    window.location.href = '{{ route('admin-coupon-index') }}';
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'An error occurred while processing your request.',
                        'error'
                    );
                }
            });
        });
    });
</script>

@endsection