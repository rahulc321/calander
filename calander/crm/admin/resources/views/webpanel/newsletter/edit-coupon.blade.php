@extends('webpanel.layouts.base')
@section('title')
Edit Coupon
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
            
            <h3>Edit Coupon</h3>
           
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                @include('webpanel.includes.notifications')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h6 class="panel-title">Edit Coupon</h6>
                        
                    </div>
                    <div class="panel-body">
                        <?php
                            
                                $url= sysUrl('update-coupon');
                            

                        ?>
                        <form class="form-horizontal " method="post"
                              action="{{$url}}/{{$edit->id}}"
                              role="form" data-result-container="#notificationArea">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                             

                            <div class="form-group">
                                <label class="col-md-2" for="subject">Coupon Coode</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="txtName" name="coupon_code" readonly="" required="" value="{{$edit->coupon_code}}">
                                    <span id="lblError" style="color: red"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="subject">Valid From</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="from" name="from"  value="{{$edit->start_date}}" >
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="subject">Valid to</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="to" name="to" value="{{$edit->end_date}}" >
                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2" for="subject">Uses</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="uses" name="uses" value="{{$edit->uses}}" >
                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="subject">Coupon Type</label>
                                <div class="col-md-6">
                                    <select name="ctype" class="form-control ctype">
                                      <option value="">Select</option>
                                      <option value="fixed" @if($edit->cupon_type=="fixed") {{'selected'}}@endif>Fixed Amount</option>
                                      <option value="percent" @if($edit->cupon_type=="percent") {{'selected'}}@endif>Percent</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="form-group fix" style="display:none">
                                <label class="col-md-2" for="subject">Fixed Amount</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control fixamt" id="fixamt" name="famount" value="{{$edit->price}}"  >
                                    <span class="lblError" style="color: red"></span>
                                    
                                </div>
                            </div>
                             <div class="form-group percent" style="display:none">
                                <label class="col-md-2" for="subject">Percent (between 1 and 100)</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control fixamt" id="percent" name="percent" value="{{$edit->price}}"  >
                                    <span class="error1 lblError" style="color: red"></span>
                                    
                                </div>
                            </div>

                             
                            <!-- 23 Aug -->
                        
                        <!-- 23 Aug -->
                        <br>

                             
                            <div class="form-group">
                                <label class="col-sm-2">&nbsp;</label>
                                <div class="col-sm-6"  >
                                    <input type="submit" value="Update Coupon" class="btn btn-success submit-btn dis" style="float:left" > 
                                    &nbsp;
                                    &nbsp;
                                    <a href="{{url('/webpanel/coupons')}}"  class="btn btn-danger submit-btn" style="float:left;margin-left: 10px" >Back</a>
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
    
<script type="text/javascript">


  document.getElementById("percent").onkeyup = function() {
  var input = parseInt(this.value);
  if (input < 1 || input > 100){
    $('.error1').html("Value should be between 1 - 100");
    $('.dis').prop('disabled',true);
    return;
    
  }
   else{
    $('.error1').html('');
    $('.dis').prop('disabled',false);
    return;
   }
}



    $(function () {
    
      $('.ctype').change(function(){
        var ctype = $(this).children("option:selected").val();


        if(ctype=='fixed'){
          $('.fix').show();
          $('.percent').hide();
        }else if(ctype=='percent'){
          $('.percent').show();
          $('.fix').hide();

        }else{
          $('.percent').hide();
          $('.fix').hide();
        }
      });



       var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
           minDate: 0,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        minDate: 0,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }





      jQuery.noConflict();
        $("#txtName").keypress(function (e) {
            var keyCode = e.keyCode || e.which;
 
            $("#lblError").html("");
 
            //Regex for Valid Characters i.e. Alphabets and Numbers.
            var regex = /^[A-Za-z0-9]+$/;
 
            //Validate TextBox value against the Regex.
            var isValid = regex.test(String.fromCharCode(keyCode));
            if (!isValid) {
                $("#lblError").html("Only Alphabets and Numbers allowed.");
            }
 
            return isValid;
        });


    });

    $(document).ready(function () {


      var ctype="{{$edit->cupon_type}}";
      if(ctype=='fixed'){
        $('.fix').show();
        $('.percent').hide();
      }else if(ctype=='percent'){
        $('.fix').hide();
        $('.percent').show();
      }else{
        $('.fix').hide();
        $('.percent').hide();
      }


  //called when key is pressed in textbox
  $(".fixamt").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $(".lblError").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });

  $('.alert').delay(2000).fadeOut('slow');
});
</script>
@endsection

