<?php
require 'connect.php';

$sql = "SELECT * FROM favorite";
$result = mysqli_query($conn, $sql);

if ($result) {

    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $row['favorite'] = (bool) $row['favorite'];
        $rows[] = $row;
    }

    echo json_encode(array("success" => true, "data" => $rows));
} else {
    echo json_encode(array("success" => false, "message" => "Failed to fetch data"));
}
?>