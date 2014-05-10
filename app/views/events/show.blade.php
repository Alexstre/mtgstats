@extends('base')

@section('content')
<div class="col-md-10">
    <div class="row">
        <div class="col-md-6">
            @foreach($events as $event)
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h2>{{ $event->name }} <small>{{ date("m F Y", strtotime($event->played_on)) }}</small></h2>
                    </div>
                </div>
                <div class="panel-body">
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
                    <hr/>
                    <p>Is there a deck missing from this event?<a href="{{ URL::to('decks/create')}}">Add it now</a> 
                    to help us out!. To learn more about adding decks and events check out <a href="{{ URL::to('about/faw') }}">the FAQ</a>.</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop