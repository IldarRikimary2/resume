<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    header("Content-Length: 0");
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

error_log('Received data: ' . print_r($data, true));

if ($data && isset($data['email']) && isset($data['password']) && isset($data['surname']) && isset($data['name']) && isset($data['number'])) {
    $email = $data['email'];
    $password = $data['password'];
    $surname = $data['surname'];
    $name = $data['name'];
    $patronymic = isset($data['patronymic']) ? $data['patronymic'] : '';
    $number = $data['number'];

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `employee` (`email`, `password`, `surname`, `name`, `patronymic`, `number`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $email, $hashedPassword, $surname, $name, $patronymic, $number);
    $result = $stmt->execute();

    if ($result) {
        $userId = $stmt->insert_id; // Get the user ID of the last inserted row
        echo json_encode(array("success" => true, "userId" => $userId, "message" => "Registration successful"));
    } else {
        echo json_encode(array("success" => false, "message" => "Registration failed"));
    }
} else {
    echo json_encode(array("error" => "Invalid request data"));
}
?>
