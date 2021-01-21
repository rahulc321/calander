@extends('webpanel.layouts.base')
@section('title')
Add Newsletter
@parent
@stop
@section('body')
<?php error_reporting(0) ;
$eurConvert = App\Modules\Currencies\Currency::where('id','=',2)->first();
//echo '<pre>';print_r($eurConvert->conversion);
?>
 

    <style type="text/css">
        .cke_chrome {
            visibility: inherit;
            width: 595px !important;
        }
    </style>
    <div class="page-header">
        <div class="page-title">
            
            <h3>Add News Letter</h3>
           
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                @include('webpanel.includes.notifications')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h6 class="panel-title">Add News Letter</h6>
                        
                    </div>
                    <div class="panel-body">
                        <?php
                            
                                $url= sysUrl('add-newsletter');
                            

                        ?>
                        <form class="form-horizontal form" method="post"
                              action="{{$url}}"
                              role="form" data-result-container="#notificationArea">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                             

                            <div class="form-group">
                                <label class="col-md-2" for="subject">Email</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" id="txtName" name="email"  required="">
                                    <span id="lblError" style="color: red"></span>
                                </div>
                            </div>
 
                        <br>

                             
                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-6"  >
                                    <input type="submit" value="Submit" class="btn btn-success submit-btn dis addbtn" style="float:left" > 
                                    &nbsp;
                                    &nbsp;
                                    <a href=""  class="btn btn-danger submit-btn" style="float:left;margin-left: 10px" >Reset</a>
                                </div>
                               
                            </div>
 
                        </form>
                    </div>
                </div>
            </div>
          


        </div>
        <!--  <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script> -->
         <!--  <textarea name="editor1"></textarea> -->
  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
 
@endsection

