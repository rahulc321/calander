@extends('webpanel.layouts.base')
@section('title')
Orders
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Orders</h3>
        </div>
    </div>

    @include('webpanel.includes.notifications')

        <div class="content">
            @include('webpanel.orders.partials.search')

            <div class="pull-right" style="font-size: 15px;font-weight: bold;">Total: {{ currency(getTotalFromOrders($orders)) }}</div>

                    <table class="table table-bordered table-striped ajaxTable deleteArena"
                           data-request-url="<?php echo route('webpanel.orders.index'); ?>">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th class="sortableHeading" data-orderBy="OID">Order ID</th>
                            <th class="sortableHeading" data-orderBy="created_at">Order Date</th>
                            <th>Expected Shipping Date</th>
                            @if(!auth()->user()->isCustomer())
                                <th class="sortableHeading" data-orderBy="created_by">Customer</th>
                            @endif
                            <th class="sortableHeading" data-orderBy="price" width="140">Amount</th>
                            <th>Items Ordered</th>
                            <th class="sortableHeading" data-orderBy="status">Status</th>
                            <!-- <th>Required Qty</th> -->
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div>
                        <nav id="paginationWrapper" class="pagination-sm"></nav>
                    </div>
        </div>
@stop