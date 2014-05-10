@extends('base')
@section('content')
    {{ Form::open(array('action' => 'DeckController@store', 'class'=>'form-horizontal')) }}
        <fieldset>
            <legend>Create a Deck</legend>
            <p>You <strong>must</strong> add the deck to an event that was previously created.
                In order to create an event visit the <a href="{{ URL::to('decks/create') }}">Create a Deck</a> page.
                Once it's added, the event will show up in the drop list below.</p>
            <div class="well">
                <div class="form-group">
                    <label class="col-md-4 control-label" for="meta">Meta</label>
                    <div class="col-md-4">
                        {{ Form::text('meta', Input::old('meta'), array('class'=>'form-control input-md', 'placeholder'=>'U/W Control')) }}
                        <p class="help-block">See this link for a list of current meta</p>
                        <p class="alert-danger">{{ $errors->first('meta') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="player">Player</label>
                    <div class="col-md-4">
                        {{ Form::text('player', Input::old('player'), array('class'=>'form-control input-md', 'placeholder'=>'Johnny B. Good')) }}
                        <p class="alert-danger">{{ $errors->first('player') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="event">Event</label>
                    <div class="col-md-4">
                        {{ Form::select('event', $all_events, Input::old('event'), array('class'=>'form-control', 'id'=>'event')) }}
                        <p class="alert-danger">{{ $errors->first('event') }}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="decklist">Deck List</label>
                    <div class="col-md-4">
                        {{ Form::textarea('decklist', '', array('class'=>'form-control', 'rows'=>10, 'id'=>'decklist')) }}
                        <p class="alert-danger">{{ $errors->first() }}</p>
                        <p class="help-block">One unique card per line. Skip a line to start sideboard. Example:</p>
                        <p class="help-block">4 Thoughseize<br>56 Swamps<br><br>15 Forest</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="submit"></label>
                    <div class="col-md-4">
                        {{ Form::submit('Submit Deck', array('id'=>'submit', 'class'=>'btn btn-primary')) }}
                    </div>
                </div>
            </div>
        </fieldset>
    {{ Form::token() . Form::close() }}
@stop