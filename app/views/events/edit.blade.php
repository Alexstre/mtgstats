@extends('base')

@section('content')
<div class="col-md-10">
    <div class="row">
        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h2>{{ $event->name }} <small>{{ date("m F Y", strtotime($event->played_on)) }}</small></h2>
                    </div>
                </div>
                <div class="panel-body">
                    {{ Form::open(array('route' => 'result/create', 'method'=>'post', 'role'=>'form', 'id'=>'finishes')) }}
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Archetype</td>
                                <td>Played by</td>
                                <td>Finish</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->decks as $deck)
                                <tr>
                                    <td><a href="{{ URL::to('decks/' . $deck->id) }}">{{ $deck->meta }}</a></td>
                                    <td>{{ $deck->player }}</td>
                                    <td>
                                        {{ Form::text($deck->id, (isset($deck->pivot->finish) ? $deck->pivot->finish : '0'), array('class'=>'form-control input-sm', 'id'=>$deck->id)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ Form::text('eventid', $event->id, array('class'=>'hidden', 'id'=>'eventid')) }}
                    {{ Form::text('doingfinish', 'hello', array('class'=>'hidden', 'id'=>'doingfinish')) }}
                    {{ Form::submit('Update Finish', array('class'=>'btn btn-primary', 'id'=>'finishupdates')) }}
                    {{ Form::close() }}
                    <hr/>
                    <p>Is there a deck missing from this event?<a href="{{ URL::to('decks/create')}}">Add it now</a> 
                    to help us out!. To learn more about adding decks and events check out <a href="{{ URL::to('about/faw') }}">the FAQ</a>.</p>
                    <hr/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading">
                    <h2>Update Brackets</h2>
                    <p>This section can be used to update the scores. Select 2 decks from the drop menus and set the scores.
                        Click "Save" when done.</p> @if (!$results)<p>We currently have no results for this tournament!</p>@endif
                </div>
                <div class="panel-body">
                    {{ Form::open(array('route' => 'result/create', 'method'=>'post', 'role'=>'form', 'class'=>'form-inline', 'id'=>'scoreupdates')) }}
                    <div class="form-group">
                        <label class="sr-only" for="score1">Score 1</label>
                        {{ Form::text('score1', (isset($results->pivot->finish) ? $results->pivot->finish : '0'), array('class'=>'form-control input-sm', 'id'=>'score1')) }}
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="deck1">First Deck</label>
                        <select name="deck1" id="deck1" class="form-control">
                            @foreach($event->decks as $deck)
                                <option value="{{ $deck->id }}">{{ $deck->player }} ({{ $deck->meta }} )</option>
                            @endforeach
                        </select>
                    </div><hr/>
                    <div class="form-group">
                        <label class="sr-only" for="score2">Score 2</label>
                        {{ Form::text('score2', (isset($results->pivot->finish) ? $results->pivot->finish : '0'), array('class'=>'form-control input-sm', 'id'=>'score2')) }}
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="deck2">Second Deck</label>
                        <select name="deck2" id="deck2" class="form-control">
                            @foreach($event->decks as $deck)
                            <option value="{{ $deck->id }}">{{ $deck->player }} ({{ $deck->meta }} )</option>
                            @endforeach
                        </select>
                    </div>
                    <hr/>
                    {{ Form::text('eventid', $event->id, array('class'=>'hidden', 'id'=>'eventid')) }}
                    {{ Form::submit('Save', array('class'=>'btn btn-primary')) }}
                    {{ Form::close() }}
                </div>
                {{ var_dump($results) }}
            </div>
        </div>
    </div>
</div>
@stop