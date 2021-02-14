<?php include ('server.php') ;
if (isset($_SESSION['mobile_number'])) {
        header('location: index.php');
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
    <title>Sign In</title>
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
                      <li class="nav-item active"><a href="login.php" class="nav-link" >Sign IN</a></li>
                      <li class="nav-item"><a href="registration.php" class="nav-link">Sign UP</a></li>
                      
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!--Body section starts-->
    <section id="body">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class = "col-sm-5">
                    <div class="card">
                       <div class="card-header bg-primary text-center font-weight-bolder text-white "><h1>
                            Login</h1>
                        </div>
                        <div class="card-body">
                            <form method="post" action="login.php">

                            	<?php include('errors.php'); ?>

                                <div class="form-group">
                                    <label for="mobile_number">Mobile Number:</label>
                                    <input type="text" class="form-control" id="mobile_number" placeholder="Enter Mobile Number" name="mobile_number">
                                </div>

                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
                                </div>
                                <p>
                                    Not yet a member? <a href="registration.php">Sign UP</a>
                                </p>
                                <button type="submit" name = "login" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </section>

</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $('.carousel').carousel({
        interval: 1500
    })
</script>
</body>
</html>