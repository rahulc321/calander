<?php error_reporting(0); ?> 
@extends('webpanel.layouts.base')
@section('title')
Enquiry
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


</style>
    <div class="page-header">
        <div class="page-title">
            <h3>All Enquiry</h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')
         

        <div class="hpanel">
            <div class="panel-body">
                <!-- <a href="{{ sysUrl('invoices/download-all/xl') }}?{{ http_build_query(Input::except('page')) }}" class="pull-right btn"><i class="icon-print2"></i> Print</a> -->
                 
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
                          
                        @foreach($enquiry as  $allEnquiry)

                        
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$allEnquiry->first_name.' '.$allEnquiry->last_name}}</td>
                            <td>{{$allEnquiry->email}}</td>
                            <td>{{$allEnquiry->contact}}</td>
                            <td>{{$allEnquiry->product_name}}</td>
                            <td><p style="line-height:1.2em;
  height:3.6em;
  overflow:hidden;">
     <a href="javascript:;" data-toggle="modal" message="{!!$allEnquiry->message!!}" data-target="#myModal" class="msg1"> {!!$allEnquiry->message!!}</a>
</p>

</td>
                            <td>{{$allEnquiry->created_at}}</td>
                             
                             
                        </tr>
                       
                         
                        
                        @endforeach
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
@stop

@section('scripts')
     <script>
          
            $(document).ready(function() {
                $('.msg1').click(function(){
                    var msg= $(this).attr('message');
                     $('.message').html(msg);
                });


                $('#example').DataTable();
            } );
        
     </script>
@stop