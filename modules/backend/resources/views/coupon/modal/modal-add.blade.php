<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="exampleModal">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Add Voucher
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="kt_modal_coupon_form" action="{{route('admin-coupon-create')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="code" style="font-weight: bold;">Code <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="code" placeholder="Enter code" required style="margin-bottom: 15px;" maxlength="30"/>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="limit" style="font-weight: bold;">Limit <span style="color: red;">*</span></label>
                        <input type="number" step="1" class="form-control" name="limit" placeholder="Enter Limit" required min="0" max="9999999" maxlength="7" />
                    </div>
                    <div class="col-md-4">
                        <label for="Discount" style="font-weight: bold;">Discount (%)</label>
                        <input type="number" step="0.1" class="form-control" name="discount" placeholder="Enter Discount" min="0" max="100" />
                    </div>
                    <div class="col-md-4">
                        <label for="discount_money" style="font-weight: bold;">Max money</label>
                        <input type="number" step="0.01" class="form-control" name="discount_money" placeholder="Enter Max money" min="0" />
                    </div>
                    <div class="col-md-6" style="margin-top: 15px;" >
                        <label for="down_date" style="font-weight: bold;">Down Date</label>
                        <input
                            type="text"
                            class="form-control date-picker"
                            placeholder="Select Date"
                            name="date"
                        />
                    </div>
                    <div class="col-md-6" style="margin-top: 15px;">
                        <label for="down_time" style="font-weight: bold;">Down Time</label>
                        <input
                            class="form-control time-picker"
                            placeholder="Select time"
                            type="text"
                            name="time"
                        />
                    </div>

                    <div class="col-md-12" style="margin-top: 15px;">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="description" style="font-weight: bold;">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter description" style="margin-bottom: 15px;"></textarea>
                        </div>
                    </div>
                </div>

                <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-modal-coupon">Add coupon</button>
                </div>
            </form>
        </div>
    </div>
</div>