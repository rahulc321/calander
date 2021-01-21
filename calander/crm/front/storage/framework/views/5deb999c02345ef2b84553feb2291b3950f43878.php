<?php $__env->startSection('title'); ?>
Orders
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Orders</h3>
        </div>
    </div>

    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="content">
            <?php echo $__env->make('webpanel.orders.partials.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="pull-right" style="font-size: 15px;font-weight: bold;">Total: <?php echo e(currency(getTotalFromOrders($orders))); ?></div>

                    <table class="table table-bordered table-striped ajaxTable deleteArena"
                           data-request-url="<?php echo route('webpanel.orders.index'); ?>">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th class="sortableHeading" data-orderBy="OID">Order ID</th>
                            <th class="sortableHeading" data-orderBy="created_at">Order Date</th>
                            <th>Expected Shipping Date</th>
                            <?php if(!auth()->user()->isCustomer()): ?>
                                <th class="sortableHeading" data-orderBy="created_by">Customer</th>
                            <?php endif; ?>
                            <th class="sortableHeading" data-orderBy="price" width="140">Amount</th>
                            <th>Items Ordered</th>
                            <th class="sortableHeading" data-orderBy="status">Status</th>
                            <!-- <th>Required Qty</th> -->
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div>
                        <nav id="paginationWrapper" class="pagination-sm"></nav>
                    </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>