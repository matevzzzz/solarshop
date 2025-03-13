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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $geslo = $_POST['geslo'];

    $sql = "SELECT * FROM uporabniki WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($geslo == $row['geslo']) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];

            // Naloži košarico iz podatkovne baze
            $user_id = $row['id'];
            $cart_sql = "SELECT * FROM kosarica1 WHERE uporabnik_id='$user_id'";
            $cart_result = $conn->query($cart_sql);
            $cart = [];
            if ($cart_result->num_rows > 0) {
                while ($cart_row = $cart_result->fetch_assoc()) {
                    $cart[] = $cart_row;
                }
            }
            $_SESSION['cart'] = $cart;

            header("Location: homepage.php");
            exit();
        } else {
            echo "Napačno geslo.";
        }
    } else {
        echo "Uporabniško ime ne obstaja.";
    }
}

$conn->close();
?>