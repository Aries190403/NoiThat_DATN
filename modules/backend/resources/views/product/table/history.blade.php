<div class="tab-pane fade" id="listLogs" role="tabpanel">
    <div class="pd-20">
        <div class="pd-20 card-box mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">History</h4>
                </div>
            </div>
            <table id="dataTableProduct" class="data-table table nowrap">
                <thead>
                    <tr style="text-align: center">
                        <th class="table-plus">User</th>
                        <th>Description</th>
                        <th>Supplier</th>
                        <th>Create at</th>
                        <th class="datatable-nosort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr style="text-align: center">
                        <td>{{$log->user->name}}</td>
                        <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$log->description}}</td>
                        @if (isset($log->supplier->name))
                            <td>{{$log->supplier->name}}</td>
                        @else
                            <td>N/A</td>
                        @endif
                        <td>{{$log->created_at}}</td>
                        <td>
                            <a href="#" id="log_detail" style="color: #ff0000;" title="Detail" data-toggle="modal" data-target="#logDetailModal" data-url="{{ route('admin-product-detailLogs', ['id' => $log->id]) }}">
                                <i class="icon-copy dw dw-eye" style="color: inherit"></i>
                            </a>                              
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@include('backend::product.modal.modal-log-detail')