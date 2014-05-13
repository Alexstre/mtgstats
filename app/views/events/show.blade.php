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
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Finish</td>
                                <td>Archetype</td>
                                <td>Played by</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->decks as $deck)
                                <tr>
                                    <td>{{ (isset($deck->pivot->finish) ? $deck->pivot->finish : '0') }}</td>
                                    <td><a href="{{ URL::to('decks/' . $deck->slug) }}">{{ $deck->meta }}</a></td>
                                    <td>{{ $deck->player }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr/>
                    <p>Is there a deck missing from this event?<a href="{{ URL::to('decks/create')}}">Add it now</a> 
                    to help us out!. To learn more about adding decks and events check out <a href="{{ URL::to('/faq') }}">the FAQ</a>.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">
                        <h2>Important Cards</h2>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped" id="eventsCards">
                        <thead>
                        <tr>
                            <td>Name</td>
                            <td>Set</td>
                            <td>Mana Cost</td>
                            <td>Type</td>
                            <td>Count</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cards as $card)
                        <tr>
                            <td><a href="{{ URL::to('/cards/' . $card->slug )}}">{{ $card->name }}</a></td>
                            <td>{{ $card->set }}</td>
                            <td>{{ $card->manacost }}</td>
                            <td>{{ $card->type }}</td>
                            <td>{{ $card_amounts[$card->id] }}</td>
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