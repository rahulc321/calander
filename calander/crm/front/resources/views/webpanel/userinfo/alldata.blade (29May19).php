 <?php error_reporting(0) ?>
 @extends('webpanel.layouts.base')
@section('title')
Invoices
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
            <h3>All Product Detail</h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')
         

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
                            @if($allProductDetail['pprice'][0]['pprice'])
                            <?php $sum=0; ?>
                            @foreach($allProductDetail['pprice'] as $aprice)

                            <?php $sum+=$aprice['pprice']; ?>

                             
                            @endforeach
                            <span class="gamount">{{$allProductDetail['balance'][0]['total']-$sum}}</span>
                            @else

                            @if(!empty($allProductDetail['balance'][0]['total']))

                             <span class="gamount">{{@$allProductDetail['balance'][0]['total']}}</span>
                            @else
                           <span class="gamount"> 0.00</span>
                            @endif
                            @endif
                            </td>

                            <td class="table-success">
                                @if($unpaid['total1'] >0)

                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add Amount</button>
                                @endif
                            </td>
                            
                             
                        </tr>
                       
                         
                    </tbody>
                </table>
                <br>
                <br>
                <br>
<!-- //////////////////////////////////////////////////////////////// -->
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>" id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Product Name</th>
                        <th>Product Price</th>
                        <th>PAid amount</th>
                        <th>Unpaid amount</th>
                        <th>IID</th>
                        <th>Status</th>
                        <th>Action</th>
                            
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                        //echo '<pre>';print_r($allProductDetail['invoiceId']['IID']);die;

                         ?>

                        @foreach($allProductDetail['product'] as $k=>$alluser)
                        @if(count($alluser)> 0)
                         
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>{{@$alluser}}</td>
                             
                            <td class="productPrice_{{$k+1}}">{{@$allProductDetail['price'][$k]}}</td>
                            <td class="paidPrice_{{$k+1}}">{{@$allProductDetail['pprice'][$k]['pprice']}}</td>
                            <td>
                            @if(!empty($allProductDetail['pprice'][$k]['pprice']))
                            {{$allProductDetail['price'][$k]-$allProductDetail['pprice'][$k]['pprice']}}
                            @endif
                            <td>123</td>
                        </td>
                            @if($allProductDetail['price'][$k]-$allProductDetail['pprice'][$k]['pprice']==0)
                            <td><label class="label label-success">Paid</label></td>
                            @else
                            @if(@$allProductDetail['status'][$k]==1)
                            <td><label class="label label-success">Paid</label></td>
                            @elseif(@$allProductDetail['status'][$k]==2)
                            <td><label class="label label-danger">Unpaid</label></td>
                            @else
                            <td><label class="label label-danger">Cancelled</label></td>
                            @endif
                            @endif
                            
                            <td> 
                                @if($allProductDetail['balance'][0]['total']-$sum > 0)
                                <form action="{{ sysUrl('single-amount') }}/{{$allProductDetail['id'][0]}}" class="paid_amt1_{{$k+1}}" style="display:none" method="post" id="form_{{$k+1}}">
                                <input type="number" name="paid_amt1" class="form-control up_{{$k+1}}" style="padding:16px;border-radius: 10px" placeholder="Amount.." required>
                                <input type="hidden" name="variant_id" value="{{@$allProductDetail['variant_id'][$k]}}">
                                <input type="hidden" name="product_id" value="{{@$allProductDetail['product_id'][$k]}}">
                                <input type="hidden" name="uid" value="{{@$allProductDetail['id'][$k]}}">
                                <button type="button" class="btn btn-success update" data="{{$k+1}}" style="float:right;margin-top:17px !important;">Update</button>
                               
                                </form>
                                <br>
                                @if($allProductDetail['price'][$k]-$allProductDetail['pprice'][$k]['pprice']!=0)
                                <button type="button" class="btn btn-warning paid_button" data="{{$k+1}}" >Add Amount</button>
                                @endif
                                @endif
                            </td>
                             
                        </tr>
                        @endif
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
              <form action="{{ sysUrl('add-amount') }}/{{$allProductDetail['id'][0]}}" method="post">
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
         $(document).ready(function(){

            $('.update').click(function(){
                var id= $(this).attr('data');
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
                if(totalamt != productprice){
                   if(totalamt > productprice){ 
                       alert('Please Enter Product Price.');
                       return false;
                    }
                }else{
                   //alert(totalamt); 
                }
                
                if(parseInt(ramount) >= parseInt(amt)){
                    $( "#form_"+id ).submit();
                    //alert('hey');
                }else{
                    alert('You have insufficient remaining balance,Please add remaining balance.')
                    return false;
                }

                // if(amt > productPrice){
                //     alert('Please Enter Product Price.');
                //     return false;
                // }else{
                //     $( "#form" ).submit(); 
                // }
                

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