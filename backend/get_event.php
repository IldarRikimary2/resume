<?php
require '../index.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['date'])) {
    $date = $_GET['date'];

    $sql = "SELECT * FROM event WHERE date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date); // Bind the formatted date
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        echo json_encode(array("success" => true, "data" => $rows));
    } else {
        echo json_encode(array("success" => false, "message" => "No event found for the selected date"));
    }
}
?>