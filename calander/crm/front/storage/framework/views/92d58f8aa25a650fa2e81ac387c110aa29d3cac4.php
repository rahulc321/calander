<?php $__env->startSection('title'); ?>
    Product: <?php echo e($product->name); ?>

    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Product: <?php echo e($product->name); ?>

                <small>Select required Qty and Process.</small>
            </h3>
        </div>
        <div class="range">
            <?php
            $previousProduct = false;
            $previous = \App\Modules\Products\Product::where('id', '<', $product->id)->max('id');
            if ($previous) {
                $previousProduct = \App\Modules\Products\Product::find($previous);
            }

            // get next user id
            $nextProduct = false;
            $next = \App\Modules\Products\Product::where('id', '>', $product->id)->min('id');
            if ($next) {
                $nextProduct = \App\Modules\Products\Product::find($next);
            }
            ?>
            <?php if($previousProduct): ?>
                <a href="<?php echo e(sysUrl('products/item-for-order/'.encryptIt($previous))); ?>"
                   class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i> Previous</a>
            <?php endif; ?>

            <?php if($nextProduct): ?>
                <a href="<?php echo e(sysUrl('products/item-for-order/'.encryptIt($next))); ?>"
                   class="btn btn-warning btn-sm">Next <i class="fa fa-arrow-right"></i> </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="content">
        <form class="ajaxForm form-horizontal" method="post" enctype="multipart/form-data"
              action="<?php echo sysUrl('orders/add-to-cart'); ?>"
              role="form" data-result-container="#notificationArea">
            <input type="hidden" name="id" value="<?php echo e(encryptIt($product->id)); ?>">

            <div class="panel">
                <div class="panel-body">
                    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="row">
                        <div class="col-md-6">
                        <?php $i=1; ?>
                        <?php foreach($product->photos as $k => $photo): ?>
                            <?php if($i==1): ?>
                             <img src="<?php echo e($photo->getFileUrl()); ?>" data-lazy="<?php echo e($photo->getFileUrl()); ?>" style="width:100%;"/>
                            <?php endif; ?>
                        <?php $i++; ?>
                        <?php endforeach; ?>

                        </div>
                        <div class="col-md-6">
                            <strong><?php echo e(currency($product->price)); ?></strong><br>
                            <div class="row">
                                <div class="col-md-3">
                                    <input class="form-control" name="qty" value="1" pattern="[0-9]+">
                                </div>
                                <span class="help-block" id="stock-label"></span>
                            </div>

                            <br/><br/>
                           <strong>Select Colors:</strong><br><br/>

                            <div class="row">
                                <div class="col-md-7">
                                    <input type="hidden" name="variant_id" value="">
                                    <?php $variants = $product->variants()->with('color')->get(); ?>
                                    <?php if($variants->count() > 0): ?>
                                        <?php foreach($variants as $variant): ?>
                                            <?php if (!$variant->color): continue; endif;?>
                                            <a class="color-box" style="background:<?php echo e(@$variant->color->hex_code); ?>"
                                               data-stock-label="<?php echo e($variant->qty > 0 ? 'In Stock' : 'Out Of Stock'); ?>"
                                               data-id="<?php echo e($variant->id); ?>" title="<?php echo e(@$variant->color->name); ?>"></a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>

                            </div>
                            <br>
                            <div style="padding-left:0px;">
                                <button type="submit" class="btn btn-success">Add To Cart</button>
                            </div>
                            <br/>
                            <strong>Description:</strong><br>
                            <p><?php echo e($product->description); ?></p>
                            <strong>Dimensions:</strong> <br/>
                            Length: <?php echo e($product->length); ?> cm <br/>
                            Height: <?php echo e($product->height); ?> cm <br/>
                            Depth: <?php echo e($product->depth); ?> cm <br/>
                            <hr/>
                            Number of Compartments: <?php echo e($product->number_of_compartments); ?> <br/>
                            Number of Pockets: <?php echo e($product->number_of_pockets); ?> <br/>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(".color-box").on('click', function (e) {
                    $("[name=variant_id]").val($(this).attr('data-id'));
                    $("#stock-label").text($(this).attr('data-stock-label'));
                    $(".color-box").removeClass('active');
                    $(this).addClass('active');
                    return false;
                });
            });
        })(jQuery, window, document);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>