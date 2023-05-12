<?php
$filtered_array = array_filter($decoded_json);
// Filter cars by selected make
if (isset($_GET['filter_make'])) {
    $make = $_GET['filter_make'];
    $filtered_array = array_filter($filtered_array, function($car) use($make) {
    return $car['Make'] === $make;
    });
}

// Filter cars by selected body type
if (isset($_GET['filter_body_type'])) {
    $body_type = $_GET['filter_body_type'];
    $filtered_array = array_filter($filtered_array, function($car) use($body_type) {
    return $car['Body_type'] === $body_type;
    });
}

// Filter cars by selected fuel type
if (isset($_GET['filter_fuel_type'])) {
    $fuel_type = $_GET['filter_fuel_type'];
    $filtered_array = array_filter($filtered_array, function($car) use($fuel_type) {
    return $car['Fuel'] === $fuel_type;
    });
}

// Sort cars by price
if (isset($_GET['sort_price_order'])) {
    $price_order = $_GET['sort_price_order'];
    usort($filtered_array, function($a, $b) use($price_order) {
    if ($price_order === 'ascPrice') {
        return $a['Price_per_day'] - $b['Price_per_day'];
    } else {
        return $b['Price_per_day'] - $a['Price_per_day'];
    }
    });
}

// Filter cars by price range
if (isset($_GET['sort_price_range'])) {
    $price_range = $_GET['sort_price_range'];
    $filtered_array = array_filter($filtered_array, function($car) use($price_range) {
    $price = $car['Price_per_day'];
    if ($price_range === 'lowPrice') {
        return $price < 50;
    } else if ($price_range === 'medPrice') {
        return $price >= 50 && $price < 100;
    } else {
        return $price >= 100;
    }
    });
}

// Sort cars by year
if (isset($_GET['sort_year_order'])) {
    $year_order = $_GET['sort_year_order'];
    usort($filtered_array, function($a, $b) use($year_order) {
    if ($year_order === 'ascYear') {
        return $a['Year'] - $b['Year'];
    } else {
        return $b['Year'] - $a['Year'];
    }
    });
}

// Sort cars by mileage
if (isset($_GET['sort_mileage'])) {
    $mileage_order = $_GET['sort_mileage'];
    usort($filtered_array, function($a, $b) use($mileage_order) {
    if ($mileage_order === 'ascMile') {
        return $a['Mileage'] - $b['Mileage'];
    } else {
        return $b['Mileage'] - $a['Mileage'];
    }
    });
}
?>

<div class="column-right">
        <?php
        $i = 0;
        if (empty($filtered_array)) {
            echo "<div class='column-right'>";
            echo "<h3 style='text-align:center'>Sorry! None of our cars fit your critera, please try again.</h3>";
            echo "</div>";
        } else {
            ?>
            <div class="car-grid"></br>
            <h1 style="text-align:center; padding:5px;">Filtered Results</h1>
            <?php
            foreach ($filtered_array as $car) {
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
                        <button class="add-cart-btn" type='submit" id='btn' name="addToCart" style="background-color:grey" onclick="unavailableAlert()">
                        <i class="fa fa-question-circle-o"></i> Unavailable</button>
                    <?php
                    } else {
                        ?>
                        <form action="addToCart.php" method="post">
                        <input type="hidden" name="car_id" value="<?php echo $car_id;?>">
                            <button class="add-cart-btn" type='submit" id='btn' name="addToCart">
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
        }