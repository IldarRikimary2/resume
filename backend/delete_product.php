<?php

require 'connect.php';

$data = json_decode(file_get_contents("php://input"));

$id = $data->id;

// Delete associated records in the group_product table
$deleteGroupProductSql = "DELETE FROM group_product WHERE id_product = ?";
$deleteGroupProductStmt = mysqli_prepare($conn, $deleteGroupProductSql);
mysqli_stmt_bind_param($deleteGroupProductStmt, "i", $id);
$deleteGroupProductResult = mysqli_stmt_execute($deleteGroupProductStmt);

if ($deleteGroupProductResult) {
    // Delete the product
    $deleteProductSql = "DELETE FROM product WHERE id = ?";
    $deleteProductStmt = mysqli_prepare($conn, $deleteProductSql);
    mysqli_stmt_bind_param($deleteProductStmt, "i", $id);
    $deleteProductResult = mysqli_stmt_execute($deleteProductStmt);

    if ($deleteProductResult) {
        echo json_encode(array("message" => "Product deleted successfully"));
    } else {
        echo json_encode(array("error" => mysqli_error($conn)));
    }
} else {
    echo json_encode(array("error" => mysqli_error($conn)));
}

?>
