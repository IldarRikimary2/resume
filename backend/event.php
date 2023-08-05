<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Проверяем, что данные пришли в ожидаемом формате
    if (isset($data['eventDate']) && isset($data['eventName']) && isset($data['eventDescription'])) {
        $eventDate = $data['eventDate'];
        $eventName = $data['eventName'];
        $eventDescription = $data['eventDescription'];

        // Теперь вы можете использовать полученные данные для добавления события в БД
        // Например:
        $sql = "INSERT INTO event (date, name, description) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $eventDate, $eventName, $eventDescription);
        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Event added successfully"));
        } else {
            echo json_encode(array("success" => false, "message" => "Failed to add event"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Invalid data format"));
    }
}
?>