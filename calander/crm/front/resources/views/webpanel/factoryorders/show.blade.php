@extends('webpanel.layouts.base')
@section('title')
Factory Order
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Factory Order Details</h3>
        </div>
    </div>

    <div class="callout callout-success" style="margin: 0;">
        <small>
            Order ID: {{ $factoryOrder->OID }} <br/>
            Order Date: {{ $factoryOrder->createdDate('d/m/Y') }} <br/>
            Order Status: {!! @\App\Modules\FactoryOrders\FactoryOrder::$statusLabel[$factoryOrder->status] !!} <br/>
            Factory: {{ $factoryOrder->factory_name }}
        </small>
    </div>

    <div class="content">
        <form method="post" action="{{ sysUrl('factoryorders/ship/'.encryptIt($factoryOrder->id)) }}">
            <input type="hidden" name="_method" value="put">
            @include('webpanel.includes.notifications')

                    <table class="table table-bordered table-responsive deleteArena">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Color</th>
                            <th>Price</th>
                            <th align="right">Total</th>
                            <th style="width:100px;">Ordered QTY</th>
                            <th style="width:100px;">Received QTY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $items = $factoryOrder->items()->with('product.photos')->get();
                        $grandTotal = 0; ?>
                        @foreach($items as $k => $item)
                            <tr class="deleteBox">
                                <td>
                                    {{ $k + 1 }}
                                </td>
                                <td>
                                    {{ @$item->product->name }} <br/>
                                    {{ @$item->variant->sku }}
                                </td>
                                <td><img src="{{ $item->product->getThumbUrl() }}"></td>
                                <td>
                                    {{ @$item->variant->color->name }}
                                </td>
                                <td>{{ currency($item->price) }}</td>
                                <?php
                                if ($factoryOrder->isReceived()):
                                    $total = $item->price * $item->shipped_qty;
                                else:
                                    $total = $item->price * $item->qty;
                                endif;
                                $grandTotal += $total; ?>
                                <td>{{ currency($total) }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>
                                    @if(!$factoryOrder->isReceived())
                                        <input type="text" class="form-control" name="shipped_qty[{{ $item->id }}]"
                                               value="{{ $item->shipped_qty }}" max="{{ $item->qty }}" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                    @else
                                        {{ $item->shipped_qty }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="6"></th>
                            <th >
                                {{ $factoryOrder->items->sum('qty') }}
                            </th>
                            <th>{{ $factoryOrder->items->sum('shipped_qty') }}</th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right;">Grand Total</th>
                            <th>
                                {{ currency($grandTotal) }}
                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td colspan="9">
                                <div class="btn-group pull-right">
                                    @include('webpanel.factoryorders.partials.admin-menu')
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
                <form action="{{ sysUrl('factoryOrders/decline/'.encryptIt($factoryOrder->id)) }}" method="post"
                      class="form-horizontal"
                      data-notification-area="#categoryNotification">
                    <div id="categoryNotification"></div>
                    <input type="hidden" name="_method" value="put">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">DECLINE FactoryOrder: {{ $factoryOrder->OID }}</h4>
                    </div>
                    <div class="modal-body">
                        <strong>FactoryOrder Date: </strong> {{ $factoryOrder->createdDate() }}<br>
                        <strong>Total Price: </strong> {{ @currency($factoryOrder->price) }}<br>
                        <strong>Total Items: </strong> {{ $factoryOrder->items->count() }}<br>
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