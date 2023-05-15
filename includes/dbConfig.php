<?php
    $hostname = "containers-us-west-39.railway.app";
    $username = "root";
    $password = "uFMAJH8gJeM2BdoffXCL";
    $dbname = "railway";
    $port = "7845";

    $conn = mysqli_connect($hostname, $username, $password, $dbname, $port);
    // $link = mysqli_connect("awseb-e-wekpd7ppkx-stack-awsebrdsdatabase-docmvdrwmlb2.cmgwtbm1ff9j.us-east-1.rds.amazonaws.com","catherine","password1","uts");
    if (!$conn)
        die("Could not connect to Server");
?>