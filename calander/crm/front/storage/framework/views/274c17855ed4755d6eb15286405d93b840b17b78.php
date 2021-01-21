<?php error_reporting(0); ?>
<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title><?php echo $__env->yieldContent('title'); ?></title>
<!-- for-mobile-apps -->
<meta name="description" content="<?php echo $__env->yieldContent('description1'); ?>">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo $__env->yieldContent('keywords'); ?>" />
<meta name="title" content="<?php echo $__env->yieldContent('title1'); ?>" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
		function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="<?php echo e(Request::root()); ?>/public/front/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo e(Request::root()); ?>/public/front/css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- js -->
<script src="<?php echo e(Request::root()); ?>/public/front/js/jquery.min.js"></script>
<!-- //js -->
<!-- cart -->
<script src="<?php echo e(Request::root()); ?>/public/front/js/simpleCart.min.js"></script>
<!-- cart -->
<!-- for bootstrap working -->
<script type="text/javascript" src="<?php echo e(Request::root()); ?>/public/front/js/bootstrap-3.1.1.min.js"></script>
<!-- //for bootstrap working -->
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- timer -->
<link rel="stylesheet" href="<?php echo e(Request::root()); ?>/public/front/css/jquery.countdown.css" />
<!-- //timer -->
<!-- animation-effect -->
<link href="<?php echo e(Request::root()); ?>/public/front/css/animate.min.css" rel="stylesheet"> 
<script src="<?php echo e(Request::root()); ?>/public/front/js/wow.min.js"></script>
<script>
 new WOW().init();
</script>
<!-- //animation-effect -->
</head>
	
<body>
    <style>
        .footer-logo.animated.wow.slideInUp.animated a img {
        width: 22%;
        }
    </style>
<!-- header -->
	<div class="header">
		<div class="container">
			<div class="header-grid" style="display:none;">
				<div class="header-grid-left animated wow slideInLeft" data-wow-delay=".5s">
					<ul>
						<li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:<?php echo e(email()); ?>"><?php echo e(email()); ?></a></li>
						<li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i><?php echo e(phone()); ?></li>
						<?php if(!empty(Auth::user())): ?>
						<li><i class="glyphicon glyphicon-user" aria-hidden="true" style="color:green"></i>Welcome : <?php echo e(Auth::user()->full_name); ?><span ><b ></b></span></li>
							

							<li><i class="glyphicon glyphicon-list" aria-hidden="true"></i><a href="<?php echo e(url('/order-history')); ?>">My Account</a></li>
						
							<li><i class="glyphicon glyphicon-log-out" aria-hidden="true"></i><a href="<?php echo e(url('/logout')); ?>">Logout</a></li>
						<?php else: ?>
						<li><i class="glyphicon glyphicon-log-in" aria-hidden="true"></i><a href="<?php echo e(url('/user-login')); ?>">Login</a></li>
						<li><i class="glyphicon glyphicon-book" aria-hidden="true"></i><a href="<?php echo e(url('/user-register')); ?>">Register</a></li>
						<?php endif; ?>
					</ul>
				</div>
				<div class="header-grid-right animated wow slideInRight" data-wow-delay=".5s">
					<ul class="social-icons">
					    <?php if(!empty(facebook())): ?>
						<li><a href="<?php echo e(facebook()); ?>" class="facebook"  target="_blank"></a></li>
						<?php endif; ?>
						 <?php if(!empty(twiter())): ?>
						<li><a href="<?php echo e(twiter()); ?>" class="twitter" target="_blank"></a></li>
						<?php endif; ?>
						 <?php if(!empty(google())): ?>
						<li><a href="<?php echo e(google()); ?>" class="g" target="_blank"></a></li>
						<?php endif; ?>
						 <?php if(!empty(insta())): ?>
						<li><a href="<?php echo e(insta()); ?>" class="instagram" target="_blank"></a></li>
						<?php endif; ?>
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
			<div class="logo-nav">
				<div class="logo-nav-left animated wow zoomIn" data-wow-delay=".5s">
					<!-- <h1><a href="<?php echo e(url('/')); ?>">


						Best Store <span>Shop anywhere</span></a>

					</h1> -->
					<a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(Request::root()); ?>/public/front/images/moretti-leather-bags-logo.png"></a>

					
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
						<ul class="nav navbar-nav">
							<li class="active"><a href="<?php echo e(url('/')); ?>" class="act">Home</a></li>	
							<!-- Mega Menu -->
							<li class="dropdown">
								<a href="<?php echo e(url('/products')); ?>" class="dropdown-toggle"  >Products</b></a>
								 
							</li>
							 
							 
							<li><a href="<?php echo e(url('/contact')); ?>">Contact Us</a></li>
							<?php if(!empty(Auth::user())): ?>
						<li style="display:none"><!--<i class="glyphicon glyphicon-user" aria-hidden="true" style="color:green"></i>--><a href="javascript:;">Welcome : <?php echo e(Auth::user()->full_name); ?></a></li>
							

							<li><!--<i class="glyphicon glyphicon-list" aria-hidden="true"></i>--><a href="<?php echo e(url('/order-history')); ?>">My Account</a></li>
						
							<li><!--<i class="glyphicon glyphicon-log-out" aria-hidden="true"></i>--><a href="<?php echo e(url('/logout')); ?>">Logout</a></li>
						<?php else: ?>
						<li><!--<i class="glyphicon glyphicon-log-in" aria-hidden="true"></i>--><a href="<?php echo e(url('/user-login')); ?>">Login</a></li>
						<li><!--<i class="glyphicon glyphicon-book" aria-hidden="true"></i>--><a href="<?php echo e(url('/user-register')); ?>">Register</a></li>
						<?php endif; ?>
						</ul>
					</div>
					</nav>
				</div>
				<div class="logo-nav-right">
					<div class="search-box">
						<div id="sb-search" class="sb-search">
							<form action="<?php echo e(url('/products')); ?>" method="get">
								<input class="sb-search-input" placeholder="Enter your search term..." type="search" id="search"  name="keyword" value="<?php echo e(Input::get('keyword')); ?>" required>
								<input class="sb-search-submit" type="submit" >
								<span class="sb-icon-search"> </span>
							</form>
						</div>
					</div>
						<!-- search-scripts -->
						<script src="<?php echo e(Request::root()); ?>/public/front/js/classie.js"></script>
						<script src="<?php echo e(Request::root()); ?>/public/front/js/uisearch.js"></script>
							<script>
								new UISearch( document.getElementById( 'sb-search' ) );
							</script>
						<!-- //search-scripts -->
				</div>
				<div class="header-right">
					<div class="cart box_1">
						<a href="<?php echo e(url('/orders/cart/xl')); ?>">
							<h3> 
								<?php if(session(\App\Modules\Orders\Order::SESSION_KEY)): ?>
								<div class="total">
								<span class="simpleCart_total1"></span> (<span id="simpleCart_quantity1" class="simpleCart_quantity1">
								<?php if(\App\Modules\Orders\Order::Current()): ?>
								<?php echo e(\App\Modules\Orders\Order::Current()->items()->count('id')); ?>

								<?php endif; ?>
								</span> items)
								</div>
								<?php else: ?>
								<div class="total">
								<span class="simpleCart_total1"></span> (<span id="simpleCart_quantity1" class="simpleCart_quantity1">
								0
								</span> items)
								</div>
								<?php endif; ?>
								<img src="<?php echo e(Request::root()); ?>/public/front/images/bag.png" alt="" />
							</h3>
						</a>
						<!-- <p><a href="javascript:;" class="simpleCart_empty">Empty Cart</a></p> -->
						<!-- <div class="clearfix"> 
							 <?php if(session(\App\Modules\Orders\Order::SESSION_KEY)): ?>
                <a class="dropdown-toggle cart-btn-header" href="<?php echo e(sysUrl('orders/cart/xl')); ?>">
                    <i class="icon-cart-checkout"></i>
                    <?php if(\App\Modules\Orders\Order::Current()): ?>
                        <span class="label label-default">(<?php echo e(\App\Modules\Orders\Order::Current()->items()->count('id')); ?>)</span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
						</div> -->
					</div>	
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
<!-- //header -->
<?php echo $__env->yieldContent('content'); ?>
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
					<!--<ul>-->
					<!--	<li><i class="glyphicon glyphicon-map-marker" aria-hidden="true"></i>1234k Avenue, 4th block, <span>New York City.</span></li>-->
					<!--	<li><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i><a href="mailto:info@example.com">info@example.com</a></li>-->
					<!--	<li><i class="glyphicon glyphicon-earphone" aria-hidden="true"></i>+1234 567 567</li>-->
					<!--</ul>-->
					
					<?php echo address(); ?>

				</div>
				<div class="col-md-4 footer-grid animated wow slideInLeft" data-wow-delay=".7s">
					<h3>Flickr Posts</h3>
					<?php //echo '>>'.count($productFooter);?>
					<?php foreach(postFooter() as $fProduct): ?>
					<?php
					$folder= $fProduct['photos'][0]['media']['folder'];
                	$fileName= $fProduct['photos'][0]['media']['filename'];

					?>
					<div class="footer-grid-left">
						<a href="<?php echo e(url('/single/')); ?>/<?php echo e(encryptIt($fProduct->id)); ?>"><img src="<?php echo e(Request::root()); ?>/public/<?php echo e($folder.$fileName); ?>" alt=" " onerror="this.onerror=null;this.src='<?=NO_IMG?>'" class="img-responsive" title="<?php echo e($product->name); ?>" /></a>
					</div>
					<?php endforeach; ?>
					<!-- <div class="footer-grid-left">
						<a href="single.html"><img src="images/14.jpg" alt=" " class="<?php echo e(Request::root()); ?>/public/front/<?php echo e(Request::root()); ?>/public/front/img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/15.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/16.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/13.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/14.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/15.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/16.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/13.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/14.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/15.jpg" alt=" " class="img-responsive" /></a>
					</div>
					<div class="footer-grid-left">
						<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/16.jpg" alt=" " class="img-responsive" /></a>
					</div> -->
					<div class="clearfix"> </div>
				</div>
				<!-- <div class="col-md-3 footer-grid animated wow slideInLeft" data-wow-delay=".8s">
					<h3>Blog Posts</h3>
					<div class="footer-grid-sub-grids">
						<div class="footer-grid-sub-grid-left">
							<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/9.jpg" alt=" " class="img-responsive" /></a>
						</div>
						<div class="footer-grid-sub-grid-right">
							<h4><a href="single.html">culpa qui officia deserunt</a></h4>
							<p>Posted On 25/3/2016</p>
						</div>
						<div class="clearfix"> </div>
					</div>
					<div class="footer-grid-sub-grids">
						<div class="footer-grid-sub-grid-left">
							<a href="single.html"><img src="<?php echo e(Request::root()); ?>/public/front/images/10.jpg" alt=" " class="img-responsive" /></a>
						</div>
						<div class="footer-grid-sub-grid-right">
							<h4><a href="single.html">Quis autem vel eum iure</a></h4>
							<p>Posted On 25/3/2016</p>
						</div>
						<div class="clearfix"> </div>
					</div>
				</div> -->
				<div class="clearfix"> </div>
			</div>
			<div class="footer-logo animated wow slideInUp" data-wow-delay=".5s">
				<!-- <h2><a href="index.html">Best Store <span>shop anywhere</span></a></h2> -->

				<a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(Request::root()); ?>/public/front/images/moretti-leather-bags-logo-new.png"></a>
			</div>
			<div class="copy-right animated wow slideInUp" data-wow-delay=".5s">
				<p>&copy 2019 Moretti Milano. All Rights Reserved.</p>
			</div>
		</div>
	</div>
<!-- //footer -->
</body>
</html>