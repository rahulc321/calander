<?php $__env->startSection('title'); ?>
View Kreditnota
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Kreditnota Details</h3>
        </div>
    </div>

    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="callout callout-success" style="margin: 0;">
        <small>
            Created Date: <?php echo e($creditNote->createdDate('d/m/Y')); ?> <br/>
            Status: <?php echo @\App\Modules\Creditnotes\Creditnote::$statusLabel[$creditNote->status]; ?> <br/>
            <?php if($creditNote->isDeclined()): ?>
                <strong>Reason: </strong> <?php echo e($creditNote->status_text); ?><br>
            <?php endif; ?>
            <?php if($creditNote->isApproved() || $creditNote->isPaid()): ?>
                <strong>Payment Type: </strong> <?php echo \App\Modules\CreditNotes\CreditNote::$paymentLabel[$creditNote->payment_type]; ?>

                <br>
            <?php endif; ?>
            Customer: <?php echo e($creditNote->user ? $creditNote->user->fullName() : ''); ?> <br/>
            Debitornr.: <?php echo e($creditNote->user->debitor_number); ?>

            <br/>
            Note:  <?php echo e($creditNote->note); ?>

        </small>
    </div>

    <div class="content">
        <form method="post" action="<?php echo e(sysUrl('creditnotes/ship/'.encryptIt($creditNote->id))); ?>">
            <input type="hidden" name="_method" value="put">

            <br/>  <br/>
            <table class="table table-bordered table-responsive deleteArena">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Product Name</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th style="width:100px;">QTY</th>
                    <th align="right">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php $items = $creditNote->items()->with('product.photos')->get();
                $grandTotal = 0; ?>
                <?php foreach($items as $k => $item): ?>
                    <tr class="deleteBox">
                        <td>
                            <?php echo e($k + 1); ?>

                        </td>
                        <td>
                            <?php echo e(@$item->product->name); ?>

                        </td>
                        <td>
                            <?php echo e(@$item->variant->color->name); ?>

                        </td>
                        <td><?php echo e(currency($item->price)); ?></td>
                        <td><?php echo e($item->qty); ?></td>
                        <?php
                        $total = $item->price * $item->qty;
                        $grandTotal += $total; ?>
                        <td><?php echo e(currency($total)); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <?php if($creditNote->tax_percent > 0): ?>
                    <?php
                    $taxPercent = $creditNote->tax_percent;
                    ?>
                    <tr>
                        <th colspan="5" style="text-align: right;">Tax</th>
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
                    <th colspan="5" style="text-align: right;">Grand Total</th>
                    <th>
                        <?php echo e(currency($grandTotal)); ?>

                    </th>
                </tr>
                <tr>
                    <td colspan="9">
                        <div class="btn-group pull-right">
                            <?php if(auth()->user()->isAdmin()): ?>
                                <?php echo $__env->make('webpanel.creditnotes.partials.admin-menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
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
                <form action="<?php echo e(sysUrl('creditnotes/decline/'.encryptIt($creditNote->id))); ?>" method="post"
                      class="form-horizontal"
                      data-notification-area="#categoryNotification">
                    <div id="categoryNotification"></div>
                    <input type="hidden" name="_method" value="put">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">DECLINE Kreditnota</h4>
                    </div>
                    <div class="modal-body">
                        <div style="padding:10px">
                            <strong>Credit note Date: </strong> <?php echo e($creditNote->createdDate()); ?><br>
                            <strong>Total Price: </strong> <?php echo e(@currency($creditNote->price)); ?><br>
                            <strong>Total Items: </strong> <?php echo e($creditNote->items->count()); ?><br>
                            <div class="panel-body">
                                <div class="form-group required">
                                    <label class="" for="name">Reason</label>
                                    <div class="">
                                        <textarea class="form-control" name="remarks" required></textarea>
                                    </div>
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

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function () {
            $('.paymentToggle').on('change', function (e) {
                window.location = $(this).attr('data-url') + '/' + $(this).val();
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>