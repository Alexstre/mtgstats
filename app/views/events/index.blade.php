@extends('base')

@section('content')

<div class="col-md-10">
    <div class="row">
        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading"><div class="panel-title">Striped Rows</div></div>
                <div class="panel-body">
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
                                    <a class="btn btn-small btn-success" href="{{ URL::to('events/' . $value->slug) }}">Show this Event</a>
                                    <a class="btn btn-small btn-info" href="{{ URL::to('events/' . $value->id . '/edit') }}">Edit this Event</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading"><div class="panel-title">Striped Rows</div></div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped" id="events">
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
                                    <a class="btn btn-small btn-success" href="{{ URL::to('events/' . $value->slug) }}">Show this Event</a>
                                    <a class="btn btn-small btn-info" href="{{ URL::to('events/' . $value->id . '/edit') }}">Edit this Event</a>
                                </td>
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