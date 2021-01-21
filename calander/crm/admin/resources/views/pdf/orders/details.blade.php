@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <br/> <br/>
    @if($order->creator)
        <table width="98%" cellspacing="0" cellpadding="4" border="0">
            <tr>
                <td width="70%">
                    @if($order->creator->parent)
                        Moretti Milano <br/>
                        Lille Kongensgade 14, 1 sal <br/>
                        1074 Copenhagen K <br/>
                        Denmark <br/>
                        <br/>
                        VAT nr: 32048366 <br/>
                        Phone: +4522323640 <br/>
                        Bank: Jyske Bank: 7851 1265999 <br/>
                        IBAN : DK5378510001265999 <br/>
                        SWIFT: JYBADKKK <br/>
                        E-mail: info@morettimilano.com <br/>
                        Webside: www.morettimilano.com <br/>
                    @endif
                </td>
                <td width="30%" valign="middle" align="left">
                    @if(@$order->creator)
                        {{ @$order->creator->fullName() }} <br>
                        {{ @$order->creator->address }} <br>
                        {{ @$order->creator->zipcode }} {{ @$order->creator->city }} <br/>
                        {{ @$order->creator->country }} <br/>
                        <br/>
                        Phone: {{ @$order->creator->phone }} <br>
                        VAT nr: {{ @$order->creator->vat_number }}
                        E-mail: {{ @$order->creator->email }} <br>
                    @endif

                    Order Date: {{ $order->createdDate('d/m/Y') }}
                    @if($order->hasExpectedShippingDate())
                        <br>
                        <strong>Expected Shipping Date : </strong>
                        {{ $order->expected_shipping_date->format("d/m/Y") }}
                    @endif
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
                <th>Qty</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0; ?>

            @foreach($items as $k => $item)
                <tr>
                    <td>{{ $k + 1 }} </td>
                    <td>{{ @$item->product->name }}</td>
                    <td>{{@$item->variant->color->name }}&nbsp;&nbsp;@if($item->note!='')Note:{{$item->note}}@else
                                @endif</td>
                    <td align="right"> {{ $item->qty }} </td>
                    <td align="right"> {{ $order->getInCurrency($item->price) }} </td>
                    <td align="right"> {{ $item->discount }} %</td>
                    <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                    <td align="right">{{ $order->getInCurrency($total) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <th colspan="6" style="text-align: right;">Total</th>
                <th align="right">
                    {{ $order->getInCurrency($grandTotal) }}
                </th>
            </tr>
            @if($order->tax_percent > 0)
                <?php
                $taxPercent = $order->tax_percent;
                ?>
                <tr>
                    <th colspan="6" style="text-align: right;">Tax</th>
                    <th align="right">
                        {{ $taxPercent }}% ({{ currency(($grandTotal * ($taxPercent / 100))) }})
                    </th>
                </tr>
                <?php
                $grandTotal += ($grandTotal * ($taxPercent / 100));
                ?>
            @endif

            @if($order->toRefund)
                <?php $refund = $order->toRefund->getRefundAmount();
                $grandTotal -= $refund;
                ?>
                <tr>
                    <th colspan="6" style="text-align: right;">Refund Deduction</th>
                    <th align="right">
                        {{ $order->getInCurrency($refund) }}
                    </th>
                </tr>
            @endif
            <tr>
                <th colspan="6" style="text-align: right;">Shipping Price</th>
                <th align="right">
                    {{ $order->getInCurrency($order->shipping_price) }}
                </th>
            </tr>
            @if($order->getCreditNoteAmount() > 0)
                <tr>
                    <th colspan="6" style="text-align: right;">Kreditnota</th>
                    <th align="right">{{ currency($order->getCreditNoteAmount()) }}</th>
                </tr>
            @endif
            <tr>
                <th colspan="6" style="text-align: right;">Grand Total</th>
                <th align="right">
                    {{ currency($order->getTotalPrice() - $order->getCreditNoteAmount()) }}
                </th>
            </tr>
            </tfoot>
        </table>

    @else
        <h3>INVALID ORDER</h3>
    @endif

@stop
