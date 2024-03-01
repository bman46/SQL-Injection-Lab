<?php
$servername = getenv("SQL_SERVER");
$username = getenv("SQL_USERNAME");
$password = getenv("SQL_PASSWORD");
$dbname = getenv("SQL_DB");

$usr = $_POST["username"];
$pwd = $_POST["password"];

// make the page look nice
include('top.html');


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/* BAD SQL QUERY */
$sql = "SELECT id, password FROM users WHERE username = '$usr'";
$result = $conn->query($sql);

/* GOOD SQL Query */
/*
$sql = "SELECT id, password FROM users WHERE username = ?";
$sth = $conn->prepare($sql);
$sth->bind_param('s', $usr);
$sth->execute();
$result = $sth->get_result();
 */


$flag = False;
if ($result != null && $result->num_rows != 0) {
	while ($row = $result->fetch_assoc()) {
		if (password_verify($pwd, $row['password'])) {
			$flag = $row['id'];
		}
	}
	if (!$flag) {
		echo("<p>Incorrect password!</p>");
	}
} else {
	echo("<p>No user found!</p>");
}

if ($flag) {
	echo "<h2>You are now logged in!</h2> ";

	// output user info
	$sql = "SELECT username, password, name, phone, address, age FROM users WHERE id='$flag'";
	//echo($sql);
	$result = $conn->query($sql);
	while ($row = $result->fetch_assoc()) {
		echo("Your username / password / full name / age / phone / address / are: <b>". $row["username"]. " / " . $row["password"]. " / " . $row["name"]. " / " . $row["age"]. " / " . $row["phone"]. " / " . $row["address"]. "</b><br>");
	}
} else {
	echo "<h2>WARNING: You are not permitted to access this page! Please login <a href='login.html'>here</a>! </h2> ";
}

$conn->close();

// make the page look nice
include('bottom.html');

?>
