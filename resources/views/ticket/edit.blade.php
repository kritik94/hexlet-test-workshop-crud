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
    <div class="row">
        <form method="post" action="{{route('tickets.update', ['ticket' => $ticket])}}" class="col-sm">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Ticket Title:</label>
                <input type="text" class="form-control" name="title" placeholder={{$ticket->title}} readonly/>
            </div>
            <div class="form-group">
                <label for="description">Ticket Description:</label>
                <textarea cols="10" rows="10" class="form-control" name="description">{{$ticket->description}}</textarea>
            </div>
            <div class="form-group">
                <label for="reporter">Ticket Reporter:</label>
                <input type="text" class="form-control" name="reporter" placeholder={{$ticket->reporter}} readonly/>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>
@endsection
