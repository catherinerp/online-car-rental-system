<div class="column-right">
        <div class="car-grid"></br>
        <h1 style="text-align:center; padding:5px;">Browse Rental Cars</h1>
        <?php
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        $i = 0;
        $filename = 'assets/cars.json';
        $data = file_get_contents($filename);
        $decoded_json = json_decode($data, true);
        foreach ($decoded_json as $car) {
            if ($i % 3 == 0) {
                echo '<div class="car-row">';
            }
            
            $car_id = $car['Car_ID'];
            $car_name = $car['Name'];
            $car_model = $car['Model'];
            $car_make = $car['Make'];
            $car_mileage = number_format($car['Mileage']);
            $car_year = $car['Year'];
            $car_availability = $car['Availability'];
            $car_price = number_format((float)$car['Price_per_day'], 2, '.', '');
            $car_fuel = $car['Fuel'];
            $car_transmission = $car['Transmission_type'];
            $car_seats = $car['Seats'];
            $car_bodytype = $car['Body_type'];
            $car_image = $car['Image'];
            ?>
            <div class="car">
                <div class="image-container">
                    <img src="assets/images/car_images/<?php echo $car_image;?>" alt="Image of<?php echo $car_name;?>" class="car-image"></img>
                    <div class="image-middle">
                    <a style="text-decoration:none; color:black;" href="viewProduct.php?car_id=<?php echo $car_id;?>">
                        <div class="image-link">
                            Details
                        </div>
                        </a>
                    </div>    
                </div>      
                <br><br>
                <span class="car-name"><?php echo $car_name;?> (<?php echo $car_year;?>)</span><br>
                <span class="car-bodytype"><?php echo $car_bodytype;?></span><br>
                <span class="car-bodytype"><?php echo $car_mileage;?>km</span><br>
                <span class="car-price">$<?php echo $car_price;?>/day</span><br>
                <?php
                if ($car_availability == false) {
                    ?>
                    <button class="add-cart-btn" type='submit" id='btn' name="addToCart" style="width:100%; background-color:grey;" onclick="unavailableAlert()">
                    <i class="fa fa-question-circle-o"></i> Unavailable</button>
                <?php
                } else {
                    ?>
                    <form action="addToCart.php" method="post">
                    <input type="hidden" name="car_id" value="<?php echo $car_id;?>">
                        <button style="width:100%;" class="add-cart-btn" type='submit" id='btn' name="addToCart">
                            <i class="fa fa-cart-arrow-down"></i> Rent
                        </button>
                    </form>
                <?php
                }
            echo "</div>";
            $i++;
            if ($i % 3 == 0) {
                echo "</div>\n";
            }
        }
        if ($i % 3 != 0) {
            echo "</div>";
        }
        echo "</div>";