<?php error_reporting(0); ?> 

<?php $__env->startSection('title'); ?>
All User Info
@parent
<?php $__env->stopSection(); ?>
<?php $__env->startSection('body'); ?>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="
https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<style>
.dataTables_length {
    float: right;
    padding: 0 0 20px 0;
    display: block;
    float: left !important;
}
.dataTables_filter {
    padding: 0 0 20px 0;
    position: relative;
    display: block;
    /* float: left; */
    float: right !important;
}


</style>
    <div class="page-header">
        <div class="page-title">
            <h3>All User Info</h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         

        <div class="hpanel">
            <div class="panel-body">
                <!-- <a href="<?php echo e(sysUrl('invoices/download-all/xl')); ?>?<?php echo e(http_build_query(Input::except('page'))); ?>" class="pull-right btn"><i class="icon-print2"></i> Print</a> -->

                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>" id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Name</th>
                        <th>Email</th>
                        <th>Paid</th>
                        <th>Unpaid</th>
                        <th>Cancel</th>
                        <th>Total Amount</th>   
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                         //echo '<pre>';print_r($userInfo);die;

                         ?>
                         <?php $i=1; ?>
                        <?php foreach($userInfo['data'] as $k=>$alluser): ?>
                        <?php if(!empty($userInfo['gtotal'][$k])): ?>

                        <?php 
                            $invoiceStatus =$userInfo['status'][$alluser['id']];
                        //echo '<pre>';print_r($userInfo['status'][$alluser['id']]);  ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td>
                                
                                <a href="<?php echo e(sysUrl('user-data')); ?>/<?php echo e($alluser['id']); ?>"><?php echo e(@$alluser['full_name']); ?></a>
                              
                            </td>
                            <td><?php echo e(@$alluser['email']); ?></td>
                            <td>
                            <?php if($invoiceStatus !=1): ?>
                            <?php if($userInfo['laser_price1'][$alluser['id']]): ?>
                            <!--  -->
                              <label class="label label-success"><?php echo e(abs($userInfo['paid'][$k]['total']+$userInfo['laser_price1'][$alluser['id']])); ?></label> 
                            <?php else: ?>
                            <label class="label label-success"><?php echo e(@$userInfo['paid'][$k]['total']); ?></label>

                            <?php endif; ?>
                            <?php else: ?>
                            <label class="label label-success"><?php echo e(@$userInfo['paid'][$k]['total']); ?></label>
                            <?php endif; ?>
                        </td>
                            <td>
                            <?php if($invoiceStatus !=1): ?>
                            <?php if(!empty($userInfo['unpaid'][$k])): ?>
                            
                            <label class="label label-warning"><?php echo e(abs(@$userInfo['unpaid'][$k]-$userInfo['laser_price1'][$alluser['id']])); ?></label>
                            <?php endif; ?>
                            <?php else: ?>
                                <?php if(!empty($userInfo['unpaid'][$k])): ?>
                                <label class="label label-warning"> <?php echo e(@$userInfo['unpaid'][$k]); ?></label>
                                <?php endif; ?>
                            <?php endif; ?>

                        </td>
                            <td><label class="label label-danger"><?php echo e(@$userInfo['cancel'][$k]); ?></label></td>
                            <td><?php echo e(@$userInfo['gtotal'][$k]); ?></td>
                        </tr>
                        <?php $i++; ?>
                        <?php endif; ?>
                        
                        <?php endforeach; ?>
                    </tbody>
                </table>

                 
            </div>
            <div>
                 
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
     <script>
         $(document).ready(function(){
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        });
     </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>