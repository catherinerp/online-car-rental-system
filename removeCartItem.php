<?php
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
?>