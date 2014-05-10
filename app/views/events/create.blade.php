@extends('base')
@section('content')

<div class="col-md-10">
    <div class="row">
        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">Adding an Event</div>
                        <div class="panel-body">
                            {{ Form::open(array('action' => 'EventController@store', 'class'=>'form-horizontal', 'role'=>'form')) }}
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Event Name</label>
                                <div class="col-sm-10">
                                    {{ Form::text('name', Input::old('name'), array('class'=>'form-control')) }}
                                    {{ $errors->first('name') }}                                
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Event Date</label>
                                <div class="col-sm-10">
                                    {{ Form::text('played_on', '', array('class'=>'form-control bfh-datepicker', 'placeholder'=>'Format: 2014-06-30', 'id'=>'datepicker')) }}
                                    {{ $errors->first('played_on') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    {{ Form::submit('Create', array('class'=>'btn btn-primary')) }}
                                </div>
                            </div>
                            {{ Form::token() . Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="content-box-large">
                    <h3>Read this first!</h3>
                    <p>In order to keep the database as clean as possible, all the events</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop