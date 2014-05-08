@extends('master')

@section('content')
    <h1>All the events</h1>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td>Name</td>
                <td>Date</td>
                <td>Admin Stuff</td>
            </tr>
        </thead>
        <tbody>
        @foreach($events as $key => $value)
            <tr>
                <td>{{ $value->name }}</td>
                <td>{{ $value->played_on }}</td>
                <td>
                    <a class="btn btn-small btn-success" href="{{ URL::to('events/' . $value->id) }}">Show this Event</a>
                    <a class="btn btn-small btn-info" href="{{ URL::to('events/' . $value->id . '/edit') }}">Edit this Event</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@stop