<div class="card-box pb-10">
    <div class="col-md-4 col-sm-12 mb-30">
        <div style="align-items: center ">
            <button
                type="button"
                class="btn btn-primary btn-sm"
                data-toggle="modal"
                data-target="#bd-example-modal-lg"
            >
                <i class="fa fa-material-plus"></i> Add
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
            @include('backend::material.modal.modal-add')
        </div>
    </div>
    @include('backend::material.modal.modal-edit')
    <table id="dataTablematerial" class="data-table table nowrap">
        <thead>
            <tr>
                <th class="table-plus">Name</th>
                <th>Color</th>
                <th style="text-align: center">Type</th>
                <th style="text-align: center">Status</th>
                <th class="datatable-nosort" style="text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($materials as $material)
            <tr>
                <td>{{$material->name}}</td>
                <td>{{$material->color}}</td>
                <td>{{$material->type}}</td>
                <td  style="text-align: center">
                    @if ($material->status == 'normal')
                        <span class="badge badge-success">
                            {{$material->status}}
                        </span>
                    @else
                        <span class="badge badge-secondary">
                            {{$material->status}}
                        </span>
                        
                    @endif
                </td>
                <td  style="text-align: center">
                    <a href="{{ route('admin-material-edit', ['id' => $material->id]) }}" class="openModalEdit" data-material-id="{{ $material->id }}" style="color: #265ed7;">
                        <i class="icon-copy dw dw-edit2" style="color: inherit;"></i>
                    </a>
                    <a href="#" id="delete-category" data-id="{{ $material->id }}" style="color: #ff0000;">
                        <i class="icon-copy dw dw-delete-3" style="color: inherit;"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>