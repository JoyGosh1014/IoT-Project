<?php include ('server.php') ;
/*include ('requests.php');*/
//session_start(); 

	if (!isset($_SESSION['mobile_number'])) {
		header('location: login.php');
        
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['mobile_number']);
		header("location: login.php");
	}

  if ((isset($_POST['sell'])) and (count($errors) > 0)){
  echo "<script type='text/javascript'>
  $('#SellModal').modal('show');
  </script>";
}
    

if ((isset($_POST['buy'])) and (count($errors) > 0)){
  echo "<script type='text/javascript'>
  $('#BuyModal').modal('show');
  </script>";
}

  
    $mobile_number = $_SESSION['mobile_number'];
    $found = $collection1->find(array('mobile_number' => $mobile_number));
    if($found){
        foreach ($found as $document) {
            $id = $document["_id"];
            $owner_name = $document["owner_name"];
            $firm_name = $document["firm_name"];
            $location = $document["location"];
            $fileName = $document["fileName"];

        }
    }

    

    $found3 = $collection2->find(array('mobile_number' => $mobile_number));

    

   
    
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>



<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
    


    <title>Profile</title>
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
                      <li class="nav-item active"><a href="index.php" class="nav-link" >Profile</a></li>
                      <li class="nav-item"><a href="requesthistory.php" class="nav-link">Request History</a></li>
                      <li class="nav-item"><a href="index.php?logout='1'" class="nav-link" >Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--Body section starts-->
    <section id="body">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header bg-white text-primary text-center "><h3>Profile</h3></div>
                        <div class = "card-img-top text-center p-2">
                        <?php echo '<img src="img/'.$fileName.'" width="300" height = "300" alt="profile image">' ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark text-center">About</h5>
                            <hr>
                            <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary">
                                <?php echo "Owner Name - ", $owner_name;?> </div>

                            <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary">
                                <?php echo "Owner of ", $firm_name;?> </div>

                            <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary">
                                <?php echo "Location - ", $location; ?> </div>

                            <div class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary">
                                <?php echo "Mobile Number - ", $mobile_number;?> </div>

                            <div id="voltage" class="border border-primary rounded-pill shadow p-1 mb-2 bg-white rounded font-weight-bolder text-center text-primary">
                                </div>
                           
                        </div>
                    </div>
                  </div>
                
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                              <li class="nav-item">
    <a class="nav-link active" id="makerequest-tab" data-toggle="tab" href="#makerequest" role="tab" aria-controls="makerequest" aria-selected="true">Make Request</a>
  </li>

  <li class="nav-item">
    <a class="nav-link " id="history-tab" data-toggle="tab" href="#history" role="tab" aria-controls="history" aria-selected="true">History</a>
  </li>
  
  <li class="nav-item">
    <a class="nav-link" id="request-tab" data-toggle="tab" href="#request" role="tab" aria-controls="request" aria-selected="true">Request</a>
  </li>
</ul>
                        </div> <!-- card header -->
                        <div class="card-body">
                        
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade " id="history" role="tabpanel" aria-labelledby="history-tab">
      <div>
          <table class="table table-bordered table-striped table-primary table-responsive-sm" id="myTable">
  <thead class="thead-light">
    <tr>
      <th>Date</th>
      <th>Hour</th>
      <th>Voltage</th>
    </tr>
  </thead>
  <tbody>
    <?php  
    foreach ($found3 as $data) {
        echo '
        <tr>
      <td>'.$data["date"].'</td>
      <td>'.$data["time"].':00'.'</td>
      <td>'.$data["voltage"].'</td>
    </tr>'  ;  
    }
         
    ?>
  </tbody>
</table>
</div> <!-- table -->
  </div>
  <div class="tab-pane fade show active text-center " id="makerequest" role="tabpanel" aria-labelledby="makerequest-tab">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#SellModal">Make Request for Sell</button>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#BuyModal">Make Request for Buy</button>

  <!-- Modal -->
<div class="modal fade" id="SellModal" tabindex="-1" role="dialog" aria-labelledby="SellModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="SellModalLabel">Request for Sell</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="index.php">

           <?php include('errors.php'); ?> 

            <div class="form-group row ">
              <label for="date" class="col-sm-3 col-form-label">Date:</label>
              <div class="col-sm-9">
                <input type="date" class="form-control" id="date" name="date">
              </div>
            </div>

            <div class="form-group row">
              <label for="time" class="col-sm-3 col-form-label">Time:</label>
              <div class="col-sm-9">
                <input type="time" class="form-control" id="time" name="time">
              </div>
            </div>
            <div class="form-group row">
              <label for="voltage" class="col-sm-3 col-form-label">Voltage:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="voltage" name="voltage">
              </div>
            </div>
            <input type="hidden" name="mobile_number" value="<?php echo $mobile_number; ?>">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  type="submit" name = "sell" class="btn btn-primary">Submit Request</button>
          </form>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="BuyModal" tabindex="-1" role="dialog" aria-labelledby="BuyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="BuyModalLabel">Request for Buy</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form method="post" action="index.php">

           <?php include('errors.php'); ?> 

            <div class="form-group row ">
              <label for="date" class="col-sm-3 col-form-label">Date:</label>
              <div class="col-sm-9">
                <input type="date" class="form-control" id="date" name="date">
              </div>
            </div>

            <div class="form-group row">
              <label for="time" class="col-sm-3 col-form-label">Time:</label>
              <div class="col-sm-9">
                <input type="time" class="form-control" id="time" name="time">
              </div>
            </div>
            <div class="form-group row">
              <label for="voltage" class="col-sm-3 col-form-label">Power:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="voltage" name="voltage">
              </div>
            </div>
            <input type="hidden" name="mobile_number" value="<?php echo $mobile_number; ?>">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  type="submit" name = "buy" class="btn btn-success">Submit Request</button>
          </form>
      </div>
    </div>
  </div>
</div>
  </div>
  <div class="tab-pane fade" id="request" role="tabpanel" aria-labelledby="request-tab">
   <table class="table table-bordered table-striped table-primary table-responsive-sm" id="RequestTable">
    <thead class="thead-light">
    <tr>
      <th>Date</th>
      <th>Time</th>
      <th>Type</th>
      <th>Voltage</th>
      <th>Mobile Number</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id = "hi">

  

</tbody>
</table>
</div>
</div>
</div> <!-- card body -->
                      </div> <!-- card -->
                    </div> <!-- col sm 8 -->
                </div> <!-- row -->
            </div> <!-- container -->
          </section>
        </div>

      
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->




<script>
    $(document).ready( function () {
      $('#myTable').DataTable();
      $('#RequestTable').DataTable();
    setInterval(function () {
      
     
        $('#voltage').load('voltage.php');
        $('#hi').load('requests.php');
        refresh();
      }, 1000);
  });
</script>



<!-- <script>
    $('.carousel').carousel({
        interval: 1500
    })
</script> -->
 

 <?php 


if (count($errors) > 0){
  echo "<script type='text/javascript'>
  $('#SellModal').modal('show');
  </script>";
}
    
?> 
</body>
</html>