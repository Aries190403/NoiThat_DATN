<!DOCTYPE html>
<html lang="en">
<head>
    @include('backend::elements.head')
</head>
<body class="login-page">
    <div class="login-header box-shadow">
        <div
            class="container-fluid d-flex justify-content-between align-items-center"
        >
            <div class="brand-logo">
                <a href="login.html">
                    <img src="{{ asset('backend/vendors/images/deskapp-logo.svg')}}" alt="" />
                </a>
            </div>
        </div>
    </div>
    <div
        class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
    >
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-lg-7">
                    <img src="{{ asset('backend/vendors/images/login-page-img.png')}}" alt="" />
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <div class="login-title">
                            <h2 class="text-center text-primary">Login To DeskApp</h2>
                        </div>
                        <form id="login-form" action="{{ route('admin-store-login') }}" method="POST" class="d-grid">
                            @csrf
                            <div class="select-role">
                            </div>
                            <div class="input-group custom">
                                <input
                                    type="text"
                                    name="email"
                                    class="form-control form-control-lg"
                                    placeholder="Email"
                                />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control form-control-lg"
                                    placeholder="**********"
                                />
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            class="custom-control-input"
                                            id="customCheck1"
                                            name="remember"
                                        />
                                        <label class="custom-control-label" for="customCheck1">Remember</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign In</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault();
            
            var formData = new FormData(this);

            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Đã xảy ra lỗi: ' + data.message,
                        confirmButtonText: 'Đóng'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script> --}}
    @include('backend::elements.footer')
</body>