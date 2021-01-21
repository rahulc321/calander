<?php $i = 1; ?>
<?php foreach($factoryOrders as $k => $order): ?>
    <tr class="deleteBox">
        <td><?php echo e($k + 1); ?></td>
        <td>
            <a href="<?php echo e(sysRoute('factoryorders.show', encryptIt($order->id))); ?>"><?php echo e($order->OID); ?></a>
        </td>
        <td>
            Ordered Qty: <?php echo e($order->totalOrderedQuantity()); ?><br>
            Received Qty: <?php echo e($order->totalReceivedQuantity()); ?><br>
        </td>
        <td><?php echo e($order->factory_name); ?></td>
        <td>
            <?php echo e(date("d/m/Y", strtotime(@$order->delivery_date))); ?>

        </td>
        <td><?php echo e($order->createdDate('d/m/Y')); ?></td>
        <td><?php echo e(@currency($order->price)); ?></td>
        <td>
            <?php echo @\App\Modules\FactoryOrders\FactoryOrder::$statusLabel[$order->status]; ?>

            <?php if($order->isDue()): ?>
                <br>
                <?php echo e(@DateDiff($order->due_date, date("Y-m-d"))->days); ?> days
            <?php endif; ?>
        </td>
        <td align="center">
            <a title="Print" href="<?php echo e(sysUrl('factoryorders/download/'.encryptIt($order->id))); ?>">
                <i class="icon-download"></i>
            </a>
        </td>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>