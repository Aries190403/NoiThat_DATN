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
            @include('backend::Category.modal.modal-add')
        </div>
    </div>
    @include('backend::Category.modal.modal-edit')
    <table id="dataTableCategory" class="data-table table nowrap">
        <thead>
            <tr style="text-align: center">
                <th></th>
                <th class="table-plus">Name</th>
                <th>Type</th>
                <th>Status</th>
                <th class="datatable-nosort">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr style="text-align: center">
                @php
                    $content = json_decode($category->content)
                @endphp
                <td>
                    <i class="f-icon {{$content->icon}}"></i>
                </td>
                <td>{{$category->name}}</td>
                <td>{{$category->type}}</td>
                <td>
                    @if ($category->status == 'normal')
                        <span class="badge badge-success">
                            {{$category->status}}
                        </span>
                    @else
                        <span class="badge badge-secondary">
                            {{$category->status}}
                        </span>
                        
                    @endif
                </td>
                <td>
                    {{-- <a href="{{route('admin-category-edit',['id'=>$category->id])}}" class="openModalEdit" data-category-id="{{ $category->id }}">Edit category</a> --}}
                    <a href="#" data-url="{{route('admin-category-edit',['id'=>$category->id])}}" class="openModalEdit" data-category-id="{{ $category->id }}" style="color: #265ed7;">
                        <i class="icon-copy dw dw-edit2" style="color: inherit;"></i>
                    </a>
                    <a href="#" id="delete-category" data-id="{{ $category->id }}" style="color: #ff0000;">
                        <i class="icon-copy dw dw-delete-3" style="color: inherit;"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>