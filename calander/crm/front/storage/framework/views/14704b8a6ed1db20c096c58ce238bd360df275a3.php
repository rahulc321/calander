<?php $__env->startSection('title'); ?>
User Login
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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

			<?php if(Session::has('error')): ?>
			<p class="alert alert-danger cstm_forgot_dng"><?php echo e(Session::get('error')); ?></p>
			<?php endif; ?>
			</div>
			<?php if(@$recovery): ?>
			<p class="cstm_forgot_reco"><?php echo e(@$recovery); ?></p>
		    <?php endif; ?>
			<br>
				<form action="<?php echo e(url('/forgot')); ?>" method="post">
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<input type="email" placeholder="Email Address" required=" " name="email">
					<div class="forgot">
						<!-- <a href="#">Forgot Password?</a> -->
						<?php if(@$notfound): ?>
						<p class="cstm_forgot_notfnd"><?php echo e($notfound); ?></p>
						<?php endif; ?>
					</div>
					<input type="submit" value="Submit">
				</form>
			</div>
			<h4 class="animated wow slideInUp" data-wow-delay=".5s">For New People</h4>
			<p class="animated wow slideInUp" data-wow-delay=".5s"><a href="<?php echo e(url('/user-register')); ?>">Register Here</a> (Or) go back to <a href="<?php echo e(url('/')); ?>">Home<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
		</div>
	</div>
<!-- //login -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.front-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>