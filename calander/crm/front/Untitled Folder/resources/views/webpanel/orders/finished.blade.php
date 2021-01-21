@extends('webpanel.layouts.base')
@section('title')
Order Details
@parent
@stop

@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Order Details</h3>
            <a href="{{ sysRoute('orders.create') }}" class="btn btn-primary pull-right">Create New Order</a>
        </div>
    </div>

    <div class="alert alert-success">
        <h4>
            ORDER#: {{ $order->OID }}
        </h4>
        <h5>Order Date: {{ $order->createdDate() }}</h5>
    </div>

    <form class="form-inline" method="post" action="">
        @include('webpanel.includes.notifications')
        <div class="panel">
            <div class="panel-body">
                <table class="table table-responsive deleteArena">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $items = $order->items()->with('variant.inventory.metric', 'variant.attachment')->get(); ?>
                    @foreach($items as $k => $item)
                        <tr class="deleteBox">
                            <td>
                                {{ $k + 1 }}
                            </td>
                            <td>{{ $item->variant->title }}</td>
                            <td>
                                <img src="{{ $item->variant->getThumbUrl() }}">
                                <br>

                                <br>
                                <strong>{{ $item->variant->inventory->name }}</strong>
                            </td>
                            <td>
                                {{ $item->qty }}
                                {{ @$item->variant->inventory->metric->name }}
                            </td>
                            <td>
                                {{ currency($item->price) }}
                                <strong>per {{ @$item->variant->inventory->metric->name }}</strong>
                            </td>
                            <td>{{ currency($item->price * $item->qty) }}</td>
                        </tr>

                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="4" style="text-align: right;">Grand Total</th>
                        <th>
                            {{ currency($order->items->sum('qty') * $order->items->sum('price')) }}
                        </th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>

@stop
