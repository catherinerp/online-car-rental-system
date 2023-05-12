<?php
include 'includes/header.php'; 
?>
<div class="main-container">
    <div class="cart-container">
        </br>
        <h1 style="text-align:center">Access Your Rent History</h1>
        <p style="margin:0 auto; padding:20px; width:100%;">
        Access your renting history here with your email address, no password required!<br>
        Simply type in the email address associated with your rental bookings.
        <p>
        <form style="text-align:center" action="viewAccount.php" method="post">
            <h4 for="">Enter your email address:</h4>
            <input type="text" style="padding: 12px 20px; margin: 8px 0; box-sizing: border-box; width: 50%" name="email" placeholder="Email"></br>
            <button class="add-cart-btn" type="submit" name="viewAccount">View Rent History</button>
        </form>
    </div>
</div>
<?php include 'includes/footer.php'; ?>