<?php include 'includes/cartHeader.php';?>
<div class="main-container">
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$fullnameErr = $emailErr = $addressErr = $stateErr = $countryErr = "";
$nameIsValid = $emailIsValid = $addressIsValid = $stateIsValid = $countryIsValid = false;
$fullname = $email = $address = $state = $country = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["fullname"])) {
        $fullnameErr = "Full name is required";
      } else {
        $fullname = test_input($_POST["fullname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$fullname)) {
          $fullnameErr = "Only letters and white space allowed";
        } else {
            $nameIsValid = true;
        }
      }

    if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        } else {
            $emailIsValid = true;
        }
    }

    if (empty($_POST["address"])) {
        $addressErr = "Address is required";
      } else {
        $address = test_input($_POST["address"]);
        $addressIsValid = true;
        }
      

      if (empty($_POST["state"])) {
        $stateErr = "State is required";
      } else {
        $state = test_input($_POST["state"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$state)) {
          $stateErr = "Only letters and white space allowed";
        } else {
            $stateIsValid = true;
        }
      }
      if (empty($_POST["country"])) {
        $countryErr = "Country is required";
      } else {
        $country = test_input($_POST["country"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$country)) {
          $countryErr = "Only letters and white space allowed";
        } else {
            $countryIsValid = true;
        }
      }
      $filename = 'assets/cars.json';
      $data = file_get_contents($filename);
      $decoded_json = json_decode($data, true);
      $cart_has_available_items = false; // flag to track if there are any available items in the cart
      
      foreach ($_SESSION['cart'] as $car_id => $car_data) {
          $car_availability = $car_data['car_availability'];
          if ($car_availability == true) {
              $cart_has_available_items = true;
              break; // exit the loop early if we find an available item
          }
      }
      
      if ($cart_has_available_items && $nameIsValid && $emailIsValid && $addressIsValid && $stateIsValid && $countryIsValid) {
        $car_availability = $car_data['car_availability'];
        foreach ($_SESSION['cart'] as $car_id => $car) {
          if ($car_availability == true) {
            // Check if car_id already exists in decoded json
            if (isset($decoded_json[$car_id])) {
                // Car already exists, update availability
                $decoded_json[$car_id]['Availability'] = false;
            } else {
                // Car does not exist, add new entry
                $decoded_json[$car_id]['Car_ID'] = $car_id;
                $decoded_json[$car_id]['Name'] = $car_name;
                $decoded_json[$car_id]['Make'] = $car_make;
                $decoded_json[$car_id]['Model'] = $car_model;
                $decoded_json[$car_id]['Mileage'] = $car_mileage;
                $decoded_json[$car_id]['Year'] = $car_year;
                $decoded_json[$car_id]['Availability'] = false;
                $decoded_json[$car_id]['Price_per_day'] = $car_price;
                $decoded_json[$car_id]['Fuel'] = $car_fuel;
                $decoded_json[$car_id]['Transmission_type'] = $car_transmission;
                $decoded_json[$car_id]['Seats'] = $car_id;
                $decoded_json[$car_id]['Body_type'] = $car_bodytype;
                $decoded_json[$car_id]['Image'] = $car_id;
            }
          }
        }
        
        $new_json = json_encode($decoded_json, JSON_PRETTY_PRINT);
        file_put_contents('assets/cars.json', $new_json);
      
      
          header("Location: confirmOrder.php?fullname=$fullname&email=$email&address=$address&state=$state&country=$country");
          exit();
      }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
$filename = 'assets/cars.json';
$data = file_get_contents($filename);
$decoded_json = json_decode($data, true);

?>

    <div class="cart-container">
        <?php
        if (empty($_SESSION['cart'])) {
            echo "<h2>Your cart is empty.</h2>";
                echo "<form method='get'>";
                echo "<button style='float:right' class='add-cart-btn' type='submit' name='goHome'>Go Home</button>";
                echo "</form>";
                echo "</div>";
            echo "</div>";
        } else {
            $total_price = 0;
            $total_quantity = 0;
            echo "<div class='cart-view-container'>";
            echo "<h1 style='text-align:center'>Shopping Cart</h1>";
            echo "<table>";
            foreach ($_SESSION['cart'] as $car_id => $car_data) {
                $car_name = $car_data['car_name'];
                $car_year = $car_data['car_year'];
                $car_image = $car_data['car_image'];
                $car_price = $car_data['car_price'];
                $quantity = $car_data['quantity'];
                echo "<tr>";
                echo "<td><img src='assets/images/car_images/$car_image' style='height:100px'></td>";
                echo "<td>$car_name ($car_year)</td>";
                echo "<td>$$car_price/day</td>";
                echo "<td>$quantity";
                if ($quantity > 1) {
                    echo " days";
                } else {
                    echo " day";
                }
                echo "</td>";
                echo "</tr>";
                $total_quantity++;
                $total_price += $car_price * $quantity;
            }
            $total_price = number_format((float)$total_price, 2, '.', '');
            ?>
            </table>
        <h2>Shipping Details</h2>
        <sub><span class="required">*</span> Required field</sub>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="fullname">Full Name <span class="required">*</span></label></br>
            <input type="text" id="fullname" name="fullname" placeholder="E.g. Jane Doe">
            <span class="required"><?php echo $fullnameErr;?></span>
            </br>
            <label for="email">Email <span class="required">*</span></label></br>
            <input type="text" id="email" name="email" placeholder="E.g. jane@email.com">
            <span class="required"><?php echo $emailErr;?></span>
            </br>
            <label for="address">Address <span class="required">*</span></label></br>
            <input type="text" id="address" name="address" placeholder="E.g. 123 Place Street">
            <span class="required"><?php echo $addressErr;?></span>
            </br>
            <label for="state">State <span class="required">*</span></label></br>
            <input type="text" id="state" name="state" placeholder="State">
            <span class="required"><?php echo $stateErr;?></span>
            </br>
            <label for="country">Country <span class="required">*</span></label></br>
            <input type="text" id="country" name="country" placeholder="Country">
            <span class="required"><?php echo $stateErr;?></span>    
            </br>
            <hr>
              <h3>Total</h3>
              <input style="float:right" class="add-cart-btn" type="submit" name="submit" value="Place Order"></input>
              <p><?php echo $total_quantity;?> <i class="fa fa-car" aria-hidden="true"></i></br>
              $<?php echo $total_price;?>/day</p>
              
        </form>
        </div>
        </div>
        <?php    
        }
        ?>
    </div>
</div>
<?php include 'includes/footer.php'?>