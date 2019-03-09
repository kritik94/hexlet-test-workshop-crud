@extends('layouts.app')

@section('content')
<div class="container">

    @if ($errors->any())
    <div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    </div><br />
    @endif
    <div class="row justify-content-md-center">
        <div class="jumbotron col-sm-8">
            <blockquote class="blockquote">
                <h3>{{$ticket->title}}</h3>
                <footer class="blockquote-footer">{{$ticket->reporter}}</footer>
                </blockquote>
            <hr>
            <p>{{$ticket->description}}</p>
            <div>
                <a href="{{route('tickets.edit', ['ticket' => $ticket])}}" class="btn btn-warning">edit</a>
                <a href="{{route('tickets.destroy', ['ticket' => $ticket])}}" class="btn btn-danger">delete</a>
            </div>
        </div>
    </div>
</div>
@endsection
