<?php

// load categories in the dropdown

include 'connect.php';
session_start();

$sql = mysqli_query($connect, "SELECT * FROM category");
$options = '';
echo '<option selected disabled class="fst-italic text-secondary text-muted">Select Category</option>';
while ($row = mysqli_fetch_assoc($sql)) {
    $options .= '<option value="' . $row['category'] . '">' . $row['category'] . '</option>';
}

echo $options;
?>