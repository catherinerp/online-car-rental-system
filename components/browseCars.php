<?php
    $filename = 'assets/cars.json';
    $data = file_get_contents($filename);
    $decoded_json = json_decode($data, true);
   
    echo '<div class="car-grid">';
    $i = 0;
    foreach ($decoded_json as $car) {
        if ($i % 3 == 0) {
            echo '<div class="car-row">';
        }
        echo '<div class="car">';
        echo "<b>" . $car['Name'] . "</b><br>";
        echo "$" . $car['Price_per_day'] . "/day<br>";
        echo "<img src='assets/images/car_images/" . $car['Image'] . "' alt='Image of ". $car['Name'] ."'style='height: 200px'></img><br><br>";
        echo '</div>';

        $i++;
        if ($i % 3 == 0) {
            echo '</div>';
        }
    }
    if ($i % 3 != 0) {
        echo '</div>';
    }
    echo '</div>';
?>    