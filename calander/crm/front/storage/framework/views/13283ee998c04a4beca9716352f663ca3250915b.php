 <?php error_reporting(0) ?>
 
<?php $__env->startSection('title'); ?>
User Info
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
td.table-success {
    background-color: #3a4b55 !important;
    color: white;
    font-size: 23px;
}
th.table-success {
    background-color: #3a4b55 !important;
    color: white;
    font-size: 23px;
}
.modal-title {
    font-size: 19px !important;
}
.form-group.jj {
    padding: 13px;
    width: 50%;
}
button.btn.btn-success.kk {
    margin-left: 13px;
}
</style>
    <div class="page-header">
        <div class="page-title">
            <h3>All Unpaid Invoice Detail</h3>
        </div>
    </div>

    <div class="content">
        <?php echo $__env->make('webpanel.includes.notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         <div class="message">
        <?php if(\Session::has('addamount')): ?>
        <p class="alert alert-info"><?php echo e(Session::get('addamount')); ?></p>
        <?php elseif(\Session::has('paidamount')): ?>
        <p class="alert alert-info"><?php echo e(Session::get('paidamount')); ?></p>
        <?php endif; ?>
         </div>
        <div class="hpanel">
            <div class="panel-body">
                <!-- <a href="<?php echo e(sysUrl('invoices/download-all/xl')); ?>?<?php echo e(http_build_query(Input::except('page'))); ?>" class="pull-right btn"><i class="icon-print2"></i> Print</a> -->
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>"  >
                    <thead>
                    <tr >
                        <th class="table-success">SN</th>
                        <th class="sortableHeading table-success" data-invoiceBy="OID">Total Unpaid Amount</th>
                        <th class="table-success">Remaining Balance</th>
                        <th class="table-success">Action</th>
                       
                            
                    </tr>
                    </thead>
                    
                    <tbody>
                        
                        <tr>
                            <td class="table-success">1</td>
                            <td class="table-success">
                            <?php if($allProductDetail['pprice'][0]['pprice']): ?>
                            <?php $sum=0; ?>
                            <?php foreach($allProductDetail['pprice'] as $aprice): ?>

                            <?php $sum+=$aprice['pprice']; ?>

                             
                            <?php endforeach; ?>
                            <?php echo e($unpaid['total1']-$sum); ?>

                            <?php else: ?>
                            <?php echo e(@$unpaid['total1']); ?>

                             <?php endif; ?>
                         </td>
                            <td class="table-success ">
                            <?php if($total_ramainging['total_amt']): ?>
                            <span class="gamount" ><?php echo e($total_ramainging['total_amt']); ?> </span>
                             <?php else: ?>
                             0.00
                             <?php endif; ?>
                            </td>

                            <td class="table-success">
                                <?php if($unpaid['total1']-$sum > 0): ?>

                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add Amount</button>
                                <?php endif; ?>
                            </td>
                            
                             
                        </tr>
                       
                         
                    </tbody>
                </table>
                <a href="javascript:void(0)" style="float:right" class="view_histroy ">View Paid Amount History</a>

                <a href="javascript:void(0)" style="float:left" class="bal_histroy ">View Remaining Balance History</a>
                
                <br>
                <br>
                <div class="r_data"></div>

                <br>
                <br>

                 <div class="t_data"></div>
                 <br>
                <br>
                <br>
 

<!-- //////////////////////////////////////////////////////////////// -->
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>" id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Invoice Id</th>
                        <th>Total Price</th>
                        <th>Paid amount</th>
                        <th>Unpaid amount</th>
                        <th>Issue Date</th>
                        <th>Due date</th>
                        <th>Due Expired</th>
                        <th>Status</th>
                        <th>Action</th>
                            
                    </tr> 
                    </thead>
                    
                    <tbody>
                         <?php
                       // echo '<pre>';print_r($allProductDetail['laser_total'][0]);die;

                         ?>
                         <?php $t=0; ?>
                        <?php foreach($allProductDetail['invoice'] as $k=>$alluser): ?>
                        <?php if(count($alluser)> 0): ?>
                          
                         <?php foreach($alluser as $allusers): ?>
                         <?php if($allProductDetail['total1'][$k] > 0): ?>
                          <?php
                       //echo '<pre>';print_r($allProductDetail['due_date'][$t]); 

                         ?>
                        <tr>
                            <td><?php echo e($k+1); ?></td>
                            <td><?php echo e(@$allusers['IID']); ?></td>
                             
                            <td class="productPrice_<?php echo e($k+1); ?>"><?php echo e(@$allProductDetail['total1'][$k]); ?></td>
                            <td class="paidPrice_<?php echo e($k+1); ?>"><?php echo e(@$allProductDetail['pprice'][$k]['pprice']); ?></td>
                            <td>
                            <?php if(!empty($allProductDetail['pprice'][$k]['pprice'])): ?>
                            <?php echo e($allProductDetail['total1'][$k]-$allProductDetail['pprice'][$k]['pprice']); ?>

                            <?php endif; ?>
                        <td><?php echo e(date('d/m/Y',strtotime($alluser[0]['created_at']))); ?></td>
                        <td><?php echo e(date('d/m/Y',strtotime($allProductDetail['due_date'][$t]))); ?></td>

                        <?php if(strtotime($allProductDetail['due_date'][$t]) < strtotime(date('Y-m-d H:i:s'))): ?>
                        <td><span class="label label-danger">DUE</span></td>
                        <?php else: ?>
                        <td></td>
                        <?php endif; ?>
                        </td>

                            <?php if(($allProductDetail['total1'][$k]-$allProductDetail['pprice'][$k]['pprice'])==0): ?>
                                <?php if($allProductDetail['total1'][$k] > 0): ?>
                                <td><label class="label label-success">Paid</label></td>
                                <?php else: ?>
                                <td><label class="label label-danger"></label></td>
                                <?php endif; ?>
                            <?php else: ?>
                            <?php if(@$allusers['status']==1): ?>
                            <td><label class="label label-success">Paid</label></td>
                            <?php elseif(@$allusers['status']==2): ?>
                            <td><label class="label label-danger">Unpaid</label></td>
                            <?php else: ?>
                            <td><label class="label label-danger">Cancelled</label></td>
                            <?php endif; ?>
                            <?php endif; ?>
                            
                            <td> 
                               
                                <form action="<?php echo e(sysUrl('single-amount')); ?>/<?php echo e(Request::segment(3)); ?>" class="paid_amt1_<?php echo e($k+1); ?>" style="display:none" method="post" id="form_<?php echo e($k+1); ?>">
                                <input type="number" name="paid_amt1" class="form-control up_<?php echo e($k+1); ?>" style="padding:16px;border-radius: 10px" placeholder="Amount.." required>
                                <input type="hidden" name="invoiceId" value="<?php echo e(@$allusers['IID']); ?>">
                                 
                                <input type="hidden" name="uid" value="<?php echo e(Request::segment(3)); ?>">
                                <button type="button" class="btn btn-success update" data1="<?php echo e(@$allusers['IID']); ?>" data="<?php echo e($k+1); ?>" style="float:right;margin-top:17px !important;">Update</button>
                               
                                </form>
                                <br>
                                <?php if($total_ramainging['total_amt'] > 0): ?>
                                <button type="button" class="btn btn-warning paid_button" data="<?php echo e($k+1); ?>" >Add Amount</button>
                                <?php endif; ?>
                                 
                                
                            </td>
                             
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                         <?php $t++; ?>
                        <?php endforeach; ?>

                    </tbody>
                </table>

                 
            </div>
            <div>
                 
            </div>
        </div>
    </div>
<div class="container">
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h1 class="modal-title">Add Amount</h1>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="container">
              <form action="<?php echo e(sysUrl('add-amount')); ?>/<?php echo e(Request::segment(3)); ?>" method="post">
                <div class="form-group jj">
                    <label>Add Amount</label>
                    <input type="number" name="add_amt" class="form-control" placeholder="Add Amount" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success kk" >Add Amount</button>
                </div>
              </form>
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
  
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
     <script>
        $(document).on('click','.hide_histroy',function(){
            $('.r_history').hide();

        });
        $(document).on('click','.hide_histroy1',function(){
            $('.r_history1').hide();

        });
        
         $(document).ready(function(){
            // view history data
            $('.view_histroy').click(function(){
                
                var id ="<?php echo Request::segment(3) ?>";
                $.ajax({
                        url:"<?php echo e(sysUrl('view_history')); ?>",
                        method:'POST',
                        data:{'_token':"<?php echo e(csrf_token()); ?>",'id':id},
                        success : function(res1){
                            $('.t_data').html(res1);
                            
                        }
                   }); 
               // $('.view_h').toggle();
            });

            // view all remaining balance history
             $('.bal_histroy').click(function(){
                
                var id ="<?php echo Request::segment(3) ?>";
                $.ajax({
                        url:"<?php echo e(sysUrl('rebal_history')); ?>",
                        method:'POST',
                        data:{'_token':"<?php echo e(csrf_token()); ?>",'id':id},
                        success : function(res2){
                            $('.r_data').html(res2);
                            
                        }
                   }); 
               // $('.view_h').toggle();
            });

            $('.update').click(function(){
                var id= $(this).attr('data');
                var data1= $(this).attr('data1');
                 
                var amt= $('.up_'+id).val();
                var ramount = $('.gamount').text();
                var productprice = $('.productPrice_'+id).text();
                var paidprice = $('.paidPrice_'+id).text();
                if(paidprice ==""){
                    var totalamt= parseInt(amt);   
                }else{
                    var totalamt= parseInt(paidprice) + parseInt(amt);
                }
                 

                // alert(totalamt);
                // alert(productprice);
                
                
                if(parseInt(ramount) >= parseInt(amt)){
                    $( "#form_"+id ).submit();
                    //alert('hey');
                }else{
                    if(amt==""){
                        alert('Please Enter Amount.');
                    return false;
                    }else{
                    alert('You have insufficient remaining balance,Please add remaining balance.')
                    return false;
                    }
                }

               if(totalamt != productprice){
                   if(totalamt > productprice){ 
                       alert('Please Enter Real Amount.');
                       return false;
                    }
                }else{
                   $.ajax({
                        url:"<?php echo e(sysUrl('changeStatus')); ?>",
                        method:'POST',
                        data:{'_token':"<?php echo e(csrf_token()); ?>",'invoiceID':data1},
                        success : function(res){
                            //alert(res);
                        }
                   }); 
                }
                

            });

            $('.paid_button').click(function(){
                var id= $(this).attr('data');
                $('.paid_amt1_'+id).toggle();
            });

            $(document).ready(function() {
                $('#example').DataTable();
            } );
        });
     </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>