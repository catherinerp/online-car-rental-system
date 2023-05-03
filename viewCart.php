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
        foreach ($_SESSION['cart'] as $car_id => $car_data) {
            $car_name = $car_data['car_name'];
            $car_year = $car_data['car_year'];
            $car_image = $car_data['car_image'];
            $car_price = $car_data['car_price'];
            $quantity = $car_data['quantity'];
            echo "<tr>";
            echo "<td>$car_name ($car_year)</td>";
            echo "<td>$$car_price/day</td>";
            echo "<td>$quantity";
            if ($quantity > 1) {
                echo " days";
            } else {
                echo " day";
            }
            echo "</td>";
            echo "</tr>";
            $total_price += $car_price * $quantity;
        }
        echo "</table>";
        echo "Total price: $$total_price/day";
    }
    ?>
</div>

<?php include 'includes/footer.php'?>