<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
	    <div style="text-align: center">
    <img src="<?php echo e(asset('assets/images/moretti-leather-bags-logo-1.png')); ?>" height="90">
    <br/>
    <!--<small style="font-size:12px;">MORETTI MILANO</small>-->
</div>
		<h2>Your Password Has been reset</h2>

		<div>
			Dear <?php echo e($user->name); ?>

			<br/>
            
            Your new login information is as follows:
			<br/><br/><br/>
            Login URL: <?php echo e(url('auth/login')); ?> <br/>
            Your username: <?php echo e($user->email); ?> <br/>
            Password: <?php echo e($password); ?> <br/><br/>
            
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>