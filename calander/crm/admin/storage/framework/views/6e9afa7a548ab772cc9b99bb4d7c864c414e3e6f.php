<?php $__env->startSection('body'); ?>

    <div style="text-align: center">
        <span style="font-size:30px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <h4 style="text-align: center">ORDERS</h4>

    <table width="99%" cellspacing="0" cellpadding="4" border="1">
        <tr>
            <td>SN</td>
            <td>Order ID</td>
            <?php if(!auth()->user()->isCustomer()): ?>
                <td>Customer</td>
            <?php endif; ?>
            <td>Order Date</td>
            <td>Total Price</td>
            <td>Total Items</td>
            <td>Status</td>
        </tr>
        <tbody>
        <?php $i = 1; ?>
        <?php foreach($orders as $k => $order): ?>
            <tr>
                <td><?php echo e($k + 1); ?></td>
                <td>
                    <?php echo e($order->OID); ?>

                </td>
                <?php if(!auth()->user()->isCustomer()): ?>
                    <td>
                        <?php echo e($order->creator->fullName()); ?>

                        <?php if($order->creator->parent): ?>
                            ( <?php echo e($order->creator->parent->fullName()); ?> )
                        <?php endif; ?>
                    </td>
                <?php endif; ?>
                <td><?php echo e($order->createdDate('d/m/Y')); ?></td>
                <td><?php echo e(@currency($order->price)); ?></td>
                <td><?php echo e($order->items->count()); ?></td>
                <td>
                    <?php echo @\App\Modules\Orders\Order::$statusLabel[$order->status]; ?>

                    <?php if($order->isDeclined()): ?>
                        <p>REASON: <?php echo e($order->remarks); ?></p>
                    <?php endif; ?>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pdf.viewbase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>