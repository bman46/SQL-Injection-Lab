<?php
$servername = getenv("SQL_SERVER");
$username = getenv("SQL_USERNAME");
$password = getenv("SQL_PASSWORD");
$dbname = getenv("SQL_DB");

$email = $_POST['email'];

// make the page look nice
include('top.html');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// BAD QUERY
$sql = "SELECT id FROM users WHERE username = '$email'";
echo("<p>$sql</p>");
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$id = $row['id'];

	// update the database
	$sql = "UPDATE users SET subscribed = TRUE WHERE id = '$id'";
	$conn->query($sql);
    }
}

echo("<h2>Done!</h2>");
echo("<p>Submitted request for $email</p>");

$conn->close();

// make the page look nice
include('bottom.html');

?>
