<div class="card-box pb-10">
    <div class="col-md-4 col-sm-12 mb-30">
        <div style="align-items: center ">
            <button
                type="button"
                class="btn btn-primary btn-sm"
                data-toggle="modal"
                data-target="#bd-example-modal-lg"
            >
                <i class="fa fa-user-plus"></i> Add
            </button>
        </div>
        <div
            class="modal fade bs-example-modal-lg"
            id="bd-example-modal-lg"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myLargeModalLabel"
            aria-hidden="true"
        >
            @include('backend::product.modal.modal-add')
        </div>
    </div>
    <table id="dataTableUsers" class="data-table table nowrap">
        <thead>
            <tr style="text-align: center">
                <th></th>
                <th>Name</th>
                <th>Type</th>
                <th>sale</th>
                <th>Status</th>
                <th class="datatable-nosort">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td></td>
                <td>{{$product->name}}</td>
                <td></td>
                <td></td>
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
                    <a href="{{route('admin-product-edit', ['id' => $product->id])}}" style="color: #265ed7;">
                        <i class="icon-copy dw dw-edit2" style="color: inherit;"></i>
                    </a>
                    {{-- <a href="{{route('admin-product-delete', ['id' => $product->id])}}" id="delete-product" style="color: #ff0000;">
                        <i class="icon-copy dw dw-delete-3" style="color: inherit;"></i>
                    </a>
                    @if ($product->locked == 'normal')
                        <a href="{{route('admin-product-state', ['id' => $product->id])}}" id="lock-product" style="color: #ff0000;">
                            <i class="icon-copy dw dw-padlock1" style="color: inherit;"></i>
                        </a>
                    @else
                        <a href="{{route('admin-product-state', ['id' => $product->id])}}" id="lock-product" style="color: #00ff3381;">
                            <i class="icon-copy dw dw-open-padlock" style="color: inherit;"></i>
                        </a>
                    @endif --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>