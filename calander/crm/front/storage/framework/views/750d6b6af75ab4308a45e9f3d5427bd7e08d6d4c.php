<?php $__env->startSection('title'); ?>
Edit Email
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Email Template</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h6 class="panel-title">Update Email Template</h6>
            </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" data-request-url="">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Subject</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($emails as $k => $email): ?>
                            <tr>
                                <td><?php echo e($k + 1); ?></td>
                                <td><?php echo e($email->subject); ?>

                                </td>
                                <td>
                                    <a href="<?php echo e(sysUrl('emails/edit/'.encryptIt($email->id))); ?>" title="Edit">
                                        <i class="icon-pencil3"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div>
            </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
    <script>
        (function ($, window, document, undefined) {
            $(function () {
            });

        })(jQuery, window, document);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>