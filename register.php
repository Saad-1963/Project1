



<?php
require_once 'passwordLib.php';

// Establishing connection to the database
$conn = new mysqli("feenix-mariadb.swin.edu.au", "s104746418","030300", "s104746418_db")
Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $customer_name = $_POST["customer_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $phone_number = $_POST["phone_number"];

    // Check if all inputs are provided
    if (empty($customer_name) || empty($email) || empty($password) || empty($confirm_password) || empty($phone_number)) {
        $error_message = "All fields are required. Please fill them out.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match. Please re-enter your password.";
    } else {
        // Check if the email address is unique
        $sql = "SELECT * FROM customer WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $error_message = "Email address already exists. Please choose another one.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new customer data into the database
            $insert_sql = "INSERT INTO customer (customer_name, email, password, phone_number) 
                           VALUES ('$customer_name', '$email', '$hashed_password', '$phone_number')";
            
            if (mysqli_query($conn, $insert_sql)) {
                // Registration successful, redirect to booking page
                header("Location: booking.php?email=$email");
                exit();
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>

<style>
.center {
  text-align: center;
}
.right {

  text-align: right;
}
.left {
  position: absolute;

  text-align: left;
}

.div_width {
  width: 300px;
}
</style>




</head>
<body>
    <h2>Register to CabsOnline</h2>
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <form method="post" action="">

        <div class= "div_width">
         <div class= "left">
        <label>Name:</label><br><br>
        <label>Email:</label><br><br>
        <label>Password:</label><br><br>
        <label>Confirm Password:</label><br><br>
        <label>Phone Number:</label><br><br>
        <br>
        <br>
        </div>

        <div class= "right">

        <input type="text" name="customer_name" required><br><br>

        <input type="email" name="email" required><br><br>
        <input type="password" name="password" required><br><br>
        <input type="password" name="confirm_password" required><br><br>
        <input type="text" name="phone_number" required><br><br>
        </div>
    <input type="submit" value="Register">
    </div>
    </form>
        <h3>Already Registered?  <a href="login.php">Login Here</a></h3>


</body>
</html>
