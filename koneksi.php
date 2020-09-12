<?php
	function koneksidb()
	{ 
		$host = 'localhost';
		$database = 'u8961758_pm';
		$user = 'u8961758_jeri';
		$password = 'jerijeri';
		error_reporting(E_ALL ^ E_DEPRECATED);
		$link = mysql_connect($host,$user,$password);
		mysql_select_db($database,$link);
		if(!$link)
			echo "Koneksi Database Error : ".mysql_error();
		return $link;
	}
?>