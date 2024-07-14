<!DOCTYPE html>
<html lang="en">

<head>
    @include('backend::elements.head')
</head>
<body> <!--class="animsition" -->

    <!-- Header -->
    @include('backend::elements.header')

    @include('backend::elements.sidebar')

    @yield('content')

    <!-- footer -->
    @include('backend::elements.footer')

    @yield('script')
    <script>
        $(document).ready(function(){
            var table = $('.data-table');
            if ($.fn.DataTable.isDataTable(table)) {
                table.DataTable().destroy();
            }
            table.DataTable({
                scrollCollapse: true,
                autoWidth: false,
                responsive: true,
                columnDefs: [{
                    targets: "datatable-nosort",
                    orderable: false,
                }],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "language": {
                    "info": "_START_-_END_ of _TOTAL_ entries",
                    searchPlaceholder: "Search",
                    paginate: {
                        next: '<i class="ion-chevron-right"></i>',
                        previous: '<i class="ion-chevron-left"></i>'
                    }
                },
            });
        });
    </script>
</body>
</html>