# PHP CRUD — Product Management System

A simple, clean, and fully functional product management system built with PHP and MySQL.
Submitted as part of the PHP Home-Based Test.

---

## Test Requirements Checklist

| Requirement                          | Status |
|--------------------------------------|--------|
| Add Product (Create)                 | ✅ Done |
| View All Products (Read)             | ✅ Done |
| Edit Product (Update)                | ✅ Done |
| Delete Product (Delete)              | ✅ Done |
| Search Product by Name               | ✅ Done |
| Pagination (10 products per page)    | ✅ Done |
| Safe DB Connection (MySQLi Prepared Statements) | ✅ Done |
| Input Validation                     | ✅ Done |
| User-Friendly UI                     | ✅ Done |
| Clean Code with Comments             | ✅ Done |
| Export to CSV/Excel                  | ✅ Done |
| Import from CSV/Excel                | ✅ Done |

---

## Features

- Full CRUD — Add, View, Edit, Delete products
- Product image upload with live preview
- Search products by name (partial match with LIKE)
- Pagination — 10 products per page
- Inventory stats — Total Products, In Stock, Low Stock
- Export all products to CSV file
- Import products from CSV file into database
- Input validation on all forms (empty fields, numeric price & quantity)
- SQL injection prevention using MySQLi Prepared Statements
- Inline code comments on every major action

---

## Security Practices

### MySQLi Prepared Statements
Every database query that takes user input uses prepared statements to prevent SQL injection.

**Example — Fetching products with search:**
```php
$sql = "SELECT * FROM products WHERE name LIKE ? LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sii", $searchTerm, $limit, $offset);
$stmt->execute();
```

**Example — Inserting a product:**
```php
$stmt = $conn->prepare("INSERT INTO products (name, product_image, price, quantity) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssdi", $name, $product_image_name, $price, $quantity);
$stmt->execute();
```

**Example — Deleting a product:**
```php
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
```

---

## Input Validation

All forms validate the following before inserting or updating data:

```php
if (empty($name) || empty($price) || empty($quantity)) {
    echo "All fields are required";
} elseif (!is_numeric($price)) {
    echo "Price must be numeric";
} elseif (!is_numeric($quantity)) {
    echo "Quantity must be numeric";
}
```

Image uploads are also validated — only JPG, JPEG, PNG, and WEBP formats are accepted:

```php
$allowed_ext = ["jpg", "jpeg", "png", "webp"];
if (!in_array($product_image_ext, $allowed_ext)) {
    echo "Invalid image format.";
}
```

---

## Tech Stack

| Layer     | Technology                  |
|-----------|-----------------------------|
| Backend   | PHP (procedural)            |
| Database  | MySQL                       |
| Frontend  | HTML, CSS, Bootstrap Icons  |
| Server    | Apache (XAMPP / WAMP)       |

---

## Folder Structure

```
PHP-CRUD-TEST/
├── assets/
│   ├── css/
│   │   ├── home.css
│   │   ├── all_products.css
│   │   └── add_product.css
│   └── js/
│       └── script.js
├── config/
│   └── db.php
├── database/
│   └── products.sql
├── includes/
│   ├── header.php
│   └── footer.php
├── uploads/
├── index.php
├── all_products.php
├── add_product.php
├── edit_product.php
├── delete_product.php
├── export.php
└── import.php
```

---

## Database Schema

**Table: `products`**

| Column          | Type             | Description              |
|-----------------|------------------|--------------------------|
| id              | INT (PK, AI)     | Unique product ID        |
| name            | VARCHAR(255)     | Product name             |
| product_image   | VARCHAR(255)     | Image filename           |
| price           | DECIMAL(10,2)    | Product price in PKR     |
| quantity        | INT              | Stock quantity           |

---

## Pages Overview

| File                 | Purpose                                        |
|----------------------|------------------------------------------------|
| `index.php`          | Homepage / landing page                        |
| `all_products.php`   | Product listing with search and pagination     |
| `add_product.php`    | Form to add a new product with image upload    |
| `edit_product.php`   | Form to edit an existing product               |
| `delete_product.php` | Deletes product record and its uploaded image  |
| `export.php`         | Exports all products to a CSV file             |
| `import.php`         | Imports products from an uploaded CSV file     |

---

## Setup Instructions

1. Copy the project folder into your server root (e.g. `htdocs` for XAMPP)
2. Open **phpMyAdmin** and import `database/products.sql`
3. Open `config/db.php` and set your database credentials:

```php
$conn = new mysqli($servername, $username, $password, $dbname);
```

4. Make sure the `uploads/` folder exists and has write permissions
5. Open browser and visit: `http://localhost/PHP-CRUD-TEST/`

---

## CSV Import Format

The import file must be a `.csv` with the following columns (header row required):

```
name,product_image,price,quantity
Samsung TV,samsung.jpg,45000,10
iPhone 15,iphone.jpg,150000,5
```

---

## Notes

- Allowed image formats: JPG, JPEG, PNG, WEBP
- Images are stored in the `uploads/` directory
- When a product is deleted, its image file is also removed from the server using `unlink()`
- Low stock threshold is quantity ≤ 5
- Pagination limit is set to 10 products per page