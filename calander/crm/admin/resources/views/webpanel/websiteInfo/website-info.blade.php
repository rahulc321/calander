@extends('webpanel.layouts.base')
@section('title')
Update Website Info
@parent
@stop
@section('body')
<?php error_reporting(0); ?>
 <div class="page-header">
        <div class="page-title">
            <h3>Update Website Info</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        @include('webpanel.includes.notifications')

        <div class="panel panel-default">
           <!--  <div class="panel-heading">
                <h6 class="panel-title">Update Email Template</h6>
            </div> -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" data-request-url="">
                        <thead>
                        <tr>
                            <th>SN</th>
                            <th>Subject</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        	<?php $i=1;?>

                        @foreach($data as $value)
                        <form action="{{sysUrl('website_info')}}" method="post">
                        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <tr>
                             <td>{{$i}}</td>
                             <td><label>{{$value->info_type}}:</label><input type="text" value="{{$value->info}}" name="info" class="form-control"></td>
                             <input type="hidden" name="info_id" value="{{$value->id}}">
                             <td> <input type="submit" value="Update" class="btn btn-success">       
                             </td>
                            </tr>
                            </form>
                            <?php
                                if($i==6){
                                    break;
                                }
                             $i++;?>                           
                        @endforeach
                        </tbody>
                    </table>
                </div>
        </div>
            </div>
    </div>

<!-- Update address -->
   <div class="row">
            <div class="col-lg-12">
              @if(@$success1)
       <div id="notificationArea">
           <div class="alert alert-success">
              {{@$success1}} 
           </div>
       </div>
       @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h6 class="panel-title">Update Address</h6>
                    </div>
                    <div class="panel-body">
                        <form action="{{sysUrl('website_info')}}" class="form-horizontal" method="post" role="form" data-result-container="#notificationArea">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="put">

                           <!--  <div class="form-group">
                                <label class="col-md-2" for="subject">Subject:</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="subject" name="subject" value="{{ $email->subject }}">
                                </div>
                            </div>
 -->
                            <div class="form-group">
                                <label class="col-md-2" for="message">Edit Address:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="message" name="info" rows="10">{{$data[6]->info}}</textarea>
                                </div>
                                
                            </div>
                            <input type="hidden" name="info_id" value="{{$data[6]->id}}">
                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-6">
                                    <input type="submit" value="Update" class="btn btn-success">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Update address -->
         <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
         
@stop

@section('scripts')
        <script>
        CKEDITOR.replace( 'message' );
        </script>

    <script>
        (function ($, window, document, undefined) {
            $(function () {


            });

        })(jQuery, window, document);
    </script>

    <script>
        (function ($, window, document, undefined) {
            $(function () {
            });

        })(jQuery, window, document);
    </script>
@stop