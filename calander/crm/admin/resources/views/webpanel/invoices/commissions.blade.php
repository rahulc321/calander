@extends('webpanel.layouts.base')
@section('title')
Commission
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Commission</h3>
        </div>
    </div>

    @include('webpanel.includes.notifications')
    @include('webpanel.invoices.partials.commission-filter')

    <div class="content">
            <?php
            $totalCommission = 0;
            $paidCommission = 0;
            foreach ($totalInvoices as $inv) {
                if ($inv->order->salesPerson):
                    $commission = percentOf($inv->order->salesPerson->commission, $inv->order ? $inv->order->getTotalWithoutShipping() : 0);
                    if($inv->isCommissionPaid()){
                        $paidCommission += $commission;
                    }
                    $totalCommission += $commission;
                endif;
            }
            ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Commission</h6>
                
                <span class="pull-right badge">Left Commission : {{currency($totalCommission-$paidCommission)}}</span>
                
                <span class="pull-right badge">Total Commission : {{ currency($paidCommission) }} paid out of {{ currency($totalCommission) }}</span>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Invoice ID</th>
                        <th class="sortableHeading" data-invoiceBy="created_by">Issued To</th>
                        <th data-invoiceBy="">Issue Date</th>
                        <th data-invoiceBy="">Due Date</th>
                        <th data-invoiceBy="status">Commission Status</th>
                        <th>Total Amount</th>
                        <th>Commission</th>
                        @if(auth()->user()->isAdmin())
                            <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    {!! sysView('invoices.partials.commission-list', compact('invoices')) !!}
                    </tbody>
                </table>
                <div>
                    <nav id="paginationWrapper">
                        {!! $invoices->appends(Input::except('page'))->render() !!}
                    </nav>
                </div>
            </div>
        </div>

    </div>


@stop


@section('scripts')
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(document).on('change', '.toggleStatus', function (e) {
                    window.location = $(this).data('url');
                })
            });
        })(jQuery, window, document);
    </script>
@stop