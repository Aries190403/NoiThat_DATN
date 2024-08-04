<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_category_form" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="name" style="font-weight: bold;">Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Enter your name" required style="margin-bottom: 15px;" />
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <label for="address" style="font-weight: bold;">Type <span style="color: red;">*</span></label>
                            <select class="form-control" name="type" required>
                                @foreach($types as $type)
                                    <option value="{{ $type['value'] }}">{{ $type['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <div class="select-icon-container">
                                    <button type="button" id="show-icon-grid" class="btn btn-primary">Select Icon</button>
                                    <div id="selected-icon-display" style="margin-left: 10px;"></div>
                                </div>
                                <div id="icon-grid" style="display: none; margin-top: 10px; max-height: 300px; overflow-y: auto;">
                                    <div class="icon-grid-container">
                                        @foreach($icons as $icon)
                                            <div class="icon-cell" data-icon="{{ $icon['class'] }}">
                                                <i class="f-icon {{ $icon['class'] }}"></i>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="hidden" id="selected-icon" name="icon" required>
                            </div>                            
                        </div>
                        <div class="col-md-12 mt-3" id="productSection" style="overflow-x: auto; max-height: 300px;">
                            <label style="font-weight: bold;">Select Products</label>
                            <input type="text" id="productSearch" class="form-control mb-3" placeholder="Search products..." style="position: sticky; top: 0; z-index: 999; background-color: #fff;">
                            <div class="row" id="productList">
                                @foreach($products as $product)
                                @php
                                    $content = json_decode($product->content);
                                    $productName = strlen($product->name) > 15 ? substr($product->name, 0, 15) . '...' : $product->name;
                                @endphp
                                <div class="col-md-3 mb-3 product-card-container">
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
                                        <input type="checkbox" name="products[]" value="{{ $product->id }}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="form-group row">
                                <div class="col-lg-4">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" accept="image/*">
                                        <label class="custom-file-label" for="thumbnail" style="text-align: center">thumbnail</label>
                                    </div>
                                </div>
                                <div class="col-lg-8" id="thumbnailPreview" style="display: none;">
                                    <div class="thumbnail-preview-container" style="margin-top: 10px; text-align: center;">
                                        <img id="thumbnailImage" src="#" alt="Thumbnail Image" style="max-width: 100%; max-height: 200px; border: 1px solid #ddd; border-radius: 5px; padding: 5px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-modal-category">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
