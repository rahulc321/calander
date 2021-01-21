<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Search</h6>
    </div>
    <div class="panel-body">
        <form method="get" action="<?php echo URL::route('webpanel.factoryorders.index'); ?>" role="form">
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date From</label>
                        <input type="text" class="form-control dp" name="date_from" value="<?php echo e(Input::get('date_from')); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Date To</label>
                        <input type="text" class="form-control dp" name="date_to" value="<?php echo e(Input::get('date_to')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Product</label>
                        <div>
                            <select class="lazySelector select2" name="product_id" style="width:100%;"
                                    data-selected="<?php echo e(Input::get('product_id')); ?>">
                                <option value="">All</option>
                                <?php echo OptionsView(App\Modules\Products\Product::all(), 'id', 'name'); ?>

                            </select>
                        </div>

                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control lazySelector" name="status"
                                data-selected="<?php echo e(Input::get('status')); ?>">
                            <option value="">All</option>
                            <?php foreach(\App\Modules\FactoryOrders\FactoryOrder::GetStatusAsArray() as $k => $status): ?>
                                <option value="<?php echo e($k); ?>"><?php echo e($status); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2" style="padding-left:30px;">
                    <div class="form-group">
                        <label>Order ID</label>
                        <input type="text" class="form-control" name="oid" value="<?php echo e(Input::get('oid')); ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <div style="padding-top: 25px;">
                        <input type="submit" class="btn btn-warning btn-sm margin-top-10" name="search" value="Search">
                        <a class="btn btn-danger btn-sm margin-top-10" href="<?php echo e(sysRoute('factoryorders.index')); ?>">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
