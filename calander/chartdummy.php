<?php
/* Template Name: Chart */



?>
<?php

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

$sql = "SELECT * FROM activity where app ='QC-Score' and `date` ='2020-02-12'";
$sql = "SELECT * FROM activity where app ='QC-Score'";
$result = $conn->query($sql);

    $data = [];
    while($row = $result->fetch_assoc()) {
       $data[] = $row;
    }
    
    
    /*$group = [];
    foreach ($data as $item)  {
        if (!isset($group[$item['date']])) {
            $group[$item['date']] = [];
        }
        foreach ($item as $key => $value) {
            if ($key == 'date') continue;
            $group[$item['date']][$key] = $value;
        }
    }*/
     
    function group_by($key, $data) {
    $result = array();
    
    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            
            $result[$val[$key]][] = $val;
            
        }else{
             
            $result[""][] = $val;
        }
    }

    return $result;
    }
    
    
 
     
    $final_result= group_by('date',$data);

    //echo '<pre>';print_r($final_result);die;
    $app1 = [];
    $i=0;
    $userData=[];
    $name1="";
    foreach($final_result as $key=>$allData){
       //echo '<pre>';print_r($allData);
         
        $date = strtotime($key)*1000;
        $new_date = date('M j Y', $date);
        $allcount= count($allData);
        
         
        
        foreach($allData as $cData){
            //echo '--'.$cData['id'].'--'.$cData['date']; echo '<br>';
            
        $sql1 = "SELECT * FROM user where id =".$cData['id'];
        $result1 = $conn->query($sql1);
        while ($row2 = $result1 -> fetch_assoc()) {
            
            $name= $row2['username'];
            $userData['uData'][]=$row2;
            $userData['uDate'][]=$key;
            $userData['mnts'][]=$cData['value'];
            $minutes =$cData['value'];
            $name1= "<b>".$name."</b> :  ".$minutes." mimutes <br>";
            
            $app1[] = array("x"=>$date, "y"=> $cData['value']);
            //$app1[] = array("y" => $cData['value'],"x" => $date);
        }
            
        }
        
       // echo $allData[$i]['id']; echo '--'.$key; echo '<pre>';
      $i++;  
    }
    

 //echo '<pre>';print_r($app1);die;

/* $app1 = array(
  array("x" => 1483381800000 , "y" => 12),
  array("x" => 1483381800000 , "y" => 1));*/


// echo '<pre>';print_r($app1);die;
 //  array("x" => 1483468200000 , "y" => 700),
 //  array("x" => 1483554600000 , "y" => 710),
 //  array("x" => 1483641000000 , "y" => 658),
 //  array("x" => 1483727400000 , "y" => 734),
 //  array("x" => 1483813800000 , "y" => 963),
 //  array("x" => 1483900200000 , "y" => 847),
 //  array("x" => 1483986600000 , "y" => 853),
 //  array("x" => 1484073000000 , "y" => 869),
 //  array("x" => 1484159400000 , "y" => 943),
 //  array("x" => 1484245800000 , "y" => 970),
 //  array("x" => 1484332200000 , "y" => 869),
 //  array("x" => 1484418600000 , "y" => 890),
 //  array("x" => 1484505000000 , "y" => 930)
 // );
 
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
   
  title:{
    text: "Site Traffic"
  },
  axisX: {
    valueFormatString: "DD MMM YYYY"
  },
  
  data: [{
    type: "spline",
    color: "#6599FF",
    xValueType: "dateTime",
    xValueFormatString: "DD MMM",
    yValueFormatString: "ll",
    dataPoints: <?php echo json_encode($app1); ?>
  }]
});
 
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>    