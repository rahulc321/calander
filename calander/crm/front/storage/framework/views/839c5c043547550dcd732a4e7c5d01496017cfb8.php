<?php $__env->startSection('title'); ?>
Products
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Product Management</h3>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h6 class="panel-title">Search</h6>
            <div class="panel-icons-group">
                <a href="<?php echo e(sysRoute('colors.index')); ?>" class="btn"><i class="icon-text-color"></i> Manage Colors</a>
                <a href="<?php echo e(route('webpanel.products.create')); ?>" class="btn"><i class="icon-plus"></i>Add Product</a>
                <a href="<?php echo e(sysUrl('products/stocks/xl')); ?>" class="btn"><i class="icon-list"></i>Stocks</a>
            </div>
        </div>
        <div class="panel-body">
            <form method="get" action="" class="form-horizontal">
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="keyword">Name</label>
                        <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo e(Input::get('keyword')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="collection_id">Collection</label>
                        <select class="form-control" id="collection_id" name="collection_id">
                            <option value="">Select</option>
                            <?php echo OptionsView(\App\Modules\Collections\Collection::all(), 'id', 'name', Input::get('collection_id')); ?>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <div style="padding-top: 25px;">
                            <button type="submit" class="btn btn-warning btn-sm" name="search" value="Search">Search</button>
                            <a class="btn btn-danger btn-sm"
                               href="<?php echo e(sysRoute('products.index')); ?>">Reset</a>
                            <a href="<?php echo e(sysUrl('products/download/xl')); ?>?<?php echo e(http_build_query(Input::except('page'))); ?>" class="btn btn-warning btn-sm">
                                <i class="icon-print2"></i> Print
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div style="padding-top: 5px;">
         <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">Inventory</h6>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed deleteArena ajaxTable   "
                                       data-request-url="<?php echo e(sysRoute('products.index')); ?>">
                                    <thead>
                                    <tr>
                                        <th class="sortableHeading" data-orderBy="name">Name</th>
                                        <th>Image</th>
                                        <th>Dimension</th>
                                        <th>Collection</th>
                                        <th>Selling Price</th>
                                        <th>Buying Price</th>
                                        <th>Actions</th>
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
            </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('modals'); ?>
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