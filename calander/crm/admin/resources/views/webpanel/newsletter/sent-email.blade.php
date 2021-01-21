@extends('webpanel.layouts.base')
@section('title')
Sent Newsletter
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
            
            <h3>Send Email</h3>
           
        </div>
    </div>

        <div class="row">
            <div class="col-lg-12">
                @include('webpanel.includes.notifications')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                        <h6 class="panel-title">Send Email</h6>
                        
                    </div>
                    <div class="panel-body">
                        <?php
                            
                                $url= sysUrl('sent-emailto');
                            

                        ?>
                        <form class="form-horizontal form" method="post"
                              action="{{$url}}"
                              role="form" data-result-container="#notificationArea">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                             

                            <div class="form-group">
                                <label class="col-md-2" for="subject">Template {{Input::old('template')}}</label>
                                <div class="col-md-6">
                                    <select name="template"   required class="form-control template">
                                        <option value="">Select template</option>
                                        @foreach($templates as $key=>$template)
                                        <option  value="{{$template->id}}" data="{{url('/')}}/newsletter/{{$template->image}}">Template {{$key+1}}</option>
                                        @endforeach
                                        
                                    </select>
                                    <br><br>
                                    <div class="img">
                                    
                                  </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2" for="message">Message:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="message" name="message" rows="10" required>{{ $email->message }}</textarea>
                                </div>
                            </div>
 
                         <div class="form-group">
                                <label class="col-md-2" for="subject">All Newsletter Users</label>
                                <div class="col-md-6">
                                     <select name="email[]" class="multiselect form-control" multiple="multiple">
        
                                     </select>
                                    
                                  </div>
                        </div>
                             
 
                             
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
  


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script type="text/javascript">
    $(function() {
        var dataAll= [];
    <?php
        foreach($newsletter as $key => $data) {?>
            dataAll.push( {
                    id: "<?php echo $data['id']; ?>",
                    email: "<?php echo $data['email'];?>"
                   
            });
    <?php } 
    ?>

     
   
  var name = ['joe', 'mary', 'rose'];
  $.each(dataAll, function (x) {
    // console.log(dataAll[x]['id']);
    return $('.multiselect').append("<option value="+dataAll[x]['id']+">" + dataAll[x]['email'] + "</option>");
  });
  
  $('.multiselect')
    .multiselect({
      allSelectedText: 'All',
      maxHeight: 200,
      includeSelectAllOption: true
    })
    .multiselect('selectAll', false)
    .multiselect('updateButtonText');
});
</script>


 <script>

        // Material Select Initialization
        $(document).ready(function() {
            $('.template').change(function(){
                var img = $('option:selected', this).attr('data');
                 
                $('.img').html('<img src='+img+'  style="width: 474px;height: 337px;" >')
            });

            CKEDITOR.replace( 'message' );
        });


        
        </script>
@endsection

