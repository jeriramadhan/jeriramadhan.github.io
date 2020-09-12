<?php
	function koneksidb()
	{ 
		$host = 'localhost';
		$database = 'pm';
		$user = 'root';
		$password = '';
		error_reporting(E_ALL ^ E_DEPRECATED);
		$link = mysql_connect($host,$user,$password);
		mysql_select_db($database,$link);
		if(!$link)
			echo "Koneksi Database Error : ".mysql_error();
		return $link;
	}
?>