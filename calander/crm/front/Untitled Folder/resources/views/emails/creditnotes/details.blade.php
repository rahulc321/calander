<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>


<div style="text-align: center">
    <img src="{{ asset('assets/images/moretti-leather-bags-logo-1.png') }}" height="90">
    <br/>
   <!-- <small style="font-size:12px;">MORETTI MILANO</small>-->
</div>

<br/><br/>

<table width="96%" cellspacing="0" cellpadding="4" border="0">
    <tr>
        <td>
            Status: {!! @\App\Modules\CreditNotes\CreditNote::$statusLabel[$creditNote->status] !!} <br/>
            @if($creditNote->isDeclined())
                <strong>Reason : </strong> {{ $creditNote->status_text }}<br>
            @endif
            @if($creditNote->isApproved() || $creditNote->isPaid())
                <strong>Payment Type
                    : </strong> {!! \App\Modules\CreditNotes\CreditNote::$paymentLabel[$creditNote->payment_type] !!}
                <br>
            @endif
        </td>
        <td>
            Date: {{ $creditNote->createdDate() }} <br/>
            Customer: {{ $creditNote->user->fullName() }}
        </td>
    </tr>
</table>

<br/> <br/>

<p align="center">Order Details</p>

<table width="96%" cellspacing="0" cellpadding="4" border="1">
    <thead>
    <thead>
    <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Image</th>
        <th>Color</th>
        <th>Price</th>
        <th style="width:100px;">QTY</th>
        <th align="right">Total</th>
    </tr>
    </thead>
    <tbody>
    <?php $items = $creditNote->items()->with('product.photos')->get();
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
            <td>{{ $item->qty }}</td>

            <?php
            $total = $item->price * $item->qty;
            $grandTotal += $total; ?>
            <td>{{ currency($total) }}</td>

        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="5"></th>
        <th>
            {{ $creditNote->items->sum('qty') }}
        </th>
        <th></th>
    </tr>
    <tr>
        <th colspan="6" style="text-align: right;">Grand Total</th>
        <th>
            {{ currency($grandTotal) }}
        </th>
    </tr>
</table>

</body>
</html>