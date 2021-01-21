<?php $i = 1;?>
@foreach($invoices as $k => $invoice)

    <tr>
        <td>{{ $k + 1  }}</td>
        <td>
            <a href="{{ sysRoute('orders.show', encryptIt(@$invoice->order->id)) }}">{{ $invoice->IID }}</a>
        </td>
        <td>{{ @$invoice->order->creator? $invoice->order->creator->fullName() : '' }}</td>
        <td>{{ $invoice->createdDate('d/m/Y') }}</td>
        <td>{{ date("d/m/Y", strtotime(@$invoice->order->due_date)) }}</td>
        <td>
            @if(strtotime(date("Y-m-d")) > strtotime($invoice->order->due_date) && $invoice->status == '2')
                <span class="label label-danger">DUE</span>
            @endif
        </td>
        <td>{!! @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status] !!}</td>
        <td align="right">{{ currency(@$invoice->order ? $invoice->order->getTotalPrice()  : 0) }}</td>
        @if(auth()->user()->isSales() OR auth()->user()->isAdmin())
            <td>
                {{ @currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0)) }}
            </td>
        @endif
        @if(auth()->user()->isAdmin())
            <td>
                <select class="toggleStatus"
                        data-url="{{ sysUrl('invoices/toggle-status/'.encryptIt($invoice->id)) }}">
                    @foreach(\App\Modules\Invoices\Invoice::GetStatusAsArray() as $k => $status)
                        <option value="{{ $k }}"
                                {!! isSelected($k, $invoice->status) !!}>{{ $status }}</option>
                    @endforeach
                </select>
            </td>
        @endif

        <td>
            <a title="Download Invoice"
               href="{{ sysUrl('invoices/download/'.encryptIt($invoice->id)) }}">
                <i class="icon-download"></i>
            </a>
        </td>

    </tr>
    <?php $i++; ?>
@endforeach