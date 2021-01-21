<?php $__env->startSection('title'); ?>
My Clients
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>My Clients</h3>
        </div>
    </div>
     <form method="get" action="" class="form-horizontal">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Filter</h3></div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="name">User Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo e(Input::get('name')); ?>">
                    </div>
                   

                    <div class="col-md-2" style="padding-top:25px;">
                        <input type="submit" class="btn btn-primary btn-xs" name="filter" value="Filter">
                        <a class="btn btn-danger btn-xs" href="<?php echo e(sysRoute('users.index')); ?>">Reset</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h6 class="panel-title">Clients</h6>
                            <div class="panel-icons-group">
                                <a href="<?php echo e(route('webpanel.users.create')); ?>" class="btn btn-link btn-icon">
                                    <i class="icon-plus-circle"></i> Add Client</a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table ajaxTable deleteArena" data-request-url="<?php echo route('webpanel.users.index'); ?>">
                                    <thead>
                                    <tr>
                                        <th class="sortableHeading" data-orderBy="name">Full Name</th>
                                        <th>Login Info</th>
                                        <th class="sortableHeading" data-orderBy="email">Email Address</th>
                                        <th class="sortableHeading" data-orderBy="phone">Phone</th>
                                        <th>User Type</th>
                                        <th class="sortableHeading" data-orderBy="discount">Discount(%)</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <nav id="paginationWrapper"></nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>