@if($creditNote->isPending())
    <a class="btn btn-danger" data-toggle="modal" data-target=".declineModal">Decline</a>
    <a class="btn btn-success" href="{{ sysUrl('creditnotes/approve/'.encryptIt($creditNote->id)) }}">Approve</a>
@endif

@if($creditNote->isApproved())
    @if($creditNote->payment_type == \App\Modules\CreditNotes\CreditNote::PAYMENT_TYPE_BANK)
        <a class="btn btn-success" href="{{ sysUrl('creditnotes/pay/'.encryptIt($creditNote->id)) }}">Mark As Paid</a>
        <br>
    @endif
    <label>Update Payment Type:</label>
    <select class="form-control paymentToggle lazySelector"
            data-selected="{{ $creditNote->payment_type }}"
            data-url="{{ sysUrl('creditnotes/change-payment-type/'.encryptIt($creditNote->id)) }}">
        @foreach(\App\Modules\CreditNotes\CreditNote::$paymentLabel as $k => $label)
            <option value="{{ $k }}">{{ $label }}</option>
        @endforeach
    </select>
@endif