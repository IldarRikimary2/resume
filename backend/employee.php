<?php
require '../index.php';

// SQL-запрос для выборки всех записей из таблицы "employee"
$sql = "SELECT * FROM employee";
$result = mysqli_query($conn, $sql);

// Проверка, есть ли записи в результате запроса
if (mysqli_num_rows($result) > 0) {
    // Если есть, создаем массив для хранения всех записей
    $rows = array();
    while ($row = mysqli_fetch_assoc($result)) {
        // Каждую запись добавляем в массив
        $rows[] = $row;
    }

    // Возвращаем результат в формате JSON
    echo json_encode(array("success" => true, "data" => $rows));
} else {
    // Если нет записей, возвращаем сообщение об ошибке
    echo json_encode(array("success" => false, "message" => "No data found"));
}
?>