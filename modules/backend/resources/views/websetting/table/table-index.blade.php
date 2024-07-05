<div class="pd-20 card-box">
    <div class="tab">
        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#home2" role="tab" aria-selected="true">General</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#profile2" role="tab" aria-selected="false">Images</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="home2" role="tabpanel">
                <div style="align-items: center ; margin-top: 1rem">
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        data-toggle="modal"
                        data-target="#bd-example-modal-lg"
                    >
                        <i class="dw dw-settings1"></i> Edit
                    </button>
                </div>
                <div
                    class="modal fade bs-example-modal-lg"
                    id="bd-example-modal-lg"
                    tabindex="-1"
                    role="dialog"
                    aria-labelledby="myLargeModalLabel"
                    aria-hidden="true"
                >
                    @include('backend::websetting.modal.modal-add') 
                </div>
                <table class="table table-bordered" style="margin-top: 1rem">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Setting</th>
                            <th scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Phone</th>
                            <td>{{ $settings['phone'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>{{ $settings['email'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Address</th>
                            <td>{{ $settings['address'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Open Time</th>
                            <td>{{ $settings['open_time'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Close Time</th>
                            <td>{{ $settings['close_time'] }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Facebook Link</th>
                            <td><a href="{{ $settings['facebook_link'] }}" target="_blank">{{ $settings['facebook_link'] }}</a></td>
                        </tr>
                        <tr>
                            <th scope="row">YouTube Link</th>
                            <td><a href="{{ $settings['youtube_link'] }}" target="_blank">{{ $settings['youtube_link'] }}</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="profile2" role="tabpanel">
                <div class="pd-20">
                    <form id="uploadForm" method="POST" action="{{ route('admin-setting-addImage') }}" enctype="multipart/form-data">
                        @csrf
                        <a href="#" class="edit-avatar btn btn-primary" id="uploadImageLink" style="color: white; background-color: rgb(0, 162, 255); margin-bottom: 1rem">
                            <i class="icon-copy dw dw-add"></i> Add
                        </a>
                        <input type="file" id="imageInput" name="image" style="display: none;" accept="image/*">
                        <input type="hidden" id="titleInput" name="title">
                        <input type="hidden" id="subtitleInput" name="subtitle">
                        <input type="hidden" id="urlInput" name="url">
                    </form>
                    <div class="container">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                            @foreach ($settings['slideshow_images'] as $index => $item)
                                <div class="col mb-4">
                                    <div class="card h-100 position-relative">
                                        <a href="#" class="editImageLink" data-index="{{ $index }}" data-title="{{ $item['title'] }}" data-subtitle="{{ $item['subtitle'] }}" data-url="{{ $item['url'] }}">
                                            <i class="icon-copy dw dw-edit1"></i>
                                        </a>
                                        <a href="#" class="deleteImageLink" data-index="{{ $index }}">
                                            <i class="icon-copy dw dw-delete-3"></i>
                                        </a>
                                        <img class="card-img-top" src="{{ asset($item['image']) }}" alt="Card image cap">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $item['title'] }}</h5>
                                            <p class="card-text">{{ $item['subtitle'] }}</p>
                                            <p class="card-text">
                                                <small class="text-muted">URL: {{ $item['url'] }}</small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach                        
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend::websetting.modal.modal-slideshow')
@include('backend::websetting.modal.modal-edit')
