@extends('pdf.viewbase')
@section('body')

    <?php $order = $invoice->order; ?>

    <div style="text-align: center">
        <span style="font-size:30px;font-weight:bold;">MORETTI MILANO</span>
        <br/>
        <span style="font-size:20px;font-weight:bold;">INVOICE</span>
    </div>

    <br/><br/>

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
                    Website: www.morettimilano.com <br/>
                @endif

            </td>
            <td width="30%" valign="middle" align="left">
                @if(@$order->creator)
                    {{ @$order->creator->fullName() }}&nbsp;(CID: {{ @$order->creator->debitor_number }})<br>
                    {{ @$order->creator->address }} <br>
                    {{ @$order->creator->zipcode }} {{ @$order->creator->city }} <br/>
                    {{ @$order->creator->country }} <br/>
                    <br/>
                    Phone: {{ @$order->creator->phone }} <br>
                    VAT nr: {{ @$order->creator->vat_number }} <br>
                    E-mail: {{ @$order->creator->email }}
                @endif

                @if($order->invoice)
                        Invoice nr#: {{ @$order->invoice->IID }} <br/>
                        Invoice Date: {{ date("d/m/Y", strtotime(@$order->invoice->issue_date)) }} <br/>
                        Due Date:  {{ date("d/m/Y", strtotime(@$order->due_date)) }}
                @endif
            </td>
        </tr>
    </table>

    <br/> <br/>

    <table width="96%" cellspacing="0" cellpadding="4" border="1">
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
                        <td>
                            {{ $k + 1 }}
                        </td>
                        <td>{{ @$item->product->name }}</td>
                        <td>{{@$item->variant->color->name }}</td>
                        <td align="right"> {{ $item->qty }}</td>
                        <td align="right"> {{ currency($item->price) }} </td>
                        <td align="right"> {{ $item->discount }}</td>
                        <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal+=$total; ?>
                        <td align="right">{{ currency($total) }}</td>
                    </tr>

                @endforeach

                </tbody>
                <tfoot>
                <tr>
                    <th colspan="6" style="text-align: right;">Total</th>
                    <th align="right">
                        {{ Currency($grandTotal) }}
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
                <tr>
                    <th colspan="6" style="text-align: right;">Shipping Price</th>
                    <th align="right">
                        <!--{{ $order->getInCurrency($order->shipping_price) }}-->
                       {{ currency($order->shipping_price) }}
                    </th>
                </tr>
                @if($order->getCreditNoteAmount() > 0)
                    <tr>
                        <th colspan="6" style="text-align: right;">Credit Note Amount</th>
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
   <!-- *Please make payment in DKK(Danish Krone) If currency mentioned on Invoice is KR.-->
@stop
