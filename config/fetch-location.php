<?php
// display locations in register input
include 'connect.php';

$input = $_GET['q'];

$query = "SELECT DISTINCT user_location FROM users WHERE user_location LIKE ?";
$stmt = $connect->prepare($query);
$stmt->bind_param("s", $input);
$input = '%' . $input . '%';
$stmt->execute();
$result = $stmt->get_result();

$locations = array();
while ($row = $result->fetch_assoc()) {
    $locations[] = $row['user_location'];
} 

header('Content-Type: application/json');

echo json_encode($locations);
?>
