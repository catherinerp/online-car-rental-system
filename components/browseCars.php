<p>
<?php
    $filename = 'assets/cars.json';
    $data = file_get_contents($filename);
    $decoded_json = json_decode($data, true);
   
    foreach ($decoded_json as $car) {
        echo "<b>" . $car['Name'] . "</b><br>";
        echo "$" . $car['Price_per_day'] . "/day<br>";
        echo "<img src='assets/images/car_images/" . $car['Image'] . "' style='height: 200px'></img><br><br>";
    }
?>    
</p>