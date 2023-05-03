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
    if (isset($_SESSION['cart'][$car_id])) {
        unset($_SESSION['cart'][$car_id]);
    }
}

if (isset($_GET['removeCartItem'])) {
    $car_id = $_GET['removeCartItem'];
    removeCartItem($car_id);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
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


if (isset($_GET['goHome'])) {
    header("Location: ../index.php");
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
        echo "<form method='get'>";
        echo "<button style='float:right' class='add-cart-btn' type='submit' name='goHome'>Go Home</button>";
        echo "</form>";
    } else {
        $total_price = 0;
        echo "<div class='cart-view-container'>";
        echo "<h1 style='text-align:center'>Shopping Cart</h1>";
        echo "<table>";
        foreach ($_SESSION['cart'] as $car_id => $car_data) {
            $car_name = $car_data['car_name'];
            $car_year = $car_data['car_year'];
            $car_image = $car_data['car_image'];
            $car_price = $car_data['car_price'];
            $quantity = $car_data['quantity'];
            echo "<tr>";
            echo "
            <td><form method='get'>
            <button type='submit' value='$car_id' name='removeCartItem' onclick='return confirm('Are you sure you want to remove this item?')'>
                <i class='fa fa-remove' style='font-size:30px'></i>
            </button>
            </td></form>";
            echo "<td><img src='assets/images/car_images/$car_image' style='height:100px'></td>";
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
        ?>
        </table>
        <p>Total price: $$total_price/day</p>
        <form method="get">
                <button class="empty-cart-btn" type="submit" name="emptyCart" <?php echo empty($_SESSION['cart']) ? 'style="display:none"' : ''; ?>>Empty Cart</button>
        </form>
        <form method="get">
            <button style="float:right" class="go-home-btn" type="submit" name="finish">Go Home</button>
        </form>
        </div>
    <?php    
    }
    ?>
</div>

<?php include 'includes/footer.php'?>