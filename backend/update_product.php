<?php

require '../index.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

// Выполнение запроса на обновление
$sql = "DELETE FROM product WHERE id = ? ";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo json_encode(array("message" => "Favorite delete successfully"));
} else {
    echo json_encode(array("error" => mysqli_error($conn)));
}

?>