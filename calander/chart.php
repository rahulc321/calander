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
foreach($array as $appNam){
if($fromDate != "" && $toDate !=""){    
$sql = "SELECT * FROM `activity` WHERE `app` LIKE '%$appNam%' and (`date` BETWEEN '".$fromDate."' AND '".$toDate."')";

}else{

//$sql = "SELECT * FROM `activity` WHERE `app` LIKE '%$appNam%' and `date` = '2019-11-30'" ;
$sql = "SELECT * FROM `activity` WHERE `app` LIKE '%$appNam%'" ;

}
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
            
        $sql1 = "SELECT * FROM user where id =".$cData['id'];
        $result1 = $conn->query($sql1);
        while ($row2 = $result1 -> fetch_assoc()) {
                 
             //$name="";
                if($userId != $cData['id']
                ){

                $sqlApp = "SELECT sum(value) as totalmnt FROM activity where `app` LIKE '%$appNam%' and id =".$cData['id']." and `date`='".$key."'";
                //$sql1 = "SELECT * FROM user where id =".$cData['id'];
                $resultApp = $conn->query($sqlApp);
                while ($rowApp = $resultApp -> fetch_assoc()) {

                   // echo '<pre>';print_r($rowApp['totalmnt  ']);
                if($row2['firstname'] !="" && $row2['lastname'] !=""){
                    $name= $cData['id'];

                }else{
                    $name= $row2['username'];
                }
                    $name1[]= $name.":  ".$rowApp['totalmnt']." Minute";

                }

            }
 
            $userId=$cData['id'];
            
            $minutes =$cData['value'];
            $sum+=$minutes;
            //$name1[]= $name.":  ".$minutes." Minute";
               
        }

    }   
        $n= implode("<br>",$name1);
       // echo $n;
        $app1[$appNam][] = array( "y"=> $sum, "label"=>$new_date,'user'=>$n,'total'=>$sum,'usercount'=>count($name1),'appnmae'=>$appNam);
         
         
    }
}


}


$array= array ('TY-', 'AA-', 'QC-', 'PP-', 'AO-');
foreach ($array as $key => $value) {

    $sqlData = "SELECT * FROM `activity` WHERE `app` LIKE '%TY-%'";
    $resultData = $conn->query($sqlData);

    $dataApp = [];
    while($rowData = $resultData->fetch_assoc()) {
       $dataApp[] = $rowData;
    }

    $appName= group_by_name('app',$dataApp);
    $array= array();
    foreach ($appName as $key => $value) {
        $array[]=$key;
    }

//echo '<pre>';print_r($array);
$appData1=[];
foreach($array as $appNam){
//$sql = "SELECT * FROM activity where app ='".$appNam."'";
if($fromDate != "" && $toDate !=""){    
$sql = "SELECT * FROM `activity` WHERE `app` LIKE '%$appNam%' and (`date` BETWEEN '".$fromDate."' AND '".$toDate."')";

}else{

$sql = "SELECT * FROM `activity` WHERE `app` LIKE '%$appNam%'";

}
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
            
        $sql1 = "SELECT * FROM user where id =".$cData['id'];
        $result1 = $conn->query($sql1);
        while ($row2 = $result1 -> fetch_assoc()) {
                          
                           
            $name="";
             
                /*if($userId != $cData['id']
                ){

                $sqlApp = "SELECT sum(value) as totalmnt FROM activity where `app` LIKE '%$appNam%' and id =".$cData['id']." and `date`='".$key."'";
                //$sql1 = "SELECT * FROM user where id =".$cData['id'];
                $resultApp = $conn->query($sqlApp);
                while ($rowApp = $resultApp -> fetch_assoc()) {

                   // echo '<pre>';print_r($rowApp['totalmnt  ']);
                if($row2['firstname'] !="" && $row2['lastname'] !=""){
                $name= $row2['username'];
                }else{
                    $name= $row2['username'];
                }
                    $name1[]= $name.":  ".$rowApp['totalmnt']." Minute";

                }*/

            //}
 
            $userId=$cData['id'];
            
            $minutes =$cData['value'];
            $sum+=$minutes;
               
        }

    }
        $n= implode("<br>",$name1);
       // echo $n;
        $appData1[$appNam][] = array( "y"=> $sum, "label"=>$new_date,'user'=>$n,'total'=>$sum,'usercount'=>count($name1),'appnmae'=>$appNam);
         
         
    }
}


}





    # code...
}



 $phpArray= array("type"=>'spline',"name"=>'TYO',"showInLegend"=>true,'toolTipContent'=>'rahul',"dataPoints"=>$app1);

 $dataAll= json_encode($phpArray,JSON_NUMERIC_CHECK); 
//echo count($app1);die;
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
                    dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
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
    data: dataAll
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


// app app
<?php
$i=1;
    foreach($appData1 as $key => $data) {?>
var chart<?=$i?> = new CanvasJS.Chart("chartContainer<?=$i?>", {
    title: {
        text: "App Visitors"
    },
    legend:{
        cursor: "pointer",
        itemclick: toggleDataSeries1
    },
    axisY: {
        title: "Total Minutes"
    },
    data:  [{
                    type: "spline",
                    name: "<?php echo $key;?>",
                    showInLegend: "true",
                    toolTipContent: "<div style='overflow: scroll'><span style='color:green'>App Name : {appnmae}</span><br><span style='color:green'>{label} &nbsp;<i style='color:red'>Total Minutes {total}</i></span><br><span style='color:green'>Total Users {usercount}</span><br>{user}</div>",
                    dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
            }]
});
chart<?=$i?>.render();

function toggleDataSeries1(e){
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else{
        e.dataSeries.visible = true;
    }
    chart<?=$i?>.render();
    
}

 <?php
 

 $i++;
  } 
    ?>


 
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
<?php
$i=1;
    foreach($appData1 as $key => $data) {?>
<br>
<br>
<div id="chartContainer<?=$i?>" style="height: 370px; width: 100%;"></div>
<?php $i++; } ?>
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

