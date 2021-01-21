<?php $i = 1; ?>
@foreach($factoryOrders as $k => $order)
    <tr class="deleteBox">
        <td>{{ $k + 1 }}</td>
        <td>
            <a href="{{ sysRoute('factoryorders.show', encryptIt($order->id)) }}">{{ $order->OID }}</a>
        </td>
        <td>
            Ordered Qty: {{ $order->totalOrderedQuantity() }}<br>
            Received Qty: {{ $order->totalReceivedQuantity() }}<br>
        </td>
        <td>{{ $order->factory_name }}</td>
        <td>
            {{ date("d/m/Y", strtotime(@$order->delivery_date)) }}
        </td>
        <td>{{ $order->createdDate('d/m/Y') }}</td>
        <td>{{ @currency($order->price) }}</td>
        <td>
            {!! @\App\Modules\FactoryOrders\FactoryOrder::$statusLabel[$order->status] !!}
            @if($order->isDue())
                <br>
                {{ @DateDiff($order->due_date, date("Y-m-d"))->days }} days
            @endif
        </td>
        <td align="center">
            <a title="Print" href="{{ sysUrl('factoryorders/download/'.encryptIt($order->id)) }}">
                <i class="icon-download"></i>
            </a>
        </td>
    </tr>
    <?php $i++; ?>
@endforeach