<?php
include 'includes/header.php';
?>
<div class="main-container">
    <div class="cart-container" style="padding:40px; padding-bottom:80px;">
        </br>
<?php
if (isset($_GET['goBack'])) {
    header("Location: ./accountForm.php");
    exit();
}

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
        echo "<h2 style='text-align:center'>Your booking #$rent_id was cancelled successfully.</h2>";
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
}
?>
        <form method="get">
            <button style="float:right" class="add-cart-btn" type="submit" name="goBack">Go Back</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>