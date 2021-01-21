<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" href="styles/kendo.common.min.css" />
    <link rel="stylesheet" href="styles/kendo.default.min.css" />
    <link rel="stylesheet" href="styles/kendo.default.mobile.min.css" />
<link href="https://kendo.cdn.telerik.com/2020.3.1021/styles/kendo.common.min.css" rel="stylesheet" />
    <link href="https://kendo.cdn.telerik.com/2020.3.1021/styles/kendo.default.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <script src="https://kendo.cdn.telerik.com/2020.3.1021/js/kendo.all.min.js"></script>
    <script src="js/jquery.min.js"></script>
    
    
    <script src="js/kendo.all.min.js"></script>
    
    

</head>
<body>
    
        <div id="example">
            <div class="demo-section k-content">

                <h4>Start time</h4>
                <input id="start" value="8:00 AM" style="width: 100%;" />

                <h4 style="margin-top: 2em;">End time</h4>
                <input id="end" value="8:30 AM" style="width: 100%;" />

            </div>
            <script>
                $(document).ready(function() {
                    function startChange() {
                        var startTime = start.value();

                        if (startTime) {
                            startTime = new Date(startTime);

                            end.max(startTime);

                            startTime.setMinutes(startTime.getMinutes() + this.options.interval);

                            end.min(startTime);
                            end.value(startTime);
                        }
                    }

                    //init start timepicker
                    var start = $("#start").kendoTimePicker({
                        change: startChange
                    }).data("kendoTimePicker");

                    //init end timepicker
                    var end = $("#end").kendoTimePicker().data("kendoTimePicker");

                    //define min/max range
                    start.min("8:00 AM");
                    start.max("6:00 PM");

                    //define min/max range
                    end.min("8:00 AM");
                    end.max("7:30 AM");
                });
            </script>

            <style>

            </style>
        </div>

    

</body>
</html>