@extends('backend::base')
@section('content')
    <div id="list-table-setting">
        <div class="mobile-menu-overlay"></div>
        <div class="main-container">
            <div class="xs-pd-20-10 pd-ltr-20">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>Setting</h4>
                            </div>
                            <nav aria-label="breadcrumb" role="navigation">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin-dashboard') }}">Home</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Setting
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                @include('backend::websetting.table.table-index')
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const settings = @json($settings);
            $('#bd-example-modal-lg').on('show.bs.modal', function(event) {
                document.getElementById('phone').value = settings.phone;
                document.getElementById('email').value = settings.email;
                document.getElementById('address').value = settings.address;
                document.getElementById('open_time').value = settings.open_time;
                document.getElementById('close_time').value = settings.close_time;
                document.getElementById('facebook_link').value = settings.facebook_link;
                document.getElementById('youtube_link').value = settings.youtube_link;
                document.getElementById('map_link').value = settings.map_link;
            });
        });
    </script>
@endsection
