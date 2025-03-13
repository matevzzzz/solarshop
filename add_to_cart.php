<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zakljucna";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Povezava ni uspela: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$user_id = $data['user_id'];
$productName = $data['productName'];
$price = $data['price'];
$quantity = $data['quantity'];
$size = $data['size'];

$sql = "INSERT INTO kosarica (uporabnik_id, productName, price, quantity, size) VALUES ('$user_id', '$productName', '$price', '$quantity', '$size')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}

$conn->close();
?>