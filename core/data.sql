CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Create Product Categories Table
CREATE TABLE product_categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

-- Create Products Table
CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    category_id INT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES product_categories(category_id)
);