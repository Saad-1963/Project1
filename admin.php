<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Page</h1>
    <form method="post" action="">
        <input type="submit" name="list_all" value="List All">
    </form>

    <!-- Add the form for assigning taxis here -->

    <?php
   $conn = new mysqli("feenix-mariadb.swin.edu.au", "s104746418","030300", "s104746418_db")
	Or die ("<p>Unable to connect to the database server.</p>". "<p>Error code ". mysqli_connect_errno().": ". mysqli_connect_error()). "</p>";

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["list_all"])) {
        // Query the database for unassigned bookings within 3 hours
        $sql = "SELECT b.reference_number, b.booking_number, c.customer_name, b.passenger_name, b.passenger_phone,
                CONCAT_WS(', ', IFNULL(b.pickup_unit_number, ''), b.pickup_street_number, b.pickup_street_name, b.pickup_suburb) AS pickup_address,
                b.destination_suburb, b.pickup_datetime
                FROM booking b
                INNER JOIN customer c ON b.customer_email = c.email
                WHERE b.status = 'unassigned'
                AND b.pickup_datetime BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 3 HOUR)";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Display the list of unassigned booking requests in a table
            echo "<h2>Unassigned Booking Requests</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Booking Ref Number</th><th>Customer Name</th><th>Passenger Name</th><th>Passenger Contact Phone</th><th>Pick-up Address</th><th>Destination Suburb</th><th>Pick-up Date/Time</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["reference_number"] . "</td>";
                echo "<td>" . $row["customer_name"] . "</td>";
                echo "<td>" . $row["passenger_name"] . "</td>";
                echo "<td>" . $row["passenger_phone"] . "</td>";
                echo "<td>" . $row["pickup_address"] . "</td>";
                echo "<td>" . $row["destination_suburb"] . "</td>";
                echo "<td>" . $row["pickup_datetime"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No unassigned booking requests found within 3 hours from now.";
        }
    }
    ?>
<h2>Assign Taxi to Booking Request</h2>
<form method="post" action="">
    <label>Booking Reference Number:</label>
    <input type="text" name="booking_ref_number" required><br><br>
    <input type="submit" name="assign_taxi" value="Assign Taxi">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["assign_taxi"])) {
    // Retrieve the booking reference number from the form
    $booking_ref_number = $_POST["booking_ref_number"];

    // Update the status of the booking request to "assigned"
    $update_sql = "UPDATE booking SET status = 'assigned' WHERE reference_number = '$booking_ref_number' AND status = 'unassigned'";

    if (mysqli_query($conn, $update_sql)) {
        echo "The booking request $booking_ref_number has been properly assigned.";
    } else {
        echo "Error assigning taxi or the booking request is already assigned.";
    }
}
?>
</body>
</html>