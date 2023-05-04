<?php

include 'includes/header.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

include 'emptyCart.php';

if (isset($_GET['goHome'])) {
    header("Location: ../index.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    echo "<p>Cart is empty.</p>";
} else {
    $total_price = 0;
    $total_quantity = 0;
    ?>
    <h1>Your order has been confirmed!</h1>
        <h3>Thank you for renting from Hertz-UTS <i class="fa fa-car"></i></h3></br>
        <p class="confirmation-order-message">
            A confirmation email with your order details has been sent to
            <b><?php echo $email?></b>.</br>
            Your car should be available to be picked up within the hour, please wait for a
            pick-up information email before picking it up.
        </p></br>
        <h2>Order Details</h2></br>
    <?php
        foreach ($_SESSION['cart'] as $car_id => $car_data) {
        $car_name = $car_data['car_name'];
        $car_year = $car_data['car_year'];
        $car_image = $car_data['car_image'];
        $car_price = $car_data['car_price'];
        $quantity = $car_data['quantity'];

        $total_quantity++;
        $total_price += $car_price * $quantity;

        $fullname = $_GET['fullname'];
        $email = $_GET['email'];
        $address = $_GET['address'];
        $state = $_GET['state'];
        $country = $_GET['country'];
        ?>
        
        <?php
        echo "<tr>
                <td>
                <div class='cart-item-image'>
                    <img src='assets/images/car_images/$car_image' style='width:75px; height:75px'>\t
                </div>
                <div class='cart-item-name'>
                $car_name
                </div>
                </td>
                <td>
                \t$quantity\t
                </td>
            </tr>\t";
            $total_price = number_format((float)$total_price, 2, '.', '');
    }
    foreach ($_SESSION['cart'] as $car_id => $quantity) {
        $_SESSION['cart'][$car_id] = 0;
        unset($_SESSION['cart'][$car_id]);
    }
    ?>
    </table>
    <h2>Shipping Details</h2></br>
    <p>
        <b>Full Name:</b> <?php echo $fullname?></br>
        <b>Email:</b> <?php echo $email?></br>
        <b>Address:</b> <?php echo $address?></br>
        <b>State:</b> <?php echo $state?></br>
        <b>Country:</b> <?php echo $country?></br>
    </p>
    <form method="get">
        <button style='float:right' class='go-home-btn' type='submit' name='emptyCart'>Go Home</button>
    </form>
    <?php
}