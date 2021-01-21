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
			<h3 class="animated wow zoomIn" data-wow-delay=".5s">Forgot password</h3>
			<p class="est animated wow zoomIn" data-wow-delay=".5s"></p>
			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<div class="message">

			@if(Session::has('error'))
			<p class="alert alert-danger cstm_forgot_dng">{{ Session::get('error') }}</p>
			@endif
			</div>
			@if(@$recovery)
			<p class="cstm_forgot_reco">{{@$recovery}}</p>
		    @endif
			<br>
				<form action="{{url('/forgot')}}" method="post">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="email" placeholder="Email Address" required=" " name="email">
					<div class="forgot">
						<!-- <a href="#">Forgot Password?</a> -->
						@if(@$notfound)
						<p class="cstm_forgot_notfnd">{{$notfound}}</p>
						@endif
					</div>
					<input type="submit" value="Submit">
				</form>
			</div>
			<h4 class="animated wow slideInUp" data-wow-delay=".5s">For New People</h4>
			<p class="animated wow slideInUp" data-wow-delay=".5s"><a href="{{url('/user-register')}}">Register Here</a> (Or) go back to <a href="{{url('/')}}">Home<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
		</div>
	</div>
<!-- //login -->
@endsection