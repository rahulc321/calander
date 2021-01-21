@extends('webpanel.layouts.front-layout')
@section('title')
Unsubscribe
@stop
@section('description1')
Registered users can login here to buy Italian leather handbags products online from the Moretti Milano store.
@stop
@section('keywords')
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
@stop
@section('title1')
Unsubscribe
@stop
@section('content')
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Unsubscribe Page</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- login -->
<br>
 
	<div class="login">
		<div class="container">
			<div class="centr"><h1 class="animated wow zoomIn" data-wow-delay=".5s">Unsubscribe Form</h1></div><hr>
			
			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<div class="message">

			@if(Session::has('error'))
			<p class="alert alert-danger cstm_login_error" style="color:red">{{ Session::get('error') }}</p>
			@endif
			</div>
			<br>
				<form action="{{url('/unsubscribe-email')}}" method="post">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<input type="email" placeholder="Email Address" required=" " name="email" value="{{$email}}" readonly="">
					 
					<input type="submit" value="Unsubscribe">
					<a class="" href="{{url('/')}}">Go Back </a>
					 
				</form>
				<br>
				
			</div>

			 
		</div>
	</div>
<!-- //login -->
@endsection