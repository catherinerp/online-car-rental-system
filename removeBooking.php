<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function updateAvailability($car_id) {
    $filename = 'assets/cars.json';
    $data = file_get_contents($filename);
    $decoded_json = json_decode($data, true);

    foreach ($decoded_json as &$car) {
        if ($car['Car_ID'] == $car_id) {
            $car['Availability'] = true;
            break;
        }
    }

    $data = json_encode($decoded_json, JSON_PRETTY_PRINT);
    file_put_contents($filename, $data);
}
function removeBooking($rent_id) {
    include 'includes/dbConfig.php';
    $stmt = $conn->prepare("DELETE FROM renting_history WHERE rent_id = ?");
    $stmt->bind_param("i", $rent_id);

    if ($stmt->execute()) {
        echo "Booking removed successfully.";
    } else {
        echo "Error: ".$stmt->error;
    }

    $stmt->close();
    $conn->close();
}

if (isset($_POST['removeBooking'])) {
    $rent_id = $_POST['removeBooking'];
    $car_id = $_POST['updateAvailability'];
    updateAvailability($car_id);
    removeBooking($rent_id);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>