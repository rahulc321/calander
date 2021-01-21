<?php $i = 1; ?>
@foreach($invoices as $k => $invoice)
    <tr class="deleteBox">
        <td>{{ $k + 1  }}</td>
        <td>{{ $invoice->IID }}</td>
        <td>{{ @$invoice->order->creator? $invoice->order->creator->fullName() : '' }}

            @if(auth()->user()->isAdmin() && $invoice->order->salesPerson)
                <br>
                <strong>Sales Person</strong><br>
                {{ $invoice->order->salesPerson->fullName() }}
            @endif
        </td>
        <td>
            {{ $invoice->createdDate('d/m/Y') }}
        </td>
        <td>
            {{ date("d/m/Y", strtotime(@$invoice->order->due_date)) }}
        </td>

        <td>
            {!! @\App\Modules\Invoices\Invoice::$commissionStatusLabel[$invoice->commission_status] !!}
        </td>
        <td>{{ currency(@$invoice->order ? $invoice->order->getTotalWithoutShipping()  : 0) }}</td>

        <td>
            @if($invoice->order->salesPerson)
                {{ currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0)) }}
            @else
                0
            @endif
        </td>

        @if(auth()->user()->isAdmin())
            <td>
                <select class="toggleStatus"
                        data-url="{{ sysUrl('invoices/toggle-commission-status/'.encryptIt($invoice->id)) }}">
                    @foreach(\App\Modules\Invoices\Invoice::GetCommissionStatusAsArray() as $k => $status)
                        <option value="{{ $k }}"
                                {!! isSelected($k, $invoice->commission_status) !!}>{{ $status }}</option>
                    @endforeach
                </select>
            </td>
        @endif
    </tr>
    <?php $i++; ?>
@endforeach