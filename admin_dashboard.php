<?php
session_start();
if (!isset($_SESSION["admin"])) {
   header("Location: login.php");
}

// You can retrieve admin information from the session if needed
$admin = $_SESSION["admin"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Risk Management System</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<div class="wrapper">
    <div class="sidebar">
        <h2>Risk Management System</h2>
        <ul>
            <li><a href="#"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fas fa-bahai"></i>Overview</a></li>
            <li><a href="#"><i class="fas fa-project-diagram"></i>Risks and Controls</a></li>
            <li><a href="#"><i class="fas fa-atom"></i>Reports</a></li>
            <li><a href="#" onclick="viewSubmittedRisks()"><i class="fab fa-expeditedssl"></i> Submitted Risks</a></li>
            <li><a href="#"><i class="fas fa-cogs"></i>Plan mitigation</a></li>
            <li><a href="#"><i class="fas fa-users-cog"></i>User Management</a></li>
            
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul> 
    </div>
    <div class="main_content">
        <div class="header">Welcome to our risk management system</div>  
        <div class="info" id="submitted-risks-container">
            <!-- Submitted risks content will be loaded here -->
        </div>
    </div>
</div>

<script>
    // JavaScript to handle opening/closing the submitted risks
    function viewSubmittedRisks() {
        // Load submitted risks content using jQuery
        $("#submitted-risks-container").load("view-submitted-risks.php");
    }
</script>
</body>
</html>