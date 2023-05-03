<?php include 'includes/header.php'; ?>

<?php
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

function removeCartItem($car_id) {
    unset($_SESSION['cart'][$car_id]);
}

function emptyCart() {
    foreach ($_SESSION['cart'] as $car_id => $quantity) {
        $_SESSION['cart'][$car_id] = 0;
        unset($_SESSION['cart'][$car_id]);
    }
}

if (isset($_GET['emptyCart'])) {
    emptyCart();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

$filename = 'assets/cars.json';
$data = file_get_contents($filename);
$decoded_json = json_decode($data, true);

?>

<div class="cart-container">
    <?php
    if (empty($_SESSION['cart'])) {
        echo "<p>Your cart is empty.</p>";
    } else {
        $total_price = 0;
        echo "<table>";
        echo "<tr><th>Item</th><th>Price</th><th>Quantity</th></tr>";
        foreach ($_SESSION['cart'] as $car_id => $quantity) {
            var_dump($decoded_json);
            var_dump($car_id);
            if(isset($decoded_json[$car_id])) {
                $car = $decoded_json[$car_id];

                $car_id = $car['Car_ID'];
                $car_name = $car['Name'];
                $car_model = $car['Model'];
                $car_make = $car['Make'];
                $car_mileage = $car['Mileage'];
                $car_year = $car['Year'];
                $car_availability = $car['Availability'];
                $car_price = $car['Price_per_day'];
                $car_fuel = $car['Fuel'];
                $car_transmission = $car['Transmission_type'];
                $car_seats = $car['Seats'];
                $car_bodytype = $car['Body_type'];
                $car_image = $car['Image'];

                echo "<tr>";
                echo "<td>$car_name</td>";
                echo "<td>$car_price</td>";
                echo "<td>$quantity</td>";
                echo "<td></td>";
                echo "</tr>";
                $total_price += $car_price * $quantity;
            }
        }
        echo "</table>";
        echo "Total price: $total_price";
    }
    ?>
</div>

<?php include 'includes/footer.php'?>