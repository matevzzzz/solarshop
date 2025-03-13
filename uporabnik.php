<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "zakljucna";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Povezava ni uspela: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM uporabniki WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ime = $_POST['ime'];
    $priimek = $_POST['priimek'];
    $gmail = $_POST['gmail'];
    $username = $_POST['username'];

    $update_sql = "UPDATE uporabniki SET ime='$ime', priimek='$priimek', gmail='$gmail', username='$username' WHERE id='$user_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Podatki so bili uspešno posodobljeni.";
    } else {
        echo "Napaka pri posodabljanju podatkov: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urejanje profila</title>
</head>
<body>
    <h2>Urejanje profila</h2>
    <form method="post">
        <label for="ime">Ime:</label>
        <input type="text" id="ime" name="ime" value="<?php echo $user['ime']; ?>" required><br>

        <label for="priimek">Priimek:</label>
        <input type="text" id="priimek" name="priimek" value="<?php echo $user['priimek']; ?>" required><br>

        <label for="gmail">E-pošta:</label>
        <input type="email" id="gmail" name="gmail" value="<?php echo $user['gmail']; ?>" required><br>

        <label for="username">Uporabniško ime:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br>

        <button type="submit">Shrani spremembe</button>
    </form>
</body>
</html>