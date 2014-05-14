@extends('layouts.default')
@section('title')
    {{ $deck->meta }} by {{ $deck->player }}
@stop
@section('content')

<h2>{{ $deck->meta }} <small>{{ $deck->player }}</small></h2>
<div class="col-md-8">
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
                            <td><a href="{{ URL::to('cards/' . $card->slug) }}">{{ $card->name }}</a></td>
                            <td>{{ $card->pivot->amount }}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-4">
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
                                <td><a href="{{ URL::to('cards/' . $card->slug) }}" onmouseover="changeImg('{{ Card::grabImage($card->name) }}')">{{ $card->name }}</a></td>
                                <td>{{ $card->pivot->amount }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="content-box-large">
        <div class="panel-body">
            <img src="{{ Card::grabImage($deck->cards[0]->name) }}" class="img-responsive" alt=""/>
        </div>
    </div>
</div>
@stop