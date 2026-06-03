<?php
include 'config/db.php';
include "includes/header.php";

$id = $_GET['id'];

// Fetch the product details
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

// Handle form submission to update product
if (isset($_POST['update_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Check new image selected or not
    if (!empty($_FILES['product_image']['name'])) {
        $image = $_FILES['product_image']['name'];
        $tmp = $_FILES['product_image']['tmp_name'];

        move_uploaded_file($tmp, "uploads/" . $image);

        $stmt = $conn->prepare("
            UPDATE products
            SET name=?, product_image=?, price=?, quantity=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssdii",
            $name,
            $image,
            $price,
            $quantity,
            $id
        );
    } else {
        $stmt = $conn->prepare("
            UPDATE products
            SET name=?, price=?, quantity=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "sdii",
            $name,
            $price,
            $quantity,
            $id
        );
    }

    $stmt->execute();

    header("Location: all_products.php");
    exit();
}
?>

<div class="addprod-app">
    <!-- HEADER -->
    <div class="addprod-header">
        <div>
            <h1>Edit Product</h1>
            <p>Update the details of the product.</p>
        </div>
    </div>

    <!-- Add Product FORM -->
    <form method="POST" enctype="multipart/form-data">
        <div class="addprod-card">

            <!-- Inpuut product name -->
            <div class="addprod-field">
                <label>Product Name <span class="addprod-req">*</span></label>
                <input type="text" name="name" value="<?php echo $product['name'] ?>" required>
            </div>

            <!-- Product image -->
            <div class="addprod-field">
                <label>Image <span class="addprod-req">*</span></label>

                <!-- Current image -->
                <img src="uploads/<?php echo $product['product_image']; ?>" id="addprod-img-preview"
                    class="addprod-img-preview" style="display:block;" alt="Preview">

                <!-- Upload box -->
                <div class="addprod-upload-box" id="addprod-upload-box"
                    onclick="document.getElementById('addprod-img-input').click()">
                    <div class="addprod-upload-icon">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </div>
                    <!-- Change image text and hint -->
                    <div class="addprod-upload-title">
                        Change Image
                    </div>
                    <!-- Image format hint -->
                    <div class="addprod-upload-hint">
                        PNG, JPG , JPEG , WEBP
                    </div>

                </div>
                <input type="file" name="product_image" id="addprod-img-input" accept="image/*" hidden>
            </div>

            <!-- Input price and quantity -->
            <div class="addprod-field-row">

                <!-- Input product price -->
                <div class="addprod-field">
                    <label>Price (PKR) <span class="addprod-req">*</span></label>
                    <input type="number" name="price" value="<?php echo $product['price'] ?>" required>
                </div>
                <!-- Input product quantity -->
                <div class="addprod-field">
                    <label>Quantity <span class="addprod-req">*</span></label>
                    <input type="number" name="quantity" value="<?php echo $product['quantity'] ?>" placeholder="0"
                        min="0" required>
                </div>
            </div>

            <div class="addprod-actions">
                <!-- Back to all products page -->
                <a href="all_products.php" class="addprod-btn">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <!-- Submit form to update product -->
                <button type="submit" name="update_product" class="addprod-btn primary">
                    <i class="bi bi-check-lg"></i> Update Product
                </button>
            </div>

        </div>
    </form>

</div>

<?php include "includes/footer.php" ?>