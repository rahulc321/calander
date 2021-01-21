@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <table width="98%" cellspacing="0" cellpadding="4" border="0">
        <tr>
            <td width="70%">
                ORDER#: {{ $factoryOrder->OID }} <br/>
                Order Date: {{ $factoryOrder->createdDate('d/m/Y') }} <br/>
                Factory: {{ $factoryOrder->factory_name }}
            </td>
            <td width="30%" style="font-size:20px;font-weight: bold;" align="right">
                {!! @\App\Modules\FactoryOrders\FactoryOrder::$statusLabel[@$factoryOrder->status] !!}
            </td>
        </tr>
    </table>

    <br/><br/>

    <table width="98%" cellspacing="0" cellpadding="4" border="1">
        <thead>
        <tr>
            <th>SN</th>
            <th>Product Name</th>
            <th>Color</th>
            <th>SKU</th>
            <th>Size</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $items = $factoryOrder->items()->with('product.photos')->get(); $grandTotal = 0; ?>

        @foreach($items as $k => $item)
            <tr class="deleteBox">
                <td> {{ $k + 1 }} </td>
                <td>{{ @$item->product->name }}</td>
                <td>{{ @$item->variant->color->name }}</td>
                <td>{{ @$item->variant->sku }}</td>
                <td>{{ @$item->product->length }} X {{ @$item->product->height }}</td>
                <td align="right"> {{ $item->qty }} </td>
                <td align="right"> {{ currency($item->price) }} </td>
                <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                <td align="right">{{ currency($total) }}</td>
            </tr>

        @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th colspan="6" style="text-align: right;">Total</th>
            <th align="right">
                {{ currency($grandTotal) }}
            </th>
        </tr>

        <tr>
            <th colspan="6" style="text-align: right;">Grand Total</th>
            <th align="right">
                {{ currency($grandTotal) }}
            </th>
        </tr>
        </tfoot>
    </table>

@stop
