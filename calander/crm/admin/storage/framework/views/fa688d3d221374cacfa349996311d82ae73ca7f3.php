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
		<h2>You have new email from User Info</h2>
		 
		<div>
			Dear Moretti Milano
			<br/>
            
			<br/>
            <p>Please find attachment.</p>
            <p style="color:green">Your Paid Amount : <b><?php echo e($data1['paidAmt']); ?></b></p>
            <p style="color:red">Your Unpaid Amount : <b><?php echo e($data1['unpaidAmt']); ?></b></p>
            <p>Your Invoice Id : <b><?php echo e($data1['InvoiceId']); ?></b></p>
 			<?php if(!empty($data1['message'])): ?>
            <p>Message : <b><?php echo $data1['message']; ?></b></p>
            <?php endif; ?>
            
            
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>