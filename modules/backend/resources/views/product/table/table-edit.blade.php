<div class="pd-20 card-box" id="table-product">
    <h5 class="h4 text-blue mb-20">Information</h5>
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home" role="tab" aria-selected="true">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#listImage" role="tab" aria-selected="false">Image</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#listLogs" role="tab" aria-selected="false">History</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <div class="row">
                    <div class="col-lg-4" style="margin-top: 1rem">
                        <div style="width:160px; height:160px; margin:0 auto 15px;position:relative">
                            <form id="uploadForm" method="POST" action="{{ route('admin-product-imgThumbnail', ['id' => $product->id]) }}" enctype="multipart/form-data">
                                @csrf
                                <a href="#" class="edit-avatar" id="uploadImageLink"><i class="icon-copy dw dw-pencil-1" style="color: red"></i></a>
                                <input type="file" id="imageInput" name="image" style="display: none;">
                            </form>
                            @php
                                $content = json_decode($product->content)
                            @endphp
                            @if (isset($content->imgThumbnail))
                                <img src="{{ asset($content->imgThumbnail) }}" alt="" />
                            @else
                                <img src="{{ asset('backend/src/images/image-clone.svg')}}" alt="" />
                            @endif
                        </div>
                        <h5 class="text-center h5 mb-0" style="margin-top: 10%">{{$product->name}}</h5>
                        <p class="text-center text-muted font-14">{{$product->role}}</p>

                        <div class="row" style="text-align: center;">
                            <div class="col-md-4" style="margin-bottom: 10px;">
                                <a href="{{ route('admin-product-del', ['id' => $product->id]) }}" id="delete-product" style="color: #ff0000;" title="Delete this product">
                                    <i class="icon-copy dw dw-delete-3" style="color: inherit; font-size: 50px"></i>
                                </a>
                            </div>
                            <div class="col-md-4" style="margin-bottom: 10px;">
                                @if ($product->status != 'normal')
                                    <a href="{{ route('admin-product-state', ['id' => $product->id]) }}" id="lock-product" style="color: #ff0000;" title="Lock this product">
                                        <i class="icon-copy dw dw-padlock1" style="color: inherit; font-size: 50px"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin-product-state', ['id' => $product->id]) }}" id="lock-product" style="color: #00ff3381;" title="Unlock this product">
                                        <i class="icon-copy dw dw-open-padlock" style="color: inherit; font-size: 50px"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-4" style="margin-bottom: 10px;">
                                <a href="#" data-id="{{ $product->id }}" id="importing-product" style="color: #ffea00;" title="Import more goods">
                                    <i class="icon-copy dw dw-box-1" style="color: inherit; font-size: 50px"></i>
                                </a>
                            </div>
                        </div>                        
                    </div>

                    <form action="{{ route('admin-product-imgThumbnail', ['id' => $product->id]) }}" id="uploadForm" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" id="image" name="image" style="display: none;">
                    </form>
                    <div class="col-lg-8">
                        <form id="productForm" method="POST" action="{{route('admin-product-update',['id'=>$product->id])}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label for="name" style="font-weight: bold;">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter your name" value="{{ isset($product->name) ? $product->name : '' }}" required style="margin-bottom: 15px;" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="price" style="font-weight: bold;">Price (USD)</label>
                                    <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter price" value="{{ isset($product->price) ? $product->price : '' }}" style="margin-bottom: 15px;" required />
                                </div>
                                <div class="col-md-6">
                                    <label for="type" style="font-weight: bold;">Type</label>
                                    <select class="form-control" name="type" style="margin-bottom: 15px;">
                                        @if (isset($product->category_id))
                                            <option value="" disabled selected>{{$product->category->name}}</option>
                                        @else
                                            <option value="" disabled selected>select type</option>
                                        @endif
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="material" style="font-weight: bold;">Material</label>
                                    <select class="form-control" name="material" style="margin-bottom: 15px;" >
                                        @if (isset($product->material_id))
                                            <option value="" disabled selected>{{$product->material->name}}</option>
                                        @else
                                            <option value="" disabled selected>select material</option>
                                        @endif
                                        @foreach($materials as $material)
                                            <option value="{{ $material->id }}">{{ $material->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="stock" style="font-weight: bold;">Stock</label>
                                    <input type="number" class="form-control" name="stock" placeholder="Enter stock quantity"  value="{{ isset($product->stock) ? $product->stock : '' }}" style="margin-bottom: 15px;" required min="0" />
                                </div>                   
                                <div class="col-md-6">
                                    <label for="stock" style="font-weight: bold;">Sale (%)</label>
                                    <input type="number" class="form-control" name="sale" placeholder="Enter sale percentage" value="{{ isset($product->sale_percentage) ? $product->sale_percentage : '' }}" style="margin-bottom: 15px;" min="0" max="100" />
                                </div>
                                <div class="col-md-4">
                                    <label for="height" style="font-weight: bold;">Height (cm)</label>
                                    <input type="number" step="0.01" class="form-control" name="height" placeholder="Enter height" value="{{ isset($content->size->height) ? $content->size->height : '' }}" style="margin-bottom: 15px;" min="0" />
                                </div>
                                <div class="col-md-4">
                                    <label for="length" style="font-weight: bold;">Length (cm)</label>
                                    <input type="number" step="0.01" class="form-control" name="length" placeholder="Enter length" value="{{ isset($content->size->length) ? $content->size->length : '' }}" style="margin-bottom: 15px;" min="0" />
                                </div>
                                <div class="col-md-4">
                                    <label for="width" style="font-weight: bold;">Width (cm)</label>
                                    <input type="number" step="0.01" class="form-control" name="width" placeholder="Enter width" value="{{ isset($content->size->width) ? $content->size->width : '' }}" style="margin-bottom: 15px;" min="0" />
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label for="description" style="font-weight: bold;">Description</label>
                                        <textarea class="form-control" name="description" placeholder="Enter description" style="margin-bottom: 15px;">{{$product->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-container">
                                <button type="submit" class="btn-save" id="saveButton" style="display: none;">
                                    <i class="ti-save"></i> Save
                                </button>
                            </div>
                        </form>
                        <div id="errorMessages"></div>                                              
                    </div>
                </div>
            </div>
            @include('backend::product.table.ImageList')
            @include('backend::product.table.history')
            @include('backend::product.modal.modal-importing')
        </div>
    </div>
</div>