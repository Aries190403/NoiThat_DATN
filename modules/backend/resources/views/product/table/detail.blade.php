<div class="tab-pane fade" id="contact2" role="tabpanel">
    <div class="pd-20">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddProductDetail">
            Add Product Detail
        </button>
        <div class="card-box pb-10">
            <table id="dataTableProductDetail" class="data-table table nowrap">
                <thead>
                    <tr style="text-align: center">
                        <th class="table-plus">#</th>
                        <th>Color</th>
                        <th>material</th>
                        <th>price</th>
                        <th>stook</th>
                        <th>size</th>
                        <th>Status</th>
                        <th class="datatable-nosort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productDetails as $product)
                    @php
                        $content = json_decode($product->content)
                    @endphp
                    <tr>
                        <td style="text-align: center">
                            {{$product->id ?? 'N/A'}}
                        </td>
                        <td style="text-align: center">
                            {{$product->material->color ?? 'N/A'}}
                        </td>
                        <td style="text-align: center">
                            {{$product->material->type ?? 'N/A'}}
                        </td>
                        <td style="text-align: center">
                            {{$product->price ?? 'N/A'}}
                        </td>
                        <td style="text-align: center">
                            {{$product->stock ?? 'N/A'}}
                        </td>

                        @php
                            $size = json_decode($product->size)
                        @endphp

                        <td style="text-align: center">
                            @if(isset($size->height) && isset($size->length) && isset($size->width))
                                {{ $size->height . ':' . $size->length . ':' . $size->width }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td style="text-align: center">
                            @if ($product->status == 'normal')
                                <span class="badge badge-success">
                                    {{$product->status}}
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    {{$product->status}}
                                </span>
                            @endif
                        </td>
                        <td style="text-align: center">
                            {{-- <a href="{{route('admin-product-edit', ['id' => $product->id])}}" style="color: #265ed7; margin-right: 10px;">
                                <i class="icon-copy dw dw-edit2" style="color: inherit;"></i>
                            </a>
                            <a href="{{route('admin-product-delete', ['id' => $product->id])}}" id="delete-product" style="color: #ff0000; margin-right: 10px;">
                                <i class="icon-copy dw dw-delete-3" style="color: inherit;"></i>
                            </a>
                            @if ($product->locked == 'normal')
                                <a href="{{route('admin-product-state', ['id' => $product->id])}}" id="lock-product" style="color: #ff0000; margin-right: 10px;">
                                    <i class="icon-copy dw dw-padlock1" style="color: inherit;"></i>
                                </a>
                            @else
                                <a href="{{route('admin-product-state', ['id' => $product->id])}}" id="lock-product" style="color: #00ff3381; margin-right: 10px;">
                                    <i class="icon-copy dw dw-open-padlock" style="color: inherit;"></i>
                                </a>
                            @endif --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
    </div>
</div>