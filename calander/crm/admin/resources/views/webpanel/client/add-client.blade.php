@extends('webpanel.layouts.base')
@section('title')
Edit Email
@parent
@stop
@section('body')
<?php error_reporting(0) ?>
    <style type="text/css">
        .cke_chrome {
            visibility: inherit;
            width: 595px !important;
        }
    </style>
    <div class="page-header">
        <div class="page-title">
            @if(!empty($client))
            <h3>Edit Future Client</h3>
            @else
            <h3>Add Future Client</h3>
            @endif
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                @include('webpanel.includes.notifications')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if(!empty($client))
                        <h6 class="panel-title">Edit Future Client</h6>
                        @else
                        <h6 class="panel-title">Add Future Client</h6>
                        @endif
                    </div>
                    <div class="panel-body">
                        <?php
                            if(!empty($client)){
                                $url= sysUrl('update-client');
                            }else{
                                $url= sysUrl('add-client');
                            }

                        ?>
                        <form class="form-horizontal " method="post"
                              action="{{$url}}"
                              role="form" data-result-container="#notificationArea">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                             

                            <div class="form-group">
                                <label class="col-md-2" for="subject">First Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="subject" name="first_name"  value="{{$client->first_name}}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="subject">Last Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="subject" name="last_name" value="{{$client->last_name}}">
                                </div>
                            </div>

                             <div class="form-group">
                                <label class="col-md-2" for="subject">Email </label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="subject" name="email" value="{{$client->email}}">
                                </div>
                            </div>
                            <!-- 23 Aug -->
                        <div class="form-group">
                            <label class="col-md-2">Show On Map:</label>
                            <div class="col-md-8">
                                <label class="radio-inline radio-success">
                                    <input type="radio" name="map_status" value="0"
                                             <?php echo isChecked(0, $client->map_status); ?> class="styled" checked>
                                    Hide
                                </label>

                                <label class="radio-inline radio-success">
                                    <input type="radio" name="map_status" value="1"
                                             <?php echo isChecked(1, $client->map_status); ?> class="styled">
                                    Show
                                </label>
                            </div>
                        </div>
                        <!-- 23 Aug -->
                        <br>

                            <div class="form-group">
                                <label class="col-md-2" for="message">Address</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="message" name="message" rows="10" required="">{{$client->address}}</textarea>
                                </div>
                            </div>
                            @if(!empty($client))
                            <input type="hidden" name="cid" value="{{$client->id}}">
                            @endif

                            @if(!empty($client))
                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-6">
                                    <input type="submit" value="Update" class="btn btn-warning submit-btn">
                                </div>
                            </div>
                            @else
                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-6">
                                    <input type="submit" value="Add Future Client" class="btn btn-success submit-btn">
                                </div>
                            </div>

                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--  <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script> -->
         <!--  <textarea name="editor1"></textarea> -->
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

@stop

