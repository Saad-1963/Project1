
<?php
// Include your database connection code here

// Function to generate a unique booking reference number (you may implement this differently)
function generateBookingReference() {
    return uniqid(); // Example: Generate a unique ID as a reference number
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $passenger_name = $_POST["passenger_name"];
    $passenger_phone = $_POST["passenger_phone"];
    $pickup_unit_number = $_POST["pickup_unit_number"];
    $pickup_street_number = $_POST["pickup_street_number"];
    $pickup_street_name = $_POST["pickup_street_name"];
    $pickup_suburb = $_POST["pickup_suburb"];
    $destination_suburb = $_POST["destination_suburb"];
    $pickup_datetime = $_POST["pickup_datetime"];
    $booking_reference_number = generateBookingReference(); // Define this function

    // Retrieve customer's email from the session
    $customer_email = $_GET['email'];
    
    // Check if pick-up date/time is at least 40 minutes in the future
    $current_datetime = new DateTime();
    $pickup_datetime_obj = new DateTime($pickup_datetime);
    $interval = $current_datetime->diff($pickup_datetime_obj);
    
    if ($interval->format('%R%i') <= 40) {

        echo "Pick-up date/time must be at least 40 minutes in the future.";
    } else {
       
        // Insert booking data into the database
        // Generate a unique booking reference number (you can use an auto-incremented column)
   	$conn = new mysqli("feenix-mariadb.swin.edu.au", "s104746418","030300", "s104746418_db")
	Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";

        $sql = "INSERT INTO booking (reference_number, customer_email, passenger_name, passenger_phone, pickup_unit_number, pickup_street_number, pickup_street_name, pickup_suburb, destination_suburb, pickup_datetime)
                VALUES ('$booking_reference_number', '$customer_email', '$passenger_name', '$passenger_phone', '$pickup_unit_number', '$pickup_street_number', '$pickup_street_name', '$pickup_suburb', '$destination_suburb', '$pickup_datetime')";
        
        if (mysqli_query($conn, $sql)) {
            echo "Booking request submitted successfully!\n Thanks for booking with CabsOnline! Your booking reference number is $booking_reference_number. We will pick up the passengers in front of your provided address at $pickup_datetime  ";

            $to = $customer_email;
             $subject = "Your booking request with CabsOnline!";
            $message = "Dear $passenger_name, Thanks for booking with CabsOnline! Your booking reference number is $booking_reference_number. We will pick up the passengers in front of your provided address at $pickup_datetime on .";
             $headers = "From: booking@cabsonline.com.au\r\n";

            // Set the envelope sender for bounce messages
            $additional_parameters = "-r saad_zaheen@gmail.com";

             if (mail($to, $subject, $message, $headers)) {
                 echo "Booking request submitted successfully! Confirmation email sent.";
             } else {
                 echo "Error sending confirmation email.";
             }


        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>






<!DOCTYPE html>
<html>

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
  width: 340px;
}
</style>

<head>
    <title>Booking Request</title>
</head>
<body>
    <h2>Booking a Cab</h2>
    <form method="post" action="">

        <div class= "div_width">
         <div class= "left">

         <label>Passenger Name:</label><br><br>

        <label>Contact Phone:</label><br><br>
        <label>Pick-up Address:</label><br>
        <label>Unit Number:</label><br><br>
        <label>Street Number:</label><br><br>
        <label>Street Name:</label><br><br>
        <label>Suburb:</label><br><br>
        <label>Destination Suburb:</label><br><br>
        <label>Pick-up Date/Time:</label><br><br>
        </div>

        <div class= "right">
        <input type="text" name="passenger_name" required><br><br>
        <input type="text" name="passenger_phone" required><br><br><br>
        <input type="text" name="pickup_unit_number"><br><br>

        <input type="text" name="pickup_street_number" required><br><br>

        <input type="text" name="pickup_street_name" required><br><br>

        <input type="text" name="pickup_suburb" required><br><br>

        <input type="text" name="destination_suburb" required><br><br>

        <input type="datetime-local" name="pickup_datetime" required><br><br>
        </div>
    <input type="submit" value="Submit Booking">
    </div>







    </form>
</body>
</html>
