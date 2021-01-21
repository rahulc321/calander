<?php $__env->startSection('title'); ?>
Factory Order
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Factory Order Details</h3>
        </div>
    </div>

    <div class="callout callout-success" style="margin: 0;">
        <small>
            Order ID: <?php echo e($factoryOrder->OID); ?> <br/>
            Order Date: <?php echo e($factoryOrder->createdDate('d/m/Y')); ?> <br/>
            Order Status: <?php echo @\App\Modules\FactoryOrders\FactoryOrder::$statusLabel[$factoryOrder->status]; ?> <br/>
            Factory: <?php echo e($factoryOrder->factory_name); ?>

        </small>
    </div>

    <div class="content">
        <form method="post" action="<?php echo e(sysUrl('factoryorders/ship/'.encryptIt($factoryOrder->id))); ?>">
            <input type="hidden" name="_method" value="put">
            <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <table class="table table-bordered table-responsive deleteArena">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Color</th>
                            <th>Price</th>
                            <th align="right">Total</th>
                            <th style="width:100px;">Ordered QTY</th>
                            <th style="width:100px;">Received QTY</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $items = $factoryOrder->items()->with('product.photos')->get();
                        $grandTotal = 0; ?>
                        <?php foreach($items as $k => $item): ?>
                            <tr class="deleteBox">
                                <td>
                                    <?php echo e($k + 1); ?>

                                </td>
                                <td>
                                    <?php echo e(@$item->product->name); ?> <br/>
                                    <?php echo e(@$item->variant->sku); ?>

                                </td>
                                <td><img src="<?php echo e($item->product->getThumbUrl()); ?>"></td>
                                <td>
                                    <?php echo e(@$item->variant->color->name); ?>

                                </td>
                                <td><?php echo e(currency($item->price)); ?></td>
                                <?php
                                if ($factoryOrder->isReceived()):
                                    $total = $item->price * $item->shipped_qty;
                                else:
                                    $total = $item->price * $item->qty;
                                endif;
                                $grandTotal += $total; ?>
                                <td><?php echo e(currency($total)); ?></td>
                                <td><?php echo e($item->qty); ?></td>
                                <td>
                                    <?php if(!$factoryOrder->isReceived()): ?>
                                        <input type="text" class="form-control" name="shipped_qty[<?php echo e($item->id); ?>]"
                                               value="<?php echo e($item->shipped_qty); ?>" max="<?php echo e($item->qty); ?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                                    <?php else: ?>
                                        <?php echo e($item->shipped_qty); ?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="6"></th>
                            <th >
                                <?php echo e($factoryOrder->items->sum('qty')); ?>

                            </th>
                            <th><?php echo e($factoryOrder->items->sum('shipped_qty')); ?></th>
                        </tr>
                        <tr>
                            <th colspan="5" style="text-align: right;">Grand Total</th>
                            <th>
                                <?php echo e(currency($grandTotal)); ?>

                            </th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td colspan="9">
                                <div class="btn-group pull-right">
                                    <?php echo $__env->make('webpanel.factoryorders.partials.admin-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
        </form>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('modals'); ?>
    <div class="modal fade declineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(sysUrl('factoryOrders/decline/'.encryptIt($factoryOrder->id))); ?>" method="post"
                      class="form-horizontal"
                      data-notification-area="#categoryNotification">
                    <div id="categoryNotification"></div>
                    <input type="hidden" name="_method" value="put">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">DECLINE FactoryOrder: <?php echo e($factoryOrder->OID); ?></h4>
                    </div>
                    <div class="modal-body">
                        <strong>FactoryOrder Date: </strong> <?php echo e($factoryOrder->createdDate()); ?><br>
                        <strong>Total Price: </strong> <?php echo e(@currency($factoryOrder->price)); ?><br>
                        <strong>Total Items: </strong> <?php echo e($factoryOrder->items->count()); ?><br>
                        <div class="panel-body">
                            <div class="form-group required">
                                <label class="" for="name">Reason</label>
                                <div class="">
                                    <textarea class="form-control" name="remarks" required></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Decline</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>