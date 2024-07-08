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
                            <h4>Invoices</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin-dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Invoices
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::invoice.table.table-index')
        </div>
    </div>
</div>
@endsection
@section('script')
    {{-- js update invoice --}}
    <script>
        $(document).ready(function(){
            $('button[data-status]').click(function() {
                var status = $(this).data('status');
                var tab = $(this).data('tab');
                var requestType = $(this).data('request-type');
                var table = $('#dataTableinvoice' + tab);

                $('button[data-status]').removeClass('active');
                $(this).addClass('active');

                table.find('.invoiceCheckbox').each(function() {
                    if ($(this).data('status') === status) {
                        $(this).show();
                        $(this).next('.dt-checkbox-label').show();
                    } else {
                        $(this).hide().prop('checked', false);
                        $(this).next('.dt-checkbox-label').hide();
                    }
                });

                table.find('#selectAll' + tab).show();
                
                table.closest('.tab-pane').find('.updateButton').data('request-type', requestType);

                toggleUpdateButton(table.closest('.tab-pane'));
            });

            $('[id^=selectAll]').click(function() {
                var tabId = $(this).attr('id').replace('selectAll', '');
                var table = $('#dataTableinvoice' + tabId);
                var isChecked = $(this).is(':checked');
                table.find('.invoiceCheckbox:visible').prop('checked', isChecked);
                toggleUpdateButton(table.closest('.tab-pane'));
            });

            $('.invoiceCheckbox').change(function() {
                var table = $(this).closest('table');
                var allChecked = table.find('.invoiceCheckbox:visible:checked').length === table.find('.invoiceCheckbox:visible').length;
                table.find('[id^=selectAll]').prop('checked', allChecked);
                toggleUpdateButton(table.closest('.tab-pane'));
            });

            function toggleUpdateButton(tabPane) {
                var updateButton = tabPane.find('.updateButton');
                if (tabPane.find('.invoiceCheckbox:visible:checked').length > 0) {
                    updateButton.show();
                } else {
                    updateButton.hide();
                }
            }

            $('.updateButton').click(function() {
                var tabPane = $(this).closest('.tab-pane');
                var selectedInvoices = tabPane.find('.invoiceCheckbox:visible:checked').map(function() {
                    return $(this).data('id');
                }).get();
                var requestType = $(this).data('request-type');

                if (selectedInvoices.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("admin-invoice-update") }}',
                        data: {
                            ids: selectedInvoices,
                            requestType: requestType,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Update successfully',
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
    </script>

    {{-- invoice detail --}}
    <script>
        $(document).ready(function(){
            $('.openInvoiceModal').click(function(e){
                e.preventDefault();
                var invoiceId = $(this).data('id');
                $.ajax({
                    url: '/admin/invoice/detail/' + invoiceId,
                    type: 'GET',
                    success: function(response){
                        console.log(response);
                        var formattedDate = moment(response.data.created_at).format('MMMM D, YYYY h:mm A');

                        $('#clientName').text(response.data.name);
                        $('#dateIssued').text(formattedDate);
                        $('#Address').text(response.data.address);
                        $('#Trading-code').text(response.payment.notes);
                        $('#paymentMethod').text(response.payment.name);
                        $('#status').text(response.payment.description);
                        $('#totalDue').text(response.data.total);
                        $('#discount').text('-'+response.data.discountMoney);

                        
                        var items = '';
                        response.data.details.forEach(function(item) {
                            var subtotal = item.price * item.quantity;
                            items += '<li class="clearfix">'+
                                        '<div class="invoice-sub">'+item.product_name+'</div>'+
                                        '<div class="invoice-rate">'+item.price+'</div>'+
                                        '<div class="invoice-hours">'+item.quantity+'</div>'+
                                        '<div class="invoice-subtotal">'+
                                            '<span class="weight-600">'+subtotal+'</span>'+
                                        '</div>'+
                                    '</li>';
                        });
                        $('#invoiceItems').html(items);
                        $('#invoiceModal').modal('show');
                    }
                });
            });
        });
    </script>
@endsection