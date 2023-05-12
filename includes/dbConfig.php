<?php
    $hostname = "localhost";
    $username = "catherine";
    $password = "password1";
    $dbname = "assignment2";

    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    $link = mysqli_connect("awseb-e-wekpd7ppkx-stack-awsebrdsdatabase-docmvdrwmlb2.cmgwtbm1ff9j.us-east-1.rds.amazonaws.com","catherine","password1","uts");
    if (!$conn)
        die("Could not connect to Server");
?>