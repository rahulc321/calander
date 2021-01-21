@extends('webpanel.layouts.front-layout')
@section('title')
User Login
@stop
@section('content')

<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Login Page</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- login -->
	<div class="login">
		<div class="container">
			<h3 class="animated wow zoomIn" data-wow-delay=".5s">Reset Password</h3>
			<p class="est animated wow zoomIn" data-wow-delay=".5s"></p>
			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<div class="message">

			@if(Session::has('error'))
			<p class="alert alert-danger error">{{ Session::get('error') }}</p>
			@endif
			</div>
			<br>
				<form action="{{url('/reset')}}/{{$id}}" id="reset_form" method="post">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="password" placeholder="New password" id="password" required=" " name="password">
					<input type="password" placeholder="Confirm password" required=" " name="confirmpassword">
					<div class="forgot">
						<!-- <a href="#">Forgot Password?</a> -->
					</div>
					<input id="reset" type="submit" value="Reset" onClick="validatePassword();">
				</form>
			</div>
			<h4 class="animated wow slideInUp" data-wow-delay=".5s">For New People</h4>
			<p class="animated wow slideInUp" data-wow-delay=".5s"><a href="{{url('/user-register')}}">Register Here</a> (Or) go back to <a href="{{url('/')}}">Home<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
		</div>
	</div>
<!-- //login -->
<!--  -->
<html>
 
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script>
    function validatePassword() {
        var validator = $("#reset_form").validate({
            rules: {
                password: "required",
                confirmpassword: {
                    equalTo: "#password"
                }
            },
            messages: {
                password: " Enter Password",
                confirmpassword: " Enter Confirm Password Same as Password"
            }
        });
        if (validator.form()) {
            // alert('Sucess');
        }
    }
 
    </script>
 
</html>
@endsection