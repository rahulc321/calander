@extends('webpanel.layouts.base')
@section('title')
Top Dashboard
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Top Dashboard</h3>
        </div>
    </div>

    @include('webpanel.includes.notifications')

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading"><h6 class="panel-title">Top Clients </h6></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            @foreach($data['topClients'] as $client)
                            <tr><td>{{ $client->fullName() }}</td> <td>({{ currency($client->total) }})</td></tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading"><h6 class="panel-title">Top Clients This Month </h6></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            @foreach($data['topClientsThisMonth'] as $client)
                                <tr><td>{{ $client->fullName() }}</td> <td>({{ currency($client->total) }})</td></tr>
                            @endforeach
                        </table>
                    </div>
                </div>
           </div>

            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading"><h6 class="panel-title">Top Clients Who Owns Money</h6></div>
                    <div class="panel-body">

                        <table class="table table-bordered">
                            @foreach($data['topClientsOwnsMoney'] as $client)
                                <tr><td>{{ $client->fullName() }}</td> <td>({{ currency($client->total) }})</td></tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading"><h6 class="panel-title">Top Salesman</h6></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            @foreach($data['topSalesMan'] as $client)
                                <tr><td>{{ $client->fullName() }}</td> <td>({{ currency($client->totalIncome * ($client->commission/100)) }})</td></tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-heading"><h6 class="panel-title">Top Salesman This Month </h6></div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            @foreach($data['topSalesManThisMonth'] as $client)
                                <tr><td>{{ $client->fullName() }}</td> <td>({{ currency($client->totalIncome * ($client->commission/100)) }})</td></tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

@stop
