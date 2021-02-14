<?php 
include 'vendor/autoload.php';


$command = escapeshellcmd('test.py');
$output = shell_exec($command);
echo gettype($output)."<br>";

echo $output;

$output = floatval($output);
$output = number_format($output, 2);
$output = floatval($output);
echo $output;
echo gettype($output)."<br>";
//print_r($sample);
//print_r($target);

//$tz = 'Asia/Dhaka';
//$tz_obj = new DateTimeZone($tz);
//$now = new DateTime("now", $tz_obj);
//$current_date = $now->format('d-m-Y');



/*$current_date = "2020-03-07";

$dayOfWeek = date("N", strtotime($current_date));

$holiday = holiday($current_date);
$weekend = weekend($current_date);*/


//echo "<br/>".$current_date;

/*$regression = new LeastSquares();
$regression->train($sample, $target);


$x_new = [$dayOfWeek, $weekend, $holiday];

$output = $regression->predict($x_new);*/


//echo "<br/>";//Our YYYY-MM-DD date string.
//$date = "25-03-2020";
 
//Get the day of the week using PHP's date function.
//$dayOfWeek = date("N", strtotime($current_date));
 
//Print out the day that our date fell on.
//echo $date . ' fell on a ' . $dayOfWeek;


//echo "<br/>".$output;


   

?>