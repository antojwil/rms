<?php
session_start();
require_once "database.php"; // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Retrieve user ID from session
$user_id = $_SESSION["user"]["id"];

// Prepare the SQL statement to retrieve risks for the current user
$sql = "SELECT * FROM message WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Error: Unable to prepare SQL statement. " . mysqli_error($conn));
}

// Bind the user ID parameter
mysqli_stmt_bind_param($stmt, "i", $user_id);

// Execute the SQL statement
if (mysqli_stmt_execute($stmt)) {
    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if any risks are found
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Submitted Risks</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Subject</th><th>Category</th><th>Risk Mapping</th><th>Current Impact</th><th>Current Likelihood</th><th>Risk Source</th><th>Control Regulation</th><th>Control Number</th><th>Risk Scoring Method</th><th>Owner</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['subject']}</td>";
            echo "<td>{$row['category']}</td>";
            echo "<td>{$row['riskMapping']}</td>";
            echo "<td>{$row['currentImpact']}</td>";
            echo "<td>{$row['currentlikelihood']}</td>";
            echo "<td>{$row['risksource']}</td>";
            echo "<td>{$row['controlregulation']}</td>";
            echo "<td>{$row['controlno']}</td>";
            echo "<td>{$row['scoringmethod']}</td>";
            echo "<td>{$row['owner']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No submitted risks found for user ID: $user_id</p>";
    }
} else {
    // Error executing the SQL statement
    echo "Error: " . mysqli_error($conn);
}

// Close the prepared statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

?>
