<?php
/*
$servername = "10.181.42.30";
$username = "expdbusr";
$password = "bQIStxDamR";
$dbname = "expedientcom";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// sql to create table
$sql = "CREATE TABLE US_Open_Reservations (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(255),
data LONGTEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "Table created successfully\n";
} else {
    echo "Error creating table: " . $conn->error;
}

$array = array('Monday'=>10,'Tuesday'=>10,'Wednesday'=>10,'Thursday' =>10,'Friday'=>10,'Saturday'=>10,'Sunday'=>10);

$sql = "INSERT INTO  US_Open_Reservations 
VALUES(
1, 
 'USOPEN','" .serialize($array). "')";

if ($conn->query($sql) === TRUE) {
    echo "Data initialized successfully\n";
} else {
    echo "Error initializing data: " . $conn->error;
}
$conn->close();
*/
/*
$sql = "SELECT id, data, name
		FROM US_Open_Reservations
		WHERE name = 'USOPEN'";
$result = $conn->query($sql);
if($result->num_rows > 0) 
{
    // output data of each row
	$row = $result->fetch_assoc();
	$array = unserialize($row["data"]);
	var_dump($array);
}

$name = 'USOPEN';
$sql = "UPDATE US_Open_Reservations SET data='".serialize($array)."' WHERE name='".$name."'";
$result = $conn->query($sql);



*/


?>
