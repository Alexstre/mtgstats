@extends('layouts.default')
@section('title')
    {{ $card->name }}
@stop
@section('content')
<div class="col-md-8">
    <div class="content-box-large">
        <div class="panel-heading"><div class="panel-title"><h2>{{ $card->name }}</h2></div></div>
        <div class="panel-body">
            <div id="chart"></div>
        </div>
        <div class="panel-heading"><div class="panel-title"><h3>A few recent decks using {{ $card->name }}</h2></div></div>
        <div class="panel-body">
            <table class="table table-bordered table-striped" id="lastDecks">
                <thead>
                <tr>
                    <td>Archetype</td>
                    <td>Pilot</td>
                    <td>Date</td>
                    <td># main deck</td>
                    <td># side board</td>
                </tr>
                </thead>
                <tbody>
                @foreach($decks as $key => $value)
                <tr>
                    <td><a href="{{ URL::to('/decks/' . $value->slug) }}">{{ $value->meta }}</a></td>
                    <td>{{ $value->player }}</td>
                    <td>{{ date("d F Y", strtotime($totals[$value->id]['played_on'])) }}</td>
                    <td>{{ (isset($totals[$value->id]['maindeck']) ? $totals[$value->id]['maindeck'] : 0) }}</td>
                    <td>{{ (isset($totals[$value->id]['sideboard']) ? $totals[$value->id]['sideboard'] : 0) }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="content-box-large">
        <div class="panel-heading"><div class="panel-title"><h3>{{ $card->name }}</h3></div></div>
        <div class="panel-body">
            <img src="{{ $image }}" class="img-responsive" alt="{{ $card->slug }}"/>
            <p class="text-center">All images courtesy of the awesome <a href="http://mtgimage.com">mtgimage.com</a></p>
        </div>
    </div>
</div>
@stop

@section('bottom')
<script src="http://code.highcharts.com/highcharts.js"></script>
<script>
    $('#lastDecks').dataTable( {
        aaSorting: [[ 2, "desc" ]],
        bSortClasses: false,
    } );
</script>
<script>
    $(function () {
        $('#chart').highcharts({
            title: {
                text: "{{ 'Popularity of ' . $card->name }}",
                x: -20 //center
            },
            xAxis: {
                categories: {{ $times }}
            },
            yAxis: {
                min: 0,
                allowDecimals: false,
                title: {
                    text: 'Amount in meta'
                },
                plotLines: [{
                    value: 0,
                    width: 2,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: ' copies'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            series: [{
                name: 'Mainboard',
                data: {{ $mb }}
            }, {
                name: 'Sideboard',
                data: {{ $sb }}
            }]
        });
    });
</script>
@stop