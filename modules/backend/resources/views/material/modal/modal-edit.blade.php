<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit material</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit_material_form" action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="name" style="font-weight: bold;">Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Enter name" required style="margin-bottom: 15px;" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="color" style="font-weight: bold;">Color</label>
                            <select class="form-control" name="color">
                                <option value="">Select color</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color['value'] }}">{{ $color['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="type" style="font-weight: bold;">Type <span style="color: red;">*</span></label>
                            <select class="form-control" name="type" required>
                                <option value="">Select type</option>
                                @foreach($types as $type)
                                    <option value="{{ $type['value'] }}">{{ $type['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group" style="margin-bottom: 15px;">
                                <label for="description" style="font-weight: bold;">Description</label>
                                <textarea class="form-control" name="description" placeholder="Enter description" style="margin-bottom: 15px;"></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="errorMessages" class="text-danger" style="margin-bottom: 15px;"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn-modal-material">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
