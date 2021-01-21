<?php $__env->startSection('title'); ?>
    Memos
    @parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-title">
            <h3>Memo</h3>
        </div>
    </div>

    <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="content">

        <div class="panel panel-default">
            <div class="panel-heading"><h6 class="panel-title"><i class="icon-pencil"></i> Memo: Last Updated At <?php echo e($memo->updated_at); ?></h6></div>
            <div class="panel-body">
                <form method="post" action="<?php echo e(sysUrl('memo')); ?>">
                    <div class="block-inner">
                        <textarea class="editor" name="memo" style="height:400px;"><?php echo e($memo->memo); ?></textarea>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>