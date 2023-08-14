<?php
require '../index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data["email"]) && isset($data["password"])) {
        $email = $data["email"];
        $password = $data["password"];

        // Check if the email exists in the database
        $query = "SELECT id, password FROM employee WHERE email = ?";
        $statement = $conn->prepare($query);
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows === 1) {
            // Email exists, check password
            $row = $result->fetch_assoc();
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                // Password is correct, user is authenticated
                $response = ["success" => true, "userId" => $row['id']];
            } else {
                // Password is incorrect
                $response = ["success" => false, "message" => "Invalid password"];
            }
        } else {
            // Email does not exist
            $response = ["success" => false, "message" => "Email does not exist"];
        }

        $statement->close();
    } else {
        // Invalid data
        $response = ["success" => false, "message" => "Invalid data"];
    }
} else {
    // Invalid request method
    $response = ["success" => false, "message" => "Invalid request method"];
}

header("Content-Type: application/json");
echo json_encode($response);
?>
