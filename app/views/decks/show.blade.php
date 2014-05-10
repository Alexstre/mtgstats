@extends('base')

@section('content')
<div class="col-md-10">
    <div class="row">
        @foreach($decks as $deck)
        <h2>{{ $deck->meta }}<small>by {{ $deck->player }}</small></h2>
        <div class="col-md-6">
            <div class="content-box-large">
                    <div class="panel-heading"><div class="panel-title">Main Deck</div></div>
                    <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Card</td>
                                <td>#</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($deck->cards as $card)
                            @if ($card->pivot->maindeck)
                                <tr>
                                    <td><a href="{{ URL::to('cards/' . $card->id) }}">{{ $card->name }}</a></td>
                                    <td>{{ $card->pivot->amount }}</td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="content-box-large">
                <div class="panel-heading"><div class="panel-title">Sideboard</div></div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <td>Card</td>
                                <td>#</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deck->cards as $card)
                                @if (!$card->pivot->maindeck)
                                    <tr>
                                        <td><a href="{{ URL::to('cards/' . $card->id) }}">{{ $card->name }}</a></td>
                                        <td>{{ $card->pivot->amount }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@stop