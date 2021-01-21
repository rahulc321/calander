<?php $i = 1; ?>
<?php foreach($orders as $k => $order): ?>
    <tr class="deleteBox">
        <td><?php echo e($k + 1); ?></td>
        <td><a href="<?php echo e(sysRoute('orders.show', encryptIt($order->id))); ?>"><?php echo e($order->OID); ?></a></td>
        <td><?php echo e($order->createdDate('d/m/Y')); ?></td>
        <td><?php echo e($order->due_date); ?></td>

        <td>
            <?php if($order->hasExpectedShippingDate()): ?>
                <?php echo e($order->expected_shipping_date->format("d/m/Y")); ?>

            <?php endif; ?>
        </td>

        <?php if(!auth()->user()->isCustomer()): ?>
            <td>
                <?php if($order->creator): ?>
                    <?php echo e($order->creator->fullName()); ?>

                    <?php if($order->creator->parent): ?>
                        ( <?php echo e($order->creator->parent->fullName()); ?> )
                    <?php endif; ?>
                <?php endif; ?>
            </td>
        <?php endif; ?>
        <td align="right"><?php echo e(@currency($order->getTotalPrice1())); ?></td>
        <td><?php echo e($order->items->sum('qty')); ?></td>
        <td>
            <?php echo @\App\Modules\Orders\Order::$statusLabel[$order->status]; ?>

            <?php if($order->isDeclined()): ?>
                <p>REASON:<?php echo e($order->remarks); ?></p>
            <?php endif; ?>

            <?php if($order->isDue()): ?>
                <br>
                <?php echo e(@DateDiff($order->due_date, date("Y-m-d"))->days); ?> days
            <?php endif; ?>
        </td>
        <td>
            <a title="Print" href="<?php echo e(sysUrl('orders/download/'.encryptIt($order->id))); ?>">
                <i class="icon-download"></i>
            </a>
            <?php if($order->isOrdered()): ?>
                <a title="Delete Order"
                   href="#"
                   class="ajaxdelete text-danger"
                   data-id="<?php echo $order->id; ?>"
                   data-url="<?php echo sysUrl('orders/delete/' . encrypt($order->id)); ?>"
                   data-token="<?php echo urlencode(md5($order->id)); ?>"><i class="icon-remove2"></i>
                </a>
            <?php endif; ?>
        </td>
    </tr>
    <?php $i++; ?>
<?php endforeach; ?>