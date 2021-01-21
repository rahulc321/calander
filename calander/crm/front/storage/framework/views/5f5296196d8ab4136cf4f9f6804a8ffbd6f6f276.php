<?php if($creditNote->isPending()): ?>
    <a class="btn btn-danger" data-toggle="modal" data-target=".declineModal">Decline</a>
    <a class="btn btn-success" href="<?php echo e(sysUrl('creditnotes/approve/'.encryptIt($creditNote->id))); ?>">Approve</a>
<?php endif; ?>

<?php if($creditNote->isApproved()): ?>
    <?php if($creditNote->payment_type == \App\Modules\CreditNotes\CreditNote::PAYMENT_TYPE_BANK): ?>
        <a class="btn btn-success" href="<?php echo e(sysUrl('creditnotes/pay/'.encryptIt($creditNote->id))); ?>">Mark As Paid</a>
        <br>
    <?php endif; ?>
    <label>Update Payment Type:</label>
    <select class="form-control paymentToggle lazySelector"
            data-selected="<?php echo e($creditNote->payment_type); ?>"
            data-url="<?php echo e(sysUrl('creditnotes/change-payment-type/'.encryptIt($creditNote->id))); ?>">
        <?php foreach(\App\Modules\CreditNotes\CreditNote::$paymentLabel as $k => $label): ?>
            <option value="<?php echo e($k); ?>"><?php echo e($label); ?></option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>