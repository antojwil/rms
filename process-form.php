<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION["user"]["id"];

$subject = $_POST["subject"];
$category = $_POST["category"];
$riskMapping = $_POST["riskMapping"];  // Corrected this line
$currentImpact = $_POST["currentImpact"];
$currentlikelihood = $_POST["currentlikelihood"];
$risksource = $_POST["risksource"];
$controlregulation = $_POST["controlregulation"];
$controlno = $_POST["controlno"];
$scoringmethod = $_POST["scoringmethod"];
$owner = $_POST["owner"];



$host = "localhost";
$dbname = "login_register";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

$sql = "INSERT INTO message (user_id, subject, category, riskMapping, currentImpact, currentlikelihood, risksource, controlregulation, controlno, scoringmethod, owner)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    die(mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "issssssssss",
    $user_id,
    $subject,
    $category,
    $riskMapping,
    $currentImpact,
    $currentlikelihood,
    $risksource,
    $controlregulation,
    $controlno,
    $scoringmethod,
    $owner
);

mysqli_stmt_execute($stmt);
// Close the statement
mysqli_stmt_close($stmt);

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="1;url=dashboard.php">
    <title>Record Saved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <h2>Record Saved</h2>
    <p>Redirecting to the dashboard</p>

</body>
</html>