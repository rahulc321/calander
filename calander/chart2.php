<?php
/* Template Name: Chart */
      
$servername = "localhost";
$username = "root";
//$username = "atacadem_squall";
//$password = "!QRa)]Fr1~B9";
$password = "123456";
//$dbname = "atacadem_gardenDB";
$dbname = "chart";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$fromDate="";
$toDate="";

if(isset($_POST['submit'])){
    if($_POST['from'] !="" && $_POST['to'] !=""){ 
   $fromDate=date("Y-m-d", strtotime($_POST['from'])); 
    $toDate=date("Y-m-d", strtotime($_POST['to']));
    }

}
 
  function group_by($key, $data,$appKey) {
    $result = array();
    
    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            
            $result[$appKey][$val[$key]][] = $val;
            
        }else{
             
            $result[$appKey][""][] = $val;
        }
    }

    return $result;
    }


    function group_by_name($key, $data) {
    $result1 = array();
    
    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            
            $result1[$val[$key]][] = $val;
            
        }else{
             
            $result1[""][] = $val;
        }
    }

    return $result1;
    }



    

$array= array ('TY-', 'AA-', 'QC-', 'PP-', 'AO-');
//$array= array ('QC-');
$app1=[];
/*foreach($array as $appNam){
if($fromDate != "" && $toDate !=""){    
$sql = "SELECT * FROM `activity` WHERE `app` LIKE '%$appNam%' and (`date` BETWEEN '".$fromDate."' AND '".$toDate."')";

}else{*/

//$sql = "SELECT * FROM `activity` WHERE `app` LIKE '%$appNam%' and `date` = '2019-11-30'" ;
$sql = "SELECT * FROM `activity` WHERE `app` LIKE '%QC-%' and `date`='2019-11-25'" ;

//}
$result = $conn->query($sql);

    $data = [];
    while($row = $result->fetch_assoc()) {
       $data[] = $row;
    }

  
    
    //echo $appNam;
    $final_result= group_by('date',$data,$appNam);
    // $app1 = [];
    // echo '<pre>';print_r($final_result);
    if(!empty($final_result)){
    $sum=0;
    foreach($final_result[$appNam] as $key=>$allData){
    $name1 = array();
    $sum=0;
      // echo '<pre>';print_r($key);echo '<br>';
       $date = strtotime($key);
        $new_date = date('M j Y', $date);

        $userId="";
        foreach($allData as $cData){
            
        $sum1=0;
        $sql1 = "SELECT * FROM user where id =".$cData['id'];
        $result1 = $conn->query($sql1);
        while ($row2 = $result1 -> fetch_assoc()) {
            $minutes =$cData['value'];
            $sum+=$minutes; 
             $name="";

                if($row2['id']==$cData['id']){
                    $sum1+=$cData['value'];
                }

               // if($userId != $cData['id']
               //  ){
                echo $row2['username'].'-'.$sum1; echo '<br>';
              
               // $name1[]= $row2['username'].":  ".$row2['username']." Minute";
                //}

            $userId=$cData['id'];   
        }

    }   
        $n= implode("<br>",$name1);
       // echo $n;
        $app1[] = array( "y"=> $sum, "label"=>$new_date,'user'=>$n,'total'=>$sum,'usercount'=>count($name1),'appnmae'=>'tc');
         
         
    }
}


//}
// Comparison function 
function date_compare($element1, $element2) { 
    $datetime1 = strtotime($element1['label']); 
    $datetime2 = strtotime($element2['label']); 
    return $datetime1 - $datetime2; 
}  
  
// Sort the array  
usort($app1, 'date_compare'); 
  
// Print the array 
  
//echo '<pre>';print_r($app1);
 
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
    var dataAll= [];
    <?php
        foreach($app1 as $key => $data) {?>
            dataAll.push( {
                    type: "spline",
                    name: "<?php echo $key;?>",
                    showInLegend: "true",
                    toolTipContent: "<div style='overflow: scroll'><span style='color:green'>App Name : {appnmae}</span><br><span style='color:green'>{label} &nbsp;<i style='color:red'>Total Minutes {total}</i></span><br><span style='color:green'>Total Users {usercount}</span><br>{user}</div>",
                    dataPoints: <?php echo json_encode($app1, JSON_NUMERIC_CHECK); ?>
            });
    <?php } 
    ?>
    
var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        text: "App Visitors"
    },
    legend:{
        cursor: "pointer",
        itemclick: toggleDataSeries
    },
    axisY: {
        title: "Total Minutes"
    },
    data: [{
                    type: "spline",
                    name: "TY+QC+AA+AO+PP",
                    showInLegend: "true",
                    toolTipContent: "<div style='overflow: scroll'><span style='color:green'>{label} &nbsp;<i style='color:red'>Total Minutes {total}</i></span><br><span style='color:green'>Total Users {usercount}</span><br>{user}</div>",
                    dataPoints: <?php echo json_encode($app1, JSON_NUMERIC_CHECK); ?>
            }]
});
chart.render();

function toggleDataSeries(e){
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else{
        e.dataSeries.visible = true;
    }
    chart.render();
    
}


 


 
}
</script>
<style type="text/css">
    .box {
  
  /*float: left;*/
  height: 20px;
  width: 20px;
  /*border: 1px solid black;*/
  border-radius: 1.5px;
  display: inline-block;
  /*clear: both;*/
}

.red {
  background-color: red;
}

.green {
  background-color: green;
}

.blue {
  background-color: blue;
}
.yellow {
  background-color: yellow;
}

/*span {
    margin-left: 10px;
    margin-right: 20px;
}*/

.container {
    padding-top: 18px;
}
.btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
    /* padding-top: 4px; */
    margin-top: 25px;
    margin-left: 10px;
}
a.canvasjs-chart-credit {
    display: none;
}
</style>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> 
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

    <div class="container">
        <h4>Date Filter</h4>
            <form class="dd" action="" method="post">
                <div class="form-group" style="float:left">
                    <label>From Date</label>
                    <input type="text" class="form-control" id="txtStartDate" name="from" value="<?=@$_POST['from']?>">
                </div>
                <div class="form-group" style="float:left">

                    <label>To Date</label>
                    <input type="text" class="form-control" id="txtEndDate" name="to" value="<?=@$_POST['to']?>">
                </div>
                <div class="form-group">
                    <button class="btn btn-success" name="submit">Submit</button>
                </div>
            </form>
    </div>

    <div style="clear:both"></div>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
 
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>     
<?php //get_footer(); ?>

 <script>
  $( function() {
    $("#txtStartDate").datepicker({ format: "dd/mm/yyyy" });
    $("#txtEndDate").datepicker({format: "dd/mm/yyyy"});
  } );
  </script>

<?php //get_footer(); ?>

