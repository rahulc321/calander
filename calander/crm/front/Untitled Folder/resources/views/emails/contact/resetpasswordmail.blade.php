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
		<h2>Reset your Password</h2>
		 
		<div>
			Dear 
			@if($data1)
			{{$data1['name']}}
			@endif
			<br/>
          
           <h4><a href="{{url('/reset')}}/{{$data1['id']}}">Click here</a> to reset your password</h4>           
            <br/><br/>
			Moretti Milano
		</div>
	</body>
</html>