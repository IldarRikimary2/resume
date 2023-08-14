<?php

require '../index.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    header("Content-Length: 0");
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

error_log('Received data: ' . print_r($data, true));

if (isset($data['name']) && isset($data['groupId'])) {
    $name = $data['name'];
    $groupId = $data['groupId'];

    // Создание нового продукта
    $sql = "INSERT INTO `product` (`name`) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $result = $stmt->execute();

    if ($result) {
        // Получение ID нового продукта
        $productId = $stmt->insert_id;

        // Связывание продукта с группой
        $sql = "INSERT INTO `group_product` (`id`, `id_product`, `id_group`) VALUES (NULL, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $productId, $groupId);
        $result = $stmt->execute();

        if ($result) {
            echo json_encode(array("success" => true, "message" => "Added successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Failed to link product with group"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Failed to create product"));
    }
} else {
    echo json_encode(array("error" => "Invalid request data"));
}

?>