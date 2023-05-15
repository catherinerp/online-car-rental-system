<?php session_start(); ?>
<?php include 'includes/header.php';

if (isset($_GET['goBack'])) {
    header("Location: ./index.php");
    exit();
}

$filename = 'assets/cars.json';
$data = file_get_contents($filename);
$cars = json_decode($data, true);

$car_id = $_GET['car_id'];
foreach ($cars as $car) {
    $car_name = $car['Name'];
    $car_model = $car['Model'];
    $car_make = $car['Make'];
    $car_year = $car['Year'];
    $car_price = number_format((float)$car['Price_per_day'], 2, '.', '');
    $car_availability = $car['Availability'];
    $car_mileage = number_format($car['Mileage']);
    $car_fuel = $car['Fuel'];
    $car_transmission = $car['Transmission_type'];
    $car_seats = $car['Seats'];
    $car_bodytype = $car['Body_type'];
    $car_image = $car['Image'];
    if ($car['Car_ID'] === $car_id) {
        ?>  
            <form method="get">
            <button style="float:left; margin:30px;" class="add-cart-btn" type="submit" name="goBack">
                <i class="fa fa-arrow-left"></i> Go Back
            </button>
            </form>
            <div class="car-view" style="
            margin: 0 auto;
            margin-top: 40px;
            margin-bottom: 40px;
            padding: 50px;
            width: 50%;
            ">
                <img src="assets/images/car_images/<?php echo $car_image;?>" alt="Image of<?php echo $car_name;?>" class="car-image"></img><br><br>
                <span style="font-size: 28px;"class="car-name"><?php echo $car_name;?> (<?php echo $car_year;?>)</span><br>
                <span class="car-price">$<?php echo $car_price;?>/day</span><br>
                <p>
                <b>Make:</b> <?php echo $car_make;?></br>
                <b>Model:</b> <?php echo $car_model;?></br>
                <b>Body Type:</b> <?php echo $car_bodytype;?><br>
                <b>Price Per Day:</b> $<?php echo $car_price;?></br>
                <b>Mileage:</b> <?php echo $car_mileage;?>km</br>
                <b>Year:</b> <?php echo $car_year;?></br>
                <b>Fuel Type:</b> <?php echo $car_fuel;?></br>
                <b>Tranmission Type:</b> <?php echo $car_transmission;?></br>
                <b>Seats:</b> <?php echo $car_seats;?></br>
                </p>
                <form action="addToCart.php" method="post">
                    <input type="hidden" name="car_id" value="<?php echo $car_id;?>">
                    <?php
                    if ($car_availability== true) {
                        echo "
                        <p style='font-size: 20px'>Rent for how many days?</br>
                        <input type='number' style='width: 50px;' value='1' name='quantity' min='1' max='10'></br>
                        </p>
                        <button class='add-cart-btn' type='submit' id='btn' name='addToCart' onclick='addedAlert()'><i class='fa fa-cart-arrow-down'></i> Rent</button>'
                        ";
                    } else {
                        echo "<h2 style='text-align:center; color:red;'>Unavailable to rent</h2>";
                    }
                    ?>
                    </form>
            </div>
    <?php
    }
}
?>
<?php include 'includes/footer.php'?>