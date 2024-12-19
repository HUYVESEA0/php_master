
<form id="addProductForm" enctype="multipart/form-data">
    <label for="productName">Tên Sản Phẩm:</label>
    <input type="text" id="productName" name="productName" required><br>

    <label for="categoryId">Danh Mục:</label>
    <select id="categoryId" name="categoryId" required>
        <!-- Options sẽ được tải động từ cơ sở dữ liệu -->
    </select><br>

    <label for="price">Giá:</label>
    <input type="number" id="price" name="price" required><br>

    <label for="description">Mô Tả:</label>
    <textarea id="description" name="description"></textarea><br>

    <label for="images">Hình Ảnh:</label>
    <input type="file" id="images" name="images[]" multiple required><br>

    <label for="quantity">Số Lượng:</label>
    <input type="number" id="quantity" name="quantity" required><br>

    <button type="submit">Thêm</button>
</form>
<div id="message"></div>