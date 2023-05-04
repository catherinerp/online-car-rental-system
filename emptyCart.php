<?php
function emptyCart() {
    foreach ($_SESSION['cart'] as $car_id => $quantity) {
        $_SESSION['cart'][$car_id] = 0;
        unset($_SESSION['cart'][$car_id]);
    }
}

if (isset($_GET['emptyCart'])) {
    emptyCart();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>