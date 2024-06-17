<!-- Modal -->
<div class="modal fade" id="modalAddProductDetail" tabindex="-1" role="dialog" aria-labelledby="modalAddProductDetailLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddProductDetailLabel">Add Product Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_product_detail_form" action="{{route('admin-product-detail-create')}}" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}" />
                    <div class="form-group">
                        <label for="material" style="font-weight: bold;">Material <span style="color: red;">*</span></label>
                        <select class="form-control" name="material" required>
                            <option value="">Select material</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="price" style="font-weight: bold;">Price (USD) <span style="color: red;">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter price" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stock" style="font-weight: bold;">Stock <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" name="stock" placeholder="Enter stock quantity" required />
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="height" style="font-weight: bold;">Height (cm) <span style="color: red;">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="height" placeholder="Enter height" required />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="length" style="font-weight: bold;">Length (cm) <span style="color: red;">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="length" placeholder="Enter length" required />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="width" style="font-weight: bold;">Width (cm) <span style="color: red;">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="width" placeholder="Enter width" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" style="font-weight: bold;">Description</label>
                        <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
                    </div>

                    <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Product Detail</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
