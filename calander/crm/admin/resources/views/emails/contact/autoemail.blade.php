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
		<h2>You have new email from Invoice</h2>
		 
		<div>
			Dear {{ $data1['userName'] }},
			<br/>
            
			<br/>
            
            <br>InvoiceID</b> :  {{ $data1['InvoiceId'] }}<br/>
            <br>Subject</b> : {{ $data1['subject'] }}<br/><br/>
            <br>Message</b> : {!! $data1['message'] !!}<br/>
             
            
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>