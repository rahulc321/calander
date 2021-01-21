<?php $__env->startSection('title'); ?>
    Sales
    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Top Selling Bags</h3>
        </div>
    </div>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">Search/Filter</h6>
                    </div>
                    <div class="panel-body">
                        <form method="get" class="form-horizontal">
                            <input type="hidden" name="type" value="variant">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <label for="date_from">Date From:</label>
                                    <input type="text" class="form-control dp" id="date_from" name="date_from"
                                           value="<?php echo e(Input::get('date_from')); ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="date_to">Date To:</label>
                                    <input type="text" class="form-control dp" id="date_to" name="date_to"
                                           value="<?php echo e(Input::get('date_to')); ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="orderBy">Order By:</label>
                                    <select class="form-control lazySelector" id="orderBy" name="orderBy"
                                            data-selected="<?php echo e(Input::get('orderBy')); ?>">
                                        <option value="total">Total Quantity</option>
                                        <option value="sellingPrice">Total Sales</option>
                                        <option value="profit">Total Profit</option>
                                    </select>
                                </div>

                                <div class="col-md-2" style="padding-left: 30px;">
                                    <div style="padding-top: 25px;">
                                        <label>&nbsp;</label>
                                        <input type="submit" name="search" value="Filter"
                                               class="btn btn-primary btn-sm">
                                        <a class="btn btn-danger btn-sm" href="<?php echo e(sysUrl('stats/sales')); ?>">Clear</a>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">List</h6>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Color</th>
                                    <th>Total Sales</th>
                                    <th>Qty</th>
                                    <th>Profit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $groupedVariants = $variants->groupBy('productName');
                                $i = 1;
                                ?>
                                <?php foreach($groupedVariants as $k => $variants): ?>
                                    <tr>
                                        <td colspan="7">
                                            <strong><?php echo e($k); ?></strong>
                                        <br/>
                                            <img src="<?php echo e(@$variants[0]->product ? @$variants[0]->product->getThumbUrl() : dummyUrl()); ?>">
                                        </td>
                                    </tr>
                                    <?php foreach($variants as $k => $variant): ?>
                                        <tr>
                                            <td><?php echo e($k + 1); ?></td>
                                            <td><?php echo e(@$variant->color->name); ?></td>
                                            <td><?php echo e(Config::get('currency.before')); ?> <?php echo e($sellingPrice = $variant->total * @$variant->product->price); ?></td>
                                            <td><?php echo e(@$variant->total); ?></td>
                                            <td><?php echo e(Config::get('currency.before')); ?> <?php echo e($sellingPrice - ($variant->total * @$variant->product->buying_price)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>