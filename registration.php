<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'tester');

    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO registration (username, password) VALUES (?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();
        echo "New Record inserted successfully";
        $stmt->close();
        $conn->close();
    }
} else {
    // If not POST request, send 405 header
    header($_SERVER["SERVER_PROTOCOL"] . " 405 Method Not Allowed");
    echo "405 Method Not Allowed";
}
?>
