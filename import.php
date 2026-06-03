<?php
include 'config/db.php';

if (isset($_POST['import'])) {
    // Check if file was uploaded without errors
    if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo "<script>alert('File upload failed!'); window.location.href='all_products.php';</script>";
        exit;
    }

    $file = $_FILES['file']['tmp_name'];// Get the temporary file path of the uploaded file to read its contents for importing data into the database

    // Validate file type and readability before processing the import to ensure that only valid CSV files are accepted 
    if (!file_exists($file) || !is_readable($file)) {
        echo "<script>alert('File not readable!'); window.location.href='all_products.php';</script>";
        exit;
    }

    $handle = fopen($file, "r");
    // Check if the file was opened successfully before attempting to read 
    if ($handle === FALSE) {
        echo "<script>alert('Could not open file!'); window.location.href='all_products.php';</script>";
        exit;
    }

    fgetcsv($handle);

    $imported = 0;
    $errors = 0;

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        if (count($data) < 4) {
            $errors++;
            continue;
        }

        $name = trim($data[0]);
        $image = trim($data[1]);
        $price = floatval($data[2]);
        $quantity = intval($data[3]);

        $stmt = $conn->prepare("
            INSERT INTO products (name, product_image, price, quantity)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("ssdi", $name, $image, $price, $quantity);

        if ($stmt->execute()) {
            $imported++;
        } else {
            $errors++;
        }
    }

    fclose($handle);

    echo "<script>
        alert('Import complete! $imported records imported, $errors failed.');
        window.location.href='all_products.php';
    </script>";
}
?>