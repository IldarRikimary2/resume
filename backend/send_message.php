<?php
// Подключение к базе данных
require 'connect.php';

// Чтение данных из POST-запроса в виде JSON
$data = json_decode(file_get_contents("php://input"), true);

// Логирование полученных данных
error_log('Received data: ' . print_r($data, true));

// Проверка, что запрос является POST-запросом
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Получаем данные из POST-запроса
    $senderId = isset($data['id_sender']) ? intval($data['id_sender']) : null;
    $receiverId = isset($data['id_receiver']) ? intval($data['id_receiver']) : null;
    $messageContent = isset($data['message']) ? $data['message'] : null;

    // Проверка, что обязательные поля не пустые
    if ($senderId !== null && $receiverId !== null && $messageContent !== null && $senderId !== '' && $receiverId !== '' && $messageContent !== '') {
        // Подготовка данных перед вставкой в базу данных
        $messageContent = $conn->real_escape_string($messageContent);

        // Выполнить SQL-запрос для вставки новой записи
        $sql = "INSERT INTO message (id_sender, id_receiver, content, times_tamp)
                VALUES ($senderId, $receiverId, '$messageContent', CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);

        if ($result) {
            // Если вставка прошла успешно, отправляем ответ об успехе
            echo json_encode(['success' => true]);
        } else {
            // Если произошла ошибка, отправляем ответ об ошибке
            echo json_encode(['success' => false, 'message' => 'Failed to send the message']);
        }
    } else {
        // Если не все обязательные поля были предоставлены, отправляем ответ об ошибке
        echo json_encode(['success' => false, 'message' => 'Invalid request parameters']);
    }
} else {
    // Если запрос не является POST-запросом, отправляем ответ об ошибке
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
