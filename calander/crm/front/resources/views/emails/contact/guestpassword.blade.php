<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
	    <div style="text-align: center">
    <img src="https://crm.morettimilano.com/public/assets/images/logo.png" height="90">
    <br/>
    <!--<small style="font-size:12px;">MORETTI MILANO</small>-->
</div>
		<h2>Your Username and Password</h2>
		 
		<div>
			Dear 
			@if($data1)
			{{$data1['name']}}
			@endif
			<br/>
          
           <h4>Your log in credentials are:</h4>
            Email: {{ $data1['user_email'] }}<br/>
            Password: {{ $data1['password'] }}<br/>           
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>