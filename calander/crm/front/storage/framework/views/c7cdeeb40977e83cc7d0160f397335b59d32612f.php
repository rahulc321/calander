<?php $__env->startSection('body'); ?>

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
            <?php if(auth()->user()->isSales()): ?>
                <td>Commission</td>
            <?php endif; ?>
        </tr>

        <?php $i = 1; ?>
        <?php foreach($invoices as $k => $invoice): ?>
            <tr>
                <td><?php echo e($k + 1); ?></td>
                <td><strong><?php echo e($invoice->IID); ?></strong></td>
                <td><?php echo e(@$invoice->order->creator? $invoice->order->creator->fullName() : ''); ?></td>
                <td><?php echo e($invoice->createdDate('d/m/Y')); ?></td>
                <td><?php echo e(date("d/m/Y", strtotime(@$invoice->order->due_date))); ?></td>
                <td><?php echo @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status]; ?></td>
                <td align="right"><?php echo e(currency(@$invoice->order->price)); ?></td>
                <?php if(auth()->user()->isSales()): ?>
                    <td align="right">
                        <?php echo e(currency(percentOf(auth()->user()->commission, @$invoice->order->price))); ?>

                    </td>
                <?php endif; ?>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
        <tbody>
        </tbody>
    </table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pdf.viewbase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>