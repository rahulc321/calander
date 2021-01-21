<?php $__env->startSection('title'); ?>
Unscribe
<?php $__env->stopSection(); ?>
<?php $__env->startSection('description1'); ?>
Registered users can login here to buy Italian leather handbags products online from the Moretti Milano store.
<?php $__env->stopSection(); ?>
<?php $__env->startSection('keywords'); ?>
luxury italian leather handbags, genuine italian leather handbags, luxury italian leather bags, italian leather bags online, italian leather handbags online, buy italian leather bags, italian leather ladies bags, ladies italian leather handbags
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title1'); ?>
Unscribe
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
				<li><a href="<?php echo e(url('/')); ?>"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
				<li class="active">Unscribe Page</li>
			</ol>
		</div>
	</div>
<!-- //breadcrumbs -->
<!-- login -->
<br>
<?php if(@$reset_success): ?>
<p class="cstm_login_success"><?php echo e(@$reset_success); ?></p>
<?php endif; ?>
	<div class="login">
		<div class="container">
			<div class="centr"><h1 class="animated wow zoomIn" data-wow-delay=".5s">Unscription Form</h1></div><hr>
			
			<div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
				<div class="message">

			<?php if(Session::has('error')): ?>
			<p class="alert alert-danger cstm_login_error"><?php echo e(Session::get('error')); ?></p>
			<?php endif; ?>
			</div>
			<br>
				<form action="<?php echo e(url('/user-login')); ?>" method="post">
					<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
					<input type="email" placeholder="Email Address" required=" " name="email">
					 
					<input type="submit" value="Unscribe">
					 
				</form>
			</div>
			 
		</div>
	</div>
<!-- //login -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('webpanel.layouts.front-layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>