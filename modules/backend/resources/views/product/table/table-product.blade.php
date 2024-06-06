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
    {{-- @include('backend::Category.modal.modal-edit') --}}
    <table id="dataTableUsers" class="data-table table nowrap">
        <thead>
            <tr style="text-align: center">
                <th></th>
                <th class="table-plus">Name</th>
                <th>Type</th>
                <th>sale</th>
                <th>Status</th>
                <th class="datatable-nosort">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr style="text-align: center">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    {{-- @if ($category->status == 'normal')
                        <span class="badge badge-success">
                            {{$category->status}}
                        </span>
                    @else
                        <span class="badge badge-secondary">
                            {{$category->status}}
                        </span>
                        
                    @endif --}}
                </td>
                <td>
                    <a href="{{route('admin-user-edit', ['id' => $user->id])}}" style="color: #265ed7;">
                        <i class="icon-copy dw dw-edit2" style="color: inherit;"></i>
                    </a>
                    <a href="{{route('admin-user-delete', ['id' => $user->id])}}" id="delete-user" style="color: #ff0000;">
                        <i class="icon-copy dw dw-delete-3" style="color: inherit;"></i>
                    </a>
                    {{-- @if ($user->locked == 'normal')
                        <a href="{{route('admin-user-state', ['id' => $user->id])}}" id="lock-user" style="color: #ff0000;">
                            <i class="icon-copy dw dw-padlock1" style="color: inherit;"></i>
                        </a>
                    @else
                        <a href="{{route('admin-user-state', ['id' => $user->id])}}" id="lock-user" style="color: #00ff3381;">
                            <i class="icon-copy dw dw-open-padlock" style="color: inherit;"></i>
                        </a>
                    @endif --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>