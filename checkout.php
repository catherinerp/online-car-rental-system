<?php session_start();

include 'includes/cartHeader.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

$firstnameErr = $surnameErr = $emailErr = $phoneErr = $addressErr = $cityErr = $stateErr = $postcodeErr = $countryErr = $paymentErr =  "";
$firstnameIsValid = $surnameIsValid = $emailIsValid = $phoneIsValid = $addressIsValid = $cityIsValid = $stateIsValid = $postcodeIsValid = $countryIsValid = $paymentIsValid = false;
$firstname = $surname = $email = $phone = $address = $city = $state = $postcode = $country = $payment = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstname"])) {
    $firstnameErr = "Full name is invalid";
  } else {
    $firstname = test_input($_POST["firstname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) {
      $firstnameErr = "Only letters and white space allowed";
    } else {
      $firstnameIsValid = true;
      }
  }
  if (empty($_POST["surname"])) {
    $surnameErr = "Surname is invalid";
  } else {
    $surname = test_input($_POST["surname"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$surname)) {
      $surnameErr = "Only letters and white space allowed";
    } else {
      $surnameIsValid = true;
    }
  }
  if (empty($_POST["email"])) {
    $emailErr = "Email is invalid";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    } else {
      $emailIsValid = true;
    }
  }
  if (empty($_POST["phone"])) {
    $phoneErr = "Phone number is invalid";
  } else {
    $phone = test_input($_POST["phone"]);
    if (!preg_match("/^\d{1,10}$/",$phone)) {
      $phoneErr = "Phone number must be 10 digits";
    } else {
      $phoneIsValid = true;
    }
  }
  if (empty($_POST["address"])) {
    $addressErr = "Address is invalid";
  } else {
    $address = test_input($_POST["address"]);
    $addressIsValid = true;
  }
  if (empty($_POST["city"])) {
    $cityErr = "City is invalid";
  } else {
    $city = test_input($_POST["city"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$city)) {
      $cityErr = "Only letters and white space allowed";
    } else {
      $cityIsValid = true;
    }
  } 
  if (empty($_POST["state"]) || $_POST["state"] == "") {
    $stateErr = "Please select a state";
  } else {
    $state = test_input($_POST["state"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$state)) {
      $stateErr = "Only letters and white space allowed";
    } else {
      $stateIsValid = true;
    }
  }      
  if (empty($_POST["postcode"])) {
    $postcodeErr = "Postcode is invalid";
  } else {
    $postcode = test_input($_POST["postcode"]);
    if (!preg_match("/^\d{1,6}$/", $postcode)) {
      $postcodeErr = "Only numbers and up to 6 digits allowed";
    } else {
      $postcodeIsValid = true;
    }
  }
  if (empty($_POST["country"])) {
    $countryErr = "Country is invalid";
  } else {
    $country = test_input($_POST["country"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$country)) {
      $countryErr = "Only letters and white space allowed";
    } else {
      $countryIsValid = true;
    }
  }
  if (empty($_POST["payment"]) || $_POST["payment"] == "") {
    $paymentErr = "Please select a payment method";
  } else {
    $payment = test_input($_POST["payment"]);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$payment)) {
      $paymentErr = "Only letters and white space allowed";
    } else {
      $paymentIsValid = true;
    }
  }
  if ($firstnameIsValid && $surnameIsValid && $emailIsValid && $phoneIsValid && $addressIsValid && $stateIsValid && $postcodeIsValid && $countryIsValid && $paymentIsValid) {
    $filename = 'assets/cars.json';
    $data = file_get_contents($filename);
    $decoded_json = json_decode($data, true);
    $cart_has_available_items = false;
    echo "i am at all things are valid";

    foreach ($_SESSION['cart'] as $car_id => $car) {
    $car_availability = $car['car_availability'];
      if ( $car_availability == true ) {
        echo "car_availability is being reached";
        $car_availability == false;
        $car_availability = $car['car_availability'];
        if ($car_availability == true) {
          $cart_has_available_items = true;
          break;
        }
      }
    }
    foreach ($_SESSION['cart'] as $car_id => $car) {
      if ($cart_has_available_items) {
      echo "cart_has_available_items is being reached";
      $car_availability = $car['car_availability'];
      if (isset($decoded_json[$car_id])) {
          $decoded_json[$car_id]['Availability'] = false;
        }
      }
      $car_id = $car['car_id'];
      $car_price = $car['car_price'];
      $rent_days = $car['quantity'];
      $bond_amount = $car_price * $rent_days;
      $email = $_POST['email'];
      $rent_date = date('Y/m/d');

      include 'includes/dbConfig.php';
      $sql = "SELECT MAX(rent_id) AS max_rent_id FROM renting_history";
      $result = mysqli_query($conn, $sql);
      
      if (!$result) {
        die('Error: ' . mysqli_error($conn));
      }
      
      $row = mysqli_fetch_assoc($result);
      $rent_id = $row['max_rent_id'] + 1;
      mysqli_free_result($result);
      $stmt = mysqli_prepare($conn, "INSERT INTO renting_history (rent_id, car_id, user_email, rent_date, rent_days, bond_amount) VALUES (?, ?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "iisssi", $rent_id, $car_id, $email, $rent_date, $rent_days, $bond_amount);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
    $new_json = json_encode($decoded_json, JSON_PRETTY_PRINT);
    file_put_contents('assets/cars.json', $new_json);
    header("Location: confirmOrder.php?firstname=$firstname&surname=$surname&email=$email&phone=$phone&address=$address&city=$city&state=$state&postcode=$postcode&country=$country&payment=$payment");
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
<div class="main-container">
    <div class="cart-container" style="padding: 40px; padding-bottom: 80px;">
        <?php
        if (empty($_SESSION['cart'])) {
          echo "<h2 style='text-align:center'>Your cart is empty.</h2>";
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
            echo "<table style='width:100%'>";
            foreach ($_SESSION['cart'] as $car_id => $car_data) {
                $car_name = $car_data['car_name'];
                $car_year = $car_data['car_year'];
                $car_image = $car_data['car_image'];
                $car_price = $car_data['car_price'];
                $quantity = $car_data['quantity'];
                echo "<tr>";
                echo "<td><img src='assets/images/car_images/$car_image' class='cart-car-image'></td>";
                echo "<td style='font-size: 20px;'>$car_name ($car_year)</td>";
                echo "<td><b>$$car_price/day</b></br>";
                echo "for $quantity";
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
          <hr>
        <h2 style="text-align:center">Billing Details</h2>
        <p style="float:right;"><span class="required">*</span> Required field</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <label for="firstname">First Name <span class="required">*</span></label></br>
            <input type="text" id="firstname" name="firstname" style="height:30px; width:202.5px" placeholder="First Name">
            <span class="required"><?php echo $firstnameErr;?></span>
            </br>
            <label for="surname">Surname <span class="required">*</span></label></br>
            <input type="text" id="surname" name="surname" style="height:30px; width:202.5px" placeholder="Surname">
            <span class="required"><?php echo $surnameErr;?></span>
            </br>
            <label for="email">Email Address <span class="required">*</span></label></br>
            <input type="text" id="email" name="email" style="height:30px; width:202.5px" placeholder="Email Address">
            <span class="required"><?php echo $emailErr;?></span>
            </br>
            <label for="phone">Phone <span class="required">*</span></label></br>
            <input type="tel" id="phone" name="phone" style="height:30px; width:202.5px" placeholder="Phone">
            <span class="required"><?php echo $phoneErr;?></span>
            </br>
            <label for="address">Address <span class="required">*</span></label></br>
            <input type="text" id="address" name="address" style="height:30px; width:202.5px" placeholder="Address">
            <span class="required"><?php echo $addressErr;?></span>
            </br>
            <label for="city">City <span class="required">*</span></label></br>
            <input type="text" id="city" name="city" style="height:30px; width:202.5px" placeholder="City">
            <span class="required"><?php echo $cityErr;?></span>
            </br>
            <label for="state">State <span class="required">*</span></label></br>
            <select name="state" id="state" style="height:30px; width:202.5px">
              <option value="" disabled selected>Select State</option>
              <option value="New South Wales">New South Wales</option>
              <option value="South Australia">South Australia</option>
              <option value="Queensland">Queensland</option>
              <option value="Tasmania">Tasmania</option>
              <option value="Northern Territory">Northern Territory</option>
              <option value="Australian Capital Territory">Australian Capital Territory</option>
              <option value="Western Australia">Western Australia</option>
              <option value="Victoria">Victoria</option>
          </select>
          <span class="required"><?php echo $stateErr;?></span>
          </br>
          <label for="postcode">Postcode <span class="required">*</span></label></br>
            <input type="text" id="postcode" name="postcode" style="height:30px; width:202.5px" placeholder="Postcode">
            <span class="required"><?php echo $postcodeErr;?></span>
            </br>
            <label for="country">Country <span class="required">*</span></label></br>
            <input type="text" id="country" name="country" style="height:30px; width:202.5px" placeholder="Country">
            <span class="required"><?php echo $countryErr;?></span>    
          </br>
          <label for="payment">Payment Method <span class="required">*</span></label></br>
            <select name="payment" id="payment" style="height:30px; width:202.5px">
              <option value="" disabled selected>Select Payment Method</option>
              <option value="Credit Card">Credit Card</option>
              <option value="Bank Transfer">Bank Transfer</option>
              <option value="Cheque">Cheque</option>
          </select>
          <span class="required"><?php echo $paymentErr;?></span>
          </br>
            <hr>
              <h3>Total</h3>
              <input style="float:right" class="add-cart-btn" type="submit" name="submit" value="Place Order"></input>
              <p style="font-size:20px"><?php echo $total_quantity;?> <i class="fa fa-car" aria-hidden="true"></i></br>
              $<?php echo $total_price;?></p>
              
        </form>
        </div>
        </div>
        <?php    
        }
        ?>
    </div>
</div>
<?php include 'includes/footer.php'?>