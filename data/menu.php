<?php
if( $_SERVER['REQUEST_METHOD'] =='POST')
{
	$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	$array = array('Monday'=>$_POST['Monday'],'Tuesday'=>$_POST['Tuesday'],'Wednesday'=>$_POST['Wednesday'],'Thursday' =>$_POST['Thursday'],'Friday'=>$_POST['Friday'],'Saturday'=>$_POST['Saturday'],'Sunday'=>$_POST['Sunday']);
	updateArray('USOPEN',$array);//$success = file_put_contents('reservations.txt',serialize($array));
	//echo $success;
}
	$array = fetchArray('USOPEN');//unserialize(file_get_contents('reservations.txt'));
	if(!empty($array))
	{
		echo'<html>
			<head>
				<link rel="stylesheet" type="text/css" href="menu.css">
				<link rel="stylesheet" type="text/css" href="../css/main.css">
			</head>
			<body class ="striped">
			<div class="center"/><img class="logo" src="logoWhiteSmall.gif"/></div>
			<div class="center"/><h1 class="title" >US Open RSVP\'s</h1></div>
			<form method="POST" class="center">
				<table>
					<tr>
						<th>Date</th><th class="open-slots">Open Slots</th>
					</tr>
					<tr>
						<td>Monday, June 13</td><td><span class="custom-dropdown"><select name="Monday">';
		echoOptions($array["Monday"]);
		echo '</select></span></td>
					</tr>
					<tr>
						<td>Tuesday, June 14</td><td><span class="custom-dropdown"><select name="Tuesday">';
		echoOptions($array["Tuesday"]);
		echo'</select></span></td>
					</tr>
					<tr>
						<td>Wednesday, June 15</td><td><span class="custom-dropdown"><select name="Wednesday">';
		echoOptions($array["Wednesday"]);
		echo '</select></span></td>
					</tr>
					<tr>
						<td>Thursday, June 16</td><td><span class="custom-dropdown"><select name="Thursday">';
		echoOptions($array["Thursday"]);
		echo'</select></span></td>
					</tr>
					<tr>
						<td>Friday, June 17</td><td><span class="custom-dropdown"><select name="Friday">';
		echoOptions($array["Friday"]);				
		echo'</select></span></td>
					</tr>
					<tr>
						<td>Saturday, June 18</td><td><span class="custom-dropdown"><select name="Saturday">';
		echoOptions($array["Saturday"]);
		echo '</select></span></td>
					</tr>
					<tr>
						<td>Sunday, June 19</td><td><span class="custom-dropdown"><select name="Sunday">';
		echoOptions($array["Sunday"]);
		echo'</select></span></td>
					</tr>
				</table>
				<input type="submit" class="submit" value="Update"/>
			</form>
			</body>
		</html>';
	}

 
function echoOptions($selected)
{
	for($i=0;$i<=10;$i++)
	{
		echo '<option value="'.$i.'" ';
		if($i ==$selected) echo 'selected="selected" ';
		echo '>'.$i.'</option>';
	}
}
	function fetchArray($name)
	{
		$servername = "10.181.42.30";
		$username = "expdbusr";
		$password = "bQIStxDamR";
		$dbname = "expedientcom";

		$array =array();
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		$sql = "SELECT id, data, name
		FROM US_Open_Reservations
		WHERE name = '".$name."'";
		$result =$conn->query($sql);
		if($result->num_rows > 0) 
		{
			// output data of each row
			$row = $result->fetch_assoc();
			$array = unserialize($row["data"]);	
		}
		$conn->close();
		return($array);
	}
	function updateArray($name,$array)
	{
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
		
		$sql = "UPDATE US_Open_Reservations SET data='".serialize($array)."' WHERE name='".$name."'";
		$result = $conn->query($sql);
		$conn->close();
	}

?>