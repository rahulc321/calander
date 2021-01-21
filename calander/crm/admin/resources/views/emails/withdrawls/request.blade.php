<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Withdraw Request</h2>

<div>
    Withdraw Request From: {{ $withdraw->creator ? $withdraw->creator->fullName() : '' }}<br>
    Withdraw Amount: {{ currency($withdraw->amount) }}<br>

    <br/><br/>
    Moretti Milano
</div>
</body>
</html>