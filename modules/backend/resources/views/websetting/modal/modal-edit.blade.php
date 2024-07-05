<div id="editImageModal" class="modal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editIndex">
                <div class="form-group">
                    <label for="editTitle">Title</label>
                    <input type="text" class="form-control" id="editTitle" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="editSubtitle">Subtitle</label>
                    <input type="text" class="form-control" id="editSubtitle" placeholder="Enter subtitle">
                </div>
                <div class="form-group">
                    <label for="editURL">URL</label>
                    <input type="text" class="form-control" id="editURL" placeholder="Enter URL">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEdit">Save changes</button>
            </div>
        </div>
    </div>
</div>
