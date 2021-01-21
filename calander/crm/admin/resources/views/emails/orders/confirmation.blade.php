<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>


<div style="text-align: center">
    <img src="{{ asset('assets/images/moretti-leather-bags-logo-1.png') }}" height="90">
    <br/>
    <!--<small style="font-size:12px;">MORETTI MILANO</small>-->
</div>

<br/><br/>

<table width="96%" cellspacing="0" cellpadding="4" border="0">
    <tr>
        <td>
            Order Status: {!! @\App\Modules\Orders\Order::$statusLabel[$order->status] !!} <br/>
            ORDER#: {{ $order->OID }}
        </td>
        <td>
            Order Date: {{ $order->createdDate() }} <br/>
            Customer: {{ $order->creator->fullName() }}
        </td>
    </tr>
</table>

<br/> <br/>

<p align="center">Order Details</p>

        <table width="96%" cellspacing="0" cellpadding="4" border="1">
            <thead>
            <tr>
                <th>SN</th>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Image</th>
                <th>Color</th>
                <th>Size</th>
                <th style="width:100px;">Qty</th>
                <th style="width:100px;">Discount(%)</th>
                <th>Price</th>
                <th align="right">Total</th>
            </tr>
            </thead>
            <tbody>
            <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0; ?>
            @foreach($items as $k => $item)
                <tr class="deleteBox">
                    <td>
                        {{ $k + 1 }}
                    </td>
                    <td><strong>{{ @$item->product->name }}</strong></td>
                    <td>{{ @$item->variant->sku }}</td>
                    <td>
                        <img src="{{ $item->product->getThumbUrl() }}">
                    </td>
                    <td>
                        {{ @$item->variant->color->name }}
                        <!--<div style="background: {{@$item->variant->color->hex_code }}; width:20px; height:20px;"></div>-->
                    </td>
                    <td>{{ @$item->product->length }} X {{ @$item->product->height }}</td>
                    <td>

                        {{ $item->qty }}

                    </td>
                    <td>
                        {{ $item->discount }}

                    </td>
                    <td>
                        {{ currency($item->price) }}
                    </td>
                    <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                    <td>{{ currency($total) }}</td>

                </tr>
            @endforeach

            </tbody>
            <tfoot>
            <tr>
                <th colspan="9" style="text-align: right;">Grand Total</th>
                <th>
                    {{ currency($grandTotal) }}
                </th>
                <th></th>
            </tr>
            </tfoot>
        </table>

</body>
</html>