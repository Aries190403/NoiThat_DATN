<div class="modal fade" id="editVoucherModal" tabindex="-1" role="dialog" aria-labelledby="editVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVoucherModalLabel">Edit Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editVoucherForm" action="#" method="post">
                    @csrf
                    <input type="hidden" name="id" id="voucherId" />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="code" style="font-weight: bold;">Code <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="code" id="voucherCode" placeholder="Enter code" required style="margin-bottom: 15px;" maxlength="30" readonly />
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="limit" style="font-weight: bold;">Limit <span style="color: red;">*</span></label>
                            <input type="number" step="1" class="form-control" name="limit" id="voucherLimit" placeholder="Enter Limit" required min="0" max="9999999" maxlength="7" />
                        </div>
                        <div class="col-md-4">
                            <label for="Discount" style="font-weight: bold;">Discount (%)</label>
                            <input type="number" step="0.1" class="form-control" name="discount" id="voucherDiscount" placeholder="Enter Discount" min="0" max="100" />
                        </div>
                        <div class="col-md-4">
                            <label for="discount_money" style="font-weight: bold;">Max money</label>
                            <input type="number" step="0.01" class="form-control" name="discount_money" id="voucherDiscountMoney" placeholder="Enter Max money" min="0" max="99999" />
                        </div>
                        <div class="col-md-6" style="margin-top: 15px;">
                            <label for="down_date" style="font-weight: bold;">Down Date</label>
                            <input type="text" class="form-control date-picker" id="voucherDate" placeholder="Select Date" name="date" />
                        </div>
                        <div class="col-md-6" style="margin-top: 15px;">
                            <label for="down_time" style="font-weight: bold;">Down Time</label>
                            <input class="form-control time-picker" id="voucherTime" placeholder="Select time" type="text" name="time" />
                        </div>

                        <div class="col-md-12" style="margin-top: 15px;">
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="description" style="font-weight: bold;">Description</label>
                                <textarea class="form-control" name="description" id="voucherDescription" placeholder="Enter description" style="margin-bottom: 15px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-modal-coupon">Update Voucher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
