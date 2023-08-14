<?php
require '../index.php';

$data = json_decode(file_get_contents("php://input"));

if ($data && isset($data->count) && isset($data->status)) {
    $id = $data->id;
    $count = $data->count;
    $status = $data->status;

    // Проверка, что значение является целым числом
    if (!is_numeric($id) || !is_int((int) $id)) {
        echo json_encode(array("error" => "Invalid id value"));
        exit;
    }

    if (!is_numeric($count) || !is_int((int) $count)) {
        echo json_encode(array("error" => "Invalid count value"));
        exit;
    }

    // Выполнение запроса на обновление
    $sql = "UPDATE product SET count = ?, status = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $count, $status, $id);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo json_encode(array("message" => "Count updated successfully"));
    } else {
        echo json_encode(array("error" => mysqli_error($conn)));
    }
} else {
    echo json_encode(array("error" => "Invalid request data"));
}
?>
