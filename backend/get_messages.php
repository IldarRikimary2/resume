<?php
require '../index.php';

if (isset($_GET['id_sender']) && isset($_GET['id_receiver'])) {
    $senderId = $_GET['id_sender'];
    $receiverId = $_GET['id_receiver'];

    try {
        $senderId = intval($senderId);
        $receiverId = intval($receiverId);

        $sql_check = "SELECT * FROM message
                      WHERE (id_sender = $senderId AND id_receiver = $receiverId)
                      OR (id_sender = $receiverId AND id_receiver = $senderId)";

        $result_check = $conn->query($sql_check);

        // Если переписка уже существует, получаем и возвращаем сообщения из таблицы "messages"
        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();
            $id_message = $row['id'];

            // Запросим информацию об отправителе из таблицы "message" с помощью JOIN
            $sql_messages = "SELECT message.content, message.times_tamp, message.id_sender, employee.name AS sender_name
                            FROM message
                            INNER JOIN employee ON message.id_sender = employee.id
                            WHERE (message.id_sender = $senderId AND message.id_receiver = $receiverId)
                            OR (message.id_sender = $receiverId AND message.id_receiver = $senderId)";

            $result_messages = $conn->query($sql_messages);

            $messages = [];
            while ($row = $result_messages->fetch_assoc()) {
                // Добавим информацию об отправителе в каждый элемент массива сообщений
                $messages[] = $row;
            }
            echo json_encode(['success' => true, 'messages' => $messages]);
        } else {
            // Если переписка не существует, создаем новую запись в таблице "message"
            $sql_insert = "INSERT INTO `message` (`id`, `id_sender`, `id_receiver`, `content`, `times_tamp`) 
                            VALUES (NULL, $senderId, $receiverId, '', NOW());";
            $conn->query($sql_insert);

            // Возвращаем пустой массив, так как пока нет сообщений в новой переписке
            echo json_encode(['success' => true, 'messages' => []]);
        }

    } catch (mysqli_sql_exception $e) {
        // Log the specific database error message
        error_log("Database error: " . $e->getMessage());

        // Return a generic error response
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request parameters']);
}
?>