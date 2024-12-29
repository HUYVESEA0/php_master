<?php
$conn;
function connect()
{
    $conn = mysqli_connect('localhost', 'huyviesea', 'huyviesea_db', 'data_center');
    if (!$conn) {
        error_log('Database connection failed: ' . mysqli_connect_error());
        die('Không thể kết nối!');
    }
    mysqli_set_charset($conn, 'utf8');
    return $conn;
}

function disconnect($conn)
{
    mysqli_close($conn);
}
//sanphm,nhom
function type_product()
{
    $conn = connect();
    $sql = "SELECT * FROM product_categories";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
    ?>
    <div class="view-table">
        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td>
                            <button class="btn btn-primary edit-category" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['name']; ?>">Edit</button>
                            <button class="btn btn-danger delete-category" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}

function product_view()
{
    $conn = connect();
    $sql = "SELECT p.id, p.name, p.category_id, c.name as category, p.price, p.description, p.image, p.quantity 
            FROM products p 
            JOIN product_categories c ON p.category_id = c.id";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
    ?>
    <div class="view-table">
        <button class="btn btn-success" id="addProductBtn">Add Product</button>
        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td>
                            <?php 
                            if (!empty($row['image'])) {
                                // Fix the image path
                                $imagePath = "/my_proj/Admin/upload/{$row['category_id']}/{$row['id']}/{$row['image']}";
                                if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imagePath)) {
                                    echo "<img src='$imagePath' alt='Product Image' style='width: 50px; height: 50px; object-fit: cover;'>";
                                } else {
                                    echo "Image not found";
                                }
                            } else {
                                echo "No image";
                            }
                            ?>
                        </td>
                        <td><?php echo $row['quantity']; ?></td>
                        <td>
                            <button class="btn btn-primary edit-product" data-id="<?php echo $row['id']; ?>">Edit</button>
                            <button class="btn btn-danger delete-product" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}
function type_customer()
{
    $conn = connect();
    $sql = "SELECT * FROM customer_types";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
    ?>
    <div class="view-table">
        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}

function customer_view()
{
    $conn = connect();
    $sql = "SELECT c.id, c.name, t.name as type, c.email, c.phone 
            FROM customers c 
            JOIN customer_types t ON c.type_id = t.id";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
    ?>
    <div class="view-table">
        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['type']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}

function payment_view()
{
    $conn = connect();
    $sql = "SELECT * FROM payments";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
    ?>
    <div class="view-table">
        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['customer_id']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}

function type_user()
{
    $conn = connect();
    $sql = "SELECT role FROM users";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
}
function user_view()
{
    $conn = connect();
    $sql = "SELECT id, username, email, role FROM users";
    $result = mysqli_query($conn, $sql);
    disconnect($conn);
    ?>
    <div class="view-table">
        <button class="btn btn-success mb-3" id="addUserBtn">Add User</button>
        <table id="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['role']; ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm edit-user" data-id="<?php echo $row['id']; ?>">Edit</button>
                            <button class="btn btn-danger btn-sm delete-user" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php
}

?>