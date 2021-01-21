<form class="form-inline" method="post" action="">
    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-responsive deleteArena">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>SKU</th>
                    <th>Color</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0;?>
                <?php foreach($items as $k => $item): ?>
                    <tr class="deleteBox">
                        <td>
                            <label class="checkbox-inline checkbox-success">
                                <input type="checkbox" class="styled" name="ids[<?php echo e($item->id); ?>]"
                                       value="<?php echo e($item->id); ?>">
                            </label>
                        </td>
                        <td>
                            <img src="<?php echo e($item->product->getThumbUrl()); ?>">
                        </td>
                        <td><?php echo e(@$item->product->name); ?></td>
                        <td><?php echo e(@$item->variant->sku); ?></td>
                        <td><?php echo e(@$item->variant->color->name); ?></td>

                        <td width="55">
                            <input class="form-control" name="qty[<?php echo e($item->id); ?>]"
                                   value="<?php echo e($item->qty); ?>" pattern="[0-9]+">
                        </td>
                        <td>
                            <?php echo e(currency($item->price)); ?>

                        </td>
                        <?php $total = $item->price * $item->qty; $grandTotal += $total; ?>
                        <td><?php echo e(currency($total)); ?></td>
                        <td>
                            <a title="Delete Item"
                               href="<?php echo sysUrl('orders/delete-cart-item/' . encrypt($item->id)); ?>"
                               class="delete"
                               data-id="<?php echo $item->id; ?>"
                               data-token="<?php echo urlencode(md5($item->id)); ?>"><i class="icon-remove4"></i></a>
                        </td>
                    </tr>

                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7" style="text-align: right;">Total</th>
                    <th>
                        <?php echo e(currency($grandTotal)); ?>

                    </th>
                    <th></th>
                </tr>
                
                <tr>
                    <th colspan="7" style="text-align: right;">Wallet Amount</th>
                    <th>
                       <?php echo e(currency($grandTotal)); ?>

                    </th>
                    <th></th>
                </tr>
                
                <tr>
                    <th colspan="7" style="text-align: right;">Grand Total</th>
                    <th>
                         <?php echo e(currency($grandTotal)); ?>

                    </th>
                    <th></th>
                </tr>

                <tr>
                    <td colspan="10">
                        <input type="submit" class="btn btn-warning btn-sm" name="save" value="Update">
                        <?php if(auth()->user()->isCustomer()): ?>
                            <a class="btn btn-warning btn-sm" href="<?php echo e(sysUrl('orders/place/xl')); ?>">Place Order</a>
                        <?php else: ?>
                            <a class="btn btn-warning btn-sm" data-toggle="modal" data-target=".placeForDealerModal"
                               href="#">Place Order For</a>
                        <?php endif; ?>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <a class="btn btn-warning btn-sm" data-toggle="modal" data-target=".replaceModal"
                               href="#">Add To Previous Order</a>
                        <?php endif; ?>
                        <a href="<?php echo e(sysRoute('orders.create')); ?>" class="btn btn-success pull-right btn-sm">Continue
                            Shopping</a>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</form>
