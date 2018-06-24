<?php
	
	
	$conn;
	$conn = ConnectDB();
	function ConnectDB()
	{
	    if (preg_match("/localhost/",$_SERVER["HTTP_HOST"])) {
		    $dbhost = 'projectgn.org:3306';
        } else {
		    $dbhost = 'localhost';
        }
		$dbuname = 'projectg_planning2';
		$dbpass = 'planning2!@#';
		$dbname = 'projectg_p2Test';
		
		$conn = mysqli_connect($dbhost, $dbuname, $dbpass);
		//if(!$conn)
		//die(header('Location:'._FULL_SITE_PATH_.'/404.php'));
		
		mysqli_select_db($conn, $dbname);;//	or die(header('Location:'._FULL_SITE_PATH_.'/404.php'));
		mysqli_query($conn, 'set names UTF8');
		mysqli_query($conn, "SET SESSION time_zone = '+7:00'");

		return $conn;
	}

//เลิกติดต่อฐานข้อมูล
	function CloseDB()
	{
		global $conn;
		mysqli_close($conn);
	}
	
	function nvl($originalVal, $returnWhenNull)
	{
		if (is_null($originalVal))
			return $returnWhenNull;
		else if ($originalVal == "")
			return $returnWhenNull;
		else
			return $originalVal;
	}

?>