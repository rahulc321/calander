<?php $i = 1; ?>
<?php foreach($invoices as $k => $invoice): ?>
    <tr class="deleteBox">
        <td><?php echo e($k + 1); ?></td>
        <td><?php echo e($invoice->IID); ?></td>
        <td><?php echo e(@$invoice->order->creator? $invoice->order->creator->fullName() : ''); ?>


            <?php if(auth()->user()->isAdmin() && $invoice->order->salesPerson): ?>
                <br>
                <strong>Sales Person</strong><br>
                <?php echo e($invoice->order->salesPerson->fullName()); ?>

            <?php endif; ?>
        </td>
        <td>
            <?php echo e($invoice->createdDate('d/m/Y')); ?>

        </td>
        <td>
            <?php echo e(date("d/m/Y", strtotime(@$invoice->order->due_date))); ?>

        </td>

        <td>
            <?php echo @\App\Modules\Invoices\Invoice::$commissionStatusLabel[$invoice->commission_status]; ?>

        </td>
        <td><?php echo e(currency(@$invoice->order ? $invoice->order->getTotalWithoutShipping()  : 0)); ?></td>

        <td>
            <?php if($invoice->order->salesPerson): ?>
                <?php echo e(currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0))); ?>

            <?php else: ?>
                0
            <?php endif; ?>
        </td>

        <?php if(auth()->user()->isAdmin()): ?>
            <td>
                <select class="toggleStatus"
                        data-url="<?php echo e(sysUrl('invoices/toggle-commission-status/'.encryptIt($invoice->id))); ?>">
                    <?php foreach(\App\Modules\Invoices\Invoice::GetCommissionStatusAsArray() as $k => $status): ?>
                        <option value="<?php echo e($k); ?>"
                                <?php echo isSelected($k, $invoice->commission_status); ?>><?php echo e($status); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        <?php endif; ?>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>