@extends('pdf.viewbase')
@section('body')


    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <table width="98%" cellspacing="0" cellpadding="4" border="0">
        @if(@$order->creator)
            <tr>
                <td width="70%">
                    {{ @$order->creator->fullName() }} <br>
                    {{ @$order->creator->email }}<br>
                    {{ @$order->creator->phone }}<br>
                    {{ @$order->creator->address }}
                </td>
                <td colspan="2"></td>
                <td width="30%" align="left">
                    @if($order->creator->parent)
                        {{ $order->creator->parent->fullName() }}<br>
                        {{ $order->creator->parent->email }}<br>
                        {{ $order->creator->parent->phone }}<br>
                        {{ $order->creator->parent->address }}<br>
                    @endif
                </td>
            </tr>
        @endif
        <tr>
            <td>
                ORDER#: {{ $order->OID }} <br/>
                REFUND #: RE-{{ $order->id  }}<br/>
                @if($order->invoice)
                    INVOICE#: {{ @$order->invoice->IID }} <br/>
                @endif
                Order Date: {{ $order->createdDate() }}
            </td>
            <td></td>
        </tr>

    </table>

    <br/><br/>
    Credit Note: {{ $order->credit_note }}
    <br>
    <br>

    <table width="98%" cellspacing="0" cellpadding="4" border="1">
        <thead>
        <tr>
            <th>SN</th>
            <th>Product Name</th>
            <th>Color</th>
            <th>SKU</th>
            <th>Size</th>
            <th>Refund Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $items = $order->refundItems()->with('product.photos')->get(); $grandTotal = 0; ?>

        @foreach($items as $k => $item)
            <tr class="deleteBox">
                <td> {{ $k + 1 }} </td>
                <td>{{ @$item->product->name }}</td>
                <td>
                    <div style="background: {{@$item->variant->color->hex_code }}; width:20px; height:20px;"></div>
                </td>
                <td>{{ @$item->variant->sku }}</td>
                <td>{{ @$item->product->length }} X {{ @$item->product->height }}</td>
                <td align="right"> {{ $item->refund_qty }} </td>
                <td align="right"> {{ $order->getInCurrency($item->price) }} </td>
                <?php $total = $item->getDiscountedPrice() * $item->refund_qty; $grandTotal += $total; ?>
                <td align="right">{{ $order->getInCurrency($total) }}</td>
            </tr>
        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th colspan="7" style="text-align: right;">Total</th>
            <th align="right">
                {{ $order->getInCurrency($grandTotal) }}
            </th>
        </tr>
        </tfoot>
    </table>

@stop
