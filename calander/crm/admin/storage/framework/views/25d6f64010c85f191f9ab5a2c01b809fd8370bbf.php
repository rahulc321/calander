<?php $__env->startSection('title'); ?>
Stocks
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>View Stock Details
            </h3>
        </div>
        <div class="range">
            <a class="btn btn-success btn-sm pull-right" href="<?php echo e(sysUrl('products/download-stocks/xl')); ?>"><i class="icon-print2"></i> Print</a>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="table-responsive">
            <table class="table table-bordered table-condensed deleteArena">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Image/Product</th>
                    <th>Color/SKU/QTY</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($products as $k => $product): ?>
                    <tr>
                        <td align="center"><?php echo e($k + 1); ?></td>
                        <td align="center">
                            <img src="<?php echo e(asset($product->getThumbUrl())); ?>"> <br/>
                            <strong><a href="<?php echo URL::route('webpanel.products.edit', array('id' => encrypt($product->id))); ?>"><?php echo e($product->name); ?></a></strong>
                        </td>
                        <td>
                            <table class="table table-bordered">
                                <?php foreach($product->variants as $variant): ?>
                                    <tr>
                                        <td width="25%">
                                            <?php echo e(@$variant->color->name); ?>

                                            <div style="background: <?php echo e(@$variant->color->hex_code); ?>; width:20px; height:20px;"></div>
                                        </td>
                                        <td width="25%"><?php echo e($variant->sku); ?></td>
                                        <td width="25%"><span class="label label-success"><?php echo e($variant->qty); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>