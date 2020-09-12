<!DOCTYPE html>
<html lang="en">
<head>
	<title>CV. BINTANG UTARA</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(images/bg-01.jpg);">
					<span class="login100-form-title-1">
						Lupa Password?
					</span>
				</div>

				<form class="login100-form validate-form" action="" role="form" method="post">
					<div class="wrap-input100 validate-input m-b-18" data-validate = "email is required">
						<span class="label-input100">Email</span>
						<input class="input100" type="text" name="email" placeholder="Masukan Email Anda">
						<span class="focus-input100"></span>
					</div>

					<div class="flex-sb-m w-full p-b-30">
						<div class="contact100-form-checkbox"></div>
					<div>
							<a href="index.php" class="txt1">
								Kembali Ke Login
							</a>
						</div>
					</div>

					<div class="container-login100-form-btn">
						<button class="login200-form-btn" name="act_resset">Kirim</button>
					</div>
				</form>
			</div>
		</div>	
	</div>
			
		 <div id="kiri">
		 	<div align="center" style="font-family:berlin Sans FB; font-size:50px; font-variant:small-caps;">	
			   <img src="style/dist/img/bu.jpg" width="70px"><font size="+5"> CV. Bintang Utara</font>
			</div>
		 	<img src="style/dist/img/tenaga.jpg" class="tengah" width="640px">
			<font size="+2" style="margin-left:50px">
			   Bintang Utara adalah sebuah perusahaan yang bergerak
			</font>
		   <font size="+2" style="margin-left:50px">
			   di bidang konstruksi.
		       Khususnya bidang pembangunan
		   </font>
		   <font size="+2" style="margin-left:50px">
			   jembatan, rumah layak huni, dan terowongan.
		   </font>
		</div>
	 		
			
		<div style="width:600px; margin:auto">
		 <?PHP 
			$host = 'localhost';
			$database = 'dbbintang';
			$user = 'root';
			$password = '';
			error_reporting(E_ALL ^ E_DEPRECATED);
			$link = mysql_connect($host,$user,$password);
			mysql_select_db($database,$link);
			///////////////////////////////////////////////////////////////////////
			if (isset($_POST['act_resset'])) 
			{
				error_reporting(0);
				date_default_timezone_set("Asia/Jakarta");
				$pass="1A2B4HTjsk5kwhadbwlff"; $panjang='8'; $len=strlen($pass); 
				$start=$len-$panjang; $xx=rand('0',$start); 
				$yy=str_shuffle($pass); 
				$passwordbaru=substr($yy, $xx, $panjang);
				
				$email = trim(strip_tags($_POST['email']));
				$password = mysql_real_escape_string(htmlentities((md5($passwordbaru))));
				
				// mencari alamat email si user
				$query = "SELECT * FROM user WHERE email ='$email'";
				$hasil = mysql_query($query);
				$data  = mysql_fetch_array($hasil);
				$cek = mysql_num_rows($hasil);
				$id_user = strip_tags($data['id_user']);
				$alamatEmail = strip_tags($data['email']);
				$nama = strip_tags($data['nama_user']);
				$username =trim(strip_tags($data['username']));
				if ($cek == 1) 
				{
				
					// title atau subject email
					$title  = "Permintaan Password Baru";
					// isi pesan email disertai password
					$pesan  = "Kami telah meresset ulang password ".$nama." Dan anda dapat login kembali ke web kami \n\n 
					DETAIL AKUN ANDA :\n Nama Penguna : ".$username." \n 
					Kata sandi Anda yang baru adalah: ".$passwordbaru."\n\n 
					\n\n PESAN NO-REPLY";
					// header email berisi alamat pengirim
					$header = "From: www.simbu.web.id>";
					// mengirim email
					$kirimEmail = mail($alamatEmail, $title, $pesan, $header);
					// cek status pengiriman email
					if ($kirimEmail)
					{ 
						// update password baru ke database (jika pengiriman email sukses)
						$query = "UPDATE user SET password='$password' WHERE id_user = '$id_user'";
						$hasil = mysql_query($query);
					
						if ($hasil)
						{ 
						echo'<div class="warning">Kata sandi baru telah direset dan sudah dikirim ke email "'.$alamatEmail.'" Silahkan cek emailnya</div>
						'.$pesan.'<hr>';
						}
						else 
						{
						 echo'<div class="warning">Pengiriman Kata sandi baru ke email gagal</div>';
						}
					}
				}
				else
				{
					echo'<div class="warning">Alamat Email tidak ditemukan</div>';
				}
			}
			
		 ?>
		</div>

		
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>