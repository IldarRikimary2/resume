<?
require '../index.php';

if (isset($_GET['dateId'])) {
    $dateId = $_GET['dateId'];
    $sql = "SELECT * FROM event WHERE id = ?";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {

        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        echo json_encode(array("success" => true, "data" => $rows));
    } else {
        echo json_encode(array("success" => false, "message" => "No data found"));
    }
}
?>