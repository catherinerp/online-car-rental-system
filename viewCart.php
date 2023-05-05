<?php

include 'includes/cartHeader.php';
session_start();

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

include 'removeCartItem.php';
include 'emptyCart.php';

if (isset($_GET['goHome'])) {
    header("Location: index.php");
    exit();
}

$filename = 'assets/cars.json';
$data = file_get_contents($filename);
$decoded_json = json_decode($data, true);

?>
<div class="main-container">

    <div class="cart-container">
        <?php
        if (empty($_SESSION['cart'])) {
            echo "<h2>Your cart is empty.</h2>";
                echo "<form method='get'>";
                echo "<button style='float:right' class='add-cart-btn' type='submit' name='goHome'>Go Home</button>";
                echo "</form>";
                echo "</div>";
            echo "</div>";
        } else {
            $total_price = 0;
            $total_quantity = 0;
            echo "<div class='cart-view-container'>";
            echo "<h1 style='text-align:center'>Shopping Cart</h1>";
            echo "<table>";
            foreach ($_SESSION['cart'] as $car_id => $car_data) {
                $car_name = $car_data['car_name'];
                $car_year = $car_data['car_year'];
                $car_image = $car_data['car_image'];
                $car_price = $car_data['car_price'];
                $car_availability = $car_data['car_availability'];
                $quantity = $car_data['quantity'];
                echo "<tr>";
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
                echo "
                <td><form method='get'>
                <button type='submit' class='remove-item-btn' value='$car_id' name='removeCartItem' onclick='return confirm('Are you sure you want to remove this item?')'>
                    <i class='fa fa-remove' style='font-size:28px'></i>
                </button>
                </td></form>";
                echo "</tr>";
                $total_quantity++;
                $total_price += $car_price * $quantity;
            }
            $total_price = number_format((float)$total_price, 2, '.', '');
            ?>
            </table>
            </br>
            <hr>
            <h3>Total</h3>
            <p><?php echo $total_quantity;?> <i class="fa fa-car" aria-hidden="true"></i></br>
            $<?php echo $total_price;?>/day</p>
            <form method="get">
                    <button class="add-cart-btn" type="submit" name="emptyCart" <?php echo empty($_SESSION['cart']) ? 'style="display:none"' : ''; ?>>Empty Cart</button>
            </form>
            <form method="get">
                <button style="float:right" class="add-cart-btn" type="submit" name="goHome">Go Home</button>
            </form>
            <a class="add-cart-btn" type="button" href="checkout.php" style="float:right">Checkout</a>
            </div>
        <?php    
        }
        ?>
    </div>
</div>
<?php include 'includes/footer.php'?>