<?php $i = 1;
?>
<?php foreach($invoices as $k => $invoice): ?>
<?php if(@$_GET['status']=='due'){ 
        if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2'){

      
        ?>
    <tr>
        <td><?php echo e($k + 1); ?></td>
        <td>
            <a href="<?php echo e(sysRoute('orders.show', encryptIt(@$invoice->order->id))); ?>"><?php echo e($invoice->IID); ?></a>
        </td>
        <td><?php echo e(@$invoice->order->creator? $invoice->order->creator->fullName() : ''); ?></td>
        <td><?php echo e(@$invoice->createdDate('d/m/Y')); ?></td>
        <td><?php echo e(date("d/m/Y", strtotime(@$invoice->order->due_date))); ?></td>
        <td>
            <?php if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2'): ?>
                <span class="label label-danger">DUE</span>
            <?php endif; ?>
        </td>
        <td><?php echo @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status]; ?></td>
        <td align="right"><?php echo e(currency(@$invoice->order ? $invoice->order->getTotalPrice()  : 0)); ?></td>
        <?php if(auth()->user()->isSales() OR auth()->user()->isAdmin()): ?>
            <td>
                <?php echo e(@currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0))); ?>

            </td>
        <?php endif; ?>
        <?php if(auth()->user()->isAdmin()): ?>
            <td>
                <select class="toggleStatus"
                        data-url="<?php echo e(sysUrl('invoices/toggle-status/'.encryptIt($invoice->id))); ?>">
                    <?php foreach(\App\Modules\Invoices\Invoice::GetStatusAsArray() as $k => $status): ?>
                        <option value="<?php echo e($k); ?>"
                                <?php echo isSelected($k, $invoice->status); ?>><?php echo e($status); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        <?php endif; ?>

        <td>
            <a title="Download Invoice"
               href="<?php echo e(sysUrl('invoices/download/'.encryptIt($invoice->id))); ?>">
                <i class="icon-download"></i>
            </a>
        </td>

    </tr>
<?php }
}else{ ?>

    <tr>
        <td><?php echo e($k + 1); ?></td>
        <td>
            <a href="<?php echo e(sysRoute('orders.show', encryptIt(@$invoice->order->id))); ?>"><?php echo e($invoice->IID); ?></a>
        </td>
        <td><?php echo e(@$invoice->order->creator? $invoice->order->creator->fullName() : ''); ?></td>
        <td><?php echo e(@$invoice->createdDate('d/m/Y')); ?></td>
        <td> <a href="javascript:;" class="due_date" id="<?php echo e($invoice->IID); ?>" data='<?php echo e(date("Y-m-d", strtotime(@$invoice->order->due_date))); ?>' data-toggle="modal" data-target="#myModal"><?php echo e(date("d/m/Y", strtotime(@$invoice->order->due_date))); ?></a></td>
        <td>
            <?php if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2'): ?>
                <span class="label label-danger">DUE</span>
            <?php endif; ?>
        </td>
        <td><?php echo @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status]; ?></td>
        <td align="right"><?php echo e(currency(@$invoice->order ? $invoice->order->getTotalPrice()  : 0)); ?></td>
        <?php if(auth()->user()->isSales() OR auth()->user()->isAdmin()): ?>
            <td>
                <?php echo e(@currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0))); ?>

            </td>
        <?php endif; ?>
        <?php if(auth()->user()->isAdmin()): ?>
            <td>
                <select class="toggleStatus"
                        data-url="<?php echo e(sysUrl('invoices/toggle-status/'.encryptIt($invoice->id))); ?>">
                    <?php foreach(\App\Modules\Invoices\Invoice::GetStatusAsArray() as $k => $status): ?>
                        <option value="<?php echo e($k); ?>"
                                <?php echo isSelected($k, $invoice->status); ?>><?php echo e($status); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        <?php endif; ?>

        <td>
            <a title="Download Invoice"
               href="<?php echo e(sysUrl('invoices/download/'.encryptIt($invoice->id))); ?>">
                <i class="icon-download"></i>
            </a>
        </td>

    </tr>

<?php }


?>
    <?php $i++; ?>
<?php endforeach; ?>
<style type="text/css">
    input#my_date_picker {
    width: 314px;
}
.due-form {
    padding: 16px;
}
</style>
 
      
    <script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" > 
    </script> 
      
    <script src= 
"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" > 
    </script> 
<div class="container">
  
   

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Due Date</h4>
        </div>
            <div class="container">
                <div class="due-form">
                <div class="form-group">
                    <label>Change Date</label>
                    <input type="text" id="my_date_picker" class="form-control" >
                    <input type="hidden" class="invoiceId">
                </div>
                <div class="form-group">
                    
                    <button class="btn btn-success date-btn">Update Date</button>
                </div>

                <div class="form-group">
                   <p class="msg" style="display:none;color:green">You have Sussfully Updated Due Date</p>
                </div>
                </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

<script> 
        $(document).ready(function() {


            $('.due_date').click(function(){
                var thisValue= $(this).attr('data');
                var invoiceId= $(this).attr('id');

                $('.invoiceId').val(invoiceId);
                $('#my_date_picker').datepicker({dateFormat: 'yy-mm-dd'}).datepicker('setDate', thisValue);
            }); 

            $('.date-btn').click(function(){
                if (!confirm('Are you sure ?')) {
                    return false;


                }


                var Id= $('.invoiceId').val();
                var due_date= $('#my_date_picker').val();
                $.ajax({
                    url:"<?php echo e(url('/webpanel/update-due-date')); ?>",
                    method:'post',
                    data:{'_token':"<?php echo e(csrf_token()); ?>",'id':Id,'due_date':due_date},
                    success:function(res){
                        if(res==1){
                            $('.msg').show();


                        setTimeout(function(){
                        location.reload(true);
                         
                        }, 3000);

                        }
                    }
                });

            });
          
            
        }) 
    </script> 