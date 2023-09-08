
# CabsOnline

CabsOnline is a web-based taxi booking system that allows passengers to book taxi services online. This README file provides an overview of the project, installation instructions, and usage guidelines.
## overview
CabsOnline is a project developed as part of the COS80021 Web Application Development course at Swinburne University of Technology. It consists of four main components: registration, login, booking, and admin functionalities. While this project is a simplified version, it demonstrates the core features of an online taxi booking system.

## Installation

Queries to create tables in database

bash
  
CREATE TABLE customer (
    email VARCHAR(255) PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL
);

CREATE TABLE booking (
    booking_number INT AUTO_INCREMENT PRIMARY KEY,
    reference_number VARCHAR(255),
    customer_email VARCHAR(255),
    passenger_name VARCHAR(255) NOT NULL,
    passenger_phone VARCHAR(20) NOT NULL,
    pickup_unit_number VARCHAR(10),
    pickup_street_number VARCHAR(10) NOT NULL,
    pickup_street_name VARCHAR(255) NOT NULL,
    pickup_suburb VARCHAR(255) NOT NULL,
    destination_suburb VARCHAR(255) NOT NULL,
    pickup_datetime DATETIME NOT NULL,
    booking_datetime DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'unassigned',
    FOREIGN KEY (customer_email) REFERENCES customer(email)
);


## Demo
#### User Registration
Register a new customer account by providing your name, email address, password, and contact phone number.

![App Screenshot](https://github.com/Saad-1963/Project1/blob/main/register%20page.JPG)

#### Login
Log in using your email address and password to access the booking functionality

![App Screenshot](https://github.com/Saad-1963/Project1/blob/main/login%20page.JPG)

#### Cab Booking
After logging in, you can make a taxi booking by providing details such as passenger name, contact phone, pick-up address, destination suburb, and pick-up date/time.
The system will generate a unique booking reference number and display a confirmation message.

![App Screenshot](https://github.com/Saad-1963/Project1/blob/main/booking%20page.JPG)

#### Admin Page
Access the admin page (admin.php) to view unassigned booking requests.
You can also assign taxis to specific booking requests by entering the booking reference number.

![App Screenshot](https://github.com/Saad-1963/Project1/blob/main/admin%20page.JPG)
