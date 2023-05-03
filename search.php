<!-- 
Author: Catherine Pe Benito
Created: 02/04/2023
This contains the search function when there is input in the search bar.
-->
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="../assets/css/categories.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600&display=swap" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/smoothness/jquery-ui.css">
    </head>
<body>

<div class="main-content">
<?php    
    include "dbConfig.php";

if(isset($_GET['query'])) {
    $query = mysqli_real_escape_string($conn, $_GET['query']);
    $filter_make = $_GET['filter_make'];
    $filter_body_type = $_GET['filter_body_type'];
    $filter_fuel_type = $_GET['filter_fuel_type'];
    $sort_price_order = $_GET['sort_price_order'];
    $sort_price_range = $_GET['sort_price_range'];
    $sort_year_order = $_GET['sort_year_order'];
    $sort_mileage = $_GET['sort_mileage'];
    $min_length = 3;

        $query_string = "SELECT * FROM `products`
        WHERE (`product_name` LIKE '%".$query."%')
        AND (`unit_price` >= ".$min_price." AND `unit_price` <= ".$max_price.")
        ORDER BY `unit_price` ".$sort_order;

        $result = mysqli_query($conn, $query_string);

        if ($result) {
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
                $count = 0;
                echo "<h1 style='text-align:center'>Search results for '$query'</h1>";
                echo "<div class='product-container'>\n";
                while ($a_row = mysqli_fetch_row($result)) {
                    if ($count % 4 == 0) {
                            echo "<div class='product-row'>\n";
                        }
                        echo "<div class='product-card'>\n";
                        foreach ($a_row as $key => $field) {
                            if ($key == 1) {
                                echo "<div class='clickable-product'><a href='productView.php?product_id=" . $a_row[0] ."' target='view'><h3>$field</h3>\n";
                            } elseif ($key == 2) {
                                echo "<p class='card-price'>$" . $field . " for ";
                            } elseif ($key == 3) {
                                echo $field . "</p>\n";
                            } elseif ($key == 4) {
                                if ($field > 0) {
                                    echo "<span class='product-stock'><p>In stock</p></span>";
                                } else {
                                    echo "<span class='product-stock'><p>Out of stock</p></span>";
                                }
                            }
                            if ($key == 5) {
                                echo "<div class='product-image'><img src='categories/images/$field' style='max-width:250px'></div></a></div>\n";
                            }
                        }
                        echo "<form action='../addToCart.php' method='post'>";
                        echo "<input type='hidden' name='product_id' value='" . $a_row[0] . "'>";
                        echo "\t<button class='add-cart-btn' type='submit' id='btn' name='addToCart' onclick='reloadPage()'>Add to Cart</button>\n";
                        echo "</form>";
                        echo "</div>\n";
                        $count++;
                        if ($count % 4 == 0) {
                            echo "</div>\n";
                        }
                    }
                if ($count % 4 != 0) {
                    echo "</div>\n";
                }
                echo "</div>\n";
            } else {
                echo "<h1 style='text-align:center'>Sorry! It seems we couldn't find anything with '$query' :(</h1>";
            }
            mysqli_free_result($result);
        } else {
            echo "Query failed: " . mysqli_error($conn);
        }
}
mysqli_close($conn);
?>
</div>
</body>
</html>