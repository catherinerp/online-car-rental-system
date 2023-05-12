<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hertz-UTS</title>
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon"/>
    <link href="assets/css/index.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<div class="header">
    <a href="./index.php"><img class="header-logo" src="assets/images/logo-full.png"></a>
    <div class="header-title">Car Rental Center</div>
    <div class="nav-item dropdown">
            <div class="dropdown">
                    <?php 
                    if (empty($_SESSION['cart'])) {
                        ?>
                        <button id="header-cart" title="Cart is empty!" class="header-cart" data-toggle="dropdown" style="color:dimgray; cursor:default" disabled>
                            <i class="fa fa-shopping-cart"></i>
                        </button>
                        <?php
                    } else {
                        $cart = $_SESSION['cart'];
                        $count = count($cart);
                        ?>
                        <button id="header-cart" class="header-cart" data-toggle="dropdown">
                        <span style="font-size: 15px" class="badge badge-pill badge-danger"><?php echo $count?></span>
                        <i class="fa fa-shopping-cart"></i>
                        </button>
                        <div class="dropdown-menu">
                            <?php
                            $total_price = 0;
                            foreach ($_SESSION['cart'] as $car_id => $car_data) {
                                $car_name = $car_data['car_name'];
                                $car_year = $car_data['car_year'];
                                $car_image = $car_data['car_image'];
                                $car_price = $car_data['car_price'];
                                $car_price = number_format((float)$car_price, 2, '.', '');
                                $quantity = $car_data['quantity'];
                                ?>
                                    <br>
                                    <img src="assets/images/car_images/<?php echo $car_image?>" style="height:50px; border-radius:8px; box-shadow:0 0 5px rgba(0, 0, 0, 0.1);">
                                    <a style="color:gray; font-size:20px; font-weight: 700px; text-decoration:none;" href="viewProduct.php?car_id=<?php echo $car_id?>"><?php echo $car_name?></a></br>
                                    <div style='float:right'>
                                    <span style="font-style">$<?php echo $car_price?></span> 
                                    <span style="font-weight:300px;"> for 
                                        <?php 
                                        echo $quantity;
                                        if ($quantity > 1) {
                                            echo " days";
                                        } else {
                                            echo " day";
                                        }?>
                                    </span>
                                    </div>
                                    </br>
                                <?php
                                    $total_price += $car_price * $quantity;
                            }
                            ?>
                        <hr>
                        <h5>Total: $<?php echo $total_price = number_format((float)$total_price, 2, '.', '');?></h5>
                        <a href="checkout.php"
                        style="
                        border: 0px;
                        border-radius: 8px;
                        background-color: #ffd100;
                        color: black;
                        " class="btn btn-primary btn-block">
                        Checkout</a>
                        <a href="viewCart.php" style="
                        border: 0px;
                        border-radius: 8px;
                        background-color: #D3D3D3;
                        color: black;
                        " class="btn btn-primary btn-block">Cart</a>
                        </div>
                <?php
                }
                ?>
            </div>
        </div>
    <div style="clear: both;"></div>
    <div class="topnav">
        <a href="./index.php">Home</a>
        <a class="account-button" href="accountForm.php">Account</a>
        <a href="./help.php">Help</a>
    </div>
</div>
<body>