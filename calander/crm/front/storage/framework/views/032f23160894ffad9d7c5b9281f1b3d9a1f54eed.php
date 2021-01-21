<?php $__env->startSection('title'); ?>
Contact Us
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="<?php echo e(url('/')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Contact Us</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- mail -->
	<div class="mail animated wow zoomIn" data-wow-delay=".5s">
		<div class="container">
			<h3>Contact Us</h3>
		<!--	<p class="est">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia 
				deserunt mollit anim id est laborum.</p>-->
			<div class="mail-grids">
			   
				<div class="col-md-8 mail-grid-left animated wow slideInLeft" data-wow-delay=".5s">
				<!---->
				<?php if(!empty(@$success_message)): ?>
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>	
                    <strong><?php echo e(@$success_message); ?></strong>
                </div>
                <?php endif; ?>
			    <!---->
					<form action="<?php echo e(url('/contact')); ?>" method="post">
						<input type="text" value="" placeholder="Name" required="" name="fname">
						<input type="email" value="" required="" placeholder="Email" name="email">
						<input type="text" value="" required="" placeholder="Subject" name="subject">
						<textarea type="text" required="" name="message"></textarea>
						<input type="submit" value="Submit Now" >
					</form>
				</div>
				<div class="col-md-4 mail-grid-right animated wow slideInRight" data-wow-delay=".5s">
					<div class="mail-grid-right1">
						<!--<img src="<?php echo e(Request::root()); ?>/public/front/images/3.png" alt=" " class="img-responsive" />-->
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
			<iframe class="animated wow slideInLeft" data-wow-delay=".5s" src="https://maps.google.com/maps?q=Piazza%20IV%20Novembre%204%20%2C%2020124%20Milano%20MI%2C%20Italy&t=&z=17&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
<!-- //mail -->


<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.front-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>