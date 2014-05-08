@extends('master')

@section('content')
    <h1>All the decks!</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td>Meta</td>
                <td>Player</td>
                <td>Admin Stuff</td>
            </tr>
        </thead>
        <tbody>
        @foreach($decks as $key => $value)
            <tr>
                <td>{{ $value->meta }}</td>
                <td>{{ $value->player }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>
                    <a class="btn btn-small btn-success" href="{{ URL::to('decks/' . $value->id) }}">Show this deck</a>
                    <a class="btn btn-small btn-info" href="{{ URL::to('decks/' . $value->id . '/edit') }}">Edit this deck</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </div>
@stop