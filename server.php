<?php 
include 'offday.php';
session_start();

// connect to database

	require 'vendor/autoload.php';
	$client = new MongoDB\Client('mongodb+srv://Abir_Das:abir1048@cluster0-lpt7x.mongodb.net/test?retryWrites=true&w=majority');

	$db = $client->Voltage;
	$collection1 = $db->Information;
	$collection2 = $db->Measurement;
	$collection3 = $db->Request;
	
	$tz = 'Asia/Dhaka';
    $tz_obj = new DateTimeZone($tz);
    $now = new DateTime("now", $tz_obj);
    $current_date = $now->format('Y-m-d');
    $current_time = $now->format('H:i');

	// variable declaration
	$firm_name = "";
	$owner_name = "";
	$location = "";
	$mobile_number = "";
	$password1 = "";
	$password2 = "";
	$fileName = "";
	$errors = array(); 

	
	
	

	// REGISTER USER
	if (isset($_POST['registration'])) {
		// receive all input values from the form
		$firm_name = $_POST['firm_name'];
		$owner_name = $_POST['owner_name'];
		$location = $_POST['location'];
		$mobile_number = $_POST['mobile_number'];
		$password1 = $_POST['password1'];
		$password2 = $_POST['password2'];


		// form validation: ensure that the form is correctly filled
		if (empty($firm_name)) { array_push($errors, "Firm Name is required"); }
		if (empty($owner_name)) { array_push($errors, "Owner Name is required"); }
		if (empty($location)) { array_push($errors, "Location is required"); }
		if (empty($mobile_number)) { array_push($errors, "Mobile Number is required"); }
		if (empty($password1)) { array_push($errors, "Password is required"); }
		if (empty($password2)) { array_push($errors, "Password is required"); }


		if ($password1 != $password2) {
			array_push($errors, "The two passwords do not match");
		}

		//

		if ($collection1->findOne(array('mobile_number' => $mobile_number))) {
			array_push($errors, "Mobile Number already exists");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password1);//encrypt the password before saving in the database
			

			$document = array( 
      			"firm_name" => $firm_name, 
      			"owner_name" => $owner_name, 
      			"location" => $location,
      			"mobile_number" => $mobile_number,
      			"password" => $password
      			);
			if (isset($_FILES["file"])) {
			if(move_uploaded_file($_FILES['file']['tmp_name'], 'img/'.$_FILES['file']['name'])){
				$document['fileName'] = $_FILES['file']['name'];
				$fileName = $document['fileName']; 
			} else{
				echo "Failed to upload file";
			}
		}

			
			if($collection1->insertOne($document)){
				$_SESSION['mobile_number'] = $mobile_number;
				header('location: index.php');
			}
		}
		}


	// ... 

	// LOGIN USER
	if (isset($_POST['login'])) {
		$mobile_number = $_POST['mobile_number'];
		$password = $_POST['password'];

		if (empty($mobile_number)) {
			array_push($errors, "Mobile Number is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);

			// search for mobile number

			//$condition = array('mobile_number' => $mobile_number, 'password' => $password);

			$found = $collection1->find(
				array('$and' => array(array("mobile_number" => 
				$mobile_number), array("password" => $password))));

			if($found){
				foreach ($found as $document) {
				$_SESSION['mobile_number'] = $document["mobile_number"];
				header('location: index.php');
			}
		}
			else {
				array_push($errors, "Wrong mobile number/password combination");
			}
				

		}
	}

	// REGISTER USER
	if (isset($_POST['sell'])) {
		// receive all input values from the form
		$date = $_POST['date'];
		$time = $_POST['time'];
		$voltage = $_POST['voltage'];
		$mobile_number = $_POST['mobile_number'];
		

	


		// form validation: ensure that the form is correctly filled
		if (empty($date)) { array_push($errors, "Date is required"); }
		if (empty($time)) { array_push($errors, "Time is required"); }
		if (empty($voltage)) { array_push($errors, "Voltage is required"); }


		if ($date < $current_date) {
			array_push($errors, "You can't use previous date");
		}

		if ($time < $current_time and $date <= $current_date) {
			array_push($errors, "You can't use previous time");
		}

		

		$time_hour = explode(":",$time);
		$hour = $time_hour[0];

		$filename = "test.csv";
		$f = fopen($filename, 'w');
		$fields = array('DayofWeek', 'Weekend', 'Holiday', 'Voltage');
		fputcsv($f, $fields);
		
		$found6 = $collection2->find(['mobile_number' => $mobile_number, 'time' => $hour]);

		if(!empty($found6)){
			foreach ($found6 as $data) {
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
		else{
			echo "No Data found";
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
		if ($voltage > $output) {
			array_push($errors, "You can't share power more than $output watt");
		}

		/*echo gettype($output)."<br>";
		echo $output;*/

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			

			$document = array( 
      			"date" => $date, 
      			"time" => $time, 
      			"voltage" => $voltage,
      			"mobile_number" => $mobile_number,
      			"type" => "Sell",
      			"status" => "Active",
      			"from" => $mobile_number,
      			"to" => "None",
      			"action" => "None"
      			);

			
			if($collection3->insertOne($document)){
				header('location: requesthistory.php');
			}
		}
		}



	if (isset($_POST['buy'])) {
		// receive all input values from the form
		$date = $_POST['date'];
		$time = $_POST['time'];
		$voltage = $_POST['voltage'];
		$mobile_number = $_POST['mobile_number'];
		


		// form validation: ensure that the form is correctly filled
		if (empty($date)) { array_push($errors, "Date is required"); }
		if (empty($time)) { array_push($errors, "Time is required"); }
		if (empty($voltage)) { array_push($errors, "Voltage is required"); }


		if ($date < $current_date) {
			array_push($errors, "You can't use previous date");
		}
		if ($time < $current_time and $date <= $current_date) {
			array_push($errors, "You can't use previous time");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			

			$document = array( 
      			"date" => $date, 
      			"time" => $time, 
      			"voltage" => $voltage,
      			"mobile_number" => $mobile_number,
      			"type" => "Buy",
      			"status" => "Active",
      			"to" => $mobile_number,
      			"from" => "None",
      			"action" => "None"

      			);

			
			if($collection3->insertOne($document)){
				header('location: requesthistory.php');
			}
		}
		}

// Update USER
	/*if (isset($_GET['update'])) {
		//header('location: server.php');
		// receive all input values from the form
		$id = $_GET['id'];
		$firm_name = $_GET['firm_name'];
		$owner_name = $_GET['owner_name'];
		$location = $_GET['location'];
		$mobile_number = $_GET['mobile_number'];

		echo $id;
		


		// form validation: ensure that the form is correctly filled
		if (empty($firm_name)) { array_push($errors, "Firm Name is required"); }
		if (empty($owner_name)) { array_push($errors, "Owner Name is required"); }
		if (empty($location)) { array_push($errors, "Location is required"); }
		if (empty($mobile_number)) { array_push($errors, "Mobile Number is required"); }


		
		$double = $collection1->find(array('mobile_number' == $mobile_number));

		if ($double) {
			array_push($errors, "Mobile Number already exists");
		}


		if($collection1->update(array("_id"=>$id), 
      array('$set'=>array("firm_name" => $firm_name, 
      			"owner_name" => $owner_name, 
      			"location" => $location,
      			"mobile_number" => $mobile_number))))
		{
			$_SESSION['mobile_number'] = $mobile_number;
				header('location: index.php');
		}

		

		}*/


	
?>