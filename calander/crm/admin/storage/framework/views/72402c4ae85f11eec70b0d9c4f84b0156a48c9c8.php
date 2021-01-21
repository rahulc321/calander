<?php error_reporting(0); ?> 

<?php $__env->startSection('title'); ?>
Enquiry
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
            <h3>All Enquiry</h3>
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
                        <th>Phone</th>
                        <th>Product Name</th>
                        <th>Message</th>
                        <th>Create Date</th>
                         
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                         //echo '<pre>';print_r($userInfo);die;

                         ?>
                          
                        <?php foreach($enquiry as  $allEnquiry): ?>

                        
                        <tr>
                            <td><?php echo e(++$i); ?></td>
                            <td><?php echo e($allEnquiry->first_name.' '.$allEnquiry->last_name); ?></td>
                            <td><?php echo e($allEnquiry->email); ?></td>
                            <td><?php echo e($allEnquiry->contact); ?></td>
                            <td><?php echo e($allEnquiry->product_name); ?></td>
                            <td><p style="line-height:1.2em;
  height:3.6em;
  overflow:hidden;">
     <a href="javascript:;" data-toggle="modal" message="<?php echo $allEnquiry->message; ?>" data-target="#myModal" class="msg1"> <?php echo $allEnquiry->message; ?></a>
</p>

</td>
                            <td><?php echo e($allEnquiry->created_at); ?></td>
                             
                             
                        </tr>
                       
                         
                        
                        <?php endforeach; ?>
                    </tbody>
                </table>

                 
            </div>
            <div>
                 
            </div>
        </div>
    </div>

    <!-- Trigger the modal with a button -->
<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Message</h4>
      </div>
      <div class="modal-body ">
         <p class="message"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<style type="text/css">
    p.message {
    padding: 10px;
    font-size: 16px;
    text-align: justify;
    background: #d7dad8;
}
 
.modal-dialog {
    width: 1201px !important;
    margin: 30px auto;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
     <script>
          
            $(document).ready(function() {
                $('.msg1').click(function(){
                    var msg= $(this).attr('message');
                     $('.message').html(msg);
                });


                $('#example').DataTable();
            } );
        
     </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>