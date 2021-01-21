@extends('webpanel.layouts.front-layout')
@section('title')
User Login
@stop
@section('description1')
Registered users can login here to buy Italian leather handbags products online from the Moretti Milano store.
@stop
@section('keywords')
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
@stop
@section('title1')
User Login | Moretti Milano
@stop
@section('content')
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Login Page</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- login -->
<br>
@if(@$reset_success)
<p class="cstm_login_success">{{@$reset_success}}</p>
@endif
	<div class="login">
		<div class="container">
			<div class="centr"><h1 class="animated wow zoomIn" data-wow-delay=".5s">Login Form</h1></div><hr>
			<p class="est animated wow zoomIn" data-wow-delay=".5s">Already registered or returning customer? Please enter your e-mail and password below to login to Moretti Milano.</p>
			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<div class="message">

			@if(Session::has('error'))
			<p class="alert alert-danger cstm_login_error">{{ Session::get('error') }}</p>
			@endif
			</div>
			<br>
				<form action="{{url('/user-login')}}" method="post">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="email" placeholder="Email Address" required=" " name="email">
					<input type="password" placeholder="Password" required=" " name="password">
					<div class="forgot">
						<!-- <a href="#">Forgot Password?</a> -->
					</div>
					<input type="submit" value="Login">
					<a class="" href="{{url('/forgot')}}">Forgot Password? </a>
				</form>
			</div>
			<h4 class="animated wow slideInUp" data-wow-delay=".5s">For New People</h4>
			<p class="animated wow slideInUp" data-wow-delay=".5s"><a href="{{url('/user-register')}}">Register Here</a> (Or) go back to <a href="{{url('/')}}">Home<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
		</div>
	</div>
<!-- //login -->
@endsection