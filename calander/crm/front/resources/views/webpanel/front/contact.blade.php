@extends('webpanel.layouts.front-layout')
@section('title')
Contact Us
@stop
@section('description1')
Contact Moretti Milano store, you can submit your query here or call the online support directly.
@stop
@section('keywords')
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
@stop
@section('title1')
Contact for Genuine Italian Leather Handbags | Moretti Milano
@stop
@section('content')
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Contact Us</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- mail -->
	<div class="mail animated wow zoomIn" data-wow-delay=".5s">
		<div class="container">
			<div class="centr"><h1>Contact Us</h1></div><hr>
			<div class="centr"><h4 class="animated wow zoomIn cat-h" data-wow-delay=".5s">Contact Morettimilano.com – One-stop-shop for 100% genuine Italian leather bags & accessories</h4></div><br>
			<div><p class="animated wow zoomIn" data-wow-delay=".5s">Leave Us a Message</p></div><br>
			<div><p class="animated wow zoomIn" data-wow-delay=".5s">If you have any query, we'd love to hear from you! Please use our contact form below and drop us a message.</p></div>
            
		<!--	<p class="est">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
				deserunt mollit anim id est laborum.</p>-->
			<div class="mail-grids">
			   
				<div class="col-md-8 mail-grid-left animated wow slideInLeft" data-wow-delay=".5s">
				<!---->
				@if(!empty(@$success_message))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                    <strong>{{@$success_message}}</strong>
                </div>
                @endif
			    <!---->
					<form action="{{url('/contact')}}" method="post">
						<input type="text" value="" placeholder="Name" required="" name="fname">
						<input type="email" value="" required="" placeholder="Email" name="email">
						<input type="text" value="" required="" placeholder="Subject" name="subject">
						<textarea type="text" required="" name="message"></textarea>
						<input type="submit" value="Submit Now" >
					</form>
				</div>
				<div class="col-md-4 mail-grid-right animated wow slideInRight" data-wow-delay=".5s">
				    <div><h4 class="animated wow zoomIn cont-h" data-wow-delay=".5s">We’re all ears – Other Ways to Connect.</h4></div><br>
					<div class="mail-grid-right1">
						<!--<img src="{{Request::root()}}/public/front/images/3.png" alt=" " class="img-responsive" />-->
						<h4>Online Support</h4>
						<ul class="phone-mail">
							<li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>Phone: +4522323640</li>
							<li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i>Email: <a href="mailto:info@morettimilano.com">info@morettimilano.com</a></li>
						</ul><!--
						<ul class="social-icons">
							<li><a href="#" class="facebook"></a></li>
							<li><a href="#" class="twitter"></a></li>
							<li><a href="#" class="g"></a></li>
							<li><a href="#" class="instagram"></a></li>
						</ul>-->
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div><h4 class="animated wow zoomIn cont-h" data-wow-delay=".5s">Where we are</h4></div><br>
			<iframe class="animated wow slideInLeft cstm_contact_ifr" data-wow-delay=".5s" src="https://maps.google.com/maps?q=Piazza%20IV%20Novembre%204%20%2C%2020124%20Milano%20MI%2C%20Italy&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
<!-- //mail -->


@endsection