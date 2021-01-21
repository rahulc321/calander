<?php $__env->startSection('title'); ?>
Factory Orders
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Factory Orders</h3>
        </div>
        <div class="range">
            <a href="<?php echo e(sysRoute('factoryorders.create')); ?>" class="btn btn-warning btn-sm pull-right">+ Add Order</a>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('webpanel.factoryorders.partials.search', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div>
            <a href="<?php echo e(sysUrl('factoryorders/download-all/xl')); ?>?<?php echo e(http_build_query(Input::except('page'))); ?>" class="pull-right"><i class="icon-print2"></i> Print</a>

            <div class="panel-body">
                <table class="table table-bordered table-striped ajaxTable deleteArena"
                       data-request-url="<?php echo route('webpanel.factoryorders.index'); ?>">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-orderBy="OID">Order ID</th>
                        <th>Ordered QTY</th>
                        <th>Factory Name</th>
                        <th class="sortableHeading" data-orderBy="created_at">Delivery Date</th>
                        <th class="sortableHeading" data-orderBy="created_at">Order Date</th>
                        <th class="sortableHeading" data-orderBy="price">Total Price</th>
                        <th data-orderBy="status">Status</th>
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



<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>