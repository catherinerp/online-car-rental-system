<p>
<?php
    $filename = 'assets/cars.json';
    $data = file_get_contents($filename);
    $decoded_json = json_decode($data)[0];
    echo "<b>". $decoded_json->Name ." </b>";
    echo $decoded_json->Model;
    echo $decoded_json->Make;
?>
</p>