<?php include 'includes/header.php'; ?>

<?php
session_start();

$filename = 'assets/cars.json';
$data = file_get_contents($filename);
$cars = json_decode($data, true);

$car_id = $_GET['car_id'];
foreach ($cars as $car) {
    $car_name = $car['Name'];
    $car_model = $car['Model'];
    $car_make = $car['Make'];
    $car_mileage = $car['Mileage'];
    $car_year = $car['Year'];
    $car_availability = $car['Availability'];
    $car_price = $car['Price_per_day'];
    $car_fuel = $car['Fuel'];
    $car_transmission = $car['Transmission_type'];
    $car_seats = $car['Seats'];
    $car_bodytype = $car['Body_type'];
    $car_image = $car['Image'];
    if ($car['Car_ID'] === $car_id) {
        ?>
            <div class="car-view" style="
            margin: 0 auto;
            padding: 50px;
            width: 50%;
            ">
                <img src="assets/images/car_images/<?php echo $car_image;?>" alt="Image of<?php echo $car_name;?>" style="width: 300px"></img><br><br>
                <span style="font-size: 28px;"class="car-name"><?php echo $car_name;?> (<?php echo $car_year;?>)</span><br>
                <span class="car-price">$<?php echo $car_price;?>/day</span><br>
                <p>
                <b>Make:</b> <?php echo $car_make;?></br>
                <b>Model:</b> <?php echo $car_model;?></br>
                <b>Body Type:</b> <?php echo $car_bodytype;?><br>
                <b>Mileage:</b> <?php echo $car_mileage;?></br>
                <b>Year:</b> <?php echo $car_year;?></br>
                <b>Price Per Day:</b> <?php echo $car_price;?></br>
                <b>Fuel Type:</b> <?php echo $car_fuel;?></br>
                <b>Tranmission Type:</b> <?php echo $car_transmission;?></br>
                <b>Seats:</b> <?php echo $car_seats;?></br>
                </p>
                <form action="addToCart.php" method="get">
                    <input type="hidden" name="car_id" value="<?php echo $car_id;?>">
                    <?php
                    if ($car_availability== true) {
                        echo "
                        <p style='font-size: 20px'>Rent for how many days?</br>
                        <input type='number' style='width: 50px;' name='quantity' min='0'</br>
                        </p>
                        <button class='add-cart-btn' type='submit' id='btn' name='addToCart' onclick='reloadPage()><i class='fa fa-cart-arrow-down'></i> Rent</button>'
                        ";
                    } else {
                        echo "<h2 style='color:red'>Unavailable to rent</h2>";
                    }
                    ?>
                    </form>
            </div>
    <?php
    }
}
?>
<?php include 'includes/footer.php'?>