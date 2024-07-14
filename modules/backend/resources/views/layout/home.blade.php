@include('backend::base')
<div id="list-table-user">
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="xs-pd-20-10 pd-ltr-20">
            <div class="page-header">
                <div>
                    <div class="profile-photo" >
                        @if (isset($user->avatar))
                            <img src="{{ asset($user->picture->image) }}" alt="" style="width: 100%; border-radius: 50%; display: block;" />
                        @else
                            <img src="{{ asset('backend/src/images/avatar-clone.svg')}}" alt="" style="width: 100%; border-radius: 50%; display: block;" />
                        @endif
                    </div>
                    <h5 class="text-center h5 mb-0">{{$user->name}}</h5>
                    <p class="text-center text-muted font-14">
                        {{$user->role}}
                    </p>
                </div>
                <div class="grid-container">
                    <div class="grid-item feature-1">
                        <a href="{{ route('admin-dashboard') }}">
                            <i class="micon bi bi-house"></i>
                            <span>Home</span>
                        </a>
                    </div>
                    <div class="grid-item feature-2">
                        <a href="{{ route('admin-user') }}">
                            <i class="micon dw dw-group"></i>
                            <span>Users</span>
                        </a>
                    </div>
                    <div class="grid-item feature-3">
                        <a href="{{ route('admin-product-index') }}">
                            <i class="micon dw dw-package"></i>
                            <span>Products</span>
                        </a>
                    </div>
                    <div class="grid-item feature-4">
                        <a href="{{ route('admin-category-index') }}">
                            <i class="micon bi bi-menu-app"></i>
                            <span>Categories</span>
                        </a>
                    </div>
                    <div class="grid-item feature-5">
                        <a href="{{ route('admin-material-index') }}">
                            <i class="micon dw dw-box"></i>
                            <span>Materials</span>
                        </a>
                    </div>
                    <div class="grid-item feature-6">
                        <a href="{{ route('admin-coupon-index') }}">
                            <i class="micon dw dw-ticket-1"></i>
                            <span>Vouchers</span>
                        </a>
                    </div>
                    <div class="grid-item feature-7">
                        <a href="{{ route('admin-invoice-index') }}">
                            <i class="micon dw dw-invoice-1"></i>
                            <span>Invoices</span>
                        </a>
                    </div>
                    <div class="grid-item feature-8">
                        <a href="{{ route('admin-statistical-index') }}">
                            <i class="micon dw dw-analytics-3"></i>
                            <span>Statistical</span>
                        </a>
                    </div>
                    <div class="grid-item feature-9">
                        <a href="{{ route('admin-feedback-index') }}">
                            <i class="micon dw dw-chat3"></i>
                            <span>Feedbacks</span>
                        </a>
                    </div>
                    <div class="grid-item feature-10">
                        <a href="{{ route('admin-supplier-index') }}">
                            <i class="micon dw dw-building1"></i>
                            <span>suppliers</span>
                        </a>
                    </div>
                    <div class="grid-item feature-11">
                        <a href="{{ route('admin-setting-index') }}">
                            <i class="micon dw dw-settings2"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                    <div class="grid-item feature-12">
                        <a href="{{route('admin-store-logout')}}">
                            <i class="icon-copy dw dw-logout1"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>