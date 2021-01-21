<?php error_reporting(0); ?> 

<?php $__env->startSection('title'); ?>
All Coupons
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
            <h3>All Coupons</h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         
        <a href="add-coupon" class="btn btn-success" style="float:right">Add New Coupon</a>
        </br>
        </br>
        <div class="hpanel">
            <div class="panel-body">
                
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                        id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Name</th>
                        <th>Valid From</th>
                        <th>Valid to</th>
                        <th>Uses</th>
                        <th>Coupon Type</th>
                        <th>Coupon Amt</th>
                        <th>Create Date</th>      
                        <th>Action</th>   
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                         //echo '<pre>';print_r($userInfo);die;

                         ?>
                         <?php $i=1; ?>
                        <?php foreach($coupons as $coupon): ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($coupon->coupon_code); ?></td>
                            <td><?php echo e($coupon->start_date); ?></td>
                            <td><?php echo e($coupon->end_date); ?></td>
                            <td><?php echo e($coupon->uses); ?></td>
                            <td><?php echo e($coupon->cupon_type); ?></td>
                            <td><?php echo e($coupon->price); ?></td>
                            <td><?php echo e($coupon->created_at); ?></td>
                             
                            <td><a href="<?php echo e(url('/webpanel/coupon-edit')); ?>/<?php echo e($coupon->id); ?>" class="btn btn-success">Edit</a>

                            <a href="<?php echo e(url('/webpanel/delete-coupon')); ?>/<?php echo e($coupon->id); ?>" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a></td>
                        </tr>
                        <?php $i++; ?>
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
         
            $(document).ready(function() {
                $('#example').DataTable();
                $('.alert').delay(2000).fadeOut('slow');
            } );
      
     </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>