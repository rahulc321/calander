<?php error_reporting(0);
$url= Request::url();
	$actUrl= explode('/',$url);
?>
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
<link href="{{Request::root()}}/public/front/css/msdropdown_dd.css" rel="stylesheet" type="text/css" media="all" />
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
@media only screen and (max-width: 768px) {
  /* For mobile phones: */
  .banner .banner-info, .hideonmobile {
      display: none;
  }
  .new-collections{
      padding: 0 !important;
  }
  .new-collections-grids {
    margin-top: 0 !important;   
  }
  .banner .container {
      min-height: 155px;
  }
}
@media only screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape) {
  /* For landscape layouts only */
  .banner .container {
      min-height: 240px;
  }
}}
@media only screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:potrait) {
  /* For landscape layouts only */
  .banner .container {
      min-height: 240px;
  }
}
@media only screen and (min-width: 768px) {
    .wmuSlider.example1 {
        height: 275px !important;
    }
}

.dd .ddTitle .ddTitleText img, .dd .ddChild li img {
    width: 30px !important;
}
.logo-nav {
    clear: both;
}
#lang_msdd {
    float: right;
}
</style>
<!-- End Facebook Pixel Code -->
</head>
	
<body>
<!-- Load Facebook SDK for JavaScript -->
<!--<div id="fb-root"></div>
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
}(document, 'script', 'facebook-jssdk'));</script>-->

<style type="text/css">
	.goog-te-banner-frame.skiptranslate {
   display: none !important;
} 
body {
   top: 0px !important; 
}
 
#google_translate_element { height: 26px !important; overflow: hidden !important; }
div#google_translate_element {
    /*float: right;*/
    /*padding: 3px;*/
}
select.language {
    float: right;
     
}
.languageselect {
    padding-top: 3px;
}

</style>
<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=install_email
  page_id="345632932192156">
</div>


<!--<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>-->
<!-- Your customer chat code -->
<div class="fb-customerchat"
  attribution=install_email
  page_id="345632932192156">
</div>
<!-- header -->
	<div class="header">
		<div class="container">
            <div class="languageselect">
   <!--         <select class="language">-->
			<!--	<option value="">Language</option>-->
			<!--	<option value="en">English</option>-->
			<!--	<option value="ru">Russian</option>-->
			<!--	<option value="it">Italian</option>-->
			<!--	<option value="de">German</option>-->
				<!--<option value="gr">Greece</option>
			<!--	<option value="dk">Denmark</option>-->
			<!--	<option value="se">Sweden</option>-->
			<!--	<option value="no">Norway</option>-->
			<!--	<option value="fi">Finland</option>-->
			<!--	<option value="jp">Japan</option>-->
			<!--</select>-->
			<div class="drop-down">
			<select id="lang" class="language"  style="width:200px">
				<option value="en" data="{{url('/')}}/en/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/english.png">English</option>
				<option value="ru" data="{{url('/')}}/ru/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/russia.png">Russian</option>
				<option value="it" data="{{url('/')}}/it/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/italy.png">Italian</option>
				<option value="de" data="{{url('/')}}/de/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/germany.png">German</option>
				<option value="gr" data="{{url('/')}}/gr/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/greece.png">Greece</option>
				<option value="dk" data="{{url('/')}}/dk/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/denmark.png">Denmark</option>
				<option value="se" data="{{url('/')}}/se/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/sweden.png">Sweden</option>
				<option value="no" data="{{url('/')}}/no/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/norway.png">Norway</option>
				<option value="fi" data="{{url('/')}}/fi/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/finland.png">Finland</option>
				<option value="jp" data="{{url('/')}}/jp/{{$actUrl[4]}}" data-image="{{Request::root()}}/public/front/images/flags/japan.png">Japan</option>
			</select>
			</div>
			</div>
			<div id="google_translate_element" style="display:none;"></div>
            <script>
               /* function googleTranslateElementInit() {
                    new google.translate.TranslateElement({pageLanguage: 'hi', includedLanguages: 'et,hi', autoDisplay: false}, 'google_translate_element');
                    var a = document.querySelector("#google_translate_element select");
                    a.selectedIndex=1;
                    a.dispatchEvent(new Event('change'));
                }*/
                
                
                $(document).ready(function(){
                    
                $('.language').change(function(){
                var val= $(this).val();
                var url= "{{url('/')}}";
                var actUrl= $('option:selected', this).attr('data');
        		//alert(actUrl);
        		window.location.href = actUrl;
                });
                    
                    
                    
                    
                    
                 var url= "{{$actUrl[3]}}";
            //	alert(url);
            	$(".cl").each(function(){
            		var value= $(this).attr("href");
            		var arr=value.split('/');
            		var actUrl= "{{url('/')}}";
            		//alert(arr[3]);
            		if(url !=""){
            			if(arr[3] != undefined){
            				$(this).attr("href", actUrl+'/'+url+'/'+arr[3]);
            			}else if(arr[3]==""){
            			    	$(this).attr("href", actUrl+'/'+url)
            			}
            		}
            	});
            	
            	$(".language option").each(function(){
            		var selectedVal= $(this).val();
            		if(url !=""){
            			$('.language option[value='+url+']').attr('selected','selected');
            		} else {
            			$('.language option[value=""]').attr('selected','selected');
            		    
            		}
        		
            	});
                    
                });
                
                $(window).load(function(){
                  
                    
                    
                    
            	setTimeout( function(){
            	var url= "{{$actUrl[3]}}";
            
            	var lang= "";
            	if(url=='en'){
            	lang= 'Eng';
            	}else if(url=='ru'){
            	lang= 'Ru';
            	}else if(url=='it'){
            	lang= 'It';
            	}else if(url=='de'){
            	lang= 'Ger';
            	}else if(url=='gr'){
            	lang= 'Gre';
            	}else if(url=='dk'){
            	lang= 'Dan';
            	}else if(url=='se'){
            	lang= 'Swe';
            	}else if(url=='no'){
            	lang= 'Nor';
            	}else if(url=='fi'){
            	lang= 'Fin';
            	}else if(url=='jp'){
            	lang= 'Jap';
            	}
            //	alert(url);
               // var lang = 'It';
                var $frame = $('.goog-te-menu-frame:first');
                if(url=='en' || url=='ru' || url=='it' || url=='de' || url=='gr' || url=='dk' || url=='el' || url=='se' || url=='no' || url=='fi' || url=='jp'){
                  var langs= $frame.contents().find('.goog-te-menu2-item span.text:contains('+lang+')').get(0).click();
              	}
            	 
            	}  , 500 );
            });
            
            
            function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: '', includedLanguages: 'en,ru,it,de,el,da,sv,no,fi,ja', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
            }
            </script>
            <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
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
							<li class="active hacti"><a href="{{url('/')}}" class="act hact cl">Home</a></li>	
							<!-- Mega Menu -->
							<li class="dropdown">
								<a href="{{url('/products')}}" class="dropdown-toggle cl"  >Products</b></a>
								 
							</li>
							<li class="dropdown">
								<a href="{{url('/blog')}}" class="dropdown-toggle cl"  >Blog</b></a>
								 
							</li>
							 
							 
							<li><a href="{{url('/contact')}}" class="cl">Contact Us</a></li>
							@if(!empty(Auth::user()))
						<!--<li class="cstm_frntlay_wel"><a href="javascript:;">Welcome : {{Auth::user()->full_name}}</a></li>-->
							

							<li><a href="{{url('/order-history')}}" class="cl">My Account</a></li>
						
							<li><a href="{{url('/logout')}}">Logout</a></li>
						@else
						<li><a href="{{url('/user-login')}}" class="cl">Login</a></li>
						<li><a href="{{url('/user-register')}}" class="cl">Register</a></li>
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
					<a href="{{url('/shipping-policy')}}" target="_blank">Shipping Policy</a></a>
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
<link rel='stylesheet' id='xoo-wsc-css'  href='https://secureservercdn.net/166.62.107.20/ex8.bd9.myftpupload.com/wp-content/plugins/side-cart-woocommerce/public/css/xoo-wsc-public.css?ver=2.1&#038;time=1592980691' type='text/css' media='all' />
<style id='xoo-wsc-inline-css' type='text/css'>

      .xoo-wsc-ctxt{
        font-size: 20px;
      }

      .xoo-wsc-container{
        width: 300px;
      }
      .xoo-wsc-body{
        font-size: 14px;
      }
      .xoo-wsc-img-col{
        width: 35%;
      }
      .xoo-wsc-sum-col{
        width: 60%;
      }
      .xoo-wsc-basket{
      	padding: 0px !important;
        background-color: #ffffff;
        bottom: 12px;
        position: fixed;
      }
      
      .xoo-wsc-bki{
        color: #000000;
        font-size: 35px;
      }
      .xoo-wsc-items-count{
        background-color: #cc0086;
        color: #ffffff;
      }
      .xoo-wsc-footer a.button{
        margin: 4px 0;
      }
    .xoo-wsc-footer{
        position: absolute;
      }
      .xoo-wsc-container{
        top: 0;
        bottom: 0;
      }
        .xoo-wsc-basket{
          right: 0;
        }
        .xoo-wsc-basket, .xoo-wsc-container{
          transition-property: right;
        }
        .xoo-wsc-items-count{
          left: -15px;
        }
        .xoo-wsc-container{
          right: -300px;
        }
        .xoo-wsc-modal.xoo-wsc-active .xoo-wsc-basket{
          right: 300px;
        }
        .xoo-wsc-modal.xoo-wsc-active .xoo-wsc-container{
          right: 0;
        }
        input.newsbtn {
     
    padding: -8px 0;
    
    outline: 0;
    padding: 4px 0;
    background: #d8703f;
    border: none;
    font-size: 1em;
    color: #fff;
    width: 14%;
    /* margin-left: 2em; */
}
.row {
    margin-right: -15px;
    margin-left: -15px;
    margin-bottom: -15px;
}
      
</style>
 
 
   
 
<div class="xoo-wsc-modal">

          <div class="xoo-wsc-basket" style="">
               
           <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModalnews">Suscribe</button>
    </div>
  
  <div class="xoo-wsc-opac"></div>
  <div class="xoo-wsc-container">
      </div>
</div>
<div class="container">
 <!--  <h2>Modal Example</h2> -->
  <!-- Trigger the modal with a button -->
  <!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalnews">Open Modal</button> -->

  <!-- Modal -->
  <div class="modal fade" id="myModalnews" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="row">

  <div class="col-sm-6 pull-left">
     <div class="form-group">
        <img src="https://mdbootstrap.com/img/Photos/Others/sidenav2.jpg" style="height:261px;width:262px">
    </div>
  </div>

  <div id="col-sm-6 pull-right">
     <form> 
  <div class="form-group">
    <h2>Newsletter</h2>
    <p>Join us now to get all news and special offers.</p>
    <br>
 
   

  <input type="email" class="newemail" placeholder="Type your email">

  <input type="submit" value="Subscribe" class="newsbtn" >
  </form> 
  </div>
  </div>

</div>
      </div>
      
    </div>
  </div>



<script src="{{Request::root()}}/public/front/js/simpleCart.min.js"></script>
<!-- cart -->
<!-- for bootstrap working -->
<script type="text/javascript" src="{{Request::root()}}/public/front/js/bootstrap-3.1.1.min.js"></script>
<!-- //for bootstrap working -->

<script src="{{Request::root()}}/public/front/js/msdropdown_jquery.dd.js"></script>
<link href="{{Request::root()}}/public/front/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic&display=swap' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic&display=swap' rel='stylesheet' type='text/css'>
<!-- //footer -->
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">


 function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
    
    function error($msg){
            Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: $msg
                 
                })       
        }
        function success($msg1){
                        Swal.fire({
                        type: 'success',
                        title: 'Success...',
                        text: $msg1,
                        timer: 3000
                        })       
        }



 $(document).ready(function(){

//  for news leter
        $('.newsbtn').click(function(event){

            var newemail= $('.newemail').val();
           //alert(newemail);

            

            if(newemail==""){
                
                error('Please Enter Email.');
                return false;
            }

            if (!ValidateEmail($(".newemail").val())) {
 
                error('Invalid email address.');
                return false;
            }
            $('.newsbtn').prop('disabled',true);
            var checked= 1;
            $.ajax({
            url:"{{url('/news-letter')}}",
            method:'post',
            data:{'_token':"{{csrf_token()}}",'email':newemail,'checkbox':checked},
            success:function(ress){
                $('.newsbtn').prop('disabled',false);
                $('.newemail').val(' ');
                $('#newscheckbox').prop('checked',false)

                if(ress==1){
                    error('You have already subscriber.');
                }else{
                    
                     $('#myModalnews').modal('hide');

                    success('Thankyou for your subsription.');
                }
                 
            }
            });

             
            event.preventDefault();
        });




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
 
 $("#lang").msDropDown();
        
});
</script>