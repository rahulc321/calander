<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Search Invoices</h6>
    </div>
    <div class="panel-body">
        <form method="get" action="" role="form">


            <div class="row">
                <!-- 4July changes -->
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
                <!-- 4July changes -->


                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sales Person</label>
                        <div>
                            <select class="select2 lazySelector" name="sales_id" style="width: 200px;"
                                    data-selected="<?php echo e(Input::get('sales_id')); ?>">
                                <option value="">All</option>
                                <?php echo OptionsView(\App\User::exceptMe()->forMe()->sales()->get(), 'id', function($item){
                                    return $item->fullName();
                                }); ?>

                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-md-2" style="padding-top: 20px;">
                    <input type="submit" class="btn btn-warning btn-sm margin-top-10" name="search" value="Search">
                    <a class="btn btn-danger btn-sm margin-top-10" href="<?php echo e(sysUrl('commissions')); ?>">Reset</a>
                </div>

            </div>

        </form>
    </div>
</div>
