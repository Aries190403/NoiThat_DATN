<div class="pd-20 card-box">
    <div class="tab">
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link text-blue active" data-toggle="tab" href="#home5" role="tab" aria-selected="true">New</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-blue" data-toggle="tab" href="#profile5" role="tab" aria-selected="false">Processing</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-blue" data-toggle="tab" href="#contact5" role="tab" aria-selected="false">Completed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-blue" data-toggle="tab" href="#failed" role="tab" aria-selected="false">Failed</a>
            </li>
        </ul>
        @include('backend::invoice.modal.modal-detail')
        <div class="tab-content">
            @foreach (['home5' => 'Pending', 'profile5' => ['Confirmed', 'Shipping'], 'contact5' => ['Completed', 'Completed - Rated'], 'failed' => ['Failed', 'Refunding', 'Refuned', 'Returnding', 'Returned']] as $tab => $statuses)
            <div class="tab-pane fade @if($loop->first) active show @endif" id="{{ $tab }}" role="tabpanel">
                <div class="pd-20">
                    <table id="dataTableinvoice{{ $tab }}" class="data-table table nowrap">
                        <thead>
                            <div class="row">
                                @if($tab == 'home5')
                                <button class="btn btn-primary status-btn" style="margin-right: 1rem;" data-status="Pending" data-tab="{{ $tab }}" data-request-type="Confirmed">Confirmed</button>
                                @elseif($tab == 'profile5')
                                <button class="btn btn-primary status-btn" style="margin-right: 1rem;" data-status="Confirmed" data-tab="{{ $tab }}" data-request-type="Shipping">Shipping</button>
                                <button class="btn btn-primary status-btn" style="margin-right: 1rem;" data-status="Shipping" data-tab="{{ $tab }}" data-request-type="Completed">Completed</button>
                                <button class="btn btn-primary status-btn" style="margin-right: 1rem;" data-status="Shipping" data-tab="{{ $tab }}" data-request-type="Returning">Returning</button>
                                @elseif($tab == 'failed')
                                <button class="btn btn-primary status-btn" style="margin-right: 1rem;" data-status="Refunding" data-tab="{{ $tab }}" data-request-type="Refunded">Refunded</button>
                                <button class="btn btn-primary status-btn" style="margin-right: 1rem;" data-status="Returnding" data-tab="{{ $tab }}" data-request-type="Returned">Returned</button>
                                @endif
                            </div>
                            <tr>
                                @if($tab != 'contact5')
                                <th>
                                    <div class="dt-checkbox">
                                        <input type="checkbox" id="selectAll{{ $tab }}" style="display: none;">
                                        <span class="dt-checkbox-label"></span>
                                    </div>
                                </th>
                                @endif
                                <th class="table-plus">Name</th>
                                <th style="text-align: center">Phone</th>
                                <th style="text-align: center">Total</th>
                                <th style="text-align: center">Discount money</th>
                                <th style="text-align: center">Status</th>
                                <th style="text-align: center">Date created</th>
                                <th class="datatable-nosort" style="text-align: center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            @if (in_array($invoice->status, (array) $statuses))
                            <tr style="text-align: center">
                                @if($tab != 'contact5')
                                <td>
                                    <div class="dt-checkbox">
                                        <input type="checkbox" class="invoiceCheckbox" data-id="{{ $invoice->id }}" data-status="{{ $invoice->status }}" style="display: none;">
                                        <span class="dt-checkbox-label" style="display: none;"></span>
                                    </div>
                                </td>
                                @endif
                                <td style="text-align: left">{{ $invoice->name }}</td>
                                <td>{{ $invoice->phone }}</td>
                                <td>{{ $invoice->total }} $</td>
                                <td>{{ $invoice->coupon_id ? $invoice->discountMoney : '0 $' }}</td>
                                <td style="text-align: center">
                                    <span class="badge badge-success">{{ $invoice->status }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($invoice->created_at)->format('F j, Y g:i A') }}</td>
                                <td style="text-align: center">
                                    {{-- action --}}
                                    <a href="#" class="openInvoiceModal" data-id="{{ $invoice->id }}" style="color: #fb9700;">
                                        <i class="icon-copy dw dw-eye" style="color: inherit;"></i>
                                    </a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                    @if($tab != 'contact5')
                    <button id="updateButton{{ $tab }}" class="btn btn-primary updateButton" style="display: none;" data-request-type="">Update</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>