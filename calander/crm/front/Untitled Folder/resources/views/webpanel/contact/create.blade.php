@extends('webpanel.layouts.base')
@section('title')
Contact Us
@parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Contact Us</h3>
        </div>
    </div>

    <div class="content">
        @if(!empty($success_message)) 
        <div class="success_message">{{$success_message}}</div>
        @endif
        <br>
        <form method="post" action="{{ url('webpanel/contact') }}" >

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h6 class="panel-title">Contact Us</h6>
                </div>

                <div class="panel-body">

                
                    <!-- <div class="form-group">
                        <label class="" for="user_id">Name :</label>
                        <input type="text" name="fname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="" for="user_id">Email :</label>
                        <input type="email" name="email" class="form-control">
                    </div> -->
                    <div class="form-group">
                        <label class="" for="user_id">Message :</label>
                         <textarea class="form-control" rows="5" id="comment" name="message" required></textarea>
                    </div>
                

                
                    </div>
            </div>
                
                <br/>
                <button type="submit" class="btn btn-success">Send Email </button>
        </form>
    </div>
<style>
.panel-body {
    padding: 26px !important;
}
.success_message {
    background-color: #8ac78a;
    padding: 12px;
    font-size: 17px;
    color: white;
    text-align: center;
    /* padding-bottom: 10px; */
}
</style>
@stop


@section('scripts')
    

@stop