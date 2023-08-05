<?php
require 'connect.php';

if (isset($_GET['groupId'])) {
    $groupId = $_GET['groupId'];
    $sql = "SELECT p.id, p.name 
        FROM `product` AS p
        LEFT JOIN `group_product` r ON p.id = r.id_product WHERE r.id_group = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $groupId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        echo json_encode(array("success" => true, "data" => $rows));
    } else {
        echo json_encode(array("success" => false, "message" => "No data found"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Missing groupId parameter"));
}
?>