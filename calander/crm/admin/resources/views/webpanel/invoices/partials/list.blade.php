<?php $i = 1;
?>
@foreach($invoices as $k => $invoice)
<?php if(@$_GET['status']=='due'){ 
        if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2'){

      
        ?>
    <tr>
        <td>{{ $k + 1  }}</td>
        <td>
            <a href="{{ sysRoute('orders.show', encryptIt(@$invoice->order->id)) }}">{{ $invoice->IID }}</a>
        </td>
        <td>{{ @$invoice->order->creator? $invoice->order->creator->fullName() : '' }}</td>
        <td>{{ @$invoice->createdDate('d/m/Y') }}</td>
        <td>{{ date("d/m/Y", strtotime(@$invoice->order->due_date)) }}</td>
        <td>
            @if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2')
                <span class="label label-danger">DUE</span>
            @endif
        </td>
        <td>{!! @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status] !!}</td>
        <td align="right">{{ currency(@$invoice->order ? $invoice->order->getTotalPrice()  : 0) }}</td>
        @if(auth()->user()->isSales() OR auth()->user()->isAdmin())
            <td>
                {{ @currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0)) }}
            </td>
        @endif
        @if(auth()->user()->isAdmin())
            <td>
                <select class="toggleStatus"
                        data-url="{{ sysUrl('invoices/toggle-status/'.encryptIt($invoice->id)) }}">
                    @foreach(\App\Modules\Invoices\Invoice::GetStatusAsArray() as $k => $status)
                        <option value="{{ $k }}"
                                {!! isSelected($k, $invoice->status) !!}>{{ $status }}</option>
                    @endforeach
                </select>
            </td>
        @endif

        <td>
            <a title="Download Invoice"
               href="{{ sysUrl('invoices/download/'.encryptIt($invoice->id)) }}">
                <i class="icon-download"></i>
            </a>
        </td>

    </tr>
<?php }
}else{ ?>

    <tr>
        <td>{{ $k + 1  }}</td>
        <td>
            <a href="{{ sysRoute('orders.show', encryptIt(@$invoice->order->id)) }}">{{ $invoice->IID }}</a>
        </td>
        <td>{{ @$invoice->order->creator? $invoice->order->creator->fullName() : '' }}</td>
        <td>{{ @$invoice->createdDate('d/m/Y') }}</td>
        <td> <a href="javascript:;" class="due_date" id="{{$invoice->IID}}" data='{{ date("Y-m-d", strtotime(@$invoice->order->due_date)) }}' data-toggle="modal" data-target="#myModal">{{ date("d/m/Y", strtotime(@$invoice->order->due_date)) }}</a></td>
        <td>
            @if(strtotime(date("Y-m-d")) > strtotime(@$invoice->order->due_date) && $invoice->status == '2')
                <span class="label label-danger">DUE</span>
            @endif
        </td>
        <td>{!! @\App\Modules\Invoices\Invoice::$statusLabel[$invoice->status] !!}</td>
        <td align="right">{{ currency(@$invoice->order ? $invoice->order->getTotalPrice()  : 0) }}</td>
        @if(auth()->user()->isSales() OR auth()->user()->isAdmin())
            <td>
                {{ @currency(percentOf($invoice->order->salesPerson->commission, @$invoice->order ? $invoice->order->getTotalWithoutShipping() : 0)) }}
            </td>
        @endif
        @if(auth()->user()->isAdmin())
            <td>
                <select class="toggleStatus"
                        data-url="{{ sysUrl('invoices/toggle-status/'.encryptIt($invoice->id)) }}">
                    @foreach(\App\Modules\Invoices\Invoice::GetStatusAsArray() as $k => $status)
                        <option value="{{ $k }}"
                                {!! isSelected($k, $invoice->status) !!}>{{ $status }}</option>
                    @endforeach
                </select>
            </td>
        @endif

        <td>
            <a title="Download Invoice"
               href="{{ sysUrl('invoices/download/'.encryptIt($invoice->id)) }}">
                <i class="icon-download"></i>
            </a>
        </td>

    </tr>

<?php }


?>
    <?php $i++; ?>
@endforeach
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
                    url:"{{url('/webpanel/update-due-date')}}",
                    method:'post',
                    data:{'_token':"{{csrf_token()}}",'id':Id,'due_date':due_date},
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