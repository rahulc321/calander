<?php error_reporting(0); ?> 
@extends('webpanel.layouts.base')
@section('title')
All Coupons
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
            <h3>All Coupons</h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')
         
        <a href="add-newsletter" class="btn btn-success" style="float:right">Add New User</a>
        </br>
        </br>
        <div class="hpanel">
            <div class="panel-body">
                
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                        id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Email</th>
                        <th>User Type</th>
                        <th>Subscription Type</th>
                        <th>Create Date</th>      
                        <th>Action</th>   
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                         //echo '<pre>';print_r($userInfo);die;

                         ?>
                         <?php $i=1; ?>
                        @foreach($newsletter as $letter)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$letter->email}}</td>
                            <td>
                                @if($letter->is_client==0)
                                <button class="btn btn-warning">Other User</button>
                                @else
                                <button class="btn btn-success">Our User</button>
                                @endif
                            </td>
                            <td> 
                                @if($letter->subscription_type==2)
                                <button class="btn btn-warning">Unsubscribe</button>
                                @elseif($letter->subscription_type==1)
                                <button class="btn btn-success">Subscribe</button>
                                @endif
                            </td>
                             
                            <td>{{$letter->created_at}}</td>
                             
                            <td><!-- <a href="{{url('/webpanel/coupon-edit')}}/{{$letter->id}}" class="btn btn-success">Edit</a> -->
                             @if($letter->subscription_type==2)
                               <a href="{{url('/webpanel/unsubscribe')}}/{{$letter->id}}" class="btn btn-success" onclick="return confirm('Are you sure you want to subscribe this user?')">Subscribe</a></td>
                                @elseif($letter->subscription_type==1)
                                <a href="{{url('/webpanel/unsubscribe')}}/{{$letter->id}}" class="btn btn-warning" onclick="return confirm('Are you sure you want to unsubscribe this user?')">Unsubscribe</a></td>
                                @endif
                            
                        </tr>
                        <?php $i++; ?>
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
         
            $(document).ready(function() {
                $('#example').DataTable();
                $('.alert').delay(2000).fadeOut('slow');
            } );
      
     </script>
@stop