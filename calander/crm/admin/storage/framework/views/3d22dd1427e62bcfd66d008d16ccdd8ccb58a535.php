<?php $i = 1; ?>
<?php foreach($orders as $k => $order): ?>
    <tr class="deleteBox">
        <td>RE-<?php echo e($order->id); ?></td>
        <td>
            <a href="<?php echo e(sysRoute('orders.show', encryptIt($order->id))); ?>"><?php echo e($order->OID); ?></a>
        </td>
        <td>
            <?php echo e($order->createdDate('d/m/Y')); ?>

        </td>

        <?php if(!auth()->user()->isCustomer()): ?>
            <td>
                <?php echo e($order->creator->fullName()); ?>

                <?php if($order->creator->parent): ?>
                    ( <?php echo e($order->creator->parent->fullName()); ?> )
                <?php endif; ?>
            </td>
        <?php endif; ?>

        <td><?php echo e(@currency($order->getRefundAmount())); ?></td>
        <td><?php echo e($order->refundItems->count()); ?></td>
        <td>
            <?php echo @\App\Modules\Orders\Order::$refundTypeLabel[$order->refund_type]; ?>

        </td>
        <td>
            <?php echo @\App\Modules\Orders\Order::$refundStatusLabel[$order->refund_status]; ?>

        </td>
        <td>
            <?php if($order->credit_note != ''): ?>
                <?php echo e($order->credit_note); ?>

            <?php endif; ?>
        </td>
        <td>
            <?php if($order->credit_note == '' && auth()->user()->isAdmin()): ?>
                <a class="actionBtn" data-toggle="modal" data-target=".actionModal"
                   data-id="<?php echo e($order->id); ?>"><i class="icon-cog4"></i>
                </a>
            <?php endif; ?>
            <?php if($order->isRefundApproved()): ?>
                    <a title="Print" href="<?php echo e(sysUrl('orders/download-refund/'.encryptIt($order->id))); ?>">
                        <i class="icon-download"></i>
                    </a>
            <?php endif; ?>
        </td>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>