<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Imports of Goods</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="quantityForm" action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="quantity" style="font-weight: bold;">quantity <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" name="quantity" placeholder="Enter quantity" required min="1" max="999999" />
                        </div>
                        <div class="col-md-6">
                            <label for="supplier" style="font-weight: bold;">Supplier <span style="color: red;">*</span></label>
                            <select class="form-control" name="supplier" required>
                                <option value="">Select supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-modal-product">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>