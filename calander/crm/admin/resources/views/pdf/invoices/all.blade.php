@extends('pdf.viewbase')
@section('body')

    <div style="text-align: center">
        <span style="font-size:30px;font-weight:bold;">MORETTI MILANO</span>
    </div>
    <h4 style="text-align: center">INVOICES</h4>
    <table width="98%" cellspacing="0" cellpadding="4" border="1">
        <tr>
            <td>SN</td>
            <td>Invoice ID</td>
            <td>Issued To</td>
            <td>Issue Date</td>
            <td>Due Date</td>
            <td>Status</td>
            <td>Total Amount</td>
            @if(auth()->user()->isSales())
                <td>Commission</td>
            @endif
        </tr>

        <?php $i = 1; ?>
        @foreach($invoices as $k => $invoice)
        <?php
        //echo '<pre>';print_r($invoice->order['price']);
        $orderPrice= $invoice->order['price'];
        $tax =$invoice->order['tax_percent'];
        $shipping_price =$invoice->order['shipping_price'];

        $actTax= ($orderPrice*$tax)/100;

        $actPrice= $orderPrice+$actTax+$shipping_price;
        ?>
            <tr>
                <td>{{ $k + 1  }}</td>
                <td><strong>{{ $invoice->IID }}</strong></td>
                <td>{{ @$invoice->order->creator? $invoice->order->creator->fullName() : '' }}</td>
                <td>{{ $invoice->createdDate('d/m/Y') }}</td>
                <td>{{ date("d/m/Y", strtotime(@$invoice->order->due_date)) }}</td>
                <td>{!! @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status] !!}</td>
                <td align="right">{{ currency(@$actPrice) }}</td>
                @if(auth()->user()->isSales())
                    <td align="right">
                        {{ currency(percentOf(auth()->user()->commission, @$invoice->order->price)) }}
                    </td>
                @endif
            </tr>
            <?php $i++; ?>
        @endforeach
        <tbody>
        </tbody>
    </table>

@stop
