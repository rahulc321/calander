@extends('webpanel.layouts.base')
@section('title')
    Ship Order
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Order Details</h3>
        </div>
    </div>

    <div class="callout callout-success" style="margin: 0; margin-bottom: 10px;">
        <p>
            <small>
                ORDER ID: {{ $order->OID }} <br/>
                Order Status: {!! @\App\Modules\Orders\Order::$statusLabel[$order->status] !!} <br/>
                Order Date: {{ $order->createdDate('d/m/Y') }} <br/>
                Customer: {{ $order->creator->fullName() }} <br/>
                Debtor number: {{ $order->creator->debitor_number }}
            </small>
        </p>
        @if($order->isDeclined())
            <div class="callout callout-danger fade in">
                <h5>DECLINED at {{ $order->declined_date }}</h5>
                <p>REASON:{{ $order->remarks }}</p>
            </div>
        @endif
    </div>

    <div class="content">
        <?php
        $action = sysUrl('orders/ship/' . encryptIt($order->id));
        if ($order->isShipped() /*&& auth()->user()->isCustomer()*/) {
            $action = sysUrl('orders/refund/' . encryptIt($order->id));
        }
        ?>

        <form method="post" action="{{ $action }}" class="form-inline">
            <input type="hidden" name="_method" value="put">
            @include('webpanel.includes.notifications')

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">Order Details</h6>
                </div>

                <table class="table table-responsive deleteArena">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Color</th>
                        <th>Note</th>
                        <th style="width:100px;">Qty</th>
                        <th style="width:50px !important;">Discount(%)</th>
                        <th>Price</th>
                        <th align="right">Total</th>
                        <th style="width:100px;">Refund Qty</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0; ?>
                    @foreach($items as $k => $item)
                        <tr class="deleteBox">
                            <td>{{ $k + 1 }}</td>
                            <td>{{ @$item->product->name }}</td>
                            <td><img src="{{ $item->product->getThumbUrl() }}"></td>
                            <td>{{ @$item->variant->color->name }}</td>
                             <td>
                            <input type="text" class="form-control" name="note[{{ @$item->id }}]" value="{{ @$item->note }}" style="min-width: 75px;">
                            </td>
                            <td>
                                @if($order->isOrdered())
                                    <input type="number" class="form-control" name="shipped_qty[{{ $item->id }}]"
                                           value="{{ $item->qty }}" style="min-width: 75px;">
                                @else
                                    {{ $item->qty }}
                                @endif
                            </td>
                            <td>
                                @if($order->isOrdered())
                                    <input type="text" class="form-control" name="discount[{{ $item->id }}]"
                                           value="{{ $item->discount }}" style="width:50px !important;">
                                @else
                                    {{ $item->discount }}
                                @endif
                            </td>
                            <td>{{ currency($item->price) }}</td>
                             
                            <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                            <td>{{ currency($total) }}</td>
                            <td>
                                @if($order->isShipped() && auth()->user()->isCustomer() && !$order->isRefundRequested())
                                    <input type="text" class="form-control" name="refund_qty[{{ $item->id }}]"
                                           value="{{ $item->refund_qty }}" max="{{ $item->shipped_qty }}">
                                @else
                                    {{ $item->refund_qty }}
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->isAdmin() && $order->isOrdered())
                                    <a href="{{ sysUrl('orders/delete-ordered-item/'.encryptIt($item->id).'/'.encryptIt($order->id)) }}"><i
                                                class="icon-remove2"></i> </a>
                                @endif
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="9">
                            @if(auth()->user()->isAdmin() && $order->isOrdered())
                                Expected Shipping Date:
                                <input type="text" class="form-control dp" name="expected_shipping_date"
                                       style="width:140px;"
                                       value="{{ $order->expected_shipping_date ? date("d/m/Y", strtotime($order->expected_shipping_date)) : '' }}">
                                <input type="submit" value="Update" name="updateQty" class="btn btn-primary submit-btn">

                            @endif
                        </td>
                        
                    </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="10" style="text-align: right;">Total</th>
                        <th>{{ Currency($grandTotal) }}</th>
                        <th></th>
                    </tr>
                    @if($order->tax_percent > 0)
                        <?php
                        $taxPercent = $order->tax_percent;
                        ?>
                        <tr>
                            <th colspan="10" style="text-align: right;">Tax</th>
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
                        <th colspan="10" style="text-align: right;">Shipping Cost</th>
                        <th>
                            {{ currency($order->shipping_price) }}
                        </th>
                        <th></th>
                    </tr>
                    @if($order->getCreditNoteAmount() > 0)
                        <tr>
                            <th colspan="10" style="text-align: right;">Kreditnota</th>
                            <th>{{ currency($order->getCreditNoteAmount()) }}</th>
                            <th></th>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="10" style="text-align: right;">Grand Total</th>
                        <th>{{ currency($order->getTotalPrice() - $order->getCreditNoteAmount()) }}</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td colspan="12">
                            <div class="btn-group pull-right">
                                @if(auth()->user()->isCustomer())
                                    <a href="{{ sysRoute('orders.create') }}" class="btn btn-warning btn-sm">Create New
                                        Order</a>

                                    @if($order->isShipped() && auth()->user()->isCustomer() && !$order->isRefundRequested())
                                        <br>
                                        <br>
                                        <label class="radio">
                                            <input type="radio" name="refund_type"
                                                   value="{{ \App\Modules\Orders\Order::REFUND_TYPE_INSTANT }}" checked>
                                            Instant Refund
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="refund_type"
                                                   value="{{ \App\Modules\Orders\Order::REFUND_TYPE_DEDUCTION }}">
                                            Deduct From next invoice
                                        </label>
                                        <br>
                                        {!! btn('Request Refund') !!}
                                    @endif
                                @else
                                    @include('webpanel.orders.partials.admin-menu')
                                @endif
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </form>

    </div>
@stop



@section('modals')
    <div class="modal fade declineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ sysUrl('orders/decline/'.encryptIt($order->id)) }}" method="post"
                      class="form-horizontal"
                      data-notification-area="#categoryNotification">
                    <div id="categoryNotification"></div>
                    <input type="hidden" name="_method" value="put">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">DECLINE ORDER: {{ $order->OID }}</h4>
                    </div>
                    <div class="modal-body">
                        <strong>Order Date: </strong> {{ $order->createdDate() }}<br>
                        <strong>Total Price: </strong> {{ @currency($order->price) }}<br>
                        <strong>Total Items: </strong> {{ $order->items->count() }}<br>
                        <div class="panel-body">
                            <div class="form-group required">
                                <label class="" for="name">Reason</label>
                                <div class="">
                                    <textarea class="form-control" name="remarks" required></textarea>
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