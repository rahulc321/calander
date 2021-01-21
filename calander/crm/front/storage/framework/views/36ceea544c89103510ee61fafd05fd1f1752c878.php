<?php echo $__env->make('webpanel.includes.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="page-container">
<?php echo $__env->make('webpanel.includes.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="page-content">
<?php echo $__env->yieldContent('body'); ?>

<?php echo $__env->make('webpanel.includes.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
</div>