<div class="column-right">
        <div class="car-grid"></br>
        <h1 style="text-align:center; padding:5px;">Browse Rental Cars</h1>
        <?php
        $i = 0;
        foreach ($decoded_json as $car) {
            if ($i % 3 == 0) {
                echo '<div class="car-row">';
            }
            $car_id = $car['Car_ID'];
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
            ?>
            
            <div class="car">
                <img src="assets/images/car_images/<?php echo $car_image;?>" alt="Image of<?php echo $car_name;?>" style="width: 300px"></img><br><br>
                <span class="car-name"><?php echo $car_name;?> (<?php echo $car_year;?>)</span><br>
                <span class="car-bodytype"><?php echo $car_bodytype;?></span><br>
                <span class="car-price">$<?php echo $car_price;?>/day</span><br>
                <a href="viewProduct.php?car_id=<?php echo $car_id;?>">
                    <i class="fa fa-eye"></i> Details
                </a></br>
                <?php
                if ($car_availability == false) {
                    ?>
                    <button class="add-cart-btn" type='submit" id='btn' name="addToCart" style="background-color:grey" onclick="unavailableAlert()">
                    <i class="fa fa-question-circle-o"></i> Unavailable</button>
                <?php
                } else {
                    ?>
                    <form action="addToCart.php" method="post">
                    <input type="hidden" name="car_id" value="<?php echo $car_id;?>">
                        <button class="add-cart-btn" type='submit" id='btn' name="addToCart" onclick="addedAlert()">
                            <i class="fa fa-cart-arrow-down"></i> Rent
                        </button>
                        </a>
                    </form>
                <?php
                }
                ?>
                </a>
            </div>

            <?php
            $i++;
            if ($i % 3 == 0) {
                echo '</div>';
            }
        }
        if ($i % 3 != 0) {
            echo '</div>';
        }
        echo '</div>';