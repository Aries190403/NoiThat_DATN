@extends('frontend::main')
@section('content')
<section class="not-found">
    <div class="container">
        <h1 class="title" data-title="Page not found!">404</h1>
        <div class="h4 subtitle">Sorry! Page not found.</div>
        <p>The requested URL was not found on this server. That’s all we know.</p>
        <p>Click <a href="{{route("home")}}">here</a> to get to the front page? </p>
    </div>
</section>
@endsection