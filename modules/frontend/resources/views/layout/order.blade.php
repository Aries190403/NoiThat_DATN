@extends('frontend::main')
@section('content')
    <section class="main-header" style="background-image:url({{ asset('frontend/assets/images/gallery-2.jpg)') }}">
        <header>
            <div class="container text-center">
                <h2 class="h2 title">Customer page</h2>
                <ol class="breadcrumb breadcrumb-inverted">
                    <li><a href="/"><span class="icon icon-home"></span></a></li>
                    <li><a class="active" href="#">Order</a></li>
                </ol>
            </div>
        </header>
    </section>
    <section class="products">
        @if (isset($Invoices))
            {{-- <div class="container">
                <div class="clearfix">
                    <div class="row">
                        <div class="col-xs-6">
                            <span class="h2 title">Your order</span>
                        </div>
                        <div class="col-xs-6 text-right">

                        </div>
                    </div>
                </div>
                <div id="orders" style="background-color: white;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2">Order no.</div>
                            <div class="col-md-2 headorder">
                                <span>Date </span>
                                <div class="sort-options pull-right">
                                    <select id="date-dropdown"
                                        style="    line-height: 21px;text-align: center; width: 110%;">
                                        <option value="all">All</option>
                                        <option value="newest">Newest</option>
                                        <option value="oldest">Oldest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 headorder"><span>Status </span>
                                <div class="sort-options pull-right">
                                    <select
                                        id="status-dropdown"style="    line-height: 21px;text-align: center;width: 110%;">
                                        <option value="all">All</option>

                                        <option value="pending">Pending</option>
                                        <option value="completed">Completed</option>
                                        <option value="canceled">Canceled</option>
                                        <!-- Thêm các giá trị khác tùy ý -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 headorder">Total</div>
                            <div class="col-md-3 headorder">Action</div>
                        </div>
                    </div>
                    <div class=" row bodyorders" id="invoice-list">
                        @foreach ($Invoices as $Invoice)
                            <div class="col-md-12">
                                <div class="col-md-2 bodyorder">#mobel{{ $Invoice->id }}</div>
                                <div class="col-md-2 bodyorder">{{ $Invoice->invoice_date }}</div>
                                <div class="col-md-2 bodyorder">{{ $Invoice->status }}</div>
                                <div class="col-md-3 bodyorder">{{ $Invoice->total }}</div>
                                <div class="col-md-3 bodyorder">
                                    <a href="/editorder/{{ $Invoice->id }}" class="btn btn-danger">View</a>
                                    @if ($Invoice->status == 'Completed')
                                        <a href="/rate/{{ $Invoice->id }}" class="btn btn-default">Rate</a>
                                    @endif
                                    @if ($Invoice->pay->description == 'Unpaid' && $Invoice->pay->name == 'VNPAY')
                                        <a href="/repay/{{ $Invoice->id }}" class="btn btn-main">PAY</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div> --}}
            <div class="container" id="orders" style="background-color: white;">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="col-md-2 classth">Order no.</th>
                            <th class="col-md-2 classth">
                                Date
                                <div class="sort-options pull-right">
                                    <select id="date-dropdown" style="text-align: center;">
                                        <option value="all">All</option>
                                        <option value="newest">Newest</option>
                                        <option value="oldest">Oldest</option>
                                    </select>
                                </div>
                            </th>
                            <th class="col-md-2 classth">
                                Status
                                <div class="sort-options pull-right">
                                    <select id="status-dropdown" style="text-align: center;">
                                        <option value="all">All</option>
                                        <option value="pending">Pending</option>
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Shipping">Shipping</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="Failed">Failed</option>
                                        <option value="Returned">Returned</option>
                                        <option value="Returning">Returning</option>
                                        <!-- Thêm các giá trị khác tùy ý -->
                                    </select>
                                </div>
                            </th>
                            <th class="col-md-2 classth">Total</th>
                            <th class="col-md-1 classth">Payment</th>
                            <th class="col-md-3 classth">Action</th>
                        </tr>
                    </thead>
                    <tbody id="invoice-list">
                        @foreach ($Invoices as $Invoice)
                            <tr>
                                <td class="col-md-2" style="text-align: center">#mobel{{ $Invoice->id }}</td>
                                <td class="col-md-2" style="text-align: center">{{ $Invoice->invoice_date }}</td>
                                <td class="col-md-2"style="text-align: center">{{ $Invoice->status }}</td>
                                <td class="col-md-2"style="text-align: center">$ {{ $Invoice->total }}</td>
                                <td class="col-md-1"style="text-align: center">{{ $Invoice->pay->description }}</td>
                                <td class="col-md-3"style="text-align: center">
                                    <a href="/viewmore/{{ $Invoice->id }}" class="btn btn-info">View</a>
                                    @if ($Invoice->status == 'Completed')
                                        <a data-toggle="modal" data-target="#rateModal{{ $Invoice->id }}"
                                            class="btn btn-danger">Rate</a>
                                    @endif
                                    @if (
                                        ($Invoice->pay->description == 'Unpaid' && $Invoice->pay->name == 'VNPAY' && $Invoice->status == 'Pending') ||
                                            $Invoice->status == 'Confirmed')
                                        <a href="/repay/{{ $Invoice->id }}" class="btn btn-main">PAY</a>
                                    @endif
                                    @if ($Invoice->status == 'Pending' || $Invoice->status == 'Confirmed')
                                        <a href="/cancel/{{ $Invoice->id }}" class="btn btn-warning">Cancel</a>
                                    @endif
                                    @if ($Invoice->status == 'Completed')
                                        <a href="/return/{{ $Invoice->id }}" class="btn btn-warning">Return</a>
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="rateModal{{ $Invoice->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="rateModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document" style="margin-top: 150px">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rateModalLabel">Comment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Địa chỉ nhận -->


                                            <!-- Đánh giá sao -->
                                            <form action="/rate/{{ $Invoice->id }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="rating">Quanlity:</label>
                                                    <div class="star-rating">
                                                        <input type="radio" id="star5" name="rating" value="5"
                                                            checked />
                                                        <label for="star5" title="5 stars">☆</label>
                                                        <input type="radio" id="star4" name="rating"
                                                            value="4" />
                                                        <label for="star4" title="4 stars">☆</label>
                                                        <input type="radio" id="star3" name="rating"
                                                            value="3" />
                                                        <label for="star3" title="3 stars">☆</label>
                                                        <input type="radio" id="star2" name="rating"
                                                            value="2" />
                                                        <label for="star2" title="2 stars">☆</label>
                                                        <input type="radio" id="star1" name="rating"
                                                            value="1" />
                                                        <label for="star1" title="1 star">☆</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="comment">Comment:</label>
                                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                <div id="invoice-list-0"></div>

            </div>
        @else
            <div class="wrapper-more">
                <h3>You don't have any orders yet.</h3>
                <a href="/shop" class="btn btn-main">View store</a>
            </div>
        @endif

        </div> <!--/container-->
    </section>
    <script>
        document.getElementById('date-dropdown').addEventListener('change', function() {
            filterInvoices();
        });

        document.getElementById('status-dropdown').addEventListener('change', function() {
            filterInvoices();
        });

        function filterInvoices() {
            var dateOrder = document.getElementById('date-dropdown').value;
            var status = document.getElementById('status-dropdown').value;

            var url = `/filter-invoices`;

            // Thực hiện yêu cầu AJAX để lấy dữ liệu đã lọc
            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify({
                        dateOrder: dateOrder,
                        status: status,
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Kiểm tra dữ liệu trả về từ server
                    if (data && data.invoices) {
                        // Cập nhật danh sách hóa đơn trên trang với dữ liệu đã lọc
                        updateInvoiceList(data.invoices);
                    } else {
                        console.error('Invalid data format or empty data:', data);
                        // Xử lý trường hợp dữ liệu không hợp lệ hoặc trống
                        // Ví dụ: Hiển thị thông báo cho người dùng
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    // Xử lý lỗi mạng hoặc lỗi trong quá trình yêu cầu AJAX
                    // Ví dụ: Hiển thị thông báo lỗi cho người dùng
                });
        }

        function updateInvoiceList(invoices) {
            var invoiceList = document.getElementById('invoice-list');
            document.getElementById('invoice-list-0').innerHTML = '';
            invoiceList.innerHTML = ''; // Xóa danh sách hiện tại
            if (!invoices || invoices.length === 0) {
                List = document.getElementById('invoice-list-0');
                // Hiển thị thông báo khi không có hóa đơn nào phù hợp
                List.innerHTML = `<span>No invoices were found that matched the search criteria.</span>`;
                return;
            }

            invoices.forEach(invoice => {
                var invoiceItem = document.createElement('tr');

                var rateButton = '';
                if (invoice.status === 'Completed') {
                    rateButton =
                        `<a data-toggle="modal" data-target="#rateModal${invoice.id}" class="btn btn-danger">Rate</a>`;
                }
                var payButton = '';
                // console.log(invoice.payname === 'VNPAY');
                if (invoice.payname === 'VNPAY' && invoice.des === 'Unpaid' && (invoice.status === 'Pending' ||
                        invoice.status === 'Confirmed')) {
                    payButton = `<a href="/repay/${invoice.id}" class="btn btn-main">PAY</a>`;
                }

                var cacelButton = '';
                if (invoice.status === 'Pending' || invoice.status === 'Confirmed') {
                    cacelButton = `<a href="/cancel/${invoice.id}" class="btn btn-warning">Cancel</a>`;
                }

                var returnlButton = '';
                if (invoice.status === 'Completed') {
                    returnlButton = `<a href="/return/${invoice.id}" class="btn btn-warning">Return</a>`;
                }

                invoiceItem.innerHTML = `<tr>
                                <td class="col-md-2" style="text-align: center">#mobel${invoice.id}</td>
                                <td class="col-md-2" style="text-align: center">${invoice.invoice_date}</td>
                                <td class="col-md-2"style="text-align: center">${invoice.status}</td>
                                <td class="col-md-2"style="text-align: center">$ ${invoice.total}</td>
                                <td class="col-md-1"style="text-align: center">${invoice.des}</td>
                                <td class="col-md-3"style="text-align: center">
                                    <a href="/viewmore/${invoice.id}" class="btn btn-info">View</a>
                                    ${rateButton}${payButton}${cacelButton}${returnlButton}
                                </td>
                            </tr>
                            <div class="modal fade" id="rateModal${invoice.id}" tabindex="-1" role="dialog"
                                aria-labelledby="rateModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rateModalLabel">Comment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Địa chỉ nhận -->


                                            <!-- Đánh giá sao -->
                                            <form action="/rate/${invoice.id}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="rating">Qunlity:</label>
                                                    <div class="star-rating">
                                                        <input type="radio" id="star5" name="rating" value="5"
                                                            checked />
                                                        <label for="star5" title="5 stars">☆</label>
                                                        <input type="radio" id="star4" name="rating"
                                                            value="4" />
                                                        <label for="star4" title="4 stars">☆</label>
                                                        <input type="radio" id="star3" name="rating"
                                                            value="3" />
                                                        <label for="star3" title="3 stars">☆</label>
                                                        <input type="radio" id="star2" name="rating"
                                                            value="2" />
                                                        <label for="star2" title="2 stars">☆</label>
                                                        <input type="radio" id="star1" name="rating"
                                                            value="1" />
                                                        <label for="star1" title="1 star">☆</label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="comment">Comment:</label>
                                                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            `;

                invoiceList.appendChild(invoiceItem);
            });
        }
    </script>

@endsection
