@extends('webpanel.layouts.front-layout')
@section('content')
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active"><a href="{{url('/order-history')}}">Order History</a></li>
				<li class="active">Edit Profile</li>
			</ol>
		</div>
	</div>
	
 <div class="container">
    
  	<hr>
	<div class="row">
      <!-- left column -->
     
      
      <!-- edit form column -->
      <div class="col-md-12 personal-info">

      	@if(Session::has('message'))
 

        <div class="alert alert-success alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>{{ Session::get('message') }}
        </div>
        @endif
        <h3>Personal info</h3>
        <?php
        //echo '<pre>';print_r($editProfile);
        ?>
        <form class="form-horizontal" role="form" action="{{url('/update-profile')}}" method="post">
          <div class="form-group">
            <label class="col-lg-3 control-label">Name:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="{{$editProfile['full_name']}}" name="fname">
            </div>
          </div>
           
          
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="{{$editProfile->email}}" name="email">
            </div>
          </div>

           
          <div class="form-group">
            <label class="col-lg-3 control-label">Phone:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="{{$editProfile->phone}}" name="phone">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Address:</label>
            <div class="col-lg-8">
              <textarea rows="4" cols="44" placeholder="Address" name="address" class="form-control" spellcheck="false">{{$editProfile->address}}</textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">City:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="{{$editProfile->city}}" name="city">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Country:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="{{$editProfile->country}}" name="country">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Zipcode:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" value="{{$editProfile->zipcode}}" name="zipcode">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Currency:</label>
            <div class="col-lg-8">
			<select class="form-control lazySelector" id="currency_id" name="currency_id" required="" aria-required="true">
				<!--<option value="">Choose Currency</option>-->
				<!--<option value="1" <?php if($editProfile->currency_id==1){ echo 'selected'; } ?>>Danish Krone</option>-->
				<option value="2" <?php if($editProfile->currency_id==2){ echo 'selected'; } ?>>Euro</option>
			</select>
            </div>
          </div>
          
           
           
          <!-- <div class="form-group">
            <label class="col-md-3 control-label">Password:</label>
            <div class="col-md-8">
              <input class="form-control" type="password" value="11111122333">
            </div>
          </div> -->
         <!--  <div class="form-group">
            <label class="col-md-3 control-label">Confirm password:</label>
            <div class="col-md-8">
              <input class="form-control" type="password" value="11111122333">
            </div>
          </div> -->
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <input type="submit" class="btn btn-primary" value="Save Changes">
              <span></span>
              <input type="reset" class="btn btn-default" value="Cancel">
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>
@endsection