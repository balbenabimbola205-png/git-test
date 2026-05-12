-- Database schema for hotel management system

CREATE DATABASE IF NOT EXISTS hotel_management;
USE hotel_management;

-- Table for rooms
CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    room_number VARCHAR(10) NOT NULL UNIQUE,
    room_type VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    status ENUM('available', 'occupied', 'maintenance') DEFAULT 'available',
    image_path VARCHAR(255),
    description TEXT
);

-- Table for guests
CREATE TABLE guests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    phone VARCHAR(20),
    address TEXT
);

-- Table for bookings
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    status ENUM('confirmed', 'checked_in', 'checked_out', 'cancelled') DEFAULT 'confirmed',
    total_amount DECIMAL(10,2),
    FOREIGN KEY (guest_id) REFERENCES guests(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- Table for payments
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE NOT NULL,
    payment_method VARCHAR(50),
    FOREIGN KEY (booking_id) REFERENCES bookings(id)
);

-- Table for users (admin, receptionist, guest)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'receptionist', 'guest') DEFAULT 'guest',
    guest_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (guest_id) REFERENCES guests(id)
);

-- Insert sample data
INSERT INTO rooms (room_number, room_type, price, status) VALUES
('101', 'Single', 50.00, 'available'),
('102', 'Double', 80.00, 'available'),
('201', 'Suite', 150.00, 'available');

INSERT INTO guests (name, email, phone, address) VALUES
('John Doe', 'john@example.com', '1234567890', '123 Main St'),
('Jane Smith', 'jane@example.com', '0987654321', '456 Elm St');

-- Insert admin user (password: admin123)
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@hotel.com', '$2y$10$xrUbdPc1v3VzQPLZlnOFuu0N1hGe7jXJxGXvFk/jR6Zr0A5nQaLQu', 'admin');

-- Insert receptionist user (password: receptionist123)
INSERT INTO users (username, email, password, role) VALUES
('receptionist', 'receptionist@hotel.com', '$2y$10$xrUbdPc1v3VzQPLZlnOFuu0N1hGe7jXJxGXvFk/jR6Zr0A5nQaLQu', 'receptionist');

-- Insert guest users (password: guest123)
INSERT INTO users (username, email, password, role, guest_id) VALUES
('guest1', 'guest1@hotel.com', '$2y$10$xrUbdPc1v3VzQPLZlnOFuu0N1hGe7jXJxGXvFk/jR6Zr0A5nQaLQu', 'guest', 1),
('guest2', 'guest2@hotel.com', '$2y$10$xrUbdPc1v3VzQPLZlnOFuu0N1hGe7jXJxGXvFk/jR6Zr0A5nQaLQu', 'guest', 2);