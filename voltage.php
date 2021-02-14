<?php
include ('server.php') ;
 $mobile_number = $_SESSION['mobile_number'];
$voltage = "0.0";
    $time = $now->format('H');
    $minute = $now->format('i');
    
    $found2 = $collection2->find(array('mobile_number' => $mobile_number, 'date'=> $current_date, 'time' => $time));
    if($found2){
        foreach ($found2 as $document2) {
            $voltage = $document2["voltage"];
        }
    }

  echo "Current Voltage - ", $voltage;
?>