<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" id="exampleModal">
        <div class="modal-header">
            <h4 class="modal-title" id="myLargeModalLabel">
                Add Supplier
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="kt_modal_supplier_form" action="{{ route('admin-supplier-create') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name" style="font-weight: bold;">Name <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter your name" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" style="font-weight: bold;">Email <span style="color: red;">*</span></label>
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" style="font-weight: bold;">Phone <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="your phone" required 
                                   maxlength="10" pattern="\d{10}" 
                                   oninput="this.value=this.value.replace(/[^0-9]/g,'');" 
                                   />
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="City" style="font-weight: bold;">City</label>
                        <select class="form-control" id="City" name="City" required>
                            <option value="" disabled selected>City</option>
                            @foreach($getAddress as $city)
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
                        <div class="form-group">
                            <label for="street" style="font-weight: bold;">Street</label>
                            <input type="text" class="form-control" name="street" placeholder="Enter your Street" required />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description" style="font-weight: bold;">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter description"></textarea>
                        </div>
                    </div>
                </div>
                <div id="errorMessages" class="text-danger"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-modal-supplier">Add Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>