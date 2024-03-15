<?php
session_start();

// Check if user is already logged in
if (isset($_SESSION["user"])) {
    header("Location: dashboard.php");
    exit();
}

// Check if admin is already logged in
if (isset($_SESSION["admin"])) {
    header("Location: admin_dashboard.php");
    exit();
}

// Include database connection
require_once "database.php";

// Handle form submission
if (isset($_POST["login"])) {
    $selectedType = $_POST["login_type"];

    // Check if user selected "User" or "Admin" login
    if ($selectedType == "user") {
        handleUserLogin();
    } elseif ($selectedType == "admin") {
        handleAdminLogin();
    }
}

function handleUserLogin() {
    global $conn;
    $email = $_POST["email"];
    $password = $_POST["password"];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user; // Store user information in session
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Password does not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Email does not match</div>";
    }
}

function handleAdminLogin() {
    global $conn;
    if (isset($_POST["username"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM admins WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $admin = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($admin) {
            // Compare plain text passwords
            if ($password === $admin["password"]) {
                $_SESSION["admin"] = $admin; // Store admin information in session
                header("Location: admin_dashboard.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Password does not match</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Username does not match</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Admin username is required</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <h4>RISK MANAGEMENT SYSTEM</h4>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<form action="login.php" method="post">
    <div class="form-group">
        <select name="login_type" class="form-control" onchange="showAdminUsername()">
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
    </div>
    
    <!-- Display admin username for admin login -->
    <div id="adminUsernameField" class="form-group" style="display: none;">
        <label for="username">Admin Username:</label>
        <input type="text" name="username" class="form-control">
    </div>

    <div class="form-group">
        <input type="email" placeholder="Enter Email:" name="email" class="form-control">
    </div>
    <div class="form-group">
        <input type="password" placeholder="Enter Password:" name="password" class="form-control">
    </div>
    <div class="form-btn">
        <input type="submit" value="Login" name="login" class="btn btn-primary">
    </div>
</form>
<script>
    function showAdminUsername() {
        var loginType = document.getElementsByName("login_type")[0];
        var adminUsernameField = document.getElementById("adminUsernameField");

        if (loginType.value === "admin") {
            adminUsernameField.style.display = "block";
        } else {
            adminUsernameField.style.display = "none";
        }
    }
</script>
<div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
</div>
</body>
</html>
