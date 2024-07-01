<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="exampleModal">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Edit settings
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="kt_modal_settings_form" action="{{route('admin-setting-change')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" style="font-weight: bold;">Phone <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="your phone" required 
                                   maxlength="10" pattern="\d{10}" 
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'');" 
                                   style="margin-bottom: 15px;" />
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" style="font-weight: bold;">Email <span style="color: red;">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required />
                        </div>
                    </div>
        
                    <div class="col-md-6">
                        <label for="open_time" style="font-weight: bold;">Open Time</label>
                        <input class="form-control time-picker" id="open_time" placeholder="Select time" type="text" name="open_time" />
                    </div>
        
                    <div class="col-md-6">
                        <label for="close_time" style="font-weight: bold;">Close Time</label>
                        <input class="form-control time-picker" id="close_time" placeholder="Select time" type="text" name="close_time" />
                    </div>
        
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="address" style="font-weight: bold;">Address <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required />
                        </div>
                    </div>
        
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="facebook_link" style="font-weight: bold;">Facebook link <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="facebook_link" name="facebook_link" placeholder="Enter Facebook link" required />
                        </div>
                    </div>
        
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label for="youtube_link" style="font-weight: bold;">YouTube link <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="youtube_link" name="youtube_link" placeholder="Enter YouTube link" required />
                        </div>
                    </div>
                </div>
        
                <div id="errorMessages" class="text-danger"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-modal-settings">Change</button>
                </div>
            </form>
        </div>
        
    </div>
</div>