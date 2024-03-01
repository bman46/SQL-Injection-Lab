<?php
$servername = getenv("SQL_SERVER");
$username = getenv("SQL_USERNAME");
$password = getenv("SQL_PASSWORD");
$dbname = getenv("SQL_DB");

$user_id = $_GET['id'];

// make the page look nice
include('top.html');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// query for user
$sql = "SELECT username FROM users WHERE id = $user_id";
//echo("<p>$sql</p>");
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo("<p>". $row['username']. "</p>");
    }
} else {
	echo("<h2>Warning!</h2><p>No users found!</p>");
}

$conn->close();

// make the page look nice
include('bottom.html');

?>
