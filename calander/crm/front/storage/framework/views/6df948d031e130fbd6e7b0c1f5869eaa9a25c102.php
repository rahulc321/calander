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
            
            InvoiceID :  <?php echo e($data1['InvoiceId']); ?><br/>
            Paid Amount : <?php echo e($data1['paidAmt']); ?><br/>
            Unpaid Amount : <?php echo e($data1['unpaidAmt']); ?><br/>
            Message: <?php echo e($data1['message']); ?> <br/></br>
            

            <a href="http://localhost/crm/public/uploads/attachments/pdf/<?php echo e($data1['fileName']); ?>" class="btn btn-success">Click here to download pdf</a>
            
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>