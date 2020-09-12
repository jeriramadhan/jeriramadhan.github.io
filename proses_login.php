<?php
session_start();
	include 'koneksi.php';
	
	function antiinjection($data)
	{
 	$filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)))); 
	return $filter_sql;
 
	}

    $link=koneksidb();
	$username = antiinjection($_POST['username']); 	
	$password = antiinjection($_POST['password']);
	
	 

	
	$data_user = mysql_query("SELECT * FROM user WHERE username = '$username' and password ='$password'");
	$query 	  = mysql_fetch_array($data_user);	
	
		if($query >0)
		{
			
			$_SESSION['username'] = $query['username'];
			$_SESSION['jabatan'] = $query['jabatan'];
			$_SESSION['nama_user'] = $query['nama_user'];
			
			if ($query['jabatan']=="Manajer")
			{
				header("Location: manajer/index.php");
				// echo "<script>alert('Berhasil login!'); window.location.href = 'manajer/index.php';</script>";
			}
			else if ($query['jabatan']=="Pelaksana")
			{
				echo "<script>alert('Berhasil login!'); window.location.href = 'pelaksana/index.php';</script>";
			}
		}
		else 
		{   	
			echo "<script>alert('Username atau password tidak sesuai!'); window.location.href = 'index.php';</script>";		
			//header("location:index.php");
		}	

?>