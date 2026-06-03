<?php

include 'config/db.php';

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=products.csv");

$output = fopen("php://output", "w");

fputcsv($output, [ "Name", "IMAGE", "PRICE", "QUANTITY"]);

$result = $conn->query("SELECT * FROM products");

while($row = $result->fetch_assoc())
{
    fputcsv($output, [
        $row['name'],
        $row['product_image'],
        $row['price'],
        $row['quantity']
    ]);
}

fclose($output);