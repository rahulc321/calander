<?php $i = 1; ?>
@foreach($orders as $k => $order)
    <tr class="deleteBox">
        <td>{{ $k + 1  }}</td>
        <td><a href="{{ sysRoute('orders.show', encryptIt($order->id)) }}">{{ $order->OID }}</a></td>
        <td>{{ $order->createdDate('d/m/Y') }}</td>

        <td>
            @if($order->hasExpectedShippingDate())
                {{ $order->expected_shipping_date->format("d/m/Y") }}
            @endif
        </td>

        @if(!auth()->user()->isCustomer())
            <td>
                @if($order->creator)
                    {{ $order->creator->fullName() }}
                    @if($order->creator->parent)
                        ( {{ $order->creator->parent->fullName() }} )
                    @endif
                @endif
            </td>
        @endif
        <td align="right">{{ @currency($order->getTotalPrice()) }}</td>
        <td>{{ $order->items->sum('qty') }}</td>
        <td>
            {!! @\App\Modules\Orders\Order::$statusLabel[$order->status] !!}
            @if($order->isDeclined())
                <p>REASON:{{ $order->remarks }}</p>
            @endif

            @if($order->isDue())
                <br>
                {{ @DateDiff($order->due_date, date("Y-m-d"))->days }} days
            @endif
        </td>
        <td>
            <a title="Print" href="{{ sysUrl('orders/download/'.encryptIt($order->id)) }}">
                <i class="icon-download"></i>
            </a>
            @if($order->isOrdered())
                <a title="Delete Order"
                   href="#"
                   class="ajaxdelete text-danger"
                   data-id="<?php echo $order->id; ?>"
                   data-url="<?php echo sysUrl('orders/delete/' . encrypt($order->id)); ?>"
                   data-token="<?php echo urlencode(md5($order->id)); ?>"><i class="icon-remove2"></i>
                </a>
            @endif
        </td>
    </tr>
    <?php $i++; ?>
@endforeach