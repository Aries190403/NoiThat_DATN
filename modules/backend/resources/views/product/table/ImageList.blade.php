<div class="tab-pane fade" id="listImage" role="tabpanel">
    <div class="pd-20">
        <div class="pd-20 card-box mb-30">
            <div class="clearfix mb-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">Images</h4>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                        Add Image
                    </button>
                </div>
            </div>
            <div class="image-list">
                @foreach ($images as $image)
                <div class="image-item">
                    <img src="{{ asset($image->image) }}" alt="" />
                    <a class="delete-image" data-id="{{ $image->id }}" data-url="{{ route('admin-product-del-img', ['id' => $image->id]) }}">×</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@include('backend::product.modal.modal-add-images')
