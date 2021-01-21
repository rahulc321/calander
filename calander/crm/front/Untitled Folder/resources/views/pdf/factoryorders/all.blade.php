@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <h4 style="text-align: center">FACTORY ORDERS</h4>

    <table width="99%" cellspacing="0" cellpadding="4" border="1">
        <tr>
            <td>SN</td>
            <td>Order ID</td>
            <td>Factory</td>
            <td>Order Date</td>
            <td>Delivery Date</td>
            <td>Total Price</td>
            <td>Total Items</td>
            <td>Status</td>
        </tr>
        <tbody>
        <?php $i = 1; ?>
        @foreach($factoryOrders as $k => $order)
            <tr>
                <td>{{ $k + 1  }}</td>
                <td>{{ $order->OID }}</td>
                <td>{{ $order->factory_name }}</td>
                <td>{{ $order->createdDate('d/m/Y') }}</td>
                <td>{{ date("d/m/Y", strtotime(@$order->delivery_date)) }} </td>
                <td>{{ @currency($order->price) }}</td>
                <td>{{ $order->items->count() }}</td>
                <td> {!! @\App\Modules\FactoryOrders\FactoryOrder::$statusLabel[$order->status] !!}</td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>

@stop
