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
            @include('backend::supplier.modal.modal-add')
        </div>
    </div>
    @include('backend::supplier.modal.modal-view')
    @include('backend::user.modal.modal-cropped')
    {{-- @include('backend::supplier.modal.modal-edit') --}}

    <table id="dataTablesupplier" class="data-table table nowrap">
        <thead>
            <tr style="text-align: center">
                <th class="table-plus">Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>status</th>
                <th class="datatable-nosort">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($suppliers as $supplier)
            <tr style="text-align: center">
                <td class="table-plus">
                    <div class="name-avatar d-flex align-items-center">
                        <div class="avatar mr-2 flex-shrink-0">
                            @if (isset($supplier->avatar))
                                <img
                                    src="{{ asset($supplier->picture->image) }}"
                                    class="border-radius-100 shadow"
                                    width="40"
                                    height="40"
                                    alt=""
                                />
                            @else
                                <img
                                    src="{{ asset('backend/src/images/no-image.svg')}}"
                                    class="border-radius-100 shadow"
                                    width="40"
                                    height="40"
                                    alt=""
                                />
                            @endif
                        </div>
                        <div class="txt">
                            <div class="weight-600">{{$supplier->name}}</div>
                        </div>
                    </div>
                </td>
                <td>{{$supplier->email}}</td>
                <td>{{$supplier->phone}}</td>
                @if (isset($supplier->address_id))
                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $supplier->address->street }}
                        @if(!empty($supplier->address->ward))
                            , {{ $supplier->address->ward }}
                        @endif
                        @if(!empty($supplier->address->district))
                            , {{ $supplier->address->district }}
                        @endif
                        @if(!empty($supplier->address->city))
                            , {{ $supplier->address->city }}
                        @endif
                    </td>
                @else
                    <td style="max-width: 40px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: center; color:#ff0000">No Address</td>
                @endif
                <td>
                    @if ($supplier->status == 'normal')
                        <span class="badge badge-success">
                            {{$supplier->status}}
                        </span>
                    @else
                        <span class="badge badge-secondary">
                            {{$supplier->status}}
                        </span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin-supplier-infor', ['id' => $supplier->id]) }}" class="openModalView" data-supplier-id="{{ $supplier->id }}" style="color: #fb9700;">
                        <i class="icon-copy dw dw-eye" style="color: inherit;"></i>
                    </a>
                    @if ($supplier->status == 'normal')
                        <a href="{{route('admin-supplier-state', ['id' => $supplier->id])}}" id="lock-supplier" style="color: #ff0000;">
                            <i class="icon-copy dw dw-padlock1" style="color: inherit;"></i>
                        </a>
                    @else
                        <a href="{{route('admin-supplier-state', ['id' => $supplier->id])}}" id="lock-supplier" style="color: #00ff3381;">
                            <i class="icon-copy dw dw-open-padlock" style="color: inherit;"></i>
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>