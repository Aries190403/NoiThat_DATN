<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="exampleModal">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Add Product
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="kt_modal_product_form" action="#" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="name" style="font-weight: bold;">Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name" required style="margin-bottom: 15px;" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="type" style="font-weight: bold;">Type <span style="color: red;">*</span></label>
                        <select class="form-control" name="type" required>
                            <option value="" disabled selected>Select type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->name }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="description" style="font-weight: bold;">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter description" style="margin-bottom: 15px;"></textarea>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">

                    </div>
                </div>

                <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-modal-category">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
