@extends('webpanel.layouts.base')
@section('title')
Invoices
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Invoices</h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')
        @include('webpanel.invoices.partials.search')

        <div class="hpanel">
            <div class="panel-body">
                (Unpaid = {{currency(@$totalUnpaid)}}) <br />  (Paid = {{currency(@$totalpaid)}}) <a href="{{ sysUrl('invoices/download-all/xl') }}?{{ http_build_query(Input::except('page')) }}" class="pull-right btn"><i class="icon-print2"></i> Print</a>

                <table class="table table-bordered  table-binvoiceed deleteArena"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Invoice ID</th>
                        <th class="sortableHeading" data-invoiceBy="created_by">Issued To</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Due Expired</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        @if(auth()->user()->isSales() OR auth()->user()->isAdmin())
                            <th>Commission</th>
                        @endif
                        @if(auth()->user()->isAdmin())
                            <th>Action</th>
                        @endif
                        <th>Download</th>
                    </tr>
                    </thead>
                    {!! sysView('invoices.partials.list', compact('invoices')) !!}
                    <tbody>
                    </tbody>
                </table>

                <div>
                    <nav id="paginationWrapper" class="pagination-sm">
                        {!! $invoices->appends(Input::except('page'))->render() !!}
                    </nav>
                </div>
            </div>
            <div>
                @if(auth()->user()->isSales())
                    <div class="sales-container">
                        <strong>Total Commission Earned:</strong>
                        <?php
                        $totalAmount = \App\Modules\Invoices\Invoice::forMe()->paid()
                                ->leftJoin('orders', 'invoices.order_id', '=', 'orders.id')->sum('price');
                        echo $totalAmount > 0 ? currency(percentOf(auth()->user()->commission, $totalAmount)) : currency(0);
                        ?>
                    </div>
                @endif
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(document).on('change', '.toggleStatus', function (e) {
                    if(confirm("Are you sure you want to perform this action ?")){
                        window.location = $(this).data('url')+'/'+$(this).val();
                    }
                    else{
                        window.location.reload();
                    }

                })
            });
        })(jQuery, window, document);
    </script>
@stop