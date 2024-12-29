<?php
require_once('../fucn.php');
?>

<div class="container">
    <!-- Add Alert Container -->
    <div id="alertContainer" class="alert alert-dismissible fade" role="alert" style="display: none; margin-top: 20px;">
        <span id="alertMessage"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <h2>Product Categories</h2>
    
    <!-- Add Category Button -->
    <button class="btn btn-success" id="showAddCategoryForm">Add Category</button>
    
    <!-- Category Form (Hidden by default) -->
    <div class="product-form" id="categoryFormContainer" style="display: none;">
        <h4 id="formTitle">Add New Category</h4>
        <form id="addTypeProductForm">
            <input type="hidden" id="categoryId" name="categoryId">
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" class="form-control" id="categoryName" name="categoryName" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="submitBtn">Add Category</button>
                <button type="button" class="btn btn-secondary" id="cancelCategoryForm">Cancel</button>
            </div>
        </form>
        <div id="message" class="alert" style="display: none;"></div>
    </div>

    <?php type_product(); ?>
</div>
