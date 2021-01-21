<?php $__env->startSection('title'); ?>
    Profile
    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Update Profile</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10">
            <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">Update Profile</h6>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post"
                          action="<?php echo URL::route('admin.profile.update'); ?>"
                          role="form" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="col-sm-2">Full Name:</label>
                            <div class="col-sm-8">
                                <input type="text" placeholder="Full Name" class="form-control" name="full_name"
                                       value="<?php echo e($user->full_name); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Email Address:</label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="email" value="<?php echo e($user->email); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Phone:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="phone" value="<?php echo e($user->phone); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Address:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="address" value="<?php echo e($user->address); ?>">
                            </div>
                            <label class="col-sm-2">City:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="city" value="<?php echo e($user->city); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2">Country:</label>
                            <div class="col-sm-3">
                                <select class="form-control lazySelector" name="country"
                                        data-selected="<?php echo e($user->country); ?>">
                                    <option value="">Select Country</option>
                                    <?php echo OptionsView(\App\Modules\Country::all(), 'name', 'name'); ?>

                                </select>
                            </div>
                            <label class="col-sm-2">Zip Code:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="zipcode" value="<?php echo e($user->zipcode); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-2" for="currency_id">Currency:</label>
                            <div class="col-md-3">
                                <select class="form-control lazySelector" id="currency_id" name="currency_id" data-selected="<?php echo e($user->currency_id); ?>">
                                    <option value="">Choose Currency</option>
                                    <?php echo OptionsView(\App\Modules\Currencies\Currency::all(), 'id', 'name'); ?>

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">&nbsp;</label>
                            <div class="col-sm-10">
                                <input type="submit" value="Update" class="btn btn-warning submit-btn">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>