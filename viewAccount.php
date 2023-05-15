<?php
include 'includes/header.php';

echo "<div class='main-container'>";
echo "<div class='cart-container' style='padding: 40px;'>";

if (isset($_GET['goBack'])) {
    header('Location: accountForm.php');
    exit();
}

if(isset($_POST['viewAccount'])) {
    include 'includes/dbConfig.php';
    $email = $_POST['email'];
    
    $query = "SELECT * FROM renting_history WHERE user_email = '$email' ORDER BY rent_id ASC";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        echo "<h2 style='text-align:center'>Rent History</h2>";
        echo "<table>";
        echo "<tr>
        <th>Rental ID</th>
        <th>Car</th>
        <th>Rent Date</th>
        <th>Days Rented</th>
        <th>Bond Amount</th>
        <th> </th>
        </tr>";
        while($row = mysqli_fetch_assoc($result)) {
            $filename = 'assets/cars.json';
            $data = file_get_contents($filename);
            $decoded_json = json_decode($data, true);
            echo "<tr>";
            echo "<td>" . $row['rent_id'] . "</td>";
            foreach ($decoded_json as $car) {
                if ($row['car_id'] == $car['Car_ID']) {
                    echo "<td>". $car['Name'] ." (" . $car['Year'] .")</td>";
                }
            }
            echo "<td>" . $row['rent_date'] . "<br></td>";
            echo "<td>" . $row['rent_days'] . "<br></td>";
            echo "<td>$" . $row['bond_amount'] . "<br></td>";
            echo "<td>
            <form action='removeBooking.php' method='post'>
                <input type='hidden' name='updateAvailability' value='". $row['car_id'] ."'>
                <button type='submit' class='remove-item-btn' value='". $row['rent_id'] ."' name='removeBooking' onclick='return confirmDelete()'>
                    <i class='fa fa-remove' style='font-size:28px'></i>
                </button>
            </form>
            </td>";
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
?>
</body>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to cancel your booking?");
    }
</script>
</html>