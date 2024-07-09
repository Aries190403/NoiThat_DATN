@extends('backend::base')
@section('content')
<div id="list-table-material">
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Feedbacks</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{route('admin-dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Feedbacks
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @include('backend::feedback.table.table-index')
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            lockFeedback();
            function lockFeedback() {
                $(document).on('click', '#lock-feedback', function(e) {
                    e.preventDefault();
                    var url = $(this).data('url');
                    var iconClass = $(this).find('i').attr('class');

                    var action = (iconClass.includes('dw-padlock1')) ? 'Publicshed' : 'Unpublicshed';
                    var titleText = (action == 'Publicshed') ? 'Publicshed' : 'Unpublicshed';
                    var confirmationText = (action == 'Publicshed') ? 'This feedback will be Publicshed!' : 'This feedback will be unpublicshed!';

                    Swal.fire({
                        title: 'Are you sure?',
                        text: confirmationText,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, ' + titleText + ' it!',
                        cancelButtonText: 'No, cancel!',
                        customClass: {
                            confirmButton: 'btn btn-success',
                            cancelButton: 'btn btn-danger'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: url,
                                type: 'Post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (response) {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'feedback ' + titleText.toLowerCase() + 'ed successfully',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    window.location.href = '{{ route('admin-feedback-index') }}';
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire(
                                        'Error!',
                                        'An error occurred while processing your request.',
                                        'error'
                                    );
                                }
                            });
                        }
                    });
                });
            }
        });
    </script>
@endsection