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
</div><br/>
    
<h2>{{ $email->subject }}</h2>

<div>
    Dear {{ @$invoice->order->creator ? $invoice->order->creator->fullName() : 'User' }}
    <br/>

    @if($dateDiff->days <= 10)
        This is the message for 10 days
    @else
        this is the message for after 10 days
    @endif

    <br/><br/>
    Moretti Milano
</div>
</body>
</html>