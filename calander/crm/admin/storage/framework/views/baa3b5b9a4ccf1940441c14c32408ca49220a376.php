<?php $__env->startSection('title'); ?>
Make Orders
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Make Order
                <small>Select product to make an order.</small>
            </h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <form method="get" action="" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Search</h3></div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-5">
                            <label for="keyword">Type Keyword:</label>
                            <input type="text" class="form-control" id="keyword" name="keyword"
                                   value="<?php echo e(Input::get('keyword')); ?>" required>
                        </div>

                        <div class="col-md-2" style="padding-top: 25px;">
                            <input type="submit" class="btn btn-primary btn-xs" name="filter" value="Filter">
                            <a class="btn btn-danger btn-xs" href="<?php echo e(sysRoute('orders.create')); ?>">Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="panel panel-default">
            <div class="panel-body">
                <?php if($products->count() > 0): ?>
                    <div class="row">
                        <?php foreach($products as $product): ?>
                            <div class="col-md-3 text-center">
                                <a href="<?php echo e(sysUrl('products/item-for-order/'.encryptIt($product->id))); ?>">
                                    <img src="<?php echo e(asset($product->getThumbUrl())); ?>" style="min-height: 75px;">
                                </a>
                                <p style="font-size:14px;font-weight: bold;"><?php echo e($product->name); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="paginationWrapper">
                        <?php echo $products->appends(Input::except('page'))->render(); ?>

                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No Products Found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>