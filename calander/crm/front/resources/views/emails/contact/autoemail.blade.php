<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
	    <div style="text-align: center">
    <img src="{{ asset('assets/images/moretti-leather-bags-logo-1.png') }}" height="90">
    <br/>
    <!--<small style="font-size:12px;">MORETTI MILANO</small>-->
</div>
		<h2>You have new email from User Info</h2>
		 
		<div>
			Dear Moretti Milano
			<br/>
            
			<br/>
            
            InvoiceID :  {{ $data1['InvoiceId'] }}<br/>
            Subject : {{ $data1['subject'] }}<br/>
            Message : {{ $data1['message'] }}<br/>
             
            
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>