<?php $i = 1;
?>
<?php foreach($invoices as $k => $invoice): ?>
<?php if(@$_GET['status']=='due'){ 
        if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2'){

      
        ?>
    <tr>
        <td><?php echo e($k + 1); ?></td>
        <td>
            <a href="<?php echo e(sysRoute('orders.show', encryptIt(@$invoice->order->id))); ?>"><?php echo e($invoice->IID); ?></a>
        </td>
        <td><?php echo e(@$invoice->order->creator? $invoice->order->creator->fullName() : ''); ?></td>
        <td><?php echo e(@$invoice->createdDate('d/m/Y')); ?></td>
        <td><?php echo e(date("d/m/Y", strtotime(@$invoice->order->due_date))); ?></td>
        <td>
            <?php if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2'): ?>
                <span class="label label-danger">DUE</span>
            <?php endif; ?>
        </td>
        <td><?php echo @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status]; ?></td>
        <td align="right"><?php echo e(currency(@$invoice->order ? $invoice->order->getTotalPrice()  : 0)); ?></td>
        <?php if(auth()->user()->isSales() OR auth()->user()->isAdmin()): ?>
            <td>
                <?php echo e(@currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0))); ?>

            </td>
        <?php endif; ?>
        <?php if(auth()->user()->isAdmin()): ?>
            <td>
                <select class="toggleStatus"
                        data-url="<?php echo e(sysUrl('invoices/toggle-status/'.encryptIt($invoice->id))); ?>">
                    <?php foreach(\App\Modules\Invoices\Invoice::GetStatusAsArray() as $k => $status): ?>
                        <option value="<?php echo e($k); ?>"
                                <?php echo isSelected($k, $invoice->status); ?>><?php echo e($status); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        <?php endif; ?>

        <td>
            <a title="Download Invoice"
               href="<?php echo e(sysUrl('invoices/download/'.encryptIt($invoice->id))); ?>">
                <i class="icon-download"></i>
            </a>
        </td>

    </tr>
<?php }
}else{ ?>

    <tr>
        <td><?php echo e($k + 1); ?></td>
        <td>
            <a href="<?php echo e(sysRoute('orders.show', encryptIt(@$invoice->order->id))); ?>"><?php echo e($invoice->IID); ?></a>
        </td>
        <td><?php echo e(@$invoice->order->creator? $invoice->order->creator->fullName() : ''); ?></td>
        <td><?php echo e(@$invoice->createdDate('d/m/Y')); ?></td>
        <td><?php echo e(date("d/m/Y", strtotime(@$invoice->order->due_date))); ?></td>
        <td>
            <?php if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2'): ?>
                <span class="label label-danger">DUE</span>
            <?php endif; ?>
        </td>
        <td><?php echo @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status]; ?></td>
        <td align="right"><?php echo e(currency(@$invoice->order ? $invoice->order->getTotalPrice()  : 0)); ?></td>
        <?php if(auth()->user()->isSales() OR auth()->user()->isAdmin()): ?>
            <td>
                <?php echo e(@currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0))); ?>

            </td>
        <?php endif; ?>
        <?php if(auth()->user()->isAdmin()): ?>
            <td>
                <select class="toggleStatus"
                        data-url="<?php echo e(sysUrl('invoices/toggle-status/'.encryptIt($invoice->id))); ?>">
                    <?php foreach(\App\Modules\Invoices\Invoice::GetStatusAsArray() as $k => $status): ?>
                        <option value="<?php echo e($k); ?>"
                                <?php echo isSelected($k, $invoice->status); ?>><?php echo e($status); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        <?php endif; ?>

        <td>
            <a title="Download Invoice"
               href="<?php echo e(sysUrl('invoices/download/'.encryptIt($invoice->id))); ?>">
                <i class="icon-download"></i>
            </a>
        </td>

    </tr>

<?php }


?>
    <?php $i++; ?>
<?php endforeach; ?>