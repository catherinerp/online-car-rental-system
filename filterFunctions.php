<?php
// Filter cars by selected make
if (isset($_GET['filter_make'])) {
    $make = $_GET['filter_make'];
    $decoded_json = array_filter($decoded_json, function($car) use($make) {
    return $car['Make'] === $make;
    });
}

// Filter cars by selected body type
if (isset($_GET['filter_body_type'])) {
    $body_type = $_GET['filter_body_type'];
    $decoded_json = array_filter($decoded_json, function($car) use($body_type) {
    return $car['Body_type'] === $body_type;
    });
}

// Filter cars by selected fuel type
if (isset($_GET['filter_fuel_type'])) {
    $fuel_type = $_GET['filter_fuel_type'];
    $decoded_json = array_filter($decoded_json, function($car) use($fuel_type) {
    return $car['Fuel'] === $fuel_type;
    });
}

// Sort cars by price
if (isset($_GET['sort_price_order'])) {
    $price_order = $_GET['sort_price_order'];
    usort($decoded_json, function($a, $b) use($price_order) {
    if ($price_order === 'ascPrice') {
        return $a['Price_per_day'] - $b['Price_per_day'];
    } else {
        return $b['Price_per_day'] - $a['Price_per_day'];
    }
    });
}

// Filter cars by price range
if (isset($_GET['sort_price_range'])) {
    $price_range = $_GET['sort_price_range'];
    $decoded_json = array_filter($decoded_json, function($car) use($price_range) {
    $price = $car['Price_per_day'];
    if ($price_range === 'lowPrice') {
        return $price < 50;
    } else if ($price_range === 'medPrice') {
        return $price >= 50 && $price < 100;
    } else {
        return $price >= 100;
    }
    });
}

// Sort cars by year
if (isset($_GET['sort_year_order'])) {
    $year_order = $_GET['sort_year_order'];
    usort($decoded_json, function($a, $b) use($year_order) {
    if ($year_order === 'ascYear') {
        return $a['Year'] - $b['Year'];
    } else {
        return $b['Year'] - $a['Year'];
    }
    });
}

// Sort cars by mileage
if (isset($_GET['sort_mileage'])) {
    $mileage_order = $_GET['sort_mileage'];
    usort($decoded_json, function($a, $b) use($mileage_order) {
    if ($mileage_order === 'ascMile') {
        return $a['Mileage'] - $b['Mileage'];
    } else {
        return $b['Mileage'] - $a['Mileage'];
    }
    });
}
?>