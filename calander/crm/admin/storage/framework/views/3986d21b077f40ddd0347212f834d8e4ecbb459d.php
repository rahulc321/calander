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
                 <b>Total Unpaid => <?php echo e(currency($unPaid-$paidPrice)); ?></b><br>
                 <b>Total Partial Payment => <?php echo e(currency($paidPrice)); ?></b>
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

                        <?php 
                        $allPrice= $userInfo['paid'][$alluser['id']]+$userInfo['unpaid'][$k]+$userInfo['cancel'][$k]; ?>
                        <?php if(!empty($allPrice)): ?>
                        <?php 
                      
                        //     echo '<pre>';print_r($userInfo['gtotal'][$id]);
                            $invoiceStatus =$userInfo['status'][$alluser['id']];
                        // $userInfo['paid'][$alluser['id']];
                        // $userInfo['unpaid'][$k];
                        // $userInfo['cancel'][$k];
                     $grandTotal= $userInfo['paid'][$alluser['id']]+$userInfo['unpaid'][$k]+$userInfo['cancel'][$k];
                        

                        ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td>
                                
                                <a href="<?php echo e(sysUrl('user-data')); ?>/<?php echo e($alluser['id']); ?>"><?php echo e(@$alluser['full_name']); ?></a>
                              
                            </td>
                            <td><?php echo e(@$alluser['email']); ?></td>
                            <td>
                            <?php if(!empty($userInfo['paid'][$alluser['id']])): ?>
                            <?php if($userInfo['laser_price1'][$alluser['id']]): ?>
                            <!--  -->
                              <label class="label label-success"> <?php echo e(currency(abs($userInfo['paid'][$alluser['id']]+$userInfo['laser_price1'][$alluser['id']]))); ?></label> 
                            <?php else: ?>
                            <label class="label label-success"> <?php echo e(currency(@$userInfo['paid'][$alluser['id']])); ?></label>

                            <?php endif; ?>
                            <?php else: ?>
                             <?php if(!empty($userInfo['paid'][$alluser['id']])): ?>
                            <label class="label label-success"> <?php echo e(currency(@$userInfo['paid'][$alluser['id']])); ?></label>
                            <?php endif; ?>
                            
                            <?php endif; ?>
                        </td>
                            <td>
                            <?php if($invoiceStatus !=1): ?>
                            <?php if(!empty($userInfo['unpaid'][$k])): ?>
                            
                            <label class="label label-warning"><?php echo e(currency(abs(@$userInfo['unpaid'][$k]-$userInfo['laser_price1'][$alluser['id']]))); ?></label>
                            <?php endif; ?>
                            <?php else: ?>
                                <?php if(!empty($userInfo['unpaid'][$k])): ?>
                                <label class="label label-warning"> <?php echo e(currency(@$userInfo['unpaid'][$k])); ?></label>
                                <?php endif; ?>
                            <?php endif; ?>

                        </td>
                           
                            <td>
                                 <?php if(!empty($userInfo['cancel'][$k])): ?>
                                <label class="label label-danger"><?php echo e(currency(@$userInfo['cancel'][$k])); ?></label>
                                <?php endif; ?>
                            </td>
                            
                            <td><?php echo e(currency($grandTotal)); ?></td>
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