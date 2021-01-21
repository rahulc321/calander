<?php $__env->startSection('title'); ?>
Unsubscribe
<?php $__env->stopSection(); ?>
<?php $__env->startSection('description1'); ?>
Registered users can login here to buy Italian leather handbags products online from the Moretti Milano store.
<?php $__env->stopSection(); ?>
<?php $__env->startSection('keywords'); ?>
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title1'); ?>
Unsubscribe
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="<?php echo e(url('/')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
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

			<?php if(Session::has('error')): ?>
			<p class="alert alert-danger cstm_login_error" style="color:red"><?php echo e(Session::get('error')); ?></p>
			<?php endif; ?>
			</div>
			<br>
				<form action="<?php echo e(url('/unsubscribe-email')); ?>" method="post">
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<input type="email" placeholder="Email Address" required=" " name="email" value="<?php echo e($email); ?>" readonly="">
					 
					<input type="submit" value="Unsubscribe">
					<a class="" href="<?php echo e(url('/')); ?>">Go Back </a>
					 
				</form>
				<br>
				
			</div>

			 
		</div>
	</div>
<!-- //login -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.front-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>