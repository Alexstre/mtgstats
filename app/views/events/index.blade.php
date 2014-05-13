@extends('base')

@section('content')

<div class="col-md-10">
    <div class="row">
        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading"><div class="panel-title"><h2>Recent events</h2></div></div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Date</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $key => $value)
                            <tr>
                                <td><a href="{{ URL::to('/events/' . $value->slug) }}">{{ $value->name }}</a></td>
                                <td>{{ date("m F Y", strtotime($value->played_on)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop