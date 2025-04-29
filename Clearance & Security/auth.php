<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$captcha = $_POST['captcha'];

// Verify CAPTCHA
if ($captcha !== $_SESSION['captcha']) {
    die("Invalid CAPTCHA. <a href='index.php'>Try again</a>");
}

// Connect to MySQL
$conn = new mysqli("localhost", "root", "COSC4343", "cybersecurity");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash the entered password with SHA1
$hashed_password = sha1($password);

// Prepare and execute query
$stmt = $conn->prepare("SELECT clearance FROM UserAccounts WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $hashed_password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['username'] = $username;
    $_SESSION['clearance'] = $row['clearance'];
    header("Location: dashboard.php");
    exit();
} else {
    echo "Invalid username or password. <a href='index.php'>Try again</a>";
}

$stmt->close();
$conn->close();
?>

