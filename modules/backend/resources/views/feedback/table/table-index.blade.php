<div class="card-box pb-10">
    <table id="dataTablefeedback" class="data-table table nowrap">
        <thead>
            <tr>
                <th class="table-plus">User</th>
                <th style="table-plus">Product</th>
                <th style="text-align: center">Comment</th>
                <th style="text-align: center">Rating</th>
                <th style="text-align: center">Status</th>
                <th class="datatable-nosort" style="text-align: center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($feedbacks as $feedback)
            <tr style="text-align: center">
                @php
                    $content = json_decode($feedback->product->content)
                @endphp
                <td class="table-plus">
                    <div class="name-avatar d-flex align-items-center">
                        <div class="avatar mr-2 flex-shrink-0">
                            @if (isset($user->avatar))
                                <img
                                    src="{{ asset($feedback->user->picture->image) }}"
                                    class="border-radius-100 shadow"
                                    width="40"
                                    height="40"
                                    alt=""
                                />
                            @else
                                <img
                                    src="{{ asset('backend/src/images/avatar-clone.svg')}}"
                                    class="border-radius-100 shadow"
                                    width="40"
                                    height="40"
                                    alt=""
                                />
                            @endif
                        </div>
                        <div class="txt">
                            <div class="weight-600">{{$feedback->user->name}}</div>
                        </div>
                    </div>
                </td>
                <td class="table-plus">
                    <div class="name-avatar d-flex align-items-center">
                        <div class="avatar mr-2 flex-shrink-0">
                            @if (isset($content->imgThumbnail))
                                <img
                                    src="{{ asset($content->imgThumbnail) }}"
                                    width="40"
                                    height="40"
                                    alt="Product Thumbnail"
                                />
                            @else
                                <img
                                    src="{{ asset('backend/src/images/image-clone.svg')}}"
                                    width="40"
                                    height="40"
                                    alt="Default Thumbnail"
                                />
                            @endif
                        </div>
                        <div class="txt">
                            <div class="weight-600" style="max-width: 100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$feedback->product->name}}</div>
                        </div>
                    </div>
                </td>
                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ $feedback->content }}
                </td>
                <td>{{$feedback->quanlity}}/5 <i class="icon-copy dw dw-star"></i></td>
                {{-- <td>{{ \Carbon\Carbon::parse($feedback->created_at)->format('F j, Y g:i A') }}</td> --}}
                <td  style="text-align: center">
                    @if ($feedback->status == '1')
                        <span class="badge badge-success">
                            Publicshed
                        </span>
                    @else
                        <span class="badge badge-secondary">
                            Unpublicshed
                        </span>
                        
                    @endif
                </td>
                <td  style="text-align: center">
                    <a href="#" class="openModalView" data-url="{{ route('admin-feedback-view', ['id' => $feedback->id]) }}" style="color: #fb9700;">
                        <i class="icon-copy dw dw-eye" style="color: inherit;"></i>
                    </a>
                    @if ($feedback->status == '1')
                        <a href="#" id="lock-feedback" data-url="{{ route('admin-feedback-state', ['id' => $feedback->id]) }}" style="color: #ff0000;">
                            <i class="icon-copy dw dw-padlock1" style="color: inherit;"></i>
                        </a>
                    @else
                        <a href="#" id="lock-feedback" data-url="{{ route('admin-feedback-state', ['id' => $feedback->id]) }}" style="color: #00ff3381;">
                            <i class="icon-copy dw dw-open-padlock" style="color: inherit;"></i>
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>