<div class="card-box pb-10">
    <div class="col-md-4 col-sm-12 mb-30">
        <div style="align-items: center">
            <button
                type="button"
                class="btn btn-primary btn-sm"
                data-toggle="modal"
                data-target="#bd-example-modal-lg"
            >
                <i class="fa fa-user-plus"></i> Add
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
            @include('backend::user.modal.modal-add')
        </div>
    </div>
    <table id="dataTableUsers" class="data-table table nowrap">
        <thead>
            <tr style="text-align: center">
                <th class="table-plus">Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Locked</th>
                <th>Role</th>
                <th class="datatable-nosort">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td class="table-plus">
                    <div class="name-avatar d-flex align-items-center">
                        <div class="avatar mr-2 flex-shrink-0">
                            @if (isset($user->avatar))
                                <img
                                    src="{{ asset($user->picture->image) }}"
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
                            <div class="weight-600">{{$user->name}}</div>
                        </div>
                    </div>
                </td>
                <td>{{$user->email}}</td>
                <td>{{$user->phone}}</td>
                @if (isset($user->address_id))
                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ $user->address->street }}
                        @if(!empty($user->address->ward))
                            , {{ $user->address->ward }}
                        @endif
                        @if(!empty($user->address->district))
                            , {{ $user->address->district }}
                        @endif
                        @if(!empty($user->address->city))
                            , {{ $user->address->city }}
                        @endif
                    </td>
                @else
                    <td style="max-width: 40px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align: center; color:#ff0000">No Address</td>
                @endif
                <td style="text-align: center">
                    @if ($user->locked == 'normal')
                        <span
                            style="background-color: #e7ebf5; color: #128e22; padding: .25em .4em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .375rem;">
                            {{$user->locked}}
                        </span>
                    @else
                        <span
                            style="background-color: #e7ebf5; color: #ff0000; padding: .25em .4em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .375rem;">
                            {{$user->locked}}
                        </span>
                        
                    @endif
                </td>
                <td style="text-align: center">
                    @if ($user->role == "ROLE_SUPER_ADMIN")
                        <span
                            style="background-color: #e7ebf5; color: #ff0000; padding: .25em .4em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .375rem;">
                            Admin
                        </span>
                    @endif
                    @if ($user->role == "ROLE_PRODUCT_EDITOR")
                        <span
                            style="background-color: #e7ebf5; color: #2200ff; padding: .25em .4em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .375rem;">
                            Product editor
                        </span>
                    @endif
                    @if ($user->role == "USER")
                        <span
                            style="background-color: #e7ebf5; color: #000000; padding: .25em .4em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .375rem;">
                            User
                        </span>
                    @endif
                   
                </td>
                <td>
                    <div class="table-actions">
                        <a href="{{route('admin-user-edit', ['id' => $user->id])}}" style="color: #265ed7;">
                            <i class="icon-copy dw dw-edit2" style="color: inherit;"></i>
                        </a>
                        <a href="{{route('admin-user-delete', ['id' => $user->id])}}" id="delete-user" style="color: #ff0000;">
                            <i class="icon-copy dw dw-delete-3" style="color: inherit;"></i>
                        </a>
                        @if ($user->locked == 'normal')
                            <a href="{{route('admin-user-state', ['id' => $user->id])}}" id="lock-user" style="color: #ff0000;">
                                <i class="icon-copy dw dw-padlock1" style="color: inherit;"></i>
                            </a>
                        @else
                            <a href="{{route('admin-user-state', ['id' => $user->id])}}" id="lock-user" style="color: #00ff3381;">
                                <i class="icon-copy dw dw-open-padlock" style="color: inherit;"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>