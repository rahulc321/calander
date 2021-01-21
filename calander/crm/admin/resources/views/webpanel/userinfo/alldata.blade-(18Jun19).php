 <?php error_reporting(0) ?>
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
                        
                        <tr>
                            <td class="table-success">1</td>
                            <td class="table-success">
                            @if($allProductDetail['pprice'][0]['pprice'])
                            <?php $sum=0; ?>
                            @foreach($allProductDetail['pprice'] as $aprice)

                            <?php $sum+=$aprice['pprice']; ?>

                             
                            @endforeach
                            {{$unpaid['total1']-$sum}}
                            @else
                            {{@$unpaid['total1']}}
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
                                @if($unpaid['total1']-$sum > 0)

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
                            
                    </tr> 
                    </thead>
                    
                    <tbody>
                         <?php
                       // echo '<pre>';print_r($allProductDetail['laser_total'][0]);die;

                         ?>
                         <?php $t=0; ?>
                        @foreach($allProductDetail['invoice'] as $k=>$alluser)
                        @if(count($alluser)> 0)
                          
                         @foreach($alluser as $allusers)
                         @if($allProductDetail['total1'][$k] > 0)
                          <?php
                       //echo '<pre>';print_r($allProductDetail['due_date'][$t]); 

                         ?>
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{@$allusers['IID']}}</td>
                             
                            <td class="productPrice_{{$k+1}}">{{@$allProductDetail['total1'][$k]}}</td>
                            <td class="paidPrice_{{$k+1}}">{{@$allProductDetail['pprice'][$k]['pprice']}}</td>
                            <td>
                            @if(!empty($allProductDetail['pprice'][$k]['pprice']))
                            {{$allProductDetail['total1'][$k]-$allProductDetail['pprice'][$k]['pprice']}}
                            @endif
                        <td>{{date('d/m/Y',strtotime($alluser[0]['created_at']))}}</td>
                        <td>{{date('d/m/Y',strtotime($allProductDetail['due_date'][$t]))}}</td>

                        @if(strtotime($allProductDetail['due_date'][$t]) < strtotime(date('Y-m-d H:i:s')))
                        <td><span class="label label-danger">DUE</span></td>
                        @else
                        <td></td>
                        @endif
                        </td>

                            @if(($allProductDetail['total1'][$k]-$allProductDetail['pprice'][$k]['pprice'])==0)
                                @if($allProductDetail['total1'][$k] > 0)
                                <td><label class="label label-success">Paid</label></td>
                                @else
                                <td><label class="label label-danger"></label></td>
                                @endif
                            @else
                            @if(@$allusers['status']==1)
                            <td><label class="label label-success">Paid</label></td>
                            @elseif(@$allusers['status']==2)
                            <td><label class="label label-danger">Unpaid</label></td>
                            @else
                            <td><label class="label label-danger">Cancelled</label></td>
                            @endif
                            @endif
                            
                            <td> 
                               
                                <form action="{{ sysUrl('single-amount') }}/{{Request::segment(3)}}" class="paid_amt1_{{$k+1}}" style="display:none" method="post" id="form_{{$k+1}}">
                                <input type="number" name="paid_amt1" class="form-control up_{{$k+1}}" style="padding:16px;border-radius: 10px" placeholder="Amount.." required>
                                <input type="hidden" name="invoiceId" value="{{@$allusers['IID']}}">
                                 
                                <input type="hidden" name="uid" value="{{Request::segment(3)}}">
                                <button type="button" class="btn btn-success update" data1="{{@$allusers['IID']}}" data="{{$k+1}}" style="float:right;margin-top:17px !important;">Update</button>
                               
                                </form>
                                <br>
                                @if($total_ramainging['total_amt'] > 0)
                                <button type="button" class="btn btn-warning paid_button" data="{{$k+1}}" >Add Amount</button>
                                @endif
                                 
                                
                            </td>
                             
                        </tr>
                        @endif
                        @endforeach
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
                        url:"{{ sysUrl('changeStatus') }}",
                        method:'POST',
                        data:{'_token':"{{ csrf_token() }}",'invoiceID':data1},
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
@stop