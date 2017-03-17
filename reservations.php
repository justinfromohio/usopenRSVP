<?php 	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	if ($_SERVER['REQUEST_METHOD'] =='GET')
	{
		$array = fetchArray('USOPEN');//unserialize(file_get_contents('data/reservations.txt'));
		echo json_encode($array);
		//echo("hello");
	
	}
	else if( $_SERVER['REQUEST_METHOD'] =='POST')
	{
		$day = $_POST['day'];

		$array = fetchArray('USOPEN');//unserialize(file_get_contents('data/reservations.txt'));
		if(array_key_exists ($day,$array))
		{
			$array[$day]--;
			if($array[$day] <=1)
			{
				sendEmail($day);
			}
			if($array[$day] <0)
			{
				$array[$day]=0;
			}
		}
		$from = "m.bender@prenault.com";
		$header = "From: ".$from."\r\n";
		mail("m.bender@prenault.com", "[DEBUG] US Open RSVP", print_r($array,true) . "\n" . print_r($_POST, true), $header);
		updateArray('USOPEN',$array);
	} 
	function getHeaderMap($csvArray)
	{
		$result=array();
		foreach ($csvArray[0] as $key => $value)
		{
			$result[$value] = $key;
		}
		return $result;
	}
	
	function mail_attachment($to, $subject, $message, $from, $file) 
	{
		// $file should include path and filename
		$filename = basename($file);
		$file_size = filesize($file);
		$content = chunk_split(base64_encode(file_get_contents($file))); 
		$uid = md5(uniqid(time()));
		$from = str_replace(array("\r", "\n"), '', $from); // to prevent email injection
		$header = "From: ".$from."\r\n"
		  ."MIME-Version: 1.0\r\n"
		  ."Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n"
		  ."This is a multi-part message in MIME format.\r\n" 
		  ."--".$uid."\r\n"
		  ."Content-type:text/plain; charset=iso-8859-1\r\n"
		  ."Content-Transfer-Encoding: 7bit\r\n\r\n"
		  .$message."\r\n\r\n"
		  ."--".$uid."\r\n"
		  ."Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"
		  ."Content-Transfer-Encoding: base64\r\n"
		  ."Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n"
		  .$content."\r\n\r\n"
		  ."--".$uid."--"; 
		return mail($to, $subject, "", $header);
	}
	function sendEmail($day)
	{
		
		$prettyDates = array("Monday"=>"Monday, June 13","Tuesday"=>"Tuesday,June 14",
			"Wednesday"=>"Wednesday, June 15","Thursday"=>"Thursday, June 16",
			"Friday"=>"Friday, June 17","Saturday"=>"Saturday, June 18","Sunday"=>"Sunday, June 19");
		$to      = 'Molly.Ruff@expedient.com';
		$subject = 'US Open Reservations';
		$message = 'Hey,' . "\r\n";
		$message .='It looks like reservations for '.$prettyDates[$day]." are nearly full.". "\r\n";
		$message .='Please confirm this information is correct or adjust availability as appropriate.'."\r\n";
		$message .='-US Open RSVP Form'."\r\n";
		$headers = "MIME-Version: 1.0"."\r\n";
		$headers .= "Content-type: text\html; charset=iso-8859-1" . "\r\n";
		$headers .= 'From: m.bender@prenault.com' . "\r\n" .
			'Reply-To:  m.bender@prenault.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= 'Cc: m.bender@prenault.com' . "\r\n";
		mail($to, $subject, $message, $headers);
		
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
