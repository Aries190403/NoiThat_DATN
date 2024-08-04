<div class="bg-white pd-20 card-box mb-30">
    <h5 class="text-center mb-4">Statistics for the Last 12 Months</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="card statistics-card total-revenue">
                    <div class="card-header">
                        Total Revenue
                    </div>
                    <div class="card-body">
                        <i class="fas fa-dollar-sign"></i>
                        <h5 class="card-title">${{ number_format($statisticsData->total_revenue, 2) }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card statistics-card total-orders">
                    <div class="card-header">
                        Total Orders
                    </div>
                    <div class="card-body">
                        <i class="fas fa-shopping-cart"></i>
                        <h5 class="card-title">{{ $statisticsData->total_orders }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card statistics-card total-vouchers">
                    <div class="card-header">
                        Total Vouchers Used
                    </div>
                    <div class="card-body">
                        <i class="fas fa-ticket-alt"></i>
                        <h5 class="card-title">{{ $statisticsData->total_vouchers }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card statistics-card total-discount">
                    <div class="card-header">
                        Total Discount Money
                    </div>
                    <div class="card-body">
                        <i class="fas fa-percentage"></i>
                        <h5 class="card-title">${{ number_format($statisticsData->total_discount, 2) }}</h5>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="bg-white pd-20 card-box mb-30">
    <div id="countorder" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>
<div class="bg-white pd-20 card-box mb-30">
    <div id="revenueChart"></div>
</div>
<div class="bg-white pd-20 card-box mb-30">
    <div class="row">
        <div class="col-md-6" id="productChart"></div>
        <div class="col-md-6" id="productRevenueChart"></div>
    </div>
</div>