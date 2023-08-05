<?php
require 'connect.php';

$data = json_decode(file_get_contents("php://input"));
var_dump($data);

if ($data && isset($data->name)) {
    $id = $data->id;
    $name = $data->name;

    // Выполнение запроса на обновление
    $sql = "UPDATE product SET name = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $name, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo json_encode(array("message" => "Product updated successfully"));
    } else {
        echo json_encode(array("error" => mysqli_error($conn)));
    }
} else {
    echo json_encode(array("error" => "Invalid request data"));
}
?>
