@extends("base")
@section("content")
<div class="col-md-10">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-wrapper">
                <div class="box">
                    <div class="content-wrap">
                        <h6>Register</h6>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        {{ Form::open(array('action'=>'UserController@newUser')) }}
                        {{ $errors->first("password") }}<br />
                        {{ Form::text("username", Input::old("username"), array('class'=>'form-control', 'placeholder'=>'Username')) }}
                        {{ Form::text("email", Input::old("email"), array('class'=>'form-control', 'placeholder'=>'Email')) }}
                        {{ Form::password("password", array('class'=>'form-control', 'placeholder'=>'Password')) }}
                        {{ Form::password("password_confirmation", array('class'=>'form-control', 'placeholder'=>'Password, again!')) }}
                        <div class="action">
                            {{ Form::submit("Register", array('class'=>'btn btn-primary signup')) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop