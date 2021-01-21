@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <br/><br/>

    <table width="98%" cellspacing="0" cellpadding="4" border="0">
        <tr>
            <td width="50%" align="left" valign="top">
                Customer: {{ $creditNote->user->fullName() }} <br/>
                Debitornr.: {{ $creditNote->user->debitor_number }}
                <br/>

                {{ @$creditNote->user->address }}  <br/>
                {{ @$creditNote->user->zipcode }} {{ @$creditNote->user->city }} <br/>
                {{ @$creditNote->user->country }} <br/><br/>

                Status: {!! @\App\Modules\CreditNotes\CreditNote::$statusLabel[$creditNote->status] !!} <br/>
                @if($creditNote->isDeclined())
                    <strong>Reason: </strong> {{ $creditNote->status_text }}<br>
                @endif
                @if($creditNote->isApproved() || $creditNote->isPaid())
                    <strong>Payment Type: </strong> {!! \App\Modules\CreditNotes\CreditNote::$paymentLabel[$creditNote->payment_type] !!}
                    <br>
                @endif

            </td>

            <td width="50%" width="50%" align="left" valign="top">

                Lille Kongensgade 14, 1.sal <br/>
                1074 København K  <br/>
                Danmark  <br/>
                <br/>
                Kreditnotanr.:  {{ @$creditNote->id }} <br/>
                Kreditnotadato: {{ $creditNote->createdDate() }}  <br/>

                CVR-nr.: 32048366 <br/>
                Telefon: +4522323640 <br/>
                Bank: Jyske Bank : 7851 1265999 <br/>
                Giro: SWIFT: JYBADKKK <br/>
                Kreditornr.: IBAN: DK5378510001265999 <br/>
                E-mail: info@morettimilano.com <br/>
                Webside: www.morettimilano.com <br/>
            </td>

        </tr>
    </table>

    <br/>

    <h4>Kreditnota</h4>
    <table width="98%" cellspacing="0" cellpadding="4" border="1">
        <thead>
        <tr>
            <th>SN</th>
            <th>Name</th>
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
                    {{ @$item->product->name }}
                </td>
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
            @if($creditNote->tax_percent > 0)
                    <?php
                    $taxPercent = $creditNote->tax_percent;
                    ?>
                    <tr>
                        <th colspan="5" style="text-align: right;">Tax</th>
                        <th>
                            {{ $taxPercent }}% ({{ currency(($grandTotal * ($taxPercent / 100))) }})
                        </th>
                        
                    </tr>
                    <?php
                    $grandTotal += ($grandTotal * ($taxPercent / 100));
                    ?>
                @endif
                <tr>
                    <th colspan="5" style="text-align: right;">Grand Total</th>
                    <th>
                        {{ currency($grandTotal) }}
                    </th>
                </tr>
        
        </tfoot>
    </table>

@stop
