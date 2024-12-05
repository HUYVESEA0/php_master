$(document).ready(function() {
    // Add Group
    $('#add-group-form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '../Pages/product.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                alert('Group added successfully');
                location.reload(); // Reload the page to update the categories list
            }
        });
    });

    // Add Product
    $('#add-product-form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '../Pages/product.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#products-table tbody').html(response);
                $('#add-product-form')[0].reset();
            }
        });
    });

    // Edit Product
    $('#edit-product-form').submit(function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: '../Pages/product.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#products-table tbody').html(response);
                $('#edit-form-container').hide();
            }
        });
    });

    // Delete Product
    $(document).on('click', '.delete-product', function() {
        var productId = $(this).data('id');
        $.ajax({
            url: '../Pages/product.php',
            type: 'POST',
            data: { delete_product: 1, product_id: productId },
            success: function(response) {
                $('#products-table tbody').html(response);
            }
        });
    });

    // Show Edit Form
    $(document).on('click', '.edit-product', function() {
        var product = $(this).data('product');
        if (product) {
            $('#edit_product_id').val(product.product_id);
            $('#edit_product_name').val(product.product_name);
            $('#edit_category_id').val(product.category_id);
            $('#edit_price').val(product.price);
            $('#edit_stock').val(product.stock);
            $('#edit_description').val(product.description);
            $('#edit-form-container').show();
        } else {
            console.error('Product data not found');
        }
    });
});