<?php $__env->startSection('title'); ?>
    Ship Order
    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Order Details</h3>
        </div>
    </div>

    <div class="callout callout-success" style="margin: 0; margin-bottom: 10px;">
        <p>
            <small>
                ORDER ID: <?php echo e($order->OID); ?> <br/>
                Order Status: <?php echo @\App\Modules\Orders\Order::$statusLabel[$order->status]; ?> <br/>
                Order Date: <?php echo e($order->createdDate('d/m/Y')); ?> <br/>
                Customer: <?php echo e($order->creator->fullName()); ?> <br/>
                Debtor number: <?php echo e($order->creator->debitor_number); ?>

            </small>
        </p>
        <?php if($order->isDeclined()): ?>
            <div class="callout callout-danger fade in">
                <h5>DECLINED at <?php echo e($order->declined_date); ?></h5>
                <p>REASON:<?php echo e($order->remarks); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <div class="content">
        <?php
        $action = sysUrl('orders/ship/' . encryptIt($order->id));
        if ($order->isShipped() /*&& auth()->user()->isCustomer()*/) {
            $action = sysUrl('orders/refund/' . encryptIt($order->id));
        }
        ?>

        <form method="post" action="<?php echo e($action); ?>" class="form-inline">
            <input type="hidden" name="_method" value="put">
            <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">Order Details</h6>
                </div>

                <table class="table table-responsive deleteArena">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>Product Name</th>
                        <th>Image</th>
                        <th>Color</th>
                        <th>Note</th>
                        <th style="width:100px;">Qty</th>
                        <th style="width:50px !important;">Discount(%)</th>
                        <th>Price</th>
                        <th align="right">Total</th>
                        <th style="width:100px;">Refund Qty</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $items = $order->items()->with('product.photos')->get(); $grandTotal = 0; ?>
                    <?php foreach($items as $k => $item): ?>
                        <tr class="deleteBox">
                            <td><?php echo e($k + 1); ?></td>
                            <td><?php echo e(@$item->product->name); ?></td>
                            <td><img src="<?php echo e($item->product->getThumbUrl()); ?>"></td>
                            <td><?php echo e(@$item->variant->color->name); ?></td>
                             <td>
                            <input type="text" class="form-control" name="note[<?php echo e(@$item->id); ?>]" value="<?php echo e(@$item->note); ?>" style="min-width: 75px;">
                            </td>
                            <td>
                                <?php if($order->isOrdered()): ?>
                                    <input type="number" class="form-control" name="shipped_qty[<?php echo e($item->id); ?>]"
                                           value="<?php echo e($item->qty); ?>" style="min-width: 75px;">
                                <?php else: ?>
                                    <?php echo e($item->qty); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($order->isOrdered()): ?>
                                    <input type="text" class="form-control" name="discount[<?php echo e($item->id); ?>]"
                                           value="<?php echo e($item->discount); ?>" style="width:50px !important;">
                                <?php else: ?>
                                    <?php echo e($item->discount); ?>

                                <?php endif; ?>
                            </td>
                            <td><?php echo e(currency($item->price)); ?></td>
                             
                            <?php $total = $item->getDiscountedPrice() * $item->qty; $grandTotal += $total; ?>
                            <td><?php echo e(currency($total)); ?></td>
                            <td>
                                <?php if($order->isShipped() && auth()->user()->isCustomer() && !$order->isRefundRequested()): ?>
                                    <input type="text" class="form-control" name="refund_qty[<?php echo e($item->id); ?>]"
                                           value="<?php echo e($item->refund_qty); ?>" max="<?php echo e($item->shipped_qty); ?>">
                                <?php else: ?>
                                    <?php echo e($item->refund_qty); ?>

                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(auth()->user()->isAdmin() && $order->isOrdered()): ?>
                                    <a href="<?php echo e(sysUrl('orders/delete-ordered-item/'.encryptIt($item->id).'/'.encryptIt($order->id))); ?>"><i
                                                class="icon-remove2"></i> </a>
                                <?php endif; ?>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="9">
                            <?php if(auth()->user()->isAdmin() && $order->isOrdered()): ?>
                                Expected Shipping Date:
                                <input type="text" class="form-control dp" name="expected_shipping_date"
                                       style="width:140px;"
                                       value="<?php echo e($order->expected_shipping_date ? date("d/m/Y", strtotime($order->expected_shipping_date)) : ''); ?>">
                                <input type="submit" value="Update" name="updateQty" class="btn btn-primary submit-btn">

                            <?php endif; ?>
                        </td>
                        
                    </tr>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="10" style="text-align: right;">Total</th>
                        <th><?php echo e(Currency($grandTotal)); ?></th>
                        <th></th>
                    </tr>
                    <?php if($order->tax_percent > 0): ?>
                        <?php
                        $taxPercent = $order->tax_percent;
                        ?>
                        <tr>
                            <th colspan="10" style="text-align: right;">Tax</th>
                            <th>
                                <?php echo e($taxPercent); ?>% (<?php echo e(currency(($grandTotal * ($taxPercent / 100)))); ?>)
                            </th>
                            <th></th>
                        </tr>
                        <?php
                        $grandTotal += ($grandTotal * ($taxPercent / 100));
                        ?>
                    <?php endif; ?>

                    <tr>
                        <th colspan="10" style="text-align: right;">Shipping Cost</th>
                        <th>
                            <?php echo e(currency($order->shipping_price)); ?>

                        </th>
                        <th></th>
                    </tr>
                    <?php if($order->getCreditNoteAmount() > 0): ?>
                        <tr>
                            <th colspan="10" style="text-align: right;">Kreditnota</th>
                            <th><?php echo e(currency($order->getCreditNoteAmount())); ?></th>
                            <th></th>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <th colspan="10" style="text-align: right;">Grand Total</th>
                        <th><?php echo e(currency($order->getTotalPrice() - $order->getCreditNoteAmount())); ?></th>
                        <th></th>
                    </tr>

                    <tr>
                        <td colspan="12">
                            <div class="btn-group pull-right">
                                <?php if(auth()->user()->isCustomer()): ?>
                                    <a href="<?php echo e(sysRoute('orders.create')); ?>" class="btn btn-warning btn-sm">Create New
                                        Order</a>

                                    <?php if($order->isShipped() && auth()->user()->isCustomer() && !$order->isRefundRequested()): ?>
                                        <br>
                                        <br>
                                        <label class="radio">
                                            <input type="radio" name="refund_type"
                                                   value="<?php echo e(\App\Modules\Orders\Order::REFUND_TYPE_INSTANT); ?>" checked>
                                            Instant Refund
                                        </label>
                                        <label class="radio">
                                            <input type="radio" name="refund_type"
                                                   value="<?php echo e(\App\Modules\Orders\Order::REFUND_TYPE_DEDUCTION); ?>">
                                            Deduct From next invoice
                                        </label>
                                        <br>
                                        <?php echo btn('Request Refund'); ?>

                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php echo $__env->make('webpanel.orders.partials.admin-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </form>

    </div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('modals'); ?>
    <div class="modal fade declineModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(sysUrl('orders/decline/'.encryptIt($order->id))); ?>" method="post"
                      class="form-horizontal"
                      data-notification-area="#categoryNotification">
                    <div id="categoryNotification"></div>
                    <input type="hidden" name="_method" value="put">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">DECLINE ORDER: <?php echo e($order->OID); ?></h4>
                    </div>
                    <div class="modal-body">
                        <strong>Order Date: </strong> <?php echo e($order->createdDate()); ?><br>
                        <strong>Total Price: </strong> <?php echo e(@currency($order->price)); ?><br>
                        <strong>Total Items: </strong> <?php echo e($order->items->count()); ?><br>
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