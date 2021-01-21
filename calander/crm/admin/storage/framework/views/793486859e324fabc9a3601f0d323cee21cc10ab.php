<?php $__env->startSection('title'); ?>
Refunds
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Refunds</h3>
        </div>
    </div>

    <div class="content">

        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Refunds Requests</h6>
            </div>
            <div class="panel-body">
                <table class="table table-ordered ajaxTable deleteArena"
                       data-request-url="<?php echo sysUrl('refunds'); ?>">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th class="sortableHeading" data-refundBy="OID">Order ID</th>
                        <th class="sortableHeading" data-refundBy="created_at">Request Date</th>
                        <?php if(!auth()->user()->isCustomer()): ?>
                            <th class="sortableHeading" data-refundBy="created_by">Customer</th>
                        <?php endif; ?>
                        <th class="sortableHeading" data-refundBy="price">Total Price</th>
                        <th>Items Refund</th>
                        <th>Refund Type</th>
                        <th data-refundBy="status">Status</th>
                        <th>Credit Note</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div>
                    <nav id="paginationWrapper"></nav>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
    <div class="modal fade actionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(sysUrl('refunds/action')); ?>" method="post"
                      class="form-horizontal"
                      data-notification-area="#categoryNotification">
                    <div id="categoryNotification"></div>
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="order_id" value="" id="refundIdField">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Refund</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel-body">

                                <label>Status</label>
                                <div>
                                    <select class="form-control" name="refund_status">
                                        <option value="<?php echo e(\App\Modules\Orders\Order::REFUND_STATUS_APPROVED); ?>">
                                            APPROVE
                                        </option>
                                        <option value="<?php echo e(\App\Modules\Orders\Order::REFUND_STATUS_DECLINED); ?>">
                                            DECLINE
                                        </option>
                                    </select>
                                </div>
                            <br/>
                            <div class="required">
                                <label for="name">Credit Note</label>
                                <div class="">
                                    <textarea class="form-control" name="credit_note" required></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        $(function () {
            $(document).on('click', '.actionBtn', function (e) {
                $("#refundIdField").val($(this).attr('data-id'));
            })
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>