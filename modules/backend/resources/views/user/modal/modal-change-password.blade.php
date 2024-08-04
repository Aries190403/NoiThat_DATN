<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="passwordForm" action="{{ route('admin-user-change-password',['id'=>$user->id]) }}" method="post">
                    @csrf
                    <div class="row">
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
                    </div>
                    <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-modal-user">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>