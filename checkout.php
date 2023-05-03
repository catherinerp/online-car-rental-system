<?php include 'includes/header.php';?>
<div class="main-container">
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/**
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
session_start();

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
        $fullname = htmlentities($_POST['fullname']);
        $email = htmlentities($_POST['email']);
        $address = htmlentities($_POST['address']);
        $state = htmlentities($_POST['state']);
        $country = htmlentities($_POST['country']);
        $subject = htmlentities("your order has been confirmed! | Grocery TO-GO");
        $sender = htmlentities("Grocery TO-GO");

        $today_date = date("d/m/Y");
        $current_time = date("h:i:a");
        $total_price = htmlentities($total_price);
        
        $message = '
        <html>
          <head>
            <title>Order Confirmation | Grocery TO-GO</title>
          </head>
          <body>
            <h1>Your order has been confirmed!</h1>
            <h3>Thank you for ordering from Grocery TO-GO.</h3>'
            .'<p>You should expect your order to be delivered within 2-3 business days.</p>'
            .'<p><b>Time:</b> '. $current_time .'</p>'
            .'<p><b>Date:</b> '. $today_date .'</></p><hr>'
            .'<h2>Billing Details </h2>'
            .'<p><b>Full Name: </b>'. $fullname .'</p>'
            .'<p><b>Email: </b>'. $email .'</p>'
            .'<p><b>Address: </b>'. $address .'</p>'
            .'<p><b>State: </b>'. $state .'</p>'
            .'<p><b>Country: </b>'. $country .'</p>
          </body>
        ';
        $message .="
        </body>
        </html>";

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username='grocerytogogo@gmail.com';
        $mail->Password='whivlxsyfmrolzyi';
        $mail->Port= 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom($email, $sender);
        $mail->addAddress($email);
        $mail->Subject = ("$fullname, $subject");
        $mail->Body = $message;
        $mail->send();

        header("Location: confirmOrderPage.php?fullname=$fullname&email=$email&address=$address&state=$state&country=$country");
        exit();
    }  
}

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }*/
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
            <div class="cart-actions">
                <h3>Total</h3>
                <p><?php echo $total_quantity;?> <i class="fa fa-car" aria-hidden="true"></i></br>
                $<?php echo $total_price;?>/day</p>
                <input style="float:right" class="checkout-btn" type="submit" name="submit" value="Place Order"></input>
            </div>
        </form>
        </div>
        </div>
        <?php    
        }
        ?>
    </div>
</div>
<?php include 'includes/footer.php'?>