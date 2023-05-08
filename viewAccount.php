<?php
include 'includes/header.php';
echo "<div class='main-container'>";
echo "<div class='cart-container'>";

if (isset($_GET['goBack'])) {
    header("Location: accountForm.php");
    exit();
}

if(isset($_POST['viewAccount'])) {
    include 'includes/dbConfig.php';
    $email = $_POST['email'];
    
    $query = "SELECT * FROM renting_history WHERE user_email = '$email'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        echo "<h2 style='text-align:center'>Rent History</h2>";
        echo "<table>";
        echo "<tr>
        <th> </th>
        <th>Car</th>
        <th>Rent Date</th>
        <th>Days Rented</th>
        <th>Bond Amount</th>
        </tr>";
        while($row = mysqli_fetch_assoc($result)) {
            $filename = 'assets/cars.json';
            $data = file_get_contents($filename);
            $decoded_json = json_decode($data, true);
            echo "<tr>";
            foreach ($decoded_json as $car) {
                if ($row['car_id'] == $car['Car_ID']) {
                    echo "<td><img style='height:150px' src='assets/images/car_images/". $car['Image'] ."'></td>";
                    echo "<td><h4> ". $car['Name'] ." (" . $car['Year'] .")</h4></td>";
                }
            }
            echo "<td>" . $row['rent_date'] . "<br></td>";
            echo "<td>" . $row['rent_days'] . "<br></td>";
            echo "<td>" . $row['bond_amount'] . "<br></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        ?>
        <h2 style="text-align:center">No Results</h2>
        <form method="get">
            <button style="float:right" class="add-cart-btn" type="submit" name="goBack">Go Back</button>
        </form>
        <h5>No rent history found under "<b><?php echo $email;?>"</b></h5>
        <?php
    }
}
echo "</div>";
echo "</div>";
include 'includes/footer.php';