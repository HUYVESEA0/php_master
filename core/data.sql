CREATE TABLE users (
    id CHAR(6) PRIMARY KEY DEFAULT (LEFT(UUID(), 6)),
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Modify existing users table to add role
ALTER TABLE users 
ADD COLUMN role ENUM('admin', 'user', 'non-user') NOT NULL DEFAULT 'non-user';

-- Add index for role column for better query performance
CREATE INDEX idx_user_role ON users(role);

-- Update any existing users to have default role
UPDATE users SET role = 'non-user' WHERE role IS NULL;

-- Create table for product categories
CREATE TABLE product_categories (
    id CHAR(6) NOT NULL PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Create table for products
CREATE TABLE products (
    id CHAR(6) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id CHAR(6),
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    quantity INT NOT NULL,
    FOREIGN KEY (category_id) REFERENCES product_categories(id)
);

-- Add image column to products table
ALTER TABLE products ADD COLUMN image VARCHAR(255);

-- Create table for product imports
CREATE TABLE product_imports (
    id CHAR(6) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category_id CHAR(6),
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES product_categories(id)
);

-- Create table for customer types
CREATE TABLE customer_types (
    id CHAR(6) PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Create table for customers
CREATE TABLE customers (
    id CHAR(6) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address VARCHAR(255),
    type_id CHAR(6),
    FOREIGN KEY (type_id) REFERENCES customer_types(id)
);

-- Create table for payments
CREATE TABLE payments (
    id CHAR(6) PRIMARY KEY,
    customer_id CHAR(6),
    amount DECIMAL(10, 2) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

-- Create table for cart
CREATE TABLE cart (
    id CHAR(6) PRIMARY KEY,
    user_id CHAR(6),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create table for cart items
CREATE TABLE cart_items (
    id CHAR(6) PRIMARY KEY,
    cart_id CHAR(6),
    product_id CHAR(6),
    quantity INT NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES cart(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
