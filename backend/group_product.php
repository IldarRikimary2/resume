<?php
require '../index.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    header("Content-Length: 0");
    exit();
}
$data = json_decode(file_get_contents("php://input"));

$groupId = $data->groupId;
$productId = $data->productId;

if ($productId !== null) {
    $sql = "INSERT INTO `group_product` (`id`, `id_product`, `id_group`) VALUES (NULL, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $productId, $groupId);
    $result = $stmt->execute();

    if ($result) {
        echo json_encode(array("success" => true, "message" => "Added successfully"));
    } else {
        echo json_encode(array("success" => false, "message" => "No data found"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid productId"));
}


if ($result) {
    echo json_encode(array("success" => true, "message" => "Added successfully"));
} else {
    echo json_encode(array("success" => false, "message" => "No data found"));
}

?>