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
         
        <a href="add-coupon" class="btn btn-success" style="float:right">Add New Coupon</a>
        </br>
        </br>
        <div class="hpanel">
            <div class="panel-body">
                
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                        id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Name</th>
                        <th>Valid From</th>
                        <th>Valid to</th>
                        <th>Uses</th>
                        <th>Coupon Type</th>
                        <th>Coupon Amt</th>
                        <th>Create Date</th>      
                        <th>Action</th>   
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                         //echo '<pre>';print_r($userInfo);die;

                         ?>
                         <?php $i=1; ?>
                        @foreach($coupons as $coupon)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$coupon->coupon_code}}</td>
                            <td>{{$coupon->start_date}}</td>
                            <td>{{$coupon->end_date}}</td>
                            <td>{{$coupon->uses}}</td>
                            <td>{{$coupon->cupon_type}}</td>
                            <td>{{$coupon->price}}</td>
                            <td>{{$coupon->created_at}}</td>
                             
                            <td><a href="{{url('/webpanel/coupon-edit')}}/{{$coupon->id}}" class="btn btn-success">Edit</a>

                            <a href="{{url('/webpanel/delete-coupon')}}/{{$coupon->id}}" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a></td>
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