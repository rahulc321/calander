<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title">Search</h6>
    </div>
    <div class="panel-body">
        <form method="get" action="" role="form" class="form-horizontal">
            <div class="row">
                <div class="col-md-3">
                    <select class="select2" name="user_id" style="width: 240px;">
                        <option value="">Select Customer</option>
                        <?php echo OptionsView(\App\User::customers()->alphabetical()->get(), 'id', function($item){ return $item->fullName(); }, Input::get('user_id')); ?>

                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control dp" name="date_from" value="<?php echo e(Input::get('date_from')); ?>" placeholder="Date From">

                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control dp" name="date_to" value="<?php echo e(Input::get('date_to')); ?>" placeholder="Date To">
                </div>

                <div class="col-md-2">
                    <div>
                        <input type="submit" class="btn btn-warning btn-sm margin-top-10" name="search" value="Search">
                        <a class="btn btn-danger btn-sm margin-top-10"
                           href="<?php echo e(sysRoute('creditnotes.index')); ?>">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
