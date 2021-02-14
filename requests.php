<?php 

include 'server.php';
/*include 'offday.php';*/
/*include('errors.php');*/ 

$mobile_number = $_SESSION['mobile_number'];
$found4 = $collection3->find(['status' => 'Active', '$or' => [['time' => ['$gte' => $current_time], 'date' => ['$gte' => $current_date]], ['time' => ['$lte' => $current_time], 'date' => ['$gt' => $current_date]]], 'mobile_number' => [ '$ne' => $mobile_number]]);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $found5 = $collection3->find(['_id' => new MongoDB\BSON\ObjectId("$id")]);
    foreach ($found5 as $document) {
      $type =  $document["type"];
      $time = $document["time"];
      $date = $document["date"];
      $voltage = $document["voltage"];
    }

    if($type == "Buy"){
          $time_hour = explode(":",$time);
          $hour = $time_hour[0];

          $filename = "test.csv";
          $f = fopen($filename, 'w');
          $fields = array('DayofWeek', 'Weekend', 'Holiday', 'Voltage');
          fputcsv($f, $fields);
    
          $found7 = $collection2->find(['mobile_number' => $mobile_number, 
            'time' => $hour]);

          if(!empty($found7)){
      foreach ($found7 as $data) {
        $holiday = holiday($data['date']);
        $dayOfWeek = date("N", strtotime($data['date']));
        if($dayOfWeek == 5)
          $weekend = 1;
        else
          $weekend = 0;

        $lineData = array($dayOfWeek, $weekend, $holiday, $data['voltage']);
        fputcsv($f, $lineData);

      }
      
    }
    
        $holiday = holiday($date);
        $dayOfWeek = date("N", strtotime($date));
        if($dayOfWeek == 5)
          $weekend = 1;
        else
          $weekend = 0;

        $lineData = array($dayOfWeek, $weekend, $holiday);
        fputcsv($f, $lineData);
        fclose($f);

    $command = escapeshellcmd('test.py');
    $output = shell_exec($command);
    $output = floatval($output);
    $output = number_format($output, 2);
    $output = floatval($output);
    /*echo $output;*/

    if ($voltage > $output) {

        array_push($errors, "You can't share power more than $output watt");
        header('location: index.php');
        }
    if (count($errors) == 0) {

      if($collection3->updateOne(['_id' => new MongoDB\BSON\ObjectId("$id")],
        ['$set' => ['status' => 'Disable', 'action' => 'Accepted', 'from' => $mobile_number]])){
        header('location: index.php');
    }
    }
    else{

    }
}
else{
  if($collection3->updateOne(['_id' => new MongoDB\BSON\ObjectId("$id")],
        ['$set' => ['status' => 'Disable', 'action' => 'Accepted', 'to' => $mobile_number]])){
        header('location: index.php');
    }
}
    }


  foreach ($found4 as $data) {
        echo '
        <tr>
      <td>'.$data["date"].'</td>
      <td>'.$data["time"].'</td>
      <td>'.$data["type"].'</td>
      <td>'.$data["voltage"].'</td>
      <td>'.$data["mobile_number"].'</td>
      <td><button type="button" name = "accept" class="btn btn-light"><a href="requests.php?id='.$data["_id"].'">Accept</a></button></td>
    </tr>'  ;  
    }

?>
