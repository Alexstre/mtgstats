@extends('master')
@section('content')
<h2>Creating an event</h2>
<p>In order to add an event you will need a complete deck list. To get started fill in the information about the event below then proceed with the deck lists</p>

<h3>Event Information</h3>
{{ Form::open(array('action' => 'EventController@store')) }}
    <div class="input-group">
        <span class="input-group-addon">Event Name</span>
        {{ Form::text('name', Input::old('name'), array('class'=>'form-control')) }}
        {{ $errors->first('name') }}
    </div>

    <div class="input-group">
        <span class="input-group-addon">Event Date</span>
        {{ Form::text('played_on', '', array('class'=>'form-control', 'id'=>'datepicker', 'placeholder'=>'Format: 2014-06-30')) }}
        {{ $errors->first('played_on') }}
    </div>

    {{ Form::submit('Create', array('class'=>'btn btn-default')) }}

    {{ Form::token() . Form::close() }}
@stop