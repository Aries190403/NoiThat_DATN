<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="exampleModal">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Add Product
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="kt_modal_product_form" action="{{route('admin-product-create')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="name" style="font-weight: bold;">Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name" required style="margin-bottom: 15px;" />
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="price" style="font-weight: bold;">Price (USD) <span style="color: red;">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter price" required />
                    </div>

                    <div class="col-md-6">
                        <label for="supplier" style="font-weight: bold;">Supplier</label>
                        <select class="form-control" name="supplier">
                            <option value="">Select supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="type" style="font-weight: bold;">Type <span style="color: red;">*</span></label>
                        <select class="form-control" name="type" required>
                            <option value="" disabled selected>Select type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="material" style="font-weight: bold;">Material</label>
                        <select class="form-control" name="material">
                            <option value="">Select material</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="stock" style="font-weight: bold;">Stock <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" name="stock" placeholder="Enter stock quantity" required min="0" max='999999' />
                    </div>
                    
                    <div class="col-md-4">
                        <label for="height" style="font-weight: bold;">Height (cm)</label>
                        <input type="number" step="0.01" class="form-control" name="height" placeholder="Enter height" min="0" />
                    </div>
                    <div class="col-md-4">
                        <label for="length" style="font-weight: bold;">Length (cm)</label>
                        <input type="number" step="0.01" class="form-control" name="length" placeholder="Enter length" min="0" />
                    </div>
                    <div class="col-md-4">
                        <label for="width" style="font-weight: bold;">Width (cm)</label>
                        <input type="number" step="0.01" class="form-control" name="width" placeholder="Enter width" min="0" />
                    </div>

                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="description" style="font-weight: bold;">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter description" style="margin-bottom: 15px;"></textarea>
                        </div>
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
