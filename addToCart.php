<?php
$data = file_get_contents('assets/cars.json');
$cars = json_decode($data, true);

$car_id = $_POST['car_id'];
$selected_car = null;

foreach ($cars as $car) {
    if ($car['Car_ID'] === $car_id) {
        $selected_car = $car;
        break;
    }
}

if (!$selected_car) {
    echo "Car does not exist in database.";
}

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if(isset($_POST['quantity'])) {
    $quantity = $_POST['quantity'];
} else {
    $quantity = 1;
}

if (isset($_SESSION['cart'][$car_id])) {
    $_SESSION['cart'][$car_id]['quantity'] += $quantity;
} else {
    $cart_item = [
        'car_id' => $car_id,
        'car_name' => $selected_car['Name'],
        'car_year' => $selected_car['Year'],
        'car_image' => $selected_car['Image'],
        'car_price' => $selected_car['Price_per_day'],
        'quantity' => $quantity
    ];
    $_SESSION['cart'][$car_id] = $cart_item;
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>