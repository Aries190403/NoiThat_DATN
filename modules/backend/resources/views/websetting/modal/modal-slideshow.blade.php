<div id="imagePreviewModal" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview and Crop Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <img id="previewImage" src="" alt="Image Preview" style="max-width: 100%;">
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="title" style="font-weight: bold;">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" style="margin-bottom: 15px;" />
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="subtitle" style="font-weight: bold;">Subtitle</label>
                            <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter Subtitle" style="margin-bottom: 15px;" />
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label for="url" style="font-weight: bold;">URL</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL" style="margin-bottom: 15px;" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmUpload">Submit</button>
            </div>
        </div>
    </div>
</div>
