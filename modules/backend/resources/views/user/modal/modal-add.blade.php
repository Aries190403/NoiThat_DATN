<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="exampleModal">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Add User
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="kt_modal_user_form" action="{{ route('admin-user-create') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="name" style="font-weight: bold;">Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name" required style="margin-bottom: 15px;" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="email" style="font-weight: bold;">Email <span style="color: red;">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required style="margin-bottom: 15px;" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px; position: relative;">
                            <label for="password" style="font-weight: bold;">
                                Password <span style="color: red;">*</span>
                                <i class="fas fa-eye toggle-password" data-target="password" style="position: absolute; right: 10px; align-items: center; cursor: pointer;"></i>
                            </label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required style="margin-bottom: 15px;" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px; position: relative;">
                            <label for="password_confirmation" style="font-weight: bold;">
                                Confirm Password <span style="color: red;">*</span>
                                <i class="fas fa-eye toggle-password" data-target="password_confirmation" style="position: absolute; right: 10px; align-items: center; cursor: pointer;"></i>
                            </label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required style="margin-bottom: 15px;" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="phone" style="font-weight: bold;">Phone <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="your phone" required 
                                   maxlength="10" pattern="\d{10}" 
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'');" 
                                   style="margin-bottom: 15px;" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="address" style="font-weight: bold;">Role <span style="color: red;">*</span></label>
                        <select class="form-control" name="role" required>
                            @foreach($roles as $role)
                                <option value="{{ $role['name'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="City" style="font-weight: bold;">City</label>
                        <select class="form-control" id="City" name="City" required>
                            <option value="" disabled selected>City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city['code'] }}">{{$city['name_with_type'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="District" style="font-weight: bold;">District</label>
                        <select class="form-control" id="District" name="District" required disabled>
                            <option value="" disabled selected>District</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <label for="Ward" style="font-weight: bold;">Ward</label>
                        <select class="form-control" id="Ward" name="Ward" required disabled>
                            <option value="" disabled selected>Ward</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="street" style="font-weight: bold;">street</label>
                            <input type="text" class="form-control" name="street" placeholder="Enter your street" style="margin-bottom: 15px;" />
                        </div>
                    </div>
                </div>
                <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-modal-user">Add User</button>
                </div>
            </form>
        </div>
    </div>
</div>