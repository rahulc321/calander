@extends('webpanel.layouts.base')
@section('title')
    Sales Statistics
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Sales Statistics</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            @include('webpanel.includes.notifications')

            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="post" id="chart-form">

                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="date_from">Date From:</label>
                                <input type="text" class="form-control dp changable" id="date_from"
                                       name="date_from"
                                       value="{{ Input::get('date_from', date("Y-m-d", strtotime("- 7 DAYS"))) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="date_to">Date To:</label>
                                <input type="text" class="form-control dp changable" id="date_to"
                                       name="date_to"
                                       value="{{ Input::get('date_to', date("Y-m-d")) }}">
                            </div>
                            <div class="col-md-2">
                                <label for="date_to">Select:</label>
                                <select class="form-control changable lazySelector" name="column"
                                        data-selected="{{ Input::get('column') }}">
                                    <option value="sales">Sales</option>
                                    <option value="profit">Profit</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="date_to">Total:</label>
                                 <div id="total-div"> 0</div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="loader" style="display: none;">Loading...</div>
                    <div id="curve_chart" style="min-height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>


@stop

@section('scripts')
    <script src="{{ asset('assets/js/highcharts/highcharts.js') }}"></script>
    <script src="{{ asset('assets/js/highcharts/exporting.js') }}"></script>

    <script type="text/javascript" src="{{ asset('js/observer.js') }}"></script>
    <script type="text/javascript">

        firstFetch();

        function drawChart(response) {
            var data = response.data;
            var label = response.label;
            var subtitle = response.subtitle;
            var obj = {
                chart: {
                    style: {
                        fontFamily: '\'PT Sans Narrow\', sans-serif'
                    }
                },
                title: {
                    text: 'Sales Statistics',
                    x: -20 //center
                },
                subtitle: {
                    text: subtitle,
                    x: -20
                },
                xAxis: {
                    categories: label
                },
                yAxis: {
                    title: {
                        text: response.unit
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: ' DKK'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: data
            };
            Highcharts.chart('curve_chart', obj);

            $("#total-div").text(parseFloat(response.total).toFixed(2));
            $("#total-div").prepend('{{Config::get('currency.before') }}');
        }

        function firstFetch() {
            observer.init('{{ sysUrl('charts/sales') }}')
                    .listen()
                    .fetchData();
        }
    </script>
@stop