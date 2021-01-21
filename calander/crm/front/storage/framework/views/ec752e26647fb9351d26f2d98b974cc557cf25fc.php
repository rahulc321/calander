<?php $__env->startSection('title'); ?>
    Order and Stock Status
    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Order and Stock Status
            </h3>
        </div>
    </div>

    <div style="padding-top: 5px;">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <form method="get" action="" class="form-horizontal">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">
                    Search
                </h6>
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="control-label col-md-2" for="keyword">Search Products:</label>
                    <div class="col-md-5">

                        <select class="lazySelector select2" name="keyword" style="width:100%;"
                                data-selected="<?php echo e(Input::get('keyword')); ?>">
                            <option value="">All</option>
                            <?php echo OptionsView(App\Modules\Products\Product::all(), 'name', 'name'); ?>

                        </select>

                    </div>
                    <div class="col-md-4">
                        <input type="submit" name="filter" value="Filter" class="btn btn-primary btn-xs">
                        <a class="btn btn-danger btn-xs" href="<?php echo e(sysUrl('products-orders')); ?>">Reset</a>
                    </div>
                </div>

            </div>
        </div>

    </form>
    <?php $sum=0;
            $salePrice= 0;
     ?>
    <?php foreach($totalprice as $price): ?>
    <?php foreach($price->variants as $variantPrice): ?>
    <?php
    $itemQty=$variantPrice->qty;
    $productPrice= $price->price;
    $actPrice= $itemQty*$productPrice;

    $selP= $price->buying_price;
    $actSalePrice= $itemQty*$selP;

    $sum+=$actPrice;
    $salePrice+=$actSalePrice;





    ?>
     

    <?php endforeach; ?>
    <?php endforeach; ?>
    <style>
        .pqty {
            background-color: #546672;
            width: 113px;
            border-radius: 13px;
            padding: 10px;
            color: white;
        }
        .pprice {
            background-color: #546672;
            width: 236px;
            border-radius: 13px;
            padding: 10px;
            color: white;
        }
        .sel-price{
            background-color: #da6560;
            width: 236px;
            border-radius: 13px;
            padding: 10px;
            color: white;
        }
         
    </style>
    <div class="row">
        <?php if(auth()->user()->isAdmin()): ?>
            <div >
                <b class="pqty">Product Qty :<span class="aqty"><?php echo e(count($totalprice)); ?></span></b>
                <b class="pprice">Total Product Price : <span class="price1"><?php echo e(currency($sum)); ?></span></b>

                <b class="sel-price">Are Selling Price : <span class="price1"><?php echo e(currency($salePrice)); ?></span></b>
            </div>
            <br>
        <?php endif; ?>
        <div class="col-lg-12">
            
            <div class="table-responsive table-bordered">
                <table class="table deleteArena">
                    <thead>
                    <tr>
                        <th class="sortableHeading" data-orderBy="name">Name</th>
                        <th>Color</th>
                        <th>Stock Available</th>
                        <?php if(auth()->user()->isAdmin()): ?>
                            <th>Ordered Qty</th>
                            <th>Required QTY</th>
                            <th>Active Ordered Qty</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($products as $product): ?>

                        <?php $totalStock = 0; 
                        // echo '>>'.count($product);
                        ?>
                        <tr>
                            <td colspan="6"><strong><?php echo e($product->name); ?></strong>
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <br>Buying Price:<?php echo e(currency($product->price)); ?><br>
                                
                                    Are Selling Price: <?php echo e($product->buying_price); ?> 
                                    <br>
                                
                                <?php endif; ?>


                                <img src="<?php echo e(asset($product->getThumbUrl())); ?>">
                            </td>
                        </tr>
                        <?php foreach($product->variants as $variant): ?>
                            <tr>
                                <td></td>
                                <td><?php echo e(@$variant->color->name); ?>

                                    <div style="background: <?php echo e(@$variant->color->hex_code); ?>; width:20px; height:20px;"></div>
                                </td>
                                <td>
                                 <?php if(auth()->user()->isAdmin()): ?>
                                 <?php if($variant->qty < 0): ?>
                                 <?php echo e('0'); ?>

                                 <?php else: ?>
                                 <?php echo e($variant->qty); ?>

                                <?php endif; ?>
                                <?php else: ?>
                                <?php echo e($variant->qty); ?>

                                <?php endif; ?>
                                
                                </td>
                                <?php $totalStock += $variant->qty; ?>
                                <?php if(auth()->user()->isAdmin()): ?>
                                    <td><?php echo e($variant->getTotalOrdered()); ?></td>

                                    <!-- <td><?php if($variant->getTotalOrdered() !=0): ?><span
                                                class="label label-success">
                                        
                                         <?php if($variant->qty > $variant->getTotalOrdered()): ?>
                                        <?php echo e('0'); ?> <?php endif; ?>
                                         <?php if($variant->qty == $variant->getTotalOrdered()): ?>
                                        <?php echo e('0'); ?> <?php endif; ?>
                                        <?php if($variant->qty < $variant->getTotalOrdered()): ?>
                                        <?php echo e($variant->getTotalOrdered() - $variant->qty); ?> <?php endif; ?>
                                        </span><?php endif; ?>
                                    </td> -->
                                    <td>
                                        
                                        <?php if($variant->getTotalOrdered() !=0): ?>
                                        <?php if(!empty($variant->total_required)): ?>
                                        <span class="label label-success">
                                            <?php echo e($variant->total_required); ?>

                                            </span>
                                         
                                          
                                          <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($variant->getTotalFactoryOrdered()); ?></td>
                                <?php endif; ?>
                            </tr>

                        <?php endforeach; ?>
                        <tr>
                            <td></td>
                            <th>Total</th>
                            <td colspan="5"><strong>Stock Qty: <?php echo e($totalStock); ?></strong>
                            <?php if(auth()->user()->isAdmin()): ?>
                                <br><strong>Stock Amount: <?php echo e(currency($totalStock * $product->price)); ?></strong><br>

                            <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div>
                    <nav id="paginationWrapper">
                        <?php echo sysView('includes.pagination', ['data' => $products]); ?>

                    </nav>
                </div>
            </div>
            <br/>

            <?php if(auth()->user()->isAdmin()): ?>
                <div class="alert alert-danger fade in block">
                    <a href="<?php echo e(sysUrl('products/clear/xl')); ?>">Clear Records</a> &nbsp;
                    <i class="icon-info"></i> This will clear all customer's orders/factory orders and all stock item
                    will
                    be set to 0
                </div>
            <?php endif; ?>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        (function ($, window, document, undefined) {
            $(function () {
                $(document).on('change', '.product-stock', function (e) {
                    var url = $(this).data('url');
                    $.post(url, {
                        'qty': $(this).val()
                    }, function (response) {

                    })
                })
            });

        })(jQuery, window, document);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>