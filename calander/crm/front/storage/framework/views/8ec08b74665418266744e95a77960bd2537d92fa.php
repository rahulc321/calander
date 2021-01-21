<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Search Invoices</h6>
    </div>
    <div class="panel-body">
        <form method="get" action="<?php echo URL::route('webpanel.invoices.index'); ?>" role="form">
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
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" name="status" id="status" style="width: 90px;"
                                data-selected="<?php echo e(Input::get('status')); ?>">
                            <option value="">All</option>
                            <?php foreach(\App\Modules\Invoices\Invoice::GetStatusAsArray() as $k => $status): ?>
                                <option value="<?php echo e($k); ?>"><?php echo e($status); ?></option>
                            <?php endforeach; ?>
                            <option value="due" <?php if(@$_GET['status']=='due'): ?> <?php echo e('selected'); ?> <?php endif; ?>>DUE</option>
                        </select>
                    </div>
                </div>
                <!--div class="col-md-2">
                    <div class="form-group">
                        <label>Already Due</label>
                        <select class="form-control" name="due" id="due" style="width: 90px;"
                                data-selected="<?php echo e(Input::get('due')); ?>">
                            <option value="" selected>All</option>
                            <option value="1" <?php echo isSelected(1, Input::get('due')); ?>>Yes</option>
                            <option value="0" <?php echo isSelected(0, Input::get('due')); ?>>No</option>
                        </select>
                    </div>
                </div>-->

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Invoice ID</label>
                        <input type="text" class="form-control" name="iid" value="<?php echo e(Input::get('IID')); ?>">
                    </div>
                </div>
<!--
                <div class="col-md-2">
                    <label for="due_date">Due Date</label>
                     <input type="text" class="form-control dp" id="due_date" name="due_date" value="<?php echo e(Input::get('due_date')); ?>">
                </div>
            </div>-->

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Customer</label>
                        <div>
                        <select class="select2 lazySelector" name="user_id" style="width: 200px;"
                                data-selected="<?php echo e(Input::get('user_id')); ?>">
                            <option value="">All</option>
                            <?php echo OptionsView(\App\User::exceptMe()->forMe()->customers()->get(), 'id', function($item){
                                return $item->fullName();
                            }); ?>

                        </select>
                        </div>
                    </div>
                </div><!--
                <div class="col-md-2">
                    <label for="amount">Min Amount</label>
                    <input type="text" class="form-control" id="amount" name="amount_min" value="<?php echo e(Input::get('amount_min')); ?>">
                </div>
                <div class="col-md-2">
                    <label for="amount">Max Amount</label>
                    <input type="text" class="form-control" id="amount" name="amount_max" value="<?php echo e(Input::get('amount_max')); ?>">
                </div>
-->
                <div class="col-md-2" style="padding-top: 20px;">
                    <input type="submit" class="btn btn-warning btn-sm margin-top-10" name="search" value="Search">
                    <a class="btn btn-danger btn-sm margin-top-10" href="<?php echo e(sysRoute('invoices.index')); ?>">Reset</a>
                </div>

            </div>

        </form>
    </div>
</div>
