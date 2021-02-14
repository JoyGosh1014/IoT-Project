<?php include ('server.php') ;
//session_start(); 

  if (!isset($_SESSION['mobile_number'])) {
    header('location: login.php');
        
  }

  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['mobile_number']);
    header("location: login.php");
  }
  $mobile_number = $_SESSION['mobile_number'];

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if($collection3->updateOne(['_id' => new MongoDB\BSON\ObjectId("$id")],
      ['$set' => ['status' => 'Disable']])){
      header('location: requesthistory.php');

    }
  }

  $collection3 = $db->Request; 
    $found4 = $collection3->find(array('mobile_number' => $mobile_number, 'status' => "Active"));

    $found5 = $collection3->find(array('mobile_number' => $mobile_number));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

    <title>Request History</title>
</head>
<body>
<div id="page">
    <!--Header Starts-->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <h4>
                    <a href="index.php" class="navbar-brand">SMART GRID</a>
                </h4>
                <button type="button" class="navbar-toggler btn-sm" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div id="menu" class="collapse navbar-collapse">
                    <ul class="navbar-nav ml-auto">
                      <li class="nav-item "><a href="index.php" class="nav-link" >Profile</a></li>
                      <li class="nav-item active"><a href="requesthistory.php" class="nav-link">Request History</a></li>
                      <li class="nav-item"><a href="requesthistory.php?logout='1'" class="nav-link" >Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--Body section starts-->
    <section id="body">
        <div class="container">
          <div class="card">
            <div class="card header">
              <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="activerequest-tab" data-toggle="tab" href="#activerequest" role="tab" aria-controls="activerequest" aria-selected="true">Active Request</a>
  </li>
  <li class="nav-item">
    <a class="nav-link " id="allrequest-tab" data-toggle="tab" href="#allrequest" role="tab" aria-controls="allrequest" aria-selected="true">All Request</a>
  </li>
</ul>
            </div>
            
                            
                    
            <div class="card body">           
<div class="tab-content " id="myTabContent">
  <div class="tab-pane fade show active  " id="activerequest" role="tabpanel" aria-labelledby="activerequest-tab">
    <div class="p-3">
          <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="activeRequestTable">
  <thead class="thead-light ">
    <tr>
      <th>Date</th>
      <th>Time</th>
      <th>Type</th>
      <th>Voltage</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php  
    foreach ($found4 as $data) {
        echo '
        <tr>
      <td>'.$data["date"].'</td>
      <td>'.$data["time"].'</td>
      <td>'.$data["type"].'</td>
      <td>'.$data["voltage"].'</td>
      <td><button type="button" class="btn btn-light"><a href="requesthistory.php?id='.$data["_id"].'">Disable</a></button></td>
    </tr>'  ;  
    }

         
    ?>
  </tbody>
</table>
</div>
 </div>
      
  <div class="tab-pane fade " id="allrequest" role="tabpanel" aria-labelledby="allrequest-tab">
    <div class="p-3">
    <table class="table text-center table-bordered table-striped table-primary table-responsive-sm" id="allRequestTable">
  <thead class="thead-light">
    <tr>
      <th>Date</th>
      <th>Time</th>
      <th>Type</th>
      <th>Voltage</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <?php  
    foreach ($found5 as $data2) {
        echo '
        <tr>
      <td>'.$data2["date"].'</td>
      <td>'.$data2["time"].'</td>
      <td>'.$data2["type"].'</td>
      <td>'.$data2["voltage"].'</td>
      <td>'.$data2["status"].'</td>
    </tr>'  ;  
    }

         
    ?>
  </tbody>
</table>
</div>
      
      </div>
      
    </div>
</div>
</div>
</div>
</section>
            </div> <!-- container -->
        
      

      
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>

<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(document).ready( function () {
    $('#allRequestTable').DataTable();
} );</script>

<script>
    $(document).ready( function () {
    $('#activeRequestTable').DataTable();
} );</script>

</body>
</html>