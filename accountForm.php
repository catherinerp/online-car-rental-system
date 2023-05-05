<?php

include 'includes/header.php'; 
?>

<div class="main-container">
    <div class="cart-container">
        <h1 style="text-align:center">Access Your Rent History</h1>
        <p style="padding: 20px;width: 100%;">
        Access your renting history here with your email address, no password required!
        <p>
        <form action="viewAccount.php" method="post">
            <h4 for="">Enter your email address:</h4>
            <input type="text" name="email" placeholder="Email"></br>
            <button class="add-cart-btn" type="submit" name="viewAccount">View Rent History</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>