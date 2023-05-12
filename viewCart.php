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
            echo "<table style='width: 100%;'>";
            foreach ($_SESSION['cart'] as $car_id => $car_data) {
                $car_name = $car_data['car_name'];
                $car_year = $car_data['car_year'];
                $car_image = $car_data['car_image'];
                $car_price = $car_data['car_price'];
                $car_availability = $car_data['car_availability'];
                $quantity = $car_data['quantity'];
                echo "<tr>";
                echo "<td><img src='assets/images/car_images/$car_image' class='cart-car-image'></td>";
                echo "<td style='font-size: 20px;'>$car_name ($car_year)</td>";
                echo "<td><b>$$car_price/day</b></br>";
                echo "for $quantity";
                if ($quantity > 1) {
                    echo " days";
                } else {
                    echo " day";
                }
                echo "</td>";
                echo "
                <td><form method='get'>
                <button type='submit' class='remove-item-btn' value='$car_id' name='removeCartItem' onclick='return confirmDelete()'>
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
            <hr>
            <h3>Total</h3>
                <a class="add-cart-btn" type="button" href="checkout.php" style="float:right; text-decoration:none; color:black; background-color:#ffd100;">Checkout</a>
            <p style="font-size:20px"><?php echo $total_quantity;?> <i class="fa fa-car" aria-hidden="true"></i>
            $<?php echo $total_price;?>/day</p>
            <form method="get">
                    <button class="add-cart-btn" type="submit" onclick="return confirmEmpty()" name="emptyCart" <?php echo empty($_SESSION['cart']) ? 'style="display:none"' : ''; ?>>Empty Cart</button>
            </form>
            </div>
        <?php    
        }
        ?>
    </div>
</div>
</body>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to remove this car?");
    }
    function confirmEmpty() {
        return confirm("Are you sure you want to empty your cart?");
    }
</script>
    </html>