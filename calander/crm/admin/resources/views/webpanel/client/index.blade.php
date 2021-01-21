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
            <h3>Future Clients</h3>
        </div>
    </div>

    <div class="content">
        @include('webpanel.includes.notifications')
         
        <a href="add-client" class="btn btn-success" style="float:right">Add Future Client</a>
        </br>
        </br>
        <div class="hpanel">
            <div class="panel-body">
                
                <table class="table table-bordered  table-binvoiceed deleteArena table-striped"
                       data-request-url="<?php echo route('webpanel.invoices.index'); ?>" id="example">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th class="sortableHeading" data-invoiceBy="OID">Name</th>
                        <th>Email</th>
                        <th>Address</th>   
                        <th>Latitude</th>   
                        <th>Longitude</th>   
                        <th>Action</th>   
                    </tr>
                    </thead>
                    
                    <tbody>
                         <?php
                         //echo '<pre>';print_r($userInfo);die;

                         ?>
                         <?php $i=1; ?>
                        @foreach($clent as $alluser)
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$alluser->first_name.' '.$alluser->last_name}}</td>
                            <td>{{$alluser->email}}</td>
                            <td>{{$alluser->address}}</td>
                            <td>{{$alluser->lat}}</td>
                            <td>{{$alluser->lng}}</td>
                            <td><a href="{{url('/webpanel/clien-edit')}}/{{$alluser->id}}" class="btn btn-success">Edit</a>

                            <a href="{{url('/webpanel/delete')}}/{{$alluser->id}}" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a></td>
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
         $(document).ready(function(){
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        });
     </script>
@stop