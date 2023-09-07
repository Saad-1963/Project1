<?php
require_once 'passwordLib.php';

// Establishing connection to the database
$conn = new mysqli("feenix-mariadb.swin.edu.au", "s104746418","030300", "s104746418_db")
Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";

// Establishing connection to the database
$conn = new mysqli($host, $user, $pass, $db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user inputs
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if email and password match a customer record in the database
    $sql = "SELECT * FROM customer WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            // Login successful, redirect to booking page
            header("Location: booking.php?email=$email");
            exit();
        } else {
            $error_message = "Incorrect password. Please try again.";
        }
    } else {
        $error_message = "Email address not found. Please register first.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
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
  width: 250px;
}
</style>

    <title>Login</title>
</head>
<body>
    <h1>Login to CabsOnline</h1>
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <form method="post" action="">

    <div class= "div_width">
         <div class= "left">
        <label>Email:</label>
        <br>
        <br>
        <label>Password:</label>

        </div>

        <div class= "right">

        <input type="email" name="email" required><br><br>
        <input type="password" name="password" required><br><br>
        </div>
    <input type="submit" value="Login">
    </div>

    </form>
    <h3>New Member?  <a href="register.php">Register Now</a></h3>

</body>
</html>
