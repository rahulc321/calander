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
		<h2>Your Password Has been reset</h2>

		<div>
			Dear {{ $user->name }}
			<br/>
            
            Your new login information is as follows:
			<br/><br/><br/>
            Login URL: {{ url('auth/login') }} <br/>
            Your username: {{ $user->email }} <br/>
            Password: {{ $password }} <br/><br/>
            
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>