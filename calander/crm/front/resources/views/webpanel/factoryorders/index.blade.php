@extends('webpanel.layouts.base')
@section('title')
Factory Orders
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Factory Orders</h3>
        </div>
        <div class="range">
            <a href="{{ sysRoute('factoryorders.create') }}" class="btn btn-warning btn-sm pull-right">+ Add Order</a>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')
        @include('webpanel.factoryorders.partials.search')

        <div>
            <a href="{{ sysUrl('factoryorders/download-all/xl') }}?{{ http_build_query(Input::except('page')) }}" class="pull-right"><i class="icon-print2"></i> Print</a>

            <div class="panel-body">
                <table class="table table-bordered table-striped ajaxTable deleteArena"
                       data-request-url="<?php echo route('webpanel.factoryorders.index'); ?>">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-orderBy="OID">Order ID</th>
                        <th>Ordered QTY</th>
                        <th>Factory Name</th>
                        <th class="sortableHeading" data-orderBy="created_at">Delivery Date</th>
                        <th class="sortableHeading" data-orderBy="created_at">Order Date</th>
                        <th class="sortableHeading" data-orderBy="price">Total Price</th>
                        <th data-orderBy="status">Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div>
                    <nav id="paginationWrapper"></nav>
                </div>
            </div>
        </div>
    </div>

@stop


