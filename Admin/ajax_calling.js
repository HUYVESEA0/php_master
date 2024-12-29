$(document).ready(function() {
    // Replace showNotification function
    function showAlert(message, type = 'success') {
        const alertContainer = $('#alertContainer');
        alertContainer.removeClass('alert-success alert-danger alert-warning show')
            .addClass(`alert-${type} show`)
            .css('display', 'block')
            .find('#alertMessage')
            .text(message);

        // Auto hide after 3 seconds
        setTimeout(() => {
            alertContainer.removeClass('show').fadeOut();
        }, 3000);
    }

    var initialPage = new URLSearchParams(window.location.search).get('page') || 'home';
    loadPage(initialPage);

    window.onpopstate = function() {
        var page = new URLSearchParams(window.location.search).get('page');
        if (page) {
            $('#loader').show();
            setTimeout(function() {
                loadPage(page);
            }, 1000);
        } else {
            $('#loader').show();
            setTimeout(function() {
                loadPage('home');
            }, 1000);
        }
    };

    $('.ajax-link').click(function(event) {
        event.preventDefault();
        var page = $(this).data('page');
        $('#loader').show();
        setTimeout(function() {
            loadPage(page);
            history.pushState(null, '', '?page=' + page);
        }, 1000);
    });

    $(document).on('submit', '#addTypeProductForm', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '../Admin/func_ajax.php',
            data: $(this).serialize() + '&action=addCategory',
            dataType: 'json',
            success: function(response) {
                $('#message').text(response.message);
                if (response.success) {
                    $('#addTypeProductForm')[0].reset();
                    setTimeout(function() {
                    location.reload();
                    },500);
                }
            }
        });
    });

    // Product Form HTML Template
    function getProductFormHtml(title = 'Add Product') {
        return `
            <div class="product-form mt-3 mb-3 p-3 border rounded">
                <h4>${title}</h4>
                <form id="productForm">
                    <input type="hidden" id="productId" name="productId">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="categoryId" name="categoryId" required></select>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="saveProduct">Save</button>
                        <button type="button" class="btn btn-secondary" id="cancelForm">Cancel</button>
                    </div>
                </form>
            </div>
        `;
    }

    // Show Add Product Form
    $(document).on('click', '#addProductBtn', function() {
        $('#formContainer').html(getProductFormHtml('Add Product')).slideDown();
        loadCategories();
    });

    // Edit Product Button Click
    $(document).on('click', '.edit-product', function() {
        var id = $(this).data('id');
        $('#formContainer').html(getProductFormHtml('Edit Product')).slideDown();
        loadCategories();
        
        $.ajax({
            type: 'POST',
            url: '../Admin/func_ajax.php',
            data: {action: 'getProduct', id: id},
            dataType: 'json',
            success: function(product) {
                $('#productId').val(product.id);
                $('#name').val(product.name);
                $('#categoryId').val(product.category_id);
                $('#price').val(product.price);
                $('#description').val(product.description);
                $('#quantity').val(product.quantity);
            }
        });
    });

    // Cancel Form Button
    $(document).on('click', '#cancelForm', function() {
        $('#formContainer').slideUp(function() {
            $(this).empty();
        });
    });

    // Update save product handler
    $(document).on('click', '#saveProduct', function() {
        var formData = new FormData($('#productForm')[0]);
        formData.append('action', $('#productId').val() ? 'updateProduct' : 'addProduct');

        $.ajax({
            type: 'POST',
            url: '../Admin/func_ajax.php',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    if (result.success) {
                        showAlert(result.message, 'success');
                        $('#formContainer').slideUp();
                        setTimeout(() => loadPage('product'), 1500);
                    } else {
                        showAlert(result.message, 'danger');
                    }
                } catch (e) {
                    showAlert('An error occurred', 'danger');
                }
            },
            error: function() {
                showAlert('Server error occurred', 'danger');
            }
        });
    });

    // Delete Product
    $(document).on('click', '.delete-product', function() {
        if (confirm('Are you sure you want to delete this product?')) {
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '../Admin/func_ajax.php',
                data: {
                    action: 'deleteProduct',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert(response.message || 'Error deleting product', 'danger');
                    }
                },
                error: function() {
                    showAlert('Server error occurred', 'danger');
                }
            });
        }
    });

    // Show Add Category Form
    $(document).on('click', '#showAddCategoryForm', function() {
        resetCategoryForm();
        $('#formTitle').text('Add New Category');
        $('#submitBtn').text('Add Category');
        $('#categoryFormContainer').slideDown();
    });

    // Reset Category Form
    function resetCategoryForm() {
        $('#categoryId').val('');
        $('#categoryName').val('');
        $('#message').hide();
    }

    // Edit Category
    $(document).on('click', '.edit-category', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        
        $('#formTitle').text('Edit Category');
        $('#categoryId').val(id);
        $('#categoryName').val(name);
        $('#submitBtn').text('Update Category');
        $('#categoryFormContainer').slideDown();
    });

    // Cancel Category Form
    $(document).on('click', '#cancelCategoryForm', function() {
        $('#categoryFormContainer').slideUp();
        resetCategoryForm();
    });

    // Update category form submit handler
    $(document).on('submit', '#addTypeProductForm', function(e) {
        e.preventDefault();
        var id = $('#categoryId').val();
        var action = id ? 'editCategory' : 'addCategory';
        
        $.ajax({
            type: 'POST',
            url: '../Admin/func_ajax.php',
            data: {
                action: action,
                id: id,
                categoryName: $('#categoryName').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showAlert(response.message, 'success');
                    $('#categoryFormContainer').slideUp();
                    resetCategoryForm();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(response.message, 'danger');
                }
            }
        });
    });

    // Update delete category handler
    $(document).on('click', '.delete-category', function() {
        if (confirm('Are you sure you want to delete this category?')) {
            var id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '../Admin/func_ajax.php',
                data: {
                    action: 'deleteCategory',
                    id: id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert(response.message, 'danger');
                    }
                }
            });
        }
    });

    // User Management
    $(document).on('click', '#addUserBtn', function() {
        $('#userId').val('');
        $('#userForm')[0].reset();
        $('#formTitle').text('Add New User');
        $('#password').prop('required', true);
        $('#userFormContainer').slideDown();
    });

    $(document).on('click', '.edit-user', function() {
        const userId = $(this).data('id');
        const username = $(this).closest('tr').find('td:eq(1)').text();
        const email = $(this).closest('tr').find('td:eq(2)').text();
        const role = $(this).closest('tr').find('td:eq(3)').text();

        $('#userId').val(userId);
        $('#username').val(username);
        $('#email').val(email);
        $('#role').val(role.toLowerCase());
        $('#password').prop('required', false);
        $('#formTitle').text('Edit User');
        $('#userFormContainer').slideDown();
    });

    $(document).on('click', '#cancelUserForm', function() {
        const form = document.getElementById('userForm');
        if (form) {
            form.reset();
        }
        $('#userFormContainer').slideUp();
    });

    $(document).on('submit', '#userForm', function(e) {
        e.preventDefault();
        const userId = $('#userId').val();
        const action = userId ? 'updateUser' : 'addUser';

        $.ajax({
            type: 'POST',
            url: '../Admin/func_ajax.php',
            data: $(this).serialize() + '&action=' + action,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showAlert(response.message, 'success');
                    $('#userFormContainer').slideUp();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showAlert(response.message, 'danger');
                }
            }
        });
    });

    $(document).on('click', '.delete-user', function() {
        if (confirm('Are you sure you want to delete this user?')) {
            const userId = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: '../Admin/func_ajax.php',
                data: {
                    action: 'deleteUser',
                    id: userId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        showAlert(response.message, 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showAlert(response.message, 'danger');
                    }
                }
            });
        }
    });
});

function loadPage(page) {
    $.ajax({
        url: '../Admin/Pages/' + page + '.php',
        type: 'POST',
        data: {page: page},
        success: function(data) {
            console.log(data);
            $('#content').html(data);
        },
        complete: function() {
            $('#loader').hide();
        }
    });
}

function loadCategories() {
    $.ajax({
        type: 'POST',
        url: '../Admin/func_ajax.php',
        data: {action: 'getCategories'},
        dataType: 'json',
        success: function(response) {
            var categorySelect = $('#categoryId');
            categorySelect.empty();
            $.each(response, function(index, category) {
                categorySelect.append($('<option>', {
                    value: category.id,
                    text: category.name
                }));
            });
        }
    });
}