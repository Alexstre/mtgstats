@extends('master')

@section('content')
    @foreach($decks as $deck)
        <h2>Showing {{ $deck->meta }}<small>by {{ $deck->player }}</small></h2>

        <h3>Main Deck</h3>
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

        <h3>Sideboard</h3>
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

    @endforeach
@stop