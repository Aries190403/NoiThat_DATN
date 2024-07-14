<div class="card-box pb-10">
    <div class="col-md-4 col-sm-12 mb-30">
        <div style="align-items: center ">
            <button
                type="button"
                class="btn btn-primary btn-sm"
                data-toggle="modal"
                data-target="#bd-example-modal-lg"
            >
                <i class="fa fa-coupon-plus"></i> Add
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
            @include('backend::coupon.modal.modal-add')
        </div>
    </div>
    @include('backend::coupon.modal.modal-view')
    @include('backend::coupon.modal.modal-edit')
    <table id="dataTablecoupon" class="data-table table nowrap">
        <thead>
            <tr>
                <th class="table-plus">Code</th>
                <th style="text-align: center">Limit</th>
                <th style="text-align: center">Discount</th>
                <th style="text-align: center">Max money</th>
                <th style="text-align: center">Down Time</th>
                <th style="text-align: center">Status</th>
                <th class="datatable-nosort" style="text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $coupon)
            <tr style="text-align: center">
                <td style="text-align: left">{{$coupon->code}}</td>
                <td>{{$coupon->limit}}</td>
                <td>{{$coupon->discount}}</td>
                <td>{{$coupon->discount_money}} $</td>
                <td>{{ \Carbon\Carbon::parse($coupon->downtime)->format('F j, Y g:i A') }}</td>
                <td  style="text-align: center">
                    @if ($coupon->status == 'normal')
                        <span class="badge badge-success">
                            {{$coupon->status}}
                        </span>
                    @else
                        <span class="badge badge-secondary">
                            {{$coupon->status}}
                        </span>
                        
                    @endif
                </td>
                <td  style="text-align: center">
                    <a href="{{ route('admin-coupon-view', ['id' => $coupon->id]) }}" class="openModalEdit" data-coupon-id="{{ $coupon->id }}" style="color: #265ed7;">
                        <i class="icon-copy dw dw-edit2" style="color: inherit;"></i>
                    </a>
                    <a href="{{ route('admin-coupon-view', ['id' => $coupon->id]) }}" class="openModalView" data-coupon-id="{{ $coupon->id }}" style="color: #fb9700;">
                        <i class="icon-copy dw dw-eye" style="color: inherit;"></i>
                    </a>
                    @if ($coupon->status == 'normal')
                        <a href="{{route('admin-coupon-state', ['id' => $coupon->id])}}" id="lock-coupon" style="color: #ff0000;">
                            <i class="icon-copy dw dw-padlock1" style="color: inherit;"></i>
                        </a>
                    @else
                        <a href="{{route('admin-coupon-state', ['id' => $coupon->id])}}" id="lock-coupon" style="color: #00ff3381;">
                            <i class="icon-copy dw dw-open-padlock" style="color: inherit;"></i>
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>