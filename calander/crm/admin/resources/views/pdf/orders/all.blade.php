@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:30px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <h4 style="text-align: center">ORDERS</h4>

    <table width="99%" cellspacing="0" cellpadding="4" border="1">
        <tr>
            <td>SN</td>
            <td>Order ID</td>
            @if(!auth()->user()->isCustomer())
                <td>Customer</td>
            @endif
            <td>Order Date</td>
            <td>Total Price</td>
            <td>Total Items</td>
            <td>Status</td>
        </tr>
        <tbody>
        <?php $i = 1; ?>
        @foreach($orders as $k => $order)
            <tr>
                <td>{{ $k + 1  }}</td>
                <td>
                    {{ $order->OID }}
                </td>
                @if(!auth()->user()->isCustomer())
                    <td>
                        {{ $order->creator->fullName() }}
                        @if($order->creator->parent)
                            ( {{ $order->creator->parent->fullName() }} )
                        @endif
                    </td>
                @endif
                <td>{{ $order->createdDate('d/m/Y') }}</td>
                <td>{{ @currency($order->price) }}</td>
                <td>{{ $order->items->count() }}</td>
                <td>
                    {!! @\App\Modules\Orders\Order::$statusLabel[$order->status] !!}
                    @if($order->isDeclined())
                        <p>REASON: {{ $order->remarks }}</p>
                    @endif
                </td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
    </table>

@stop
