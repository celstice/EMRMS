<?php
// USER RATINGS

include 'connect.php';
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

$currentDate = date('Y-m-d');
$start = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
$end = date('Y-m-d', strtotime('next saturday', strtotime($start)));

$select5=mysqli_query($connect, "SELECT 
COUNT(CASE WHEN responsive1=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN responsive2=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability1=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability2=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN facility=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN access=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication1=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication2=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost1=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost2=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN integrity=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN assurance=5 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN outcome=5 THEN 1 ELSE NULL END) 
AS total5
FROM feedbacks WHERE DATE(feedback_date) BETWEEN '$start' AND '$end'");
$total5 = mysqli_fetch_assoc($select5);
$rate5 = $total5['total5'];

// echo "<br>";
$select4 = mysqli_query($connect, "SELECT 
COUNT(CASE WHEN responsive1=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN responsive2=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability1=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability2=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN facility=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN access=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication1=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication2=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost1=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost2=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN integrity=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN assurance=4 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN outcome=4 THEN 1 ELSE NULL END) 
AS total4
FROM feedbacks WHERE DATE(feedback_date) BETWEEN '$start' AND '$end'");
$total4 = mysqli_fetch_assoc($select4);
$rate4 = $total4['total4'];

// echo "<br>";
$select3 = mysqli_query($connect, "SELECT 
COUNT(CASE WHEN responsive1=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN responsive2=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability1=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability2=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN facility=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN access=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication1=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication2=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost1=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost2=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN integrity=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN assurance=3 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN outcome=3 THEN 1 ELSE NULL END) 
AS total3
FROM feedbacks WHERE DATE(feedback_date) BETWEEN '$start' AND '$end'");
$total3 = mysqli_fetch_assoc($select3);
$rate3 = $total3['total3'];

// echo "<br>";
$select2 = mysqli_query($connect, "SELECT 
COUNT(CASE WHEN responsive1=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN responsive2=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability1=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability2=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN facility=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN access=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication1=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication2=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost1=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost2=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN integrity=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN assurance=2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN outcome=2 THEN 1 ELSE NULL END) 
AS total2
FROM feedbacks WHERE DATE(feedback_date) BETWEEN '$start' AND '$end'");
$total2 = mysqli_fetch_assoc($select2);
$rate2 = $total2['total2'];

// echo "<br>";
$select1 = mysqli_query($connect, "SELECT 
COUNT(CASE WHEN responsive1=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN responsive2=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability1=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability2=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN facility=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN access=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication1=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication2=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost1=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost2=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN integrity=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN assurance=1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN outcome=1 THEN 1 ELSE NULL END) 
AS total1
FROM feedbacks WHERE DATE(feedback_date) BETWEEN '$start' AND '$end'");
$total1 = mysqli_fetch_assoc($select1);
$rate1 = $total1['total1'];

// echo "<br>";
$selectAll = mysqli_query($connect, "SELECT 
COUNT(CASE WHEN responsive1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN responsive2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN reliability2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN facility THEN 1 ELSE NULL END) +
COUNT(CASE WHEN access THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN communication2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost1 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN cost2 THEN 1 ELSE NULL END) +
COUNT(CASE WHEN integrity THEN 1 ELSE NULL END) +
COUNT(CASE WHEN assurance THEN 1 ELSE NULL END) +
COUNT(CASE WHEN outcome THEN 1 ELSE NULL END) 
AS totalResponses
FROM feedbacks WHERE DATE(feedback_date) BETWEEN '$start' AND '$end'");
$all = mysqli_fetch_assoc($selectAll);
$ratings = $all['totalResponses'];

$rate['rate5'] = round(($rate5 / $ratings) * 100,2);
// echo $rate['rate5']."<br>";
$rate['rate4'] = round(($rate4 / $ratings) * 100, 2);
// echo $rate['rate4']."<br>";
$rate['rate3'] = round(($rate3 / $ratings) * 100, 2);
// echo $rate['rate3']."<br>";
$rate['rate2'] = round(($rate2 / $ratings) * 100, 2);
// echo $rate['rate2']."<br>";
$rate['rate1'] = round(($rate1 / $ratings) * 100, 2);
// echo $rate['rate1']."<br>";

// sample data
// $rate['rate5'] = 77;
// $rate['rate4'] = 20;
// $rate['rate3'] = 3;
// $rate['rate2'] = 0;
// $rate['rate1'] = 0;
echo json_encode($rate);
?>