<?php
require_once '../config/function/func_product.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $product_name = $_POST['product_name'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $description = $_POST['description'];
        $image_url = '../core/upload/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image_url);
        addProduct($conn, $product_name, $category_id, $price, $stock, $description, $image_url);
    } elseif (isset($_POST['edit_product'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $category_id = $_POST['category_id'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $description = $_POST['description'];
        $image_url = '../core/upload/' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image_url);
        updateProduct($conn, $product_id, $product_name, $category_id, $price, $stock, $description, $image_url);
    } elseif (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];
        deleteProduct($conn, $product_id);
    } elseif (isset($_POST['add_group'])) {
        $group_name = $_POST['group_name'];
        $group_id = addGroup($conn, $group_name);
        $image_url = '../core/upload/' . $group_id . '.jpg';
        move_uploaded_file($_FILES['group_image']['tmp_name'], $image_url);
    }

    // Fetch updated products
    $products_result = getProducts($conn);
    if ($products_result->num_rows > 0) {
        while($row = $products_result->fetch_assoc()) {
            $image_url = '../core/upload/' . $row["product_id"] . '.jpg';
            echo "<tr>
                    <td>" . $row["product_id"]. "</td>
                    <td>" . $row["product_name"]. "</td>
                    <td>" . $row["category_name"]. "</td>
                    <td>" . $row["price"]. "</td>
                    <td>" . $row["stock"]. "</td>
                    <td><img src='" . $image_url . "' alt='" . $row["product_name"]. "' width='100'></td>
                    <td>" . $row["description"]. "</td>
                    <td>
                        <button class='edit-product' data-product='" . json_encode($row) . "'>Edit</button>
                        <button class='delete-product' data-id='" . $row["product_id"] . "'>Delete</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No products found</td></tr>";
    }
    exit;
}

$categories_result = getProductCategories($conn);
$products_result = getProducts($conn);
?>

<h1>Product</h1>
<p><span id="product"></span></p>

<!-- Add Group Form -->
<div class="form-container">
    <h2>Add Group</h2>
    <form id="add-group-form" enctype="multipart/form-data">
        <input type="hidden" name="add_group" value="1">
        <label for="group_name">Group Name:</label>
        <input type="text" id="group_name" name="group_name" required>
        <label for="group_image">Group Image:</label>
        <input type="file" id="group_image" name="group_image" required>
        <button type="submit">Add Group</button>
    </form>
</div>

<!-- Add Product Form -->
<div class="form-container">
    <h2>Add Product</h2>
    <form id="add-product-form" enctype="multipart/form-data">
        <input type="hidden" name="add_product" value="1">
        <label for="product_name">Product Name:</label>
        <input type="text" id="product_name" name="product_name" required>
        <label for="category_id">Category:</label>
        <select id="category_id" name="category_id" required>
            <?php
            if ($categories_result->num_rows > 0) {
                while($row = $categories_result->fetch_assoc()) {
                    echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                }
            }
            ?>
        </select>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required>
        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>
        <button type="submit">Add Product</button>
    </form>
</div>

<!-- Product Information Table -->
<div class="view-table">
    <h2>Product Information</h2>
    <table id="products-table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($products_result->num_rows > 0) {
                while($row = $products_result->fetch_assoc()) {
                    $image_url = '../core/upload/' . $row["product_id"] . '.jpg';
                    echo "<tr>
                            <td>" . $row["product_id"]. "</td>
                            <td>" . $row["product_name"]. "</td>
                            <td>" . $row["category_name"]. "</td>
                            <td>" . $row["price"]. "</td>
                            <td>" . $row["stock"]. "</td>
                            <td><img src='" . $image_url . "' alt='" . $row["product_name"]. "' width='100'></td>
                            <td>" . $row["description"]. "</td>
                            <td>
                                <button class='edit-product' data-product='" . json_encode($row) . "'>Edit</button>
                                <button class='delete-product' data-id='" . $row["product_id"] . "'>Delete</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No products found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Edit Product Form -->
<div class="form-container" id="edit-form-container" style="display:none;">
    <h2>Edit Product</h2>
    <form id="edit-product-form" enctype="multipart/form-data">
        <input type="hidden" name="edit_product" value="1">
        <input type="hidden" id="edit_product_id" name="product_id">
        <label for="edit_product_name">Product Name:</label>
        <input type="text" id="edit_product_name" name="product_name" required>
        <label for="edit_category_id">Category:</label>
        <select id="edit_category_id" name="category_id" required>
            <?php
            if ($categories_result->num_rows > 0) {
                while($row = $categories_result->fetch_assoc()) {
                    echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                }
            }
            ?>
        </select>
        <label for="edit_price">Price:</label>
        <input type="number" id="edit_price" name="price" step="0.01" required>
        <label for="edit_stock">Stock:</label>
        <input type="number" id="edit_stock" name="stock" required>
        <label for="edit_description">Description:</label>
        <textarea id="edit_description" name="description" required></textarea>
        <label for="edit_image">Image:</label>
        <input type="file" id="edit_image" name="image">
        <button type="submit">Update Product</button>
    </form>
</div>

<script type="text/javascript" src="../controller/ajax_product.js"></script>

<?php
$conn->close();
?>