<?php
session_start();
require_once "database.php"; // Include your database connection file

// Check if the ID parameter is set
if (isset($_GET['id'])) {
    $risk_id = $_GET['id'];
    
    // Delete the risk from the database using $risk_id
    $sql = "DELETE FROM message WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Error: Unable to prepare SQL statement. " . mysqli_error($conn));
    }

    // Bind the risk ID parameter
    mysqli_stmt_bind_param($stmt, "i", $risk_id);

    // Execute the SQL statement
    if (mysqli_stmt_execute($stmt)) {
        // Close the prepared statement and database connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Redirect to the submitted risks page
        header("Location: view-submitted-risks.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

} else {
    echo "Error: Risk ID not provided.";
}
?>
