<?php $__env->startSection('title'); ?>
Edit Email
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Update Email Template</h3>
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">Update</h6>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal ajaxForm" method="post"
                              action="<?php echo sysUrl('emails/update/' . encryptIt($email->id)); ?>"
                              role="form" data-result-container="#notificationArea">

                            <input type="hidden" name="_method" value="put">

                            <div class="form-group">
                                <label class="col-md-2" for="subject">Subject:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="subject" name="subject" value="<?php echo e($email->subject); ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="message">Email Template:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="message" name="message" rows="10"><?php echo e($email->message); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-6">
                                    <input type="submit" value="Update" class="btn btn-warning btn-sm submit-btn">
                                </div>
                            </div>
                        </form>
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