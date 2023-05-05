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
        // Email found in database
        while($row = mysqli_fetch_assoc($result)) {
            // Print matching columns
            echo "Car: " . $row['car_id'] . "<br>";
            echo "Bond: " . $row['bond_amount'] . "<br>";
            // and so on for other columns
        }
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
echo "</div>;";
echo "</div>;";
include 'includes/footer.php';