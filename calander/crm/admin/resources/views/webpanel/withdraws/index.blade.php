@extends('webpanel.layouts.base')
@section('title')
Withdraw
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Withdraw Request</h3>
        </div>
    </div>


    <div class="content">

        @include('webpanel.includes.notifications')
        @include('webpanel.withdraws.partials.search')


          <a href="{{ sysUrl('withdraws/download-all/xl') }}?{{ http_build_query(Input::except('page')) }}"
                   class="pull-right printBtn btn btn-warning2 btn-sm"><i class="icon-print2"></i> Print</a>

                <table class="table table-bordered table-striped table-bwithdrawed ajaxTable deleteArena"
                       data-request-url="<?php echo route('webpanel.withdraws.index'); ?>">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>WithDraw ID</th>
                        <th class="sortableHeading" data-withdrawBy="created_at">Date</th>
                        <th data-withdrawBy="status">Status</th>
                        <th data-withdrawBy="status">Remarks</th>
                        <th>Amount</th>
                        @if(auth()->user()->isAdmin())
                            <th>Requested By</th>
                            <th>Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div>
                    <nav id="paginationWrapper"></nav>
                </div>


        @if(auth()->user()->isSales())
            <?php
            $totalAmount = \App\Modules\Invoices\Invoice::forMe()->paid()
                    ->leftJoin('orders', 'invoices.order_id', '=', 'orders.id')->sum('price');
            $totalWithdrawls = \App\Modules\Withdraws\Withdraw::forMe()->notDeclined()->sum('amount');

            $totalCommission = $totalAmount > 0 ? percentOf(auth()->user()->commission, $totalAmount) : 0;
            $availableCommission = $totalCommission - $totalWithdrawls;
            ?>
            <br/>

            <div class="callout callout-info fade in">
                <a class="btn btn-sm btn-warning pull-right" data-toggle="modal" data-target=".withdrawModal">Withdraw</a>
                <h5>Available Withdrawal Amount: </h5>
                <div class="list-item-container">
                    <div class="list-item">
                        <h3 class="text-success">{{ currency($availableCommission) }}</h3>
                        <small>Last Withdraw Date: </small>
                        <div class="pull-right font-bold"> </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@stop


@section('modals')
    @if(auth()->user()->isSales())
        <div class="modal fade withdrawModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ sysRoute('withdraws.store') }}" method="post"
                          class="ajaxForm" data-notification-area="#withdrawlNotification">

                        <div id="withdrawlNotification"></div>

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Withdraw Your Amount</h4>
                        </div>

                        <div class="modal-body with-padding">
                            <strong>Available Commission:</strong> {{ currency($availableCommission) }}
                            <br>
                            <strong>Min. Balance to Withdraw: </strong> {{ currency(config('currency.minBalance')) }}
                            <br/><br/>
                            @if($availableCommission > config('currency.minBalance'))
                                <input type="hidden" name="cal_val" value="{{ encryptIt($availableCommission) }}">
                                <div class="panel-body">
                                    <div class="form-group required">
                                        <label for="amount">Specify Amount for withdraw Requests.</label>
                                        <div>
                                            <input type="text" class="form-control" name="amount" required min="{{ config('currency.minBalance') }}">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    <strong>Sorry! You do not have the sufficient commission yet to request for a withdraw.</strong>
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            @if($availableCommission > config('currency.minBalance'))
                                <button type="submit" class="btn btn-success">Withdraw</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="modal fade withdrawStatusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ sysUrl('withdraws/toggle-status/xl') }}" method="post"
                      data-notification-area="#withdrawlNotification">
                    <input type="hidden" name="withdraw_id" value="0">
                    <div id="withdrawlNotification"></div>

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Update Withdraw Request</h4>
                    </div>
                    <div class="modal-body with-padding">
                        <div class="form-group">
                            <label>Status:</label>
                            <div>
                                <select class="form-control" name="status">
                                    @foreach(\App\Modules\Withdraws\Withdraw::GetStatusAsArray() as $k => $status)
                                        <option value="{{ $k }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group required">
                            <label for="name">Remarks:</label>
                            <div>
                                <textarea class="form-control" name="remarks" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(document).on('click', '.changeStatus', function (e)
                {
                    $("[name=withdraw_id]").val($(this).data('id'));
                    $("[name=status]").val($(this).data('status'));
                    $(".withdrawStatusModal").modal({show: true});
                })
            });
        })(jQuery, window, document);
    </script>
@stop