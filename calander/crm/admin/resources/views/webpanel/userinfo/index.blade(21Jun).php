<?php error_reporting(0); ?> 
@extends('webpanel.layouts.base')
@section('title')
All User Info
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
            <h3>All User Info</h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')
         

        <div class="hpanel">
            <div class="panel-body">
                <!-- <a href="{{ sysUrl('invoices/download-all/xl') }}?{{ http_build_query(Input::except('page')) }}" class="pull-right btn"><i class="icon-print2"></i> Print</a> -->
                <b>Total Unpaid => {{$userInfo['totalUnpaid']}}</b>
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>" id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Name</th>
                        <th>Email</th>
                        <th>Paid</th>
                        <th>Unpaid</th>
                        <th>Cancel</th>
                        <th>Total Amount</th>   
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                         //echo '<pre>';print_r($userInfo);die;

                         ?>
                         <?php $i=1; ?>
                        @foreach($userInfo['data'] as $k=>$alluser)
                        @if(!empty($userInfo['gtotal'][$k]))

                        <?php 
                            $invoiceStatus =$userInfo['status'][$paalluser['id']];
                        //echo '<pre>';print_r($userInfo['status'][$alluser['id']]);  ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td>
                                
                                <a href="{{ sysUrl('user-data') }}/{{$alluser['id']}}">{{@$alluser['full_name']}}</a>
                              
                            </td>
                            <td>{{@$alluser['email']}}</td>
                            <td>
                            @if($invoiceStatus !=1)
                            @if($userInfo['laser_price1'][$alluser['id']])
                            <!--  -->
                              <label class="label label-success">{{abs($userInfo['paid'][$k]['total']+$userInfo['laser_price1'][$alluser['id']])}}</label> 
                            @else
                            <label class="label label-success">{{@$userInfo['paid'][$k]['total']}}</label>

                            @endif
                            @else
                            <label class="label label-success">{{@$userInfo['paid'][$k]['total']}}</label>
                            @endif
                        </td>
                            <td>
                            @if($invoiceStatus !=1)
                            @if(!empty($userInfo['unpaid'][$k]))
                            
                            <label class="label label-warning">{{abs(@$userInfo['unpaid'][$k]-$userInfo['laser_price1'][$alluser['id']])}}</label>
                            @endif
                            @else
                                @if(!empty($userInfo['unpaid'][$k]))
                                <label class="label label-warning"> {{@$userInfo['unpaid'][$k]}}</label>
                                @endif
                            @endif

                        </td>
                            <td><label class="label label-danger">{{@$userInfo['cancel'][$k]}}</label></td>
                            <td>{{@$userInfo['gtotal'][$k]}}</td>
                        </tr>
                        <?php $i++; ?>
                        @endif
                        
                        @endforeach
                    </tbody>
                </table>

                 
            </div>
            <div>
                 
            </div>
        </div>
    </div>

@stop

@section('scripts')
     <script>
         $(document).ready(function(){
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        });
     </script>
@stop