<?php $__env->startSection('title'); ?>
Update Website Info
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<?php error_reporting(0); ?>
 <div class="page-header">
        <div class="page-title">
            <h3>Update Website Info</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="panel panel-default">
           <!--  <div class="panel-heading">
                <h6 class="panel-title">Update Email Template</h6>
            </div> -->
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
                        	<?php $i=1;?>

                        <?php foreach($data as $value): ?>
                        <form action="<?php echo e(sysUrl('website_info')); ?>" method="post">
                        	<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <tr>
                             <td><?php echo e($i); ?></td>
                             <td><label><?php echo e($value->info_type); ?>:</label><input type="text" value="<?php echo e($value->info); ?>" name="info" class="form-control"></td>
                             <input type="hidden" name="info_id" value="<?php echo e($value->id); ?>">
                             <td> <input type="submit" value="Update" class="btn btn-success">       
                             </td>
                            </tr>
                            </form>
                            <?php
                                if($i==6){
                                    break;
                                }
                             $i++;?>                           
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
        </div>
            </div>
    </div>

<!-- Update address -->
   <div class="row">
            <div class="col-lg-12">
              <?php if(@$success1): ?>
       <div id="notificationArea">
           <div class="alert alert-success">
              <?php echo e(@$success1); ?> 
           </div>
       </div>
       <?php endif; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">Update Address</h6>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo e(sysUrl('website_info')); ?>" class="form-horizontal" method="post" role="form" data-result-container="#notificationArea">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                            <input type="hidden" name="_method" value="put">

                           <!--  <div class="form-group">
                                <label class="col-md-2" for="subject">Subject:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="subject" name="subject" value="<?php echo e($email->subject); ?>">
                                </div>
                            </div>
 -->
                            <div class="form-group">
                                <label class="col-md-2" for="message">Edit Address:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="message" name="info" rows="10"><?php echo e($data[6]->info); ?></textarea>
                                </div>
                                
                            </div>
                            <input type="hidden" name="info_id" value="<?php echo e($data[6]->id); ?>">
                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-6">
                                    <input type="submit" value="Update" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Update address -->
         <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
         
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
        <script>
        CKEDITOR.replace( 'message' );
        </script>

    <script>
        (function ($, window, document, undefined) {
            $(function () {


            });

        })(jQuery, window, document);
    </script>

    <script>
        (function ($, window, document, undefined) {
            $(function () {
            });

        })(jQuery, window, document);
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>