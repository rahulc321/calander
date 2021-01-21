<?php $i = 1; ?>
<?php foreach($creditNotes as $k => $creditNote): ?>
    <tr class="deleteBox">
        <td><?php echo e($k + 1); ?></td>
        <td>
            <a href="<?php echo e(sysRoute('creditnotes.show', encryptIt($creditNote->id))); ?>"><?php echo e($creditNote->user? $creditNote->user->fullName() : ''); ?></a>
        </td>
        <td>
            <?php echo e($creditNote->note); ?>

        </td>
        <td><?php echo e($creditNote->createdDate('d/m/Y')); ?></td>
        <td><?php echo e(@currency($creditNote->getTotalPrice())); ?></td>
        <td><?php echo e(currency($creditNote->paid)); ?></td>
        <td>
            <?php echo @\App\Modules\Creditnotes\Creditnote::$statusLabel[$creditNote->status]; ?>

            <?php if($creditNote->isDeclined()): ?>
                <br>
                <strong>Reason:</strong><br>
                <?php echo e($creditNote->status_text); ?>

            <?php endif; ?>

            <?php if($creditNote->isApproved()): ?>
                <br>
                <strong>Payment Type: </strong><?php echo \App\Modules\CreditNotes\CreditNote::$paymentLabel[$creditNote->payment_type]; ?>

            <?php endif; ?>
        </td>
        <td align="center">
            <?php if($creditNote->isPending()): ?>
                <a title="Edit" href="<?php echo e(sysRoute('creditnotes.edit', encryptIt($creditNote->id))); ?>">
                    <i class="icon-pencil4"></i>
                </a>
                <a title="Delete"
                   href="#"
                   class="ajaxdelete"
                   data-id="<?php echo $creditNote->id; ?>"
                   data-url="<?php echo sysUrl('creditnotes/delete/' . encrypt($creditNote->id)); ?>"
                   data-token="<?php echo urlencode(md5($creditNote->id)); ?>"><i class="icon-remove2"></i>
            <?php endif; ?>
            <a title="Print" href="<?php echo e(sysUrl('creditnotes/download/'.encryptIt($creditNote->id))); ?>">
                <i class="icon-download"></i>
            </a>

        </td>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>