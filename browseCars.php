<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$filename = 'assets/cars.json';
$data = file_get_contents($filename);
$decoded_json = json_decode($data, true);
?>
    <div class="column-left">
        <h3>Filter</h3>
        <form method="GET">
            <h5>Make</h5>
            <select name="filter_body_type" class="form-control">
                <option value="" disabled selected>Filter by Make</option>
                <?php
                $makes = array();
                foreach ($decoded_json as $car) {
                    $make = $car['Make'];
                    if (!in_array($make, $makes)) {
                        $makes[] = $make;
                    ?>
                    <option value="<?php echo $make; ?>"><?php echo $make; ?></option>
                <?php
                    }
                }
                ?>
            </select></br>
            <h5>Body Type</h5>
            <select name="filter_body_type" class="form-control" >
                <option value="" disabled selected>Filter by Body Type</option>
                <?php
                $body_types = array();
                foreach ($decoded_json as $car) {
                    $body_type = $car['Body_type'];
                    if (!in_array($body_type, $body_types)) {
                        $body_types[] = $body_type;
                    ?>
                    <option value="<?php echo $body_type; ?>"><?php echo $body_type; ?></option>
                <?php
                    }
                }
                ?>
            </select></br>
            <h5>Fuel Type</h5>
            <select name="filter_fuel_type" class="form-control">
                <option value="" disabled selected>Filter by Fuel Type</option>
                <?php
                $fuels = array();
                foreach ($decoded_json as $car) {
                    $fuel = $car['Fuel'];
                    if (!in_array($fuel, $fuels)) {
                        $fuels[] = $fuel;
                    ?>
                    <option value="<?php echo $fuel; ?>"><?php echo $fuel; ?></option>
                <?php
                    }
                }
                ?>
            </select></br>
            <h5>Price</h5>
            <select id="sort-order" name="sort_price_order" class="form-control">
                <option value="" disabled selected>Sort by Price</option>
                <option value="ascPrice">Sort by Price (Low to High)</option>
                <option value="descPrice">Sort by Price (High to Low)</option>
            </select></br>
            <h5>Price Range</h5>
            <select id="sort-order" name="sort_price_range" class="form-control">
                <option value="" disabled selected>Sort by Price Range</option>
                <option value="lowPrice">0 - $50</option>
                <option value="medPrice">$50 - $100</option>
                <option value="highPrice">$50 - $100 </option>
            </select></br>
            <h5>Year</h5>
            <select id="sort-order" name="sort_year_order" class="form-control">
                <option value="" disabled selected>Sort by Year</option>
                <option value="ascYear">Sort by Year (Low to High)</option>
                <option value="descYear">Sort by Year (High to Low)</option>
            </select></br>
            <h5>Mileage</h5>
            <select id="sort-order" name="sort_mileage" class="form-control">
                <option value="" disabled selected>Sort by Mileage</option>
                <option value="ascMile">Sort by Mileage (Low to High)</option>
                <option value="descMile">Sort by Mileage (High to Low)</option>
            </select></br>
            <input type="hidden" name="query">
            <button type="submit" class="add-cart-btn" style="margin: 10px 30px;"><b>Filter <b><i class="fa fa-chevron-right" style="font-size: 11px"></i></button>
        </form>
    </div>
    <?php
    if(isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conn, $_GET['query']);
    $sort_order = $_GET['sort_order'];
    $min_length = 3;
    } else {
    ?>
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
}
?>   
</div>
<script> 
    function unavailableAlert() {
        alert("Sorry, this car is not available now.\nPlease try other cars.");
    }
    function addedAlert() {
        alert("<?php echo $car_name . " (" . $car_year . ")";?> added to cart.");
    }
</script>
