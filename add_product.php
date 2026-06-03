<?php

include 'config/db.php';
include "includes/header.php";

// Handle form submission to add new product
if (isset($_POST["add_product"])) {

    // Handle image upload
    $product_image_name = $_FILES["product_image"]["name"]; // Get the original name of the uploaded file to store in database and use for saving the file on server
    $product_image_tmp = $_FILES["product_image"]["tmp_name"]; // Get the temporary file path of the uploaded file to move it to the desired location on server
    $product_image_ext = pathinfo($product_image_name, PATHINFO_EXTENSION); // Extract the file extension from the uploaded file name to validate the file type and ensure only allowed image formats are accepted
    $allowed_ext = ["jpg", "jpeg", "png", "webp"]; // Define an array of allowed image extensions to validate the uploaded file and prevent unauthorized file types from being uploaded to the server

    // Validate image
    // Check if the uploaded file has an allowed image extension before processing
    if (in_array($product_image_ext, $allowed_ext)) {

        move_uploaded_file($product_image_tmp, "uploads/" . $product_image_name); // Move the uploaded file from its temporary location to the "uploads" directory on the server with its original name to save the image and make it accessible for display in the application

        $name = $_POST["name"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];

        // Validate form inputs
        if (empty($name) || empty($price) || empty($quantity)) {
            echo "All fields are required";
        } elseif (!is_numeric($price)) {
            echo "Price must be numeric";
        } elseif (!is_numeric($quantity)) {
            echo "Quantity must be numeric";
        } else {
            //If All validations pass insert product into database
            $stmt = $conn->prepare("INSERT INTO products (name, product_image, price, quantity) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssdi", $name, $product_image_name, $price, $quantity);

            if ($stmt->execute()) {
                // Show success message and redirect to all products page after successful insertion of product into database
                echo "<script>alert('Product Added Successfully');
                        window.location.href='all_products.php';
                      </script>";
            } else {
                echo "Error adding product: " . $stmt->error;
            }
        }
    } else {
        // If the uploaded file does not have an allowed image extension, show an error message to the user indicating that only specific image formats are accepted for upload
        echo "<script>alert('Invalid image format. Only JPG, JPEG, PNG, and WEBP are allowed.');</script>";
    }
}

?>

<div class="addprod-app">
    <!-- HEADER -->
    <div class="addprod-header">
        <div>
            <h1>Add Product</h1>
            <p>Fill in the details to add a new product to your inventory.</p>
        </div>
    </div>

    <!-- Add Product FORM -->
    <form method="POST" enctype="multipart/form-data">
        <div class="addprod-card">
            <!-- Inpuut product name -->
            <div class="addprod-field">
                <label>Product Name <span class="addprod-req">*</span></label>
                <input type="text" name="name" placeholder="e.g. LED Bulb" required>
            </div>

            <!-- Input product image with preview -->
            <div class="addprod-field">
                <label>Image <span class="addprod-req">*</span></label>
                <div class="addprod-upload-box" id="addprod-upload-box"
                    onclick="document.getElementById('addprod-img-input').click()">
                    <div class="addprod-upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                    <div class="addprod-upload-title">Click to upload</div>
                    <div class="addprod-upload-hint">PNG, JPG , JPEG , WEBP</div>
                </div>
                <input type="file" name="product_image" id="addprod-img-input" accept="image/*" hidden>
                <img id="addprod-img-preview" class="addprod-img-preview" alt="Preview">
            </div>

            <!-- Input price and quantity -->
            <div class="addprod-field-row">
                <!-- Input product price -->
                <div class="addprod-field">
                    <label>Price (PKR) <span class="addprod-req">*</span></label>
                    <input type="number" name="price" placeholder="0.00" min="0" step="0.01" required>
                </div>
                <!-- Input product quantity -->
                <div class="addprod-field">
                    <label>Quantity <span class="addprod-req">*</span></label>
                    <input type="number" name="quantity" placeholder="0" min="0" required>
                </div>
            </div>

            <div class="addprod-actions">
                <!-- Back to all products page -->
                <a href="all_products.php" class="addprod-btn">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <!-- Submit form to add product -->
                <button type="submit" name="add_product" class="addprod-btn primary">
                    <i class="bi bi-check-lg"></i> Add Product
                </button>
            </div>
        </div>
    </form>
</div>
<!-- <script src="assests/js/script.js"></script> -->
<?php include "includes/footer.php" ?>