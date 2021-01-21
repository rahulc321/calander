<?php $i = 1; ?>
@foreach($orders as $k => $order)
    <tr class="deleteBox">
        <td>RE-{{ $order->id  }}</td>
        <td>
            <a href="{{ sysRoute('orders.show', encryptIt($order->id)) }}">{{ $order->OID }}</a>
        </td>
        <td>
            {{ $order->createdDate('d/m/Y') }}
        </td>

        @if(!auth()->user()->isCustomer())
            <td>
                {{ $order->creator->fullName() }}
                @if($order->creator->parent)
                    ( {{ $order->creator->parent->fullName() }} )
                @endif
            </td>
        @endif

        <td>{{ @currency($order->getRefundAmount()) }}</td>
        <td>{{ $order->refundItems->count() }}</td>
        <td>
            {!! @\App\Modules\Orders\Order::$refundTypeLabel[$order->refund_type] !!}
        </td>
        <td>
            {!! @\App\Modules\Orders\Order::$refundStatusLabel[$order->refund_status] !!}
        </td>
        <td>
            @if($order->credit_note != '')
                {{ $order->credit_note }}
            @endif
        </td>
        <td>
            @if($order->credit_note == '' && auth()->user()->isAdmin())
                <a class="actionBtn" data-toggle="modal" data-target=".actionModal"
                   data-id="{{ $order->id }}"><i class="icon-cog4"></i>
                </a>
            @endif
            @if($order->isRefundApproved())
                    <a title="Print" href="{{ sysUrl('orders/download-refund/'.encryptIt($order->id)) }}">
                        <i class="icon-download"></i>
                    </a>
            @endif
        </td>
    </tr>
    <?php $i++; ?>
@endforeach