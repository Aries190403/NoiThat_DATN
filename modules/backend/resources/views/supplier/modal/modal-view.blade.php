<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalLabel">Supplier Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row container-fluid">
                    <div class="col-lg-4">
                        <div class="profile-photo">
                            <img id="supplier-avatar" src="{{ asset('backend/src/images/no-image.svg') }}" alt="" style="width: 100%; border-radius: 50%; display: block;" />
                        </div>
                        <div class="form-group">
                            <label for="name" style="font-weight: bold;">Name</label>
                            <input type="text" class="form-control" name="name" id="supplier-name" placeholder="Enter your name" required disabled />
                        </div>
                    </div>
                    <div class="col-lg-8 row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" style="font-weight: bold;">Email</label>
                                <input type="email" class="form-control" name="email" id="supplier-email" placeholder="Enter your email" required disabled />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" style="font-weight: bold;">Phone</label>
                                <input type="text" class="form-control" name="phone" id="supplier-phone" placeholder="your phone" required 
                                       maxlength="10" pattern="\d{10}" 
                                       oninput="this.value=this.value.replace(/[^0-9]/g,'');" disabled />
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="City" style="font-weight: bold;">City</label>
                            <select class="form-control city-select" name="City" id="supplierCity" required>
                                <option value="" disabled selected>City</option>
                                @foreach($getAddress as $city)
                                    <option value="{{ $city['code'] }}">{{$city['name_with_type'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="District" style="font-weight: bold;" >District</label>
                            <select class="form-control district-select" name="District" id="supplierDistrict" required disabled>
                                <option value="" disabled selected>District</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="Ward" style="font-weight: bold;" id="supplierWardLabel">Ward</label>
                            <select class="form-control ward-select" name="Ward" id="supplierWard" required disabled>
                                <option value="" disabled selected>Ward</option>
                            </select>
                        </div>
                        
                        
                        <div class="col-md-12 mt-3">
                            <div class="form-group">
                                <label for="street" style="font-weight: bold;">Street</label>
                                <input type="text" class="form-control" name="street" id="supplier-street" required />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description" style="font-weight: bold;">Description</label>
                                <textarea class="form-control" name="description" id="supplier-description" placeholder="Enter description" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="edit-save-btn">Edit</button>
            </div>
        </div>
    </div>
</div>