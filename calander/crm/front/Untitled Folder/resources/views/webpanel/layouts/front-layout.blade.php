<?php error_reporting(0); ?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="google-site-verification" content="3jwnogKKdnYYHqX9lBLMtSTJ8JuZCip89R7S-C1Qt8U"/>

<title>{{trim(View::yieldContent('title1'))}}</title>

<link rel="canonical" href="{{Request::fullUrl()}}" />
<link rel="apple-touch-icon" sizes="57x57" href="{{Request::root()}}/public/assets/images/fav/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="{{Request::root()}}/public/assets/images/fav/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="{{Request::root()}}/public/assets/images/fav/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{Request::root()}}/public/assets/images/fav/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="{{Request::root()}}/public/assets/images/fav/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{Request::root()}}/public/assets/images/fav/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="{{Request::root()}}/public/assets/images/fav/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{Request::root()}}/public/assets/images/fav/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="{{Request::root()}}/public/assets/images/fav/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="{{Request::root()}}/public/assets/images/fav/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="{{Request::root()}}/public/assets/images/fav/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="{{Request::root()}}/public/assets/images/fav/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="{{Request::root()}}/public/assets/images/fav/favicon-16x16.png">
<link rel="manifest" href="{{Request::root()}}/public/assets/images/fav/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="{{Request::root()}}/public/assets/images/fav/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">


<!-- for-mobile-apps -->
<meta name="description" content="{{trim(View::yieldContent('description1'))}}">

<meta name="keywords" content="{{trim(View::yieldContent('keywords'))}}" />
<meta name="title" content="{{trim(View::yieldContent('title1'))}})" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="{{Request::root()}}/public/front/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="{{Request::root()}}/public/front/css/custom.css" rel="stylesheet" type="text/css" media="all" />
<!-- js -->
<script src="{{Request::root()}}/public/front/js/jquery.min.js"></script>
<script id="lazy" src="{{Request::root()}}/public/front/js/jquery.lazy.min.js"></script>
<script>
	lazy.addEventListener('load', function () {
       $(function() {
            $('.lazy').Lazy();
       });
    });
  
</script>


<!-- timer -->
<!--<link rel="stylesheet" href="{{Request::root()}}/public/front/css/jquery.countdown.css" />-->
<!-- //timer -->
<!-- animation-effect -->
<!--<link href="{{Request::root()}}/public/front/css/animate.min.css" rel="stylesheet"> -->
<!--<script src="{{Request::root()}}/public/front/js/wow.min.js"></script>-->
<script>
 //new WOW().init();
</script>
<!-- //animation-effect -->
<!-- Google Analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-158618698-1', 'auto');
ga('send', 'pageview');
</script>
<!-- End Google Analytics -->
<!-- Facebook Pixel Code -->

<script>

!function(f,b,e,v,n,t,s)

{if(f.fbq)return;n=f.fbq=function(){n.callMethod?

n.callMethod.apply(n,arguments):n.queue.push(arguments)};

if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

n.queue=[];t=b.createElement(e);t.async=!0;

t.src=v;s=b.getElementsByTagName(e)[0];

s.parentNode.insertBefore(t,s)}(window,document,'script',

'https://connect.facebook.net/en_US/fbevents.js');


fbq('init', '454890158263553'); 

fbq('track', 'PageView');

</script>

<noscript>

<img height="1" width="1" 

src="https://www.facebook.com/tr?id=454890158263553&ev=PageView

&noscript=1"/>

</noscript>
<style>
    .fa.fa-star {
        display: none;
    }
</style>
<!-- End Facebook Pixel Code -->
</head>
	
<body>
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
  FB.init({
    xfbml            : true,
    version          : 'v6.0'
  });
};

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=install_email
  page_id="345632932192156">
</div>
<!-- header -->
	<div class="header">
		<div class="container">
			<div class="header-grid cstm_frntlay_hdgrd">
				<div class="header-grid-left animated wow slideInLeft" data-wow-delay=".5s">
					<ul>
						<li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:{{email()}}">{{email()}}</a></li>
						<li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>{{phone()}}</li>
						@if(!empty(Auth::user()))
						<!--<li><i class="glyphicon glyphicon-user cstm_frntlay_glfuser" aria-hidden="true"></i>Welcome : {{Auth::user()->full_name}}<span ><b ></b></span></li>-->
							

							<li><i class="glyphicon glyphicon-list" aria-hidden="true"></i><a href="{{url('/order-history')}}">My Account</a></li>
						
							<li><i class="glyphicon glyphicon-log-out" aria-hidden="true"></i><a href="{{url('/logout')}}">Logout</a></li>
						@else
						<li><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i><a href="{{url('/user-login')}}">Login</a></li>
						<li><i class="glyphicon glyphicon-book" aria-hidden="true"></i><a href="{{url('/user-register')}}">Register</a></li>
						@endif
					</ul>
				</div>
				<div class="header-grid-right animated wow slideInRight" data-wow-delay=".5s">
					<ul class="social-icons">
					    @if(!empty(facebook()))
						<li><a href="{{facebook()}}" class="facebook"  target="_blank"></a></li>
						@endif
						 @if(!empty(twiter()))
						<li><a href="{{twiter()}}" class="twitter" target="_blank"></a></li>
						@endif
						 @if(!empty(google()))
						<li><a href="{{google()}}" class="g" target="_blank"></a></li>
						@endif
						 @if(!empty(insta()))
						<li><a href="{{insta()}}" class="instagram" target="_blank"></a></li>
						@endif
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="logo-nav">
				<div class="logo-nav-left animated wow zoomIn" data-wow-delay=".5s">
				
					<a href="{{url('/')}}"><img src="{{Request::root()}}/public/front/images/moretti-leather-bags-logo.png" alt="Moretti leather bags logo"></a>

					
				</div>
				<div class="logo-nav-left1">
					<nav class="navbar navbar-default">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header nav_2">
						<button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
					</div> 
					<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
						<ul class="nav navbar-nav menu">
							<li class="active hacti"><a href="{{url('/')}}" class="act hact">Home</a></li>	
							<!-- Mega Menu -->
							<li class="dropdown">
								<a href="{{url('/products')}}" class="dropdown-toggle"  >Products</b></a>
								 
							</li>
							<li class="dropdown">
								<a href="{{url('/blog')}}" class="dropdown-toggle"  >Blog</b></a>
								 
							</li>
							 
							 
							<li><a href="{{url('/contact')}}">Contact Us</a></li>
							@if(!empty(Auth::user()))
						<!--<li class="cstm_frntlay_wel"><a href="javascript:;">Welcome : {{Auth::user()->full_name}}</a></li>-->
							

							<li><a href="{{url('/order-history')}}">My Account</a></li>
						
							<li><a href="{{url('/logout')}}">Logout</a></li>
						@else
						<li><a href="{{url('/user-login')}}">Login</a></li>
						<li><a href="{{url('/user-register')}}">Register</a></li>
						@endif
						</ul>
					</div>
					</nav>
				</div>
				<div class="logo-nav-right">
					<div class="search-box">
						<div id="sb-search" class="sb-search">
							<form action="{{url('/products')}}" method="get">
								<input class="sb-search-input" placeholder="Enter your search term..." type="search" id="search"  name="keyword" value="{{ Input::get('keyword') }}" required>
								<input class="sb-search-submit" type="submit" >
								<span class="sb-icon-search"> </span>
							</form>
						</div>
					</div>
						<!-- search-scripts -->
						<script src="{{Request::root()}}/public/front/js/classie.js"></script>
						<script id="uisearch" src="{{Request::root()}}/public/front/js/uisearch.js" async></script>
							<script>
            					uisearch.addEventListener('load', function () {
                                     new UISearch( document.getElementById( 'sb-search' ) );
                                });
							</script>
						<!-- //search-scripts -->
				</div>
				<div class="header-right">
					<div class="cart box_1">
						<a href="{{url('/orders/cart/xl')}}">
							<h3> 
								@if(session(\App\Modules\Orders\Order::SESSION_KEY))
								<div class="total">
								<span class="simpleCart_total1"></span> (<span id="simpleCart_quantity1" class="simpleCart_quantity1">
								@if(\App\Modules\Orders\Order::Current())
								{{ \App\Modules\Orders\Order::Current()->items()->count('id') }}
								@endif
								</span> items)
								</div>
								@else
								<div class="total">
								<span class="simpleCart_total1"></span> (<span id="simpleCart_quantity1" class="simpleCart_quantity1">
								0
								</span> items)
								</div>
								@endif
								<img src="{{Request::root()}}/public/front/images/bag.png" alt="Bag" />
							</h3>
						</a>
					
					</div>	
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //header -->
@yield('content')
	<div class="footer">
		<div class="container">
			<div class="footer-grids">
				<div class="col-md-4 footer-grid animated wow slideInLeft" data-wow-delay=".5s">
					<h3>About Moretti Milano</h3>
					<p>Moretti Milano is an Italian brand, that mixes proud traditional craftmanship with the latest trends comming out of Milan. We follow a long line of traditions focusing on style, quality, and uncompromising attention to detail.
All our bags are handcrafted using only the finest leather available, and only after careful inspection it shipped to our clients. That is why your Moretti Bag will be yours for life.
Our young and vibrant design team finds inspiration in today’s emerging trends from Milan, to bring you some of the best Italy has to offer</p>
				</div>
				<div class="col-md-4 footer-grid animated wow slideInLeft" data-wow-delay=".6s">
					<h3>Contact Info</h3>
				
					{!!address()!!}
				</div>
				<div class="col-md-4 footer-grid animated wow slideInLeft" data-wow-delay=".7s">
					<h3>Latest Products</h3>
					<?php //echo '>>'.count($productFooter);?>
					@foreach(postFooter() as $fProduct)
					<?php
					$folder= $fProduct['photos'][0]['media']['folder'];
                	$fileName= $fProduct['photos'][0]['media']['filename'];
                     
                     
             
                     
					?>
					<div class="footer-grid-left">
						<a href="{{url('/single/')}}/{{encryptIt($fProduct->id)}}"><img src="{{IMGPATH}}/public/{{$folder.$fileName}}" alt="{{$fProduct->name}}" onerror="this.onerror=null;this.src='<?=NO_IMG?>'" class="img-responsive" title="{{$product->name}}" /></a>
					</div>
				 
					@endforeach
			
					<div class="clearfix"> </div>
				</div>
				
				<div class="clearfix"> </div>
			</div>
			<div class="footer-logo animated wow slideInUp" data-wow-delay=".5s">
				<!-- <h2><a href="index.html">Best Store <span>shop anywhere</span></a></h2> -->

				<a href="{{url('/')}}"><img src="{{Request::root()}}/public/front/images/moretti-leather-bags-logo-new.png" alt="Moretti leather bags logo"></a>
			</div>
			<div class="copy-right animated wow slideInUp" data-wow-delay=".5s">
				<p>&copy 2019 Moretti Milano. All Rights Reserved.</p>
			</div>
		</div>
	</div>
	<!-- //js -->
<!-- cart -->
<script src="{{Request::root()}}/public/front/js/simpleCart.min.js"></script>
<!-- cart -->
<!-- for bootstrap working -->
<script type="text/javascript" src="{{Request::root()}}/public/front/js/bootstrap-3.1.1.min.js"></script>
<!-- //for bootstrap working -->

<link href="{{Request::root()}}/public/front/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&display=swap' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic&display=swap' rel='stylesheet' type='text/css'>
<!-- //footer -->
</body>
</html>
<script type="text/javascript">

 $(document).ready(function(){

 var url = window.location.href;

 // Loop all menu items
 $('.menu li').each(function(){

  // select href
  var href = $(this).find('a').attr('href');

  // Check filename
  if(url == href){
   // Add active class
   $(this).addClass('active');
   $(this).find('a').addClass('act');
   $('.hacti').removeClass('active');
   $('.hact').removeClass('act');
  }
 });
});
</script>