<?php session_start(); ?>
<?php
$data = file_get_contents('assets/cars.json');
$cars = json_decode($data, true);

$car_id = $_POST['car_id'];
$selected_car = null;

foreach ($cars as $car) {
    if ($car['Car_ID'] === $car_id) {
        $selected_car = $car;
        if (!$selected_car) {
            echo "Car does not exist in the database.";
        }
        break;
    }
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if(isset($_POST['quantity'])) {
    $quantity = $_POST['quantity'];
} else {
    $quantity = 1;
}

if (isset($_SESSION['cart'][$car_id])) {
    if ($_SESSION['cart'][$car_id]['quantity'] + $quantity > 10) {
        echo "<script type='text/javascript'>
        alert('Cars are not available to rent for more than 10 days.');
        window.location.href = '{$_SERVER['HTTP_REFERER']}';
        </script>";
    } else {
        echo "<script type='text/javascript'>
        alert('Car added to cart.');
        window.location.href = '{$_SERVER['HTTP_REFERER']}';
        </script>";
        $_SESSION['cart'][$car_id]['quantity'] += $quantity;
    }
} else {
    if ($quantity > 10) {
        echo "<script type='text/javascript'>
        alert('Cars are not available to rent for more than 10 days.');
        window.location.href = '{$_SERVER['HTTP_REFERER']}';
        </script>";
    } else {
        $cart_item = [
            'car_id' => $car_id,
            'car_name' => $selected_car['Name'],
            'car_year' => $selected_car['Year'],
            'car_image' => $selected_car['Image'],
            'car_availability' => $selected_car['Availability'],
            'car_price' => $selected_car['Price_per_day'],
            'quantity' => $quantity
        ];
        echo "<script type='text/javascript'>
        alert('Car added to cart.');
        window.location.href = '{$_SERVER['HTTP_REFERER']}';
        </script>";
        $_SESSION['cart'][$car_id] = $cart_item;
    }
}
?>