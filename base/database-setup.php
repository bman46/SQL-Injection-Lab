<?php
$servername = getenv("SQL_SERVER");
$username = getenv("SQL_USERNAME");
$password = getenv("SQL_PASSWORD");
$dbname = getenv("SQL_DB");

// make the page look nice
include('top.html');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// delete old table if it exists
$sql = "DROP TABLE IF EXISTS `users`;";
$result = $conn->query($sql);
echo "<p>$sql</p><p>$result</p><hr>";

// create new login table
$sql = "
CREATE TABLE `users` (
	id int NOT NULL AUTO_INCREMENT,
	username varchar(255),
	password varchar(255),
	name varchar(255),
	phone varchar(255),
	address varchar(255),
	age int,
	subscribed bool,
	PRIMARY KEY (id)
);";
$result = $conn->query($sql);
echo "<p>$sql</p><p>$result</p><hr>";

// insert dummy user
$password = password_hash("password", PASSWORD_DEFAULT);
$sql = '
INSERT INTO `users` VALUES (
	NULL,
	"JohnSmith@email.com",
	"' . $password. '",
	"John Smith",
	"123-456-0252",
	"555 Maple Street, State College, PA 16801",
	42,
	FALSE
);';
$result = $conn->query($sql);
echo "<p>$sql</p><p>$result</p><hr>";

$password = password_hash("monkey", PASSWORD_DEFAULT);
$sql = '
INSERT INTO `users` VALUES (
	NULL,
	"JaneDoe@email.com",
	"' . $password. '",
	"Jane Doe",
	"123-456-7890",
	"556 Maple Street, State College, PA 16801",
	23,
	FALSE
);';
$result = $conn->query($sql);
echo "<p>$sql</p><p>$result</p><hr>";

$password = password_hash("12345", PASSWORD_DEFAULT);
$sql = '
INSERT INTO `users` VALUES (
	NULL,
	"JimDoe@email.com",
	"' . $password. '",
	"Jim Doe",
	"123-456-7890",
	"556 Maple Street, State College, PA 16801",
	25,
	FALSE
);';
$result = $conn->query($sql);
echo "<p>$sql</p><p>$result</p><hr>";

$conn->close();

// make the page look nice
include('bottom.html');
?>

