<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
function removeBooking($rent_id) {
    include 'includes/dbConfig.php';
    $stmt = $conn->prepare("DELETE FROM renting_history WHERE rent_id = ?");
    $stmt->bind_param("i", $rent_id);

    // Execute the delete statement
    if ($stmt->execute()) {
        // Success! Row deleted.
        echo "Booking removed successfully.";
    } else {
        // Error occurred.
        echo "Error: ".$stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

if (isset($_GET['removeBooking'])) {
    print $rent_id;
    $rent_id = $_GET['removeBooking'];
    removeBooking($rent_id);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>