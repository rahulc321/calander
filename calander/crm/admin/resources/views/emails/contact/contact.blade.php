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
		<h2>Your have new email from Contact us</h2>
		 
		<div>
			Dear Moretti Milano
			<br/>
            
			<br/>
            
            Name:  {{ $data1['name'] }}<br/>
            Email: {{ $data1['user_email'] }}<br/>
            Message: {{ $data1['message'] }} <br/>
            
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>