@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row">
        @foreach ($tickets as $ticket)
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$ticket->title}}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{$ticket->reporter}}</h6>
                    <p class="card-text">{{$ticket->description}}</p>
                    <a href="{{route('tickets.show', ['ticket' => $ticket])}}" class="card-link">ticket link</a>
                    <a href="{{route('tickets.edit', ['ticket' => $ticket])}}" class="card-link">edit</a>
                </div>
            </div>
        </div>
        @endforeach
        @if ($tickets->isEmpty())
            <h3>Has not tickets. Add first himself!</h3>
        @endif
    </div>
    <div class="row">
        <a href="{{route('tickets.create')}}">add ticket</a>
    </div>
</div>
@endsection
