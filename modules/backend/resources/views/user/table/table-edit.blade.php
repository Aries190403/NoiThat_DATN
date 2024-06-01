<div class="pd-20 card-box" id="table-user">
    <h5 class="h4 text-blue mb-20">Information</h5>
    <div class="btn-container">
        <button class="btn-save" id="saveButtom">
            <span class="icon-copy ti-save"></span> Save
        </button>
    </div>
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            {{-- <li class="nav-item">
                <a
                    class="nav-link active"
                    data-toggle="tab"
                    href="#home2"
                    role="tab"
                    aria-selected="true"
                    >Home</a
                >
            </li> --}}
            {{-- <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="tab"
                    href="#profile2"
                    role="tab"
                    aria-selected="false"
                    >Profile</a
                >
            </li>
            <li class="nav-item">
                <a
                    class="nav-link"
                    data-toggle="tab"
                    href="#contact2"
                    role="tab"
                    aria-selected="false"
                    >Contact</a
                >
            </li> --}}
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="home2" role="tabpanel">
                <div class="row">
                    <div class="col-lg-4" style="margin-top: 1rem">
                        <div class="profile-photo" >
                            {{-- <a href="#" class="edit-avatar" id="chooseImage"><i class="icon-copy dw dw-pencil-1" style="color: red"></i></a> --}}
                            <form id="uploadForm" method="POST" action="{{ route('admin-up-avatar', ['id' => $user->id]) }}" enctype="multipart/form-data">
                                @csrf
                                <a href="#" class="edit-avatar" id="uploadImageLink"><i class="icon-copy dw dw-pencil-1" style="color: red"></i></a>
                                {{-- <a href="#" id="uploadImageLink">Upload Image</a> --}}
                                <input type="file" id="imageInput" name="image" style="display: none;">
                            </form>
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

                        <div class="row" style="text-align: center;">
                            <div class="col-4" style="margin-bottom: 10px;">
                                <a href="{{ route('admin-user-delete', ['id' => $user->id]) }}" id="delete-user" style="color: #ff0000;" title="Delete this user">
                                    <i class="icon-copy dw dw-delete-3" style="color: inherit; font-size: 50px"></i>
                                </a>
                            </div>
                            <div class="col-4" style="margin-bottom: 10px;">
                                @if ($user->locked == 'normal')
                                    <a href="{{ route('admin-user-state', ['id' => $user->id]) }}" id="lock-user" style="color: #ff0000;" title="Lock this user">
                                        <i class="icon-copy dw dw-padlock1" style="color: inherit; font-size: 50px"></i>
                                    </a>
                                @else
                                    <a href="{{ route('admin-user-state', ['id' => $user->id]) }}" id="lock-user" style="color: #00ff3381;" title="Unlock this user">
                                        <i class="icon-copy dw dw-open-padlock" style="color: inherit; font-size: 50px"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="col-4" style="margin-bottom: 10px;">
                                <a href="#" id="change-password" style="color: #b6b62d;" title="Change password">
                                    <i class="icon-copy dw dw-password" style="color: inherit; font-size: 50px"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin-up-avatar', ['id' => $user->id]) }}" id="uploadForm" enctype="multipart/form-data" style="display: none;">
                        @csrf
                        <input type="file" id="image" name="image" style="display: none;">
                    </form>
                    <div class="col-lg-8">
                        <form id="userForm" method="POST" action="{{route('admin-user-save-edit',['id' => $user->id])}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label for="name" style="font-weight: bold;">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter your name" value="{{ isset($user->name) ? $user->name : '' }}" required style="margin-bottom: 15px;" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label for="email" style="font-weight: bold;">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter your email" value="{{ isset($user->email) ? $user->email : '' }}" required readonly style="margin-bottom: 15px;" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label for="phone" style="font-weight: bold;">Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="your phone" value="{{ isset($user->phone) ? $user->phone : '' }}" required maxlength="10" pattern="\d{10}" oninput="this.value=this.value.replace(/[^0-9]/g,'');" style="margin-bottom: 15px;" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="role" style="font-weight: bold;">Role</label>
                                    <select class="form-control" name="role" required>
                                        <option value="{{ isset($user->role) ? $user->role : '' }}" selected>{{ isset($user->role) ? $user->role : '' }}</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role['name'] }}">{{ $role['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="City" style="font-weight: bold;">City</label>
                                    <select class="form-control" id="City" name="City" required>
                                        <option value="{{ isset($user->address->city) ? $user->address->city : '' }}" selected>{{ isset($user->address->city) ? $user->address->city : '' }}</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city['code'] }}">{{$city['name_with_type'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="District" style="font-weight: bold;">District</label>
                                    <select class="form-control" id="District" name="District" required disabled>
                                        <option value="{{ isset($user->address->district) ? $user->address->district : '' }}" selected>{{ isset($user->address->district) ? $user->address->district : '' }}</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="Ward" style="font-weight: bold;">Ward</label>
                                    <select class="form-control" id="Ward" name="Ward" required disabled>
                                        <option value="{{ isset($user->address->ward) ? $user->address->ward : '' }}" selected>{{ isset($user->address->ward) ? $user->address->ward : '' }}</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label for="street" style="font-weight: bold;">Street</label>
                                        <input type="text" class="form-control" name="street" placeholder="Enter your street" value="{{ isset($user->address->street) ? $user->address->street : '' }}" style="margin-bottom: 15px;" />
                                    </div>
                                </div>
                            </div>
                            <div class="btn-container">
                                <button type="submit" class="btn-save" id="saveButton">
                                    <i class="ti-save"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>                             
                </div>
            </div>
            {{-- <div class="tab-pane fade" id="profile2" role="tabpanel">
                <div class="pd-20">
                    <div class="pd-20">
                        Lorem ipsum dolor sit amet, consectetur adipisicing
                        elit, sed do eiusmod tempor incididunt ut labore et
                        dolore magna aliqua. Ut enim ad minim veniam, quis
                        nostrud exercitation ullamco laboris nisi ut aliquip ex
                        ea commodo consequat. Duis aute irure dolor in
                        reprehenderit in voluptate velit esse cillum dolore eu
                        fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                        non proident, sunt in culpa qui officia deserunt mollit
                        anim id est laborum.
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="contact2" role="tabpanel">
                <div class="pd-20">
                    Lorem ipsum dolor sit amet, consectetur adipisicing
                    elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis
                    nostrud exercitation ullamco laboris nisi ut aliquip ex
                    ea commodo consequat. Duis aute irure dolor in
                    reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                    non proident, sunt in culpa qui officia deserunt mollit
                    anim id est laborum.
                </div>
            </div> --}}
        </div>
    </div>
</div>