<?php $__env->startSection('body'); ?>

    <div style="text-align: center">
        <span style="font-size:35px;font-weight:bold;">MORETTI MILANO</span>
    </div>

    <table width="98%" cellspacing="0" cellpadding="4" border="0">
        <tr>
            <td width="70%">
                ORDER#: <?php echo e($factoryOrder->OID); ?> <br/>
                Order Date: <?php echo e($factoryOrder->createdDate('d/m/Y')); ?> <br/>
                Factory: <?php echo e($factoryOrder->factory_name); ?>

            </td>
            <td width="30%" style="font-size:20px;font-weight: bold;" align="right">
                <?php echo @\App\Modules\FactoryOrders\FactoryOrder::$statusLabel[@$factoryOrder->status]; ?>

            </td>
        </tr>
    </table>

    <br/><br/>

    <table width="98%" cellspacing="0" cellpadding="4" border="1">
        <thead>
        <tr>
            <th>SN</th>
            <th>Product Name</th>
            <th>Color</th>
            <th>SKU</th>
            <th>Size</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php $items = $factoryOrder->items()->with('product.photos')->get(); $grandTotal = 0; ?>

        <?php foreach($items as $k => $item): ?>
            <tr class="deleteBox">
                <td> <?php echo e($k + 1); ?> </td>
                <td><?php echo e(@$item->product->name); ?></td>
                <td><?php echo e(@$item->variant->color->name); ?></td>
                <td><?php echo e(@$item->variant->sku); ?></td>
                <td><?php echo e(@$item->product->length); ?> X <?php echo e(@$item->product->height); ?></td>
                <td align="right"> <?php echo e($item->qty); ?> </td>
                <td align="right"> <?php echo e(currency($item->price)); ?> </td>
                <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                <td align="right"><?php echo e(currency($total)); ?></td>
            </tr>

        <?php endforeach; ?>

        </tbody>
        <tfoot>
        <tr>
            <th colspan="6" style="text-align: right;">Total</th>
            <th align="right">
                <?php echo e(currency($grandTotal)); ?>

            </th>
        </tr>

        <tr>
            <th colspan="6" style="text-align: right;">Grand Total</th>
            <th align="right">
                <?php echo e(currency($grandTotal)); ?>

            </th>
        </tr>
        </tfoot>
    </table>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pdf.viewbase', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>