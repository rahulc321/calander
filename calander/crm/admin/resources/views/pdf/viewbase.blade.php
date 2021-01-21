<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="">
    <link rel="shortcut icon" href="" type="image/png">

    <title>
        @section('title')
        Print Report
        @show
    </title>
    
     <style>
         
		body
		{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
		}
		table, td
		{
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size:12px;
		}

       .headrowformat
       {
           text-align: center;
           font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
           font-size:20px;
           background-color: #92d050;
           color:#000000;
           letter-spacing: -0.5px;
       }

        .smallheadformat
        {
            text-align: center;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size:16px;
            background-color: #92d050;
            color:#000000;
            letter-spacing: -0.5px;
        }

        .smallhead
        {
            text-align: center;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size:12px;
            background-color: #92d050;
            color:#000000;
            text-transform: uppercase;
            letter-spacing: -0.5px;
        }

        .personlabel
        {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size:12px;
            padding-left:5px;
            padding-right:5px;
            text-align: left;
        }

         .blankrow
         {
             min-height: 9px;
         }

        table.gridtable {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color:#333333;
            border-width: 1px;
            border-color: #0c1318;
            border-collapse: collapse;
            width: 99%;
            margin-left:5px;
            margin-top:5px;
            margin-bottom:5px;
        }

        table.gridtable th
        {
            font-size:11px;
            border-width: 1px;
            padding: 6px;
            border-style: solid;
            border-color: #0c1318;
            background-color:#58ceb1;
            text-align: center;
            text-transform: uppercase;
        }

        table.gridtable td
        {
            font-size:11px;
            border-width: 1px;
            padding: 6px;
            border-style: solid;
            border-color: #0c1318;
            background-color: #ffffff;
        }

        .softtable
        {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color:#333333;
            border-width: 1px;
            border-color: #0c1318;
            border-collapse: collapse;
        }

        table.softtable td
        {
            font-size:11px;
            border-width: 1px;
            padding: 8px;
            border-style: solid;
        }

         .softbg
         {
             font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
             text-transform: uppercase;
             background-color:#58ceb1;
             font-size:11px;
         }

         .ucase
        {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
             font-size:11px;
            text-transform: uppercase;
        }

        .imgspace
        {
            padding-top:5px;
            padding-bottom:5px;
        }
    </style>

    {{-- Custom Css HERE--}}
    @section('styles')
    @show

</head>

<body>
@yield('body')
</body>
</html>