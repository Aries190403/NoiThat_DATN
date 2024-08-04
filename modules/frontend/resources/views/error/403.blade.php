@extends('frontend::main')
@section('content')
    <section class="forbidden">
        <div class="container">
            <h1 class="title" data-title="ERROR: 403 FORBIDDEN !">403</h1>
            <div class="h4 subtitle">Sorry! ERROR: 403 FORBIDDEN.</div>
            <p>Sorry, access to this resource on the server is denied.
                Either check the URL</p>
            <p>Click <a href="{{ route('home') }}">here</a> to get to the front page? </p>
        </div>
    </section>
@endsection
