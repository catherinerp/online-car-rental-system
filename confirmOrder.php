<?php
include 'includes/cartHeader.php';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

include 'emptyCart.php';

if (isset($_GET['goHome'])) {
    header("Location: ./index.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    ?>
    <div class="main-container">
        <div class="cart-container" style="padding: 40px; padding-bottom: 80px">
            <h2 style="text-align:center">Your cart is empty.</h2>
            <form method="get">
                <button style='float:right' class='add-cart-btn' type='submit' name='emptyCart'>Go Home</button>
            </form>
        </div>
    </div>
    <?php
} else {
    $total_price = 0;
    $total_quantity = 0;
    $firstname = $_GET['firstname'];
    $surname = $_GET['surname'];
    $email = $_GET['email'];
    $phone = $_GET['phone'];
    $address = $_GET['address'];
    $city = $_GET['city'];
    $state = $_GET['state'];
    $postcode = $_GET['postcode'];
    $country = $_GET['country'];
    $payment = $_GET['payment'];
    ?>
    <div class="main-container">
        <div class="cart-container" style="padding: 40px; padding-bottom: 80px">
        <h1>Your order has been confirmed!</h1>
            <h3>Thank you for renting from Hertz-UTS <i class="fa fa-car"></i></h3></br>
            <p class="confirmation-order-message">
                Your car should be available to be picked up within the hour, please wait for a
                pick-up confirmation email before picking it up.
            </p>
            <hr>
        <h2>Billing Details</h2></br>
        <p>
            <b>Full Name:</b> <?php echo $firstname . ' ' . $surname;?></br>
            <b>Email:</b> <?php echo $email?></br>
            <b>Phone:</b> <?php echo substr($phone, 0, 4) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7); ?></br>
            <b>Address:</b> <?php echo $address . ' ' . $city . ' ' . $state . ' ' . $postcode . ' ' . $country;?></br>
            <b>Payment Method:</b> <?php echo $payment?></br>
        </p>
            <h2>Order Details</h2></br>
            <table style="width:100%">
        <?php
            foreach ($_SESSION['cart'] as $car_id => $car_data) {
            $car_name = $car_data['car_name'];
            $car_year = $car_data['car_year'];
            $car_image = $car_data['car_image'];
            $car_price = $car_data['car_price'];
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
            echo "</tr>";
            $total_quantity++;
                $total_price += $car_price * $quantity;
        }
        $total_price = number_format((float)$total_price, 2, '.', '');
        foreach ($_SESSION['cart'] as $car_id => $quantity) {
            $_SESSION['cart'][$car_id] = 0;
            unset($_SESSION['cart'][$car_id]);
        }
        ?>
        </table>
        <hr>
            <h3>Total</h3>
            <p style="font-size:20px"><?php echo $total_quantity;?> <i class="fa fa-car" aria-hidden="true"></i></br>
            $<?php echo $total_price;?></p>
        <form method="get">
            <button style='float:right' class='add-cart-btn' type='submit' name='emptyCart'>Go Home</button>
        </form>
    </div>
</div>
    <?php
}