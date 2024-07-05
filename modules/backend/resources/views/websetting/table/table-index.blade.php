<div class="pd-20 card-box mb-30">
    <div style="align-items: center ">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bd-example-modal-lg">
            <i class="dw dw-settings1"></i> Edit
        </button>
    </div>
    <div class="modal fade bs-example-modal-lg" id="bd-example-modal-lg" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
            <tr>
                <th scope="row">Map Link</th>
                <td><a href="{{ $settings['map_link'] }}" target="_blank">{{ $settings['map_link'] }}</a></td>
            </tr>
        </tbody>
    </table>
</div>
