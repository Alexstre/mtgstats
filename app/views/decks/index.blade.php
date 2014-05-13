@extends('base')

@section('content')
 <div class="col-md-10">
    <div class="row">
        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading"><div class="panel-title"><h2>Recent Decks</h2></div></div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Archetype</td>
                                <td>Pilot</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($decks as $key => $value)
                            <tr>
                                <td><a href="{{ URL::to('/decks/' . $value->slug) }}">{{ $value->meta }}</a></td>
                                <td>{{ $value->player }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $decks->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@stop