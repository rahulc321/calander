<?php $__env->startSection('title'); ?>
Change Password
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Change Password</h3>
        </div>
    </div>

            <div class="row">
                <div class="col-lg-10">
                    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">Change Password</h6>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" method="post" action="<?php echo e(url('webpanel/my/password')); ?>" role="form">

                                <div class="form-group">
                                    <label class="col-sm-2">New Password:</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name="password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2">Repeat New Password:</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2">&nbsp;</label>
                                    <div class="col-sm-8">
                                        <input type="submit" value="Change Password" class="btn btn-warning submit-btn">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>