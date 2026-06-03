<?php

include 'config/db.php';
// Get product ID from query parameters 
$id = $_GET['id'];

// Get image name
$stmt = $conn->prepare("SELECT product_image FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
// Fetch the product to get the image name
$product = $stmt->get_result()->fetch_assoc();

// Delete image
$imagePath = "uploads/" . $product['product_image'];
// Check if file exists before attempting to delete to avoid errors
if(file_exists($imagePath))
{
    unlink($imagePath);
}

// Delete record
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: all_products.php");
exit();