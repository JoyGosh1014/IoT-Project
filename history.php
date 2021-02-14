<?php

include ('server.php') ;
$mobile_number = $_SESSION['mobile_number'];

$found3 = $collection2->find(array('mobile_number' => $mobile_number));

foreach ($found3 as $data) {
        echo '
        <tr>
      <td>'.$data["date"].'</td>
      <td>'.$data["time"].':00'.'</td>
      <td>'.$data["voltage"].'</td>
    </tr>'  ;  
    }

?>