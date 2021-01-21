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
		<h2>Registration Successful</h2>
		Dear User
			<br/>
			Click here to reset your password: {{ url('password/reset/'.$token) }}

			<br/><br/>
			Moretti Milano
	</body>
</html>