<?php
include 'config/db.php';
include "includes/header.php";

// Fetch product statistics
// Total Products
// Get total count of products for stats
$totalProducts = $conn->query("SELECT COUNT(*) as total FROM products");
$totalProducts = $totalProducts->fetch_assoc()['total'];

// In Stock Products
// Get count of products with quantity greater than 0 for in-stock stats
$inStock = $conn->query("SELECT COUNT(*) as total FROM products WHERE quantity > 0");
$inStock = $inStock->fetch_assoc()['total'];

// Low Stock Products
// Get count of products with quantity less than or equal to 5 for low-stock stats
$lowStock = $conn->query("SELECT COUNT(*) as total FROM products WHERE quantity <= 5");
$lowStock = $lowStock->fetch_assoc()['total'];

// Get search term from query parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination settings
$limit = 10; // Number of products per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $limit; // Calculate offset for LIMIT clause

// Total products count for pagination
$count = $conn->query("SELECT COUNT(*) as total FROM products"); // Get total count of products for pagination
$total = $count->fetch_assoc()['total']; // Fetch total count from query result
$totalPages = ceil($total / $limit); // Calculate total pages based on total products and limit per page

// Use prepared statement to prevent SQL injection and handle search term, limit, and offset
$sql = "SELECT * FROM products WHERE name LIKE ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

$searchTerm = "%$search%"; // Add wildcards for partial matching in search
$stmt->bind_param("sii", $searchTerm, $limit, $offset);
$stmt->execute();
$allproducts = $stmt->get_result();

?>

<div class="products-app">

    <!-- HEADER -->
    <div class="products-header">
        <div>
            <h1>Products</h1>
            <p>Manage your inventory efficiently</p>
        </div>
        <div class="products-actions">
            <!-- Search Products by Name -->
            <form method="GET">
                <div class="products-search">
                    <i class="bi bi-search"></i>
                    <input type="text" name="search" placeholder="Search product..."
                        value="<?php echo htmlspecialchars($search); ?>">
                </div>
            </form>

            <!-- Add Product Button -->
            <a href="add_product.php" class="products-btn primary">
                <i class="bi bi-plus-lg"></i> Add Product
            </a>

            <!-- Export Data Into CSV Button -->
            <a href="export.php" class="products-btn">
                <i class="bi bi-download"></i> Export
            </a>

            <!-- Import Data From CSV Button -->
            <form method="POST" action="import.php" enctype="multipart/form-data">
                <label class="products-btn">
                    <i class="bi bi-upload"></i> Import
                    <input type="file" name="file" hidden accept=".csv">
                </label>
                <button type="submit" name="import" hidden id="importSubmit"></button>
            </form>
        </div>
    </div>

    <!-- STATS -->
    <div class="products-stats">
        <!-- // Total Products -->
        <div class="products-stat-card">
            <div class="products-stat-label">Total Products</div>
            <div class="products-stat-val"><?php echo $totalProducts; ?></div>
            <div class="products-stat-sub"><span class="products-dot info"></span>Across 6 categories</div>
        </div>
        <!-- // In Stock Products -->
        <div class="products-stat-card">
            <div class="products-stat-label">In Stock</div>
            <div class="products-stat-val"><?php echo $inStock; ?></div>
            <div class="products-stat-sub"><span class="products-dot green"></span>79% availability</div>
        </div>
        <!-- // Low Stock Products -->
        <div class="products-stat-card">
            <div class="products-stat-label">Low Stock</div>
            <div class="products-stat-val"><?php echo $lowStock; ?></div>
            <div class="products-stat-sub"><span class="products-dot warn"></span>Need restocking</div>
        </div>
    </div>

    <!-- TABLE CARD -->
    <div class="products-card">
        <table class="products-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Products list -->
                <?php foreach ($allproducts as $product) { ?>
                <tr>
                    <!-- Product ID -->
                    <td>
                        <span class="products-id">
                            <?php echo $product['id']; ?>
                        </span>
                    </td>
                    <!-- Product Image -->
                    <td>
                        <img src="uploads/<?php echo $product['product_image']; ?>"
                            alt="<?php echo $product['name']; ?>">
                    </td>
                    <!-- Product Name -->
                    <td>
                        <span class="products-name">
                            <?php echo $product['name']; ?>
                        </span>
                    </td>
                    <!-- Product Price -->
                    <!-- Format price with commas for thousands and prefix with currency symbol -->
                    <td>
                        <span class="products-price">
                            Rs. <?php echo number_format($product['price']); ?>
                            <span>PKR</span>
                        </span>
                    </td>
                    <!-- Product Quantity -->
                    <td>
                        <span class="products-quantity">
                            <?php echo $product['quantity']; ?>
                        </span>
                    </td>
                    <!-- Actions Buttons -->
                    <td>
                        <div class="products-row-actions">
                            <!-- Product Edit Button -->
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="products-act">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>
                            <!-- Product Delete Button -->
                            <!-- Show confirmation dialog before deleting to prevent accidental deletions -->
                            <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="products-act del"
                                onclick="return confirm('Are you sure you want to delete this product?')">
                                <i class="bi bi-trash"></i>
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>

    <!-- Products pagination -->
    <div class="products-pagination">

        <!-- Current records info -->
        <span class="products-pag-info">
            Showing <?php echo $offset + 1; ?> -
            <?php echo min($offset + $limit, $total); ?>
            of <?php echo $total; ?> products
        </span>

        <!-- Page navigation -->
        <div class="products-pag-btns">

            <!-- Show previous page button only if not on the first page to prevent showing a disabled button when there are no previous pages available -->
            <?php if ($page > 1) { ?>
            <a href="?page=<?php echo $page - 1; ?>">‹</a>
            <?php } ?>

            <!-- Highlight current page number with 'active' class for better user experience and navigation clarity -->
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
            <?php } ?>

            <!-- Show next page button only if there are more pages available to navigate to prevent showing a disabled button when on the last page -->
            <?php if ($page < $totalPages) { ?>
            <a href="?page=<?php echo $page + 1; ?>">›</a>
            <?php } ?>

        </div>
    </div>

</div>

<?php include "includes/footer.php" ?>