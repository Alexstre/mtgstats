@extends('layouts.default')
@section('title', 'Decks')
@section('content')
<div class="col-md-4">
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

<div class="col-md-8">
    <div class="content-box-large">
        <div class="panel-body">
            <div id="chart"></div>
        </div>
    </div>
</div>
@stop
@section('bottom')
<script src="http://code.highcharts.com/highcharts.js"></script>
<script>
    $(function () {
        $('#chart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
            },
            title: {
                text: 'Current overview of the meta (by archetype popularity)'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Archetype Popularity',
                data: [
                    {{ $arch }}
                ]
            }]
        });
    });
</script>
@stop