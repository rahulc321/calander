<?php $i = 1; ?>
@foreach($creditNotes as $k => $creditNote)
    <tr class="deleteBox">
        <td>{{ $k + 1 }}</td>
        <td>
            <a href="{{ sysRoute('creditnotes.show', encryptIt($creditNote->id)) }}">{{ $creditNote->user? $creditNote->user->fullName() : ''}}</a>
        </td>
        <td>
            {{ $creditNote->note }}
        </td>
        <td>{{ $creditNote->createdDate('d/m/Y') }}</td>
        <td>{{ @currency($creditNote->getTotalPrice()) }}</td>
        <td>{{ currency($creditNote->paid) }}</td>
        <td>
            {!! @\App\Modules\Creditnotes\Creditnote::$statusLabel[$creditNote->status] !!}
            @if($creditNote->isDeclined())
                <br>
                <strong>Reason:</strong><br>
                {{ $creditNote->status_text }}
            @endif

            @if($creditNote->isApproved())
                <br>
                <strong>Payment Type: </strong>{!! \App\Modules\CreditNotes\CreditNote::$paymentLabel[$creditNote->payment_type] !!}
            @endif
        </td>
        <td align="center">
            @if($creditNote->isPending())
                <a title="Edit" href="{{ sysRoute('creditnotes.edit', encryptIt($creditNote->id)) }}">
                    <i class="icon-pencil4"></i>
                </a>
                <a title="Delete"
                   href="#"
                   class="ajaxdelete"
                   data-id="<?php echo $creditNote->id; ?>"
                   data-url="<?php echo sysUrl('creditnotes/delete/' . encrypt($creditNote->id)); ?>"
                   data-token="<?php echo urlencode(md5($creditNote->id)); ?>"><i class="icon-remove2"></i>
            @endif
            <a title="Print" href="{{ sysUrl('creditnotes/download/'.encryptIt($creditNote->id)) }}">
                <i class="icon-download"></i>
            </a>

        </td>
    </tr>
    <?php $i++; ?>
@endforeach