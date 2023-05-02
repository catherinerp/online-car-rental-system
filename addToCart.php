<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    if(isset($_GET['quantity'])) {
        $quantity = $_GET['quantity'];

    } else {
        $quantity = 1;
    }

    if (array_key_exists($car_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$car_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$car_id] = array('quantity' => $quantity);
    }

    $_SESSION['cart'][$car_id] = array('quantity' => $quantity);

    echo "<pre>";
    print_r($_SESSION['cart']);
    echo "</pre>";

}
?> 