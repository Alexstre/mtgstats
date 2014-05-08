@extends('master')

@section('content')
    @foreach($events as $event)
        <h2>Showing {{ $event->name }}<small>from {{ date("m F Y", strtotime($event->played_on)) }}</small></h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <td>Meta</td>
                        <td>Played by</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($event->decks as $deck)
                    <tr>
                        <td><a href="{{ URL::to('decks/' . $deck->id) }}">{{ $deck->meta }}</a></td>
                        <td>{{ $deck->player }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
@stop