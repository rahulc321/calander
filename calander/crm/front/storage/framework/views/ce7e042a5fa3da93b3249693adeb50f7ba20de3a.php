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
            <h3>Future Clients</h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         
        <a href="add-client" class="btn btn-success" style="float:right">Add Future Client</a>
        </br>
        </br>
        <div class="hpanel">
            <div class="panel-body">
                
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>" id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Name</th>
                        <th>Email</th>
                        <th>Address</th>   
                        <th>Latitude</th>   
                        <th>Longitude</th>   
                        <th>Action</th>   
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                         //echo '<pre>';print_r($userInfo);die;

                         ?>
                         <?php $i=1; ?>
                        <?php foreach($clent as $alluser): ?>
                        <tr>
                            <td><?php echo e($i); ?></td>
                            <td><?php echo e($alluser->first_name.' '.$alluser->last_name); ?></td>
                            <td><?php echo e($alluser->email); ?></td>
                            <td><?php echo e($alluser->address); ?></td>
                            <td><?php echo e($alluser->lat); ?></td>
                            <td><?php echo e($alluser->lng); ?></td>
                            <td><a href="<?php echo e(url('/webpanel/clien-edit')); ?>/<?php echo e($alluser->id); ?>" class="btn btn-success">Edit</a>

                            <a href="<?php echo e(url('/webpanel/delete')); ?>/<?php echo e($alluser->id); ?>" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a></td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>

                </table>

                 
            </div>
             <?php echo $clent->render(); ?>

            <div>
                 
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
     <script>
         $(document).ready(function(){
            $(document).ready(function() {
                //$('#example').DataTable();
            } );
        });
     </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>