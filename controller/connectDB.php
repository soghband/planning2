<?php
	
	
	$conn;
	$conn = ConnectDB();
	function ConnectDB()
	{
		$dbhost = 'projectgn.org:3306';
		$dbuname = 'projectg_planning2';
		$dbpass = 'planning2!@#';
		$dbname = 'projectg_p2Test';
		
		$conn = mysqli_connect($dbhost, $dbuname, $dbpass);
		//if(!$conn)
		//die(header('Location:'._FULL_SITE_PATH_.'/404.php'));
		
		mysqli_select_db($conn, $dbname);;//	or die(header('Location:'._FULL_SITE_PATH_.'/404.php'));
		mysqli_query($conn, 'set names UTF8');
		
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