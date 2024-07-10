@extends('backend::base')
@section('content')
<div id="list-table-coupon">
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Statistical</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin-dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Statistical
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::statistical.table.table-index')
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        var statisticsOrder = {!! $statisticsOrder !!};
        
        var categories = [];
        var completeCounts = [];
        var failCounts = [];
        var refundCounts = [];

        statisticsOrder.forEach(function(stat) {
            categories.push(stat.month);
            completeCounts.push(parseInt(stat.complete_count));
            failCounts.push(parseInt(stat.fail_count));
            refundCounts.push(parseInt(stat.refund_count));
        });

        Highcharts.chart('countorder', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Order statistics for the Last 12 Months'
            },
            xAxis: {
                categories: categories,
                crosshair: true
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of orders'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Complete',
                data: completeCounts

            }, {
                name: 'Fail',
                data: failCounts

            }, {
                name: 'Refun',
                data: refundCounts

            }]
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var productData = {!! $productStatistics !!};

            // Ensure productData is an array
            if (!Array.isArray(productData)) {
                console.error('Expected an array for productData');
                return;
            }

            var chartData = productData.map(function (data) {
                return {
                    name: data.name,
                    y: parseFloat(data.total_quantity_sold)
                };
            });

            Highcharts.chart('productChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Product Sales for the Last 12 Months'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y}'
                        }
                    }
                },
                series: [{
                    name: 'Quantity Sold',
                    data: chartData
                }]
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var revenueData = {!! $revenueStatistics !!};

            if (!Array.isArray(revenueData)) {
                console.error('Expected an array for revenueData');
                return;
            }

            var categories = revenueData.map(data => data.month);
            var chartData = revenueData.map((data, index) => ({
                name: data.month,
                y: parseFloat(data.total_revenue),
                color: Highcharts.getOptions().colors[index % Highcharts.getOptions().colors.length]
            }));

            Highcharts.chart('revenueChart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Monthly Revenue for the Last 12 Months'
                },
                xAxis: {
                    categories: categories,
                    title: {
                        text: 'Month'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Total Revenue'
                    }
                },
                plotOptions: {
                    column: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.y:.2f}'
                        }
                    }
                },
                series: [{
                    name: 'Revenue',
                    data: chartData
                }]
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var productRevenueData = {!! $productRevenueData !!};

            // Ensure productRevenueData is an array
            if (!Array.isArray(productRevenueData)) {
                console.error('Expected an array for productRevenueData');
                return;
            }

            var totalRevenue = productRevenueData.reduce(function (acc, curr) {
                return acc + parseFloat(curr.total_revenue);
            }, 0);

            var chartData = productRevenueData.map(function (data) {
                return {
                    name: data.product_name,
                    y: parseFloat(data.total_revenue)
                };
            });

            Highcharts.chart('productRevenueChart', {
                chart: {
                    type: 'pie'
                },
                title: {
                    text: 'Revenue Share by Product for the Last 12 Months'
                },
                subtitle: {
                    text: 'Total Revenue: ' + totalRevenue.toFixed(2) + ' USD'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Revenue',
                    data: chartData
                }]
            });
        });
    </script>
@endsection