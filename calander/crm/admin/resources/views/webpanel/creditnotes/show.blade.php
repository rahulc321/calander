@extends('webpanel.layouts.base')
@section('title')
View Kreditnota
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Kreditnota Details</h3>
        </div>
    </div>

    @include('webpanel.includes.notifications')

    <div class="callout callout-success" style="margin: 0;">
        <small>
            Created Date: {{ $creditNote->createdDate('d/m/Y') }} <br/>
            Status: {!! @\App\Modules\Creditnotes\Creditnote::$statusLabel[$creditNote->status] !!} <br/>
            @if($creditNote->isDeclined())
                <strong>Reason: </strong> {{ $creditNote->status_text }}<br>
            @endif
            @if($creditNote->isApproved() || $creditNote->isPaid())
                <strong>Payment Type: </strong> {!! \App\Modules\CreditNotes\CreditNote::$paymentLabel[$creditNote->payment_type] !!}
                <br>
            @endif
            Customer: {{ $creditNote->user ? $creditNote->user->fullName() : '' }} <br/>
            Debitornr.: {{ $creditNote->user->debitor_number }}
            <br/>
            Note:  {{ $creditNote->note }}
        </small>
    </div>

    <div class="content">
        <form method="post" action="{{ sysUrl('creditnotes/ship/'.encryptIt($creditNote->id)) }}">
            <input type="hidden" name="_method" value="put">

            <br/>  <br/>
            <table class="table table-bordered table-responsive deleteArena">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Product Name</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th style="width:100px;">QTY</th>
                    <th align="right">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php $items = $creditNote->items()->with('product.photos')->get();
                $grandTotal = 0; ?>
                @foreach($items as $k => $item)
                    <tr class="deleteBox">
                        <td>
                            {{ $k + 1 }}
                        </td>
                        <td>
                            {{ @$item->product->name }}
                        </td>
                        <td>
                            {{ @$item->variant->color->name }}
                        </td>
                        <td>{{ currency($item->price) }}</td>
                        <td>{{ $item->qty }}</td>
                        <?php
                        $total = $item->price * $item->qty;
                        $grandTotal += $total; ?>
                        <td>{{ currency($total) }}</td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                @if($creditNote->tax_percent > 0)
                    <?php
                    $taxPercent = $creditNote->tax_percent;
                    ?>
                    <tr>
                        <th colspan="5" style="text-align: right;">Tax</th>
                        <th>
                            {{ $taxPercent }}% ({{ currency(($grandTotal * ($taxPercent / 100))) }})
                        </th>
                        <th></th>
                    </tr>
                    <?php
                    $grandTotal += ($grandTotal * ($taxPercent / 100));
                    ?>
                @endif
                <tr>
                    <th colspan="5" style="text-align: right;">Grand Total</th>
                    <th>
                        {{ currency($grandTotal) }}
                    </th>
                </tr>
                <tr>
                    <td colspan="9">
                        <div class="btn-group pull-right">
                            @if(auth()->user()->isAdmin())
                                @include('webpanel.creditnotes.partials.admin-menu')
                            @endif
                        </div>
                    </td>
                </tr>
                </tfoot>
            </table>
        </form>
    </div>

@stop


@section('modals')
    <div class="modal fade declineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ sysUrl('creditnotes/decline/'.encryptIt($creditNote->id)) }}" method="post"
                      class="form-horizontal"
                      data-notification-area="#categoryNotification">
                    <div id="categoryNotification"></div>
                    <input type="hidden" name="_method" value="put">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">DECLINE Kreditnota</h4>
                    </div>
                    <div class="modal-body">
                        <div style="padding:10px">
                            <strong>Credit note Date: </strong> {{ $creditNote->createdDate() }}<br>
                            <strong>Total Price: </strong> {{ @currency($creditNote->price) }}<br>
                            <strong>Total Items: </strong> {{ $creditNote->items->count() }}<br>
                            <div class="panel-body">
                                <div class="form-group required">
                                    <label class="" for="name">Reason</label>
                                    <div class="">
                                        <textarea class="form-control" name="remarks" required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Decline</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function () {
            $('.paymentToggle').on('change', function (e) {
                window.location = $(this).attr('data-url') + '/' + $(this).val();
            });
        });
    </script>
@stop