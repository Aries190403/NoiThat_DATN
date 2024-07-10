<div class="modal fade" id="importGoodsModal" tabindex="-1" role="dialog" aria-labelledby="importGoodsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importGoodsModalLabel">Import Goods</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="importGoodsForm" action="{{ route('admin-product-importProducts') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-md-6 mt-3" id="productSection" style="overflow-x: auto;">
                        <div class="form-group">
                            <label for="supplier" style="font-weight: bold;">Select Supplier</label>
                            <select class="form-control" name="supplier" id="supplier" required>
                                <option value="">Select supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3" id="productSection" style="overflow-x: auto; max-height: 500px;">
                        <label style="font-weight: bold;">Select Products</label>
                        <input type="text" id="productSearch" class="form-control mb-3" placeholder="Search products..." style="position: sticky; top: 0; z-index: 999; background-color: #fff;">
                        <div class="row" id="productList">
                            @foreach($products as $product)
                            @php
                                $content = json_decode($product->content);
                                $productName = strlen($product->name) > 15 ? substr($product->name, 0, 15) . '...' : $product->name;
                            @endphp
                            <div class="col-md-2 mb-3 product-card-container">
                                <div class="product-card" data-product-id="{{ $product->id }}">
                                    <div class="product-image">
                                        @if (isset($content->imgThumbnail))
                                            <img src="{{ asset($content->imgThumbnail) }}" alt="{{ $product->name }}" style="max-width: 100%;">
                                        @else
                                            <img src="{{ asset('backend/src/images/image-clone.svg')}}" alt="{{ $product->name }}" style="max-width: 100%;">
                                        @endif
                                    </div>
                                    <div class="product-details">
                                        <span title="{{ $product->name }}">{{ $productName }}</span>
                                    </div>
                                    <div class="product-actions">
                                        <input type="checkbox" class="product-checkbox" name="products[]" value="{{ $product->id }}" style="position: absolute; top: 10px; right: 10px;">
                                        <input type="number" name="quantity[]" class="form-control product-quantity" min="1" max="999">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
