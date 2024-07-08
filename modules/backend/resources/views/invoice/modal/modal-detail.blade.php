<!-- Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="invoice-wrap">
                    <div class="invoice-box">
                        <div class="invoice-header">
                            <div class="logo text-center">
                                <img src="vendors/images/deskapp-logo.png" alt="">
                            </div>
                        </div>
                        <h4 class="text-center mb-30 weight-600">INVOICE</h4>
                        <div class="row pb-30">
                            <div class="col-md-6">
                                <h5 class="mb-15" id="clientName">Client Name</h5>
                                <p class="font-14 mb-5">
                                    Date Issued: <strong class="weight-600" id="dateIssued">10 Jan 2018</strong>
                                </p>
                                <p class="font-14 mb-5">
                                    Trading code: <strong class="weight-600" id="Trading-code">4556</strong>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="text-right">
                                    <p class="font-14 mb-5">
                                        Address: <strong class="weight-600" id="Address"></strong>
                                    </p>
                                    <p class="font-14 mb-5">
                                        Payment method: <strong class="weight-600" id="paymentMethod"></strong>
                                    </p>
                                    <p class="font-14 mb-5">
                                        Status: <strong class="weight-600" id="status"></strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-desc pb-30">
                            <div class="invoice-desc-head clearfix">
                                <div class="invoice-sub">Product</div>
                                <div class="invoice-rate">Price</div>
                                <div class="invoice-hours">Quantity</div>
                                <div class="invoice-subtotal">Subtotal</div>
                            </div>
                            <div class="invoice-desc-body">
                                <ul id="invoiceItems" class="hidden">
                                    <!-- Invoice items will be appended here -->
                                </ul>
                            </div>
                            <div class="invoice-desc-footer">
                                <div class="invoice-desc-head clearfix">
                                    <div class="invoice-subtotal">Total Due</div>
                                </div>
                                <div class="invoice-desc-body">
                                    <ul>
                                        <li class="clearfix">
                                            <div class="invoice-sub"></div>
                                            <div class="invoice-subtotal">
                                                <span class="weight-600 font-16 text-danger" style="text-align: right" id="discount"></span>
                                                <br>
                                                <span class="weight-600 font-24 text-danger" id="totalDue"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-center pb-20">Thank You!!</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>