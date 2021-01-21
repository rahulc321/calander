<?php $__env->startSection('title'); ?>
Dashboard
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="content">
            <div class="row">
                <div class="col-lg-12 text-center m-t-md">
                </div>
            </div>
            <?php echo $__env->make('webpanel.dashboard.partials.'.strtolower(str_slug(auth()->user()->userType->title)), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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