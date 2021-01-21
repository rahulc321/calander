 <!-- <?php error_reporting(0) ?> -->
 @extends('webpanel.layouts.base')
@section('title')
User Info
@parent
@stop
@section('body')
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
textarea#comment {
    width: 50% !important;
    padding: 14px !important;
    margin-left: 6px !important;
}
</style>
    <div class="page-header">
        <div class="page-title">
            <h3>All Unpaid Invoice Detail</h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')
         <div class="message">
        @if(\Session::has('addamount'))
        <p class="alert alert-info">{{ Session::get('addamount') }}</p>
        @elseif(\Session::has('paidamount'))
        <p class="alert alert-info">{{ Session::get('paidamount') }}</p>
        @elseif(\Session::has('sendemail'))
        <p class="alert alert-info">{{ Session::get('sendemail') }}</p>
        @endif
         </div>
        <div class="hpanel">
            <div class="panel-body">
                <!-- <a href="{{ sysUrl('invoices/download-all/xl') }}?{{ http_build_query(Input::except('page')) }}" class="pull-right btn"><i class="icon-print2"></i> Print</a> -->
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
                        <?php
                        $sum=0;
                        foreach($lprice['laserPrice'] as $laserPrice){
                            $sum+=$laserPrice['lPrice']; 
                        }

                        ?>
                        <tr>
                            <td class="table-success">1</td>
                            <td class="table-success">
                            @if($sum)
                            

                            {{$unpaid-$sum}}
                            @else
                            {{@$unpaid}}
                             @endif
                         </td>
                            <td class="table-success ">
                            @if($total_ramainging['total_amt'])
                            <span class="gamount" >{{$total_ramainging['total_amt']}} </span>
                             @else
                             0.00
                             @endif
                            </td>

                            <td class="table-success">
                                @if($unpaid > 0)

                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add Amount</button>
                                @endif
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
                        <th>Send Mail</th>
                            
                    </tr> 
                    </thead>
                    
                    <tbody>
                        
                         <?php $t=0; ?>
                        @foreach($allProductDetail as $k=>$alluser)
                        @if(count($alluser)> 0)

                         <?php
                         $due_date= Carbon\Carbon::parse($alluser->due_date)->format('Y-m-d');  
                        $totalLaserPrice= $lprice['laserPrice'][$t]['lPrice'];

                      $totalProductTax= ($alluser->price+$alluser->shipping_price)*$alluser->tax_percent/100; 
                         ?>
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{@$alluser->IID}}</td>
                             
                            <td class="productPrice_{{$k+1}}">{{$alluser->price+$alluser->shipping_price+$totalProductTax}}</td>
                            <td class="paidPrice_{{$k+1}}">{{$totalLaserPrice}}</td>
                            <td class="unpaidPrice_{{$k+1}}">
                            @if(!empty($totalLaserPrice))

                            {{($alluser->price+$alluser->shipping_price+$totalProductTax)-$totalLaserPrice}}
                            @endif
                            </td>
                        <td>{{date('d/m/Y',strtotime($alluser->issue_date))}}</td>
                        <td>{{date('d/m/Y',strtotime($due_date))}}</td>

                        @if(strtotime($due_date) < strtotime(date('Y-m-d H:i:s')))
                        <td><span class="label label-danger">DUE</span></td>
                        @else
                        <td></td>
                        @endif
                        </td>
                        <td>
                            <label class="label label-danger">Unpaid</label>
                        </td>
                            <td> 
                               
                                <form action="{{ sysUrl('single-amount') }}/{{Request::segment(3)}}" class="paid_amt1_{{$k+1}}" style="display:none" method="post" id="form_{{$k+1}}">
                                <input type="number" name="paid_amt1" class="form-control up_{{$k+1}}" style="border-radius: 10px" placeholder="Amount.." required>
                                <input type="hidden" name="invoiceId" value="{{@$alluser->IID}}">
                                 
                                <input type="hidden" name="uid" value="{{Request::segment(3)}}">
                                <button type="button" class="btn btn-success update" data1="{{@$alluser->IID}}" data="{{$k+1}}" style="float:right;margin-top:17px !important;">Update</button>
                               
                                </form>
                                <br>
                                @if($total_ramainging['total_amt'] > 0)
                                <button type="button" class="btn btn-warning paid_button hd_{{$k+1}}" data="{{$k+1}}" >Add Amount</button>
                                @endif
                                 
                                
                            </td>
                             <td>@if($totalLaserPrice > 0)
                                <button type="button" class="btn btn-success sendMail" data="{{$k+1}}" data-toggle="modal" data-target="#myModal2" data1="{{$alluser->id}}" data2="{{$alluser->IID}}">Send Mail</button>
                                @endif
                             </td>
                        </tr>
                         
                        @endif
                         <?php $t++; ?>
                        @endforeach

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
              <form action="{{ sysUrl('add-amount') }}/{{Request::segment(3)}}" method="post">
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

<!-- second model -->
<div class="container">
  <div class="modal" id="myModal2">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h1 class="modal-title">Send Mail</h1>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
          <div class="container">
              <form action="{{ sysUrl('send-email') }}/{{Request::segment(3)}}" method="post">
                <div class="form-group">
                    <h2 class="totalPrice"></h2>
                    <h2 class="paidP"></h2>
                    <h2 class="uPaidP"></h2>
                    
                </div>
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea class="form-control" name="sendtext" rows="5" id="comment"></textarea>
                </div>
                <!-- hidden field -->
                <input type="hidden" name="paidPrice1" class="paidPrice1">
                <input type="hidden" name="uPaidPrice1" id="uPaidPrice1">
                <input type="hidden" name="userId" class="userId" value="<?= Request::segment(3)?>">
                <input type="hidden" name="invoiceId" class="invoiceId1">
                <input type="hidden" name="IID" class="IID">

                <div class="form-group">
                    <button type="submit" class="btn btn-success kk" >Send</button>
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
@stop

@section('scripts')
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
                        url:"{{ sysUrl('view_history') }}",
                        method:'POST',
                        data:{'_token':"{{ csrf_token() }}",'id':id},
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
                        url:"{{ sysUrl('rebal_history') }}",
                        method:'POST',
                        data:{'_token':"{{ csrf_token() }}",'id':id},
                        success : function(res2){
                            $('.r_data').html(res2);
                            
                        }
                   }); 
               // $('.view_h').toggle();
            });

            $('.update').click(function(){
               /* var id= $(this).attr('data');
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
                        url:"{{ sysUrl('changeStatus') }}",
                        method:'POST',
                        data:{'_token':"{{ csrf_token() }}",'invoiceID':data1},
                        success : function(res){
                            //alert(res);
                        }
                   }); 
                }*/
                var id= $(this).attr('data');
                var data1= $(this).attr('data1');
                 
                var amt= $('.up_'+id).val();
                var ramount = $('.gamount').text();
                var productprice = $('.productPrice_'+id).text();
                var paidprice = $('.paidPrice_'+id).text();
                if(paidprice ==""){
                    var totalamt= amt;   
                }else{
                    var totalamt= parseFloat(paidprice) + parseFloat(amt);
                }
                 

               //alert(totalamt);
                // alert(productprice);
                
                
                if(parseInt(ramount) < parseInt(amt)){
                    // $( "#form_"+id ).submit();
                    //alert('hey');
                     alert('You have insufficient remaining balance,Please add remaining balance.')
                    return false;
                }else if(amt==""){
                     
                        alert('Please Enter Amount.');
                    return false;
                    
                     
                }else if(totalamt < productprice){
                   if(totalamt > productprice){ 
                       alert('Please Enter Real Amount.');
                       return false;
                    }else{
                        $( "#form_"+id ).submit();
                        //alert('submit');
                    }
                }else{
                   $.ajax({
                        url:"{{ sysUrl('changeStatus') }}",
                        method:'POST',
                        data:{'_token':"{{ csrf_token() }}",'invoiceID':data1},
                        success : function(res){
                            //alert(res);
                            location.reload();
                        }
                   }); 
                   //alert('Your Upaid amount left 0');
                }

            });

            $('.paid_button').click(function(){
                var id= $(this).attr('data');
                $('.paid_amt1_'+id).toggle();
                $('.hd_'+id).toggle();
            });

            $(document).ready(function() {
                $('#example').DataTable();
            } );

            // after click send mail
            $('.sendMail').click(function(){
                var id = $(this).attr('data');
                var invoiceID = $(this).attr('data1');
                var IID = $(this).attr('data2');
                var totalPrice= $('.productPrice_'+id).text();
                var paidPrice= $('.paidPrice_'+id).text();
                var unPaidPrice= $('.unpaidPrice_'+id).text();

                $('.invoiceId1').val(invoiceID); 
                $('.IID').val(IID); 
                // put value in hidden field
                $('.paidPrice1').val(paidPrice);
                $('#uPaidPrice1').val($.trim(unPaidPrice));
                // show value on popup
                $('.totalPrice').html('Total Amount : '+totalPrice).css('color','green');
                $('.paidP').html('Paid Amount : '+paidPrice).css('color','#e48561');
                $('.uPaidP').html('Left Amount : '+unPaidPrice).css('color','red');
               
            });

        });
     </script>
@stop