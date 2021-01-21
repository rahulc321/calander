@extends('webpanel.layouts.front-layout')
@section('title')
User Register
@stop
@section('description1')
Register here and create your profile to order & buy online Italian leather handbags from the Moretti Milano store.
@stop
@section('keywords')
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
@stop
@section('title1')
User Register | Moretti Milano
@stop
@section('content')
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="{{url('/')}}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Register Page</li>
			</ol>
		</div>
	</div>
	
<!-- //breadcrumbs -->
<!-- register -->
	<div class="register">
		<div class="container">
			<div class="centr"><h1 class="animated wow zoomIn" data-wow-delay=".5s">Register Here</h1></div><hr>
			<p class="est animated wow zoomIn" data-wow-delay=".5s">New to Moretti Milano? Please fill out the form below and create a customer profile with us! It will help you to shop faster, track your recent orders’ status and review previous orders.</p>
			
			<div class="login-form-grids">
				<div class="message">
			@if(Session::has('success'))
			<p class="alert alert-success">{{ Session::get('success') }}</p>
			@endif
			</div>
				<h5 class="animated wow slideInUp" data-wow-delay=".5s">profile information</h5>
				<form action="{{url('/user-register')}}" class="animated wow slideInUp" data-wow-delay=".5s" name="registration" method="post">

					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="form-group">
						<label>First Name</label>
						<input type="text" placeholder="First Name" required=" " name="firstname">
					</div>
					<div class="form-group">
						<label>Last Name</label>
						<input type="text" placeholder="Last Name" required=" " name="lastname">
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" placeholder="Email Address" required=" " name="email">
					</div>
					<div class="form-group">
						<label>Phone</label>
						<input type="text" placeholder="Phone Number" required=" " name="phone">
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" rows="4" cols="44" placeholder="Address" name="address"></textarea>
					</div>
					<div class="form-group">
						<label>City</label>
						<input type="text" placeholder="City" required=" " name="city">
					</div>
					<div class="form-group">
						<label>Country</label>
						<input type="text" placeholder="Country" required=" " name="country">
					</div>
					<div class="form-group">
						<label>Zip Code</label>
						<input type="text" placeholder="Zip Code" required=" " name="zipcode">
					</div>
					<!--<div class="form-group">-->
					<!--	<label>Currency</label>-->
					<!--	<select class="form-control lazySelector" id="currency_id" name="currency_id" required>-->
	    <!--                        <option value="">Choose Currency</option>-->
	    <!--                        <option value="1">Danish Krone</option><option value="2">Euro</option>-->
	    <!--                </select>-->
	    <!--            </div>-->

				 
				<div class="register-check-box animated wow slideInUp" data-wow-delay=".5s">
					<!-- <div class="check">
						<label class="checkbox"><input type="checkbox" name="checkbox"><i> </i>Subscribe to Newsletter</label>
					</div> -->
				</div>
				<!-- <h6 class="animated wow slideInUp" data-wow-delay=".5s">Login information</h6> -->
				<div class="animated wow slideInUp" data-wow-delay=".5s">
					<div class="form-group">
						<label>Password</label>
						<input type="password" placeholder="Password" required=" " name="password" id="password">
					</div>
					<div class="form-group">
						<label>Confirm Password</label>
						<input type="password" placeholder="Password Confirmation" required=" " name="cpassword">
					</div>
					<div class="register-check-box">
						<!-- <div class="check">
							<label class="checkbox"><input type="checkbox" name="checkbox"><i> </i>I accept the terms and conditions</label>
						</div> -->
					</div>
					<input type="submit" value="Register">
					</div>
				</form>
			</div>
			<!-- <div class="register-home animated wow slideInUp" data-wow-delay=".5s">
				<a href="index.html">Home</a>
			</div> -->
		</div>
	</div>
<!-- //register -->
  	

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script src="//cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<script type="text/javascript">
	 
	// Wait for the DOM to be ready
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='registration']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      firstname: "required",
      lastname: "required",
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        email: true,
        remote:"{{url('/check-email')}}"
      },
		phone:{
		required:true,
		minlength:9,
		maxlength:10,
		number: true
		},
       password: {
            required: true,
            minlength: 5
        },
        cpassword: {
            required: true,
            minlength: 5,
            equalTo: "#password"
        }
    },
    // Specify validation error messages
    messages: {
      firstname: "Please enter your firstname",
      lastname: "Please enter your lastname",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      cpassword: {
        required: "Password don't Match!"
        
      },
      phone: {
        required: "Please provide a Phone Number",
        minlength: "Your Phone Number must be at least 10 characters long",
        maxlength: "Your Phone Number must be at least 10 characters long"
      },

       email: {
        required: "Please enter a valid email address",
        remote: "Email Already Exists."
         
      }
       
       
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});

</script>
@endsection