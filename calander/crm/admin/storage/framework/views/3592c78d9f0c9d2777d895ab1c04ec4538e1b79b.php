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
		<h2>You have new email from Invoice</h2>
		 
		<div>
			Dear <?php echo e($data1['userName']); ?>,
			<br/>
            
			<br/>
            
            <br>InvoiceID</b> :  <?php echo e($data1['InvoiceId']); ?><br/>
            <br>Subject</b> : <?php echo e($data1['subject']); ?><br/><br/>
            <br>Message</b> : <?php echo $data1['message']; ?><br/>
             
            
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>