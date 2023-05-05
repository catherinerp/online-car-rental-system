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
      if ($nameIsValid && $emailIsValid && $addressIsValid && $stateIsValid && $countryIsValid) {
        $filename = 'assets/cars.json';
        $data = file_get_contents($filename);
        $decoded_json = json_decode($data, true);
  
        $cart_has_available_items = false;
  
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