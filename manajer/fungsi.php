<?php
include "../koneksi.php";
//fungsi page
function redirectPage ($page) {
    $newpage = "<script type='text/javascript'>";
    $newpage .= "window.location.href='$page';";
    $newpage .= "</script>";
    $newpage .= "<noscript>";
    $newpage .= "<meta http-equiv='refresh' content='0;url=$page'/>";
    $newpage .= "</noscript>";
    
    return $newpage;
  }
//end fungsi page
?>

<!--Proses Tambah proyek-->
<?php
if (isset($_GET['proses']))
{
	$proses = $_GET['proses'];
	if ($proses=='tambah_proyek')
	{
		$link=koneksidb();
		$username = $_POST['username'];
		$id_proyek = $_POST['id_proyek'];
		$id_jenis = $_POST['id_jenis'];
		$nama_proyek = $_POST['nama_proyek'];
		$biaya = str_replace(',', '.',str_replace('.', '',$_POST['biaya']));
		$tanggal_mulai = date('Y-m-d',strtotime($_POST['tanggal_mulai']));
		$durasix = $_POST['durasi_proyek'] - 1;
		$jam = $_POST['jam'];
		$durasi_proyek1 = round($durasix/$jam);
		$durasi_proyek = $_POST['durasi_proyek'];
		$tanggal_selesai = date('Y-m-d',strtotime('+'.$durasi_proyek1.'days',strtotime($tanggal_mulai)));
		$pemilik = $_POST['pemilik'];
		$lokasi = $_POST['lokasi'];
		
		
		$arr = explode(' ', $pemilik);
		$singkatan = "";
		foreach($arr as $kata)
		{
			$singkatan .= substr($kata, 0, 1);
		}
		
		$no_proyek = substr($id_proyek,1,3);
		$tahun = substr($id_proyek,-4);
		
		$no_spk = "$no_proyek/CPM/TR.00.01/$singkatan/$tahun";
		
		// $ppn = $biaya * 0.1;
		$nilai_proyek = $biaya;
		$bulat = round($nilai_proyek, -3);
		
		$ratusan = substr($bulat, -4);
		
		if($ratusan < 5000)
		{
			$np = $bulat - $ratusan;
		}
		else 
		{
			$np = $bulat;
		}

		   $input = "INSERT INTO proyek 
		            (id_proyek, username, id_jenis, no_spk, nama_proyek, tanggal_mulai, tanggal_selesai, durasi_proyek, biaya, nilai_proyek, pemilik, lokasi, jam)
					VALUES
				    ('$id_proyek','$username','$id_jenis','$no_spk','$nama_proyek','$tanggal_mulai','$tanggal_selesai',
				    '$durasi_proyek','$biaya','$np','$pemilik','$lokasi','$jam')";
		   
		   $query_input = mysql_query($input);

	   		if ($query_input)
	   		{
	   			$page = "proyek.php?pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "proyek.php?pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);

	}
}	
?>
<!--Akhir proses tambah proyek-->

<!-- proses ubah proyek-->
<?php
if (isset($_GET['proses2']))
{
	$proses2 = $_GET['proses2'];
	if ($proses2=='ubah_proyek')
	{
		$link=koneksidb();
		$id_proyek = $_POST['id_proyek'];
		$id_jenis = $_POST['id_jenis'];
		$nama_proyek = $_POST['nama_proyek'];
		$biaya = str_replace(',', '.',str_replace('.', '',$_POST['biaya']));
		$tanggal_mulai = date('y-m-d',strtotime($_POST['tanggal_mulai']));
		$durasix = $_POST['durasi_proyek'] - 1;
		$jam = $_POST['jam'];
		$durasi_proyek1 = round($durasix/$jam);
		$durasi_proyek = $_POST['durasi_proyek'];
		$tanggal_selesai = date('y-m-d',strtotime('+'.$durasi_proyek1.'days',strtotime($tanggal_mulai)));
		$pemilik = $_POST['pemilik'];
		$lokasi = $_POST['lokasi'];
		
		
		$arr = explode(' ', $pemilik);
		$singkatan = "";
		foreach($arr as $kata)
		{
			$singkatan .= substr($kata, 0, 1);
		}
		
		$no_proyek = substr($id_proyek,1,3);
		$tahun = substr($id_proyek,-4);
		
		$no_spk = "$no_proyek/CPM/TR.00.01/$singkatan/$tahun";
		
		// $ppn = $biaya * 0.1;
		$nilai_proyek = $biaya;
		$bulat = round($nilai_proyek, -3);
		
		$ratusan = substr($bulat, -4);
		
		if($ratusan < 5000)
		{
			$np = $bulat - $ratusan;
		}
		else 
		{
			$np = $bulat;
		}


		$sql=("UPDATE proyek SET no_spk='$no_spk',
								 id_jenis='$id_jenis',
		               		     nama_proyek='$nama_proyek',
								 tanggal_mulai='$tanggal_mulai',
								 tanggal_selesai='$tanggal_selesai',
								 durasi_proyek='$durasi_proyek',
								 biaya='$biaya',
								 nilai_proyek='$np',
								 pemilik='$pemilik',
								 lokasi='$lokasi',
								 jam='$jam'
		                         WHERE id_proyek='$id_proyek'");
								 
	 	$query_edit = mysql_query($sql);

	 	if ($query_edit)
	   		{
	   			$page = "proyek.php?edit=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "proyek.php?edit=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);	
	}
}
?>
<!--akhir ubah proyek-->
<!--proses hapus proyek-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_proyek') 
		{
			$link=koneksidb();
			$id_proyek = $_GET['id_proyek'];
			$sql2= mysql_query("delete from proyek where id_proyek='$id_proyek'")or die(mysql_error());

			$page = "proyek.php?hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses hapus proyek-->

<!--Proses Tambah pekerjaan proyek-->
<?php
if (isset($_GET['proses_tambah_pekerjaan_proyek']))
{
		$link=koneksidb();
		$id_proyek = $_POST['id_proyek'];
		$id_master_sub = $_POST['id_master_sub'];
		
		$biaya = str_replace(',', '.',str_replace('.', '',$_POST['harga_satuan']));
		$volume = str_replace(',', '.',str_replace('.', '',$_POST['volume']));
		
		$sql3 = mysql_query("select biaya from proyek where id_proyek='$id_proyek'");
		$row = mysql_fetch_array($sql3);
		$biaya_total = $row['biaya'];
		
		$sql4 = mysql_query("select kode_sub from master_sub_pekerjaan where id_master_sub='$id_master_sub'");
		$row2 = mysql_fetch_array($sql4);
		$kode = $row2['kode_sub'];
		
		
		
		$jumlah = $biaya * $volume;
		$bobot = ($jumlah / $biaya_total) * 100;
		
		$querynilai = mysql_query("SELECT nilai_proyek FROM proyek where id_proyek = '$id_proyek'");
		$ceknilai = mysql_fetch_array($querynilai);
		$np = $ceknilai['nilai_proyek'];
		
		if ($biaya > $np )
		{
			?>
			<script language ="javascript">
				document.location='pekerjaan_proyek.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal';
			</script>
		  <?php
		}
		else
		{

			$input = "insert into sub_pekerjaan (id_sub,id_proyek,id_master_sub,kode_sub,harga_satuan,volume,bobot,jumlah)
					  values (' ','$id_proyek','$id_master_sub','$kode','$biaya','$volume','$bobot','$jumlah')";
			$query_input = mysql_query($input);
	
			if ($query_input)
			{
				$page = "pekerjaan_proyek.php?id_proyek=$id_proyek&pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "pekerjaan_proyek.php?id_proyek=$id_proyek&pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);
		}
}
?>
<!--Akhir proses tambah pekerjaan proyek-->

<!--proses hapus pekerjaan proyek-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_pp') 
		{
			$link=koneksidb();
			$id_proyek = $_GET['id_proyek'];
			$id_sub = $_GET['id_sub'];
			
			$sql2= mysql_query("delete from sub_pekerjaan where id_sub='$id_sub'")or die(mysql_error());

			$page = "pekerjaan_proyek.php?id_proyek=$id_proyek&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses hapus pekerjaan proyek-->

<!--Proses Tambah upah-->
<?php
if (isset($_GET['proses']))
{
	$proses = $_GET['proses'];
	if ($proses=='tambah_upah')
	{
		$link=koneksidb();
		$id_proyek = $_POST['id_proyek'];
		$kode_tenaga = $_POST['kode_tenaga'];
		$jenis_tenaga = $_POST['jenis_tenaga'];
		$upah = str_replace(',', '.',str_replace('.', '',$_POST['biaya']));
		
		$querynilai = mysql_query("SELECT nilai_proyek FROM proyek where id_proyek = '$id_proyek'");
		$ceknilai = mysql_fetch_array($querynilai);
		$np = $ceknilai['nilai_proyek'];
		
		if ($upah < 1000 || $upah > $np )
		{
			?>
			<script language ="javascript">
				document.location='tenaga.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal';
			</script>
		  <?php
		}
		else
		{
		
		   $input = "INSERT INTO tenaga (id_tenaga,id_proyek,kode_tenaga,jenis_tenaga,upah)
		             VALUES(' ','$id_proyek', '$kode_tenaga', '$jenis_tenaga', '$upah')";
		   
		   $query_input = mysql_query($input);

	   		if ($query_input)
	   		{
	   			$page = "tenaga.php?id_proyek=$id_proyek&pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "tenaga.php?pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);
		}
	}
}	
?>
<!--Akhir proses tambah upah-->

<!-- proses ubah upah-->
<?php
if (isset($_GET['proses2']))
{
	$proses2 = $_GET['proses2'];
	if ($proses2=='ubah_upah')
	{
		$link=koneksidb();
		$id_proyek = $_POST['id_proyek'];
		$id_tenaga = $_POST['id_tenaga'];
		$upah = str_replace(',', '.',str_replace('.', '',$_POST['upah']));
		$jenis_tenaga = $_POST['jenis_tenaga'];
		
		$querynilai = mysql_query("SELECT nilai_proyek FROM proyek where id_proyek = '$id_proyek'");
		$ceknilai = mysql_fetch_array($querynilai);
		$np = $ceknilai['nilai_proyek'];
		
		if ($upah < 1000 || $upah > $np )
		{
			?>
			<script language ="javascript">
				document.location='tenaga.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal';
			</script>
		  <?php
		}
		else
		{

			$sql=("UPDATE tenaga SET jenis_tenaga='$jenis_tenaga',upah = '$upah'
									 WHERE id_tenaga='$id_tenaga'");
									 
			$query_edit = mysql_query($sql);
	
			if ($query_edit)
				{
					$page = "tenaga.php?id_proyek=$id_proyek&edit=sukses";
					echo redirectPage($page);	
				}	
				else
				{
					$page = "tenaga.php?edit=gagal";
					echo redirectPage($page);
				
				}
					mysql_close($open);	
		 }
	}
}
?>
<!--akhir ubah upah-->

<!--proses hapus upah-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_upah') 
		{
			$link=koneksidb();
			$id_proyek = $_GET['id_proyek'];
			$id_tenaga = $_GET['id_tenaga'];
			
			$sql2= mysql_query("delete from tenaga where id_tenaga='$id_tenaga'")or die(mysql_error());

			$page = "tenaga.php?id_proyek=$id_proyek&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses hapus upah-->

<!--Proses Tambah alat-->
<?php
if (isset($_GET['proses']))
{
	$proses = $_GET['proses'];
	if ($proses=='tambah_alat')
	{
		$link=koneksidb();
		$id_proyek = $_POST['id_proyek'];
		$satuan = $_POST['satuan'];
		$nama_bahan = $_POST['nama_bahan'];
		$kode = $_POST['kode'];
		$harga_bahan = str_replace(',', '.',str_replace('.', '',$_POST['biaya']));
		
		$querynilai = mysql_query("SELECT nilai_proyek FROM proyek where id_proyek = '$id_proyek'");
		$ceknilai = mysql_fetch_array($querynilai);
		$np = $ceknilai['nilai_proyek'];
		
		if ($harga_bahan < 100 || $harga_bahan > $np)
		{
			?>
			<script language ="javascript">
				document.location='alat.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal';
			</script>
		  <?php
		}
		else
		{
		
		   $input = "INSERT INTO bahan_material (id_bahan, id_proyek,kode, nama_bahan, harga_bahan, satuan)
		             VALUES(' ','$id_proyek', '$kode', '$nama_bahan', '$harga_bahan', '$satuan')";
		   
		   $query_input = mysql_query($input);

	   		if ($query_input)
	   		{
	   			$page = "alat.php?id_proyek=$id_proyek&pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "alat.php?pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);
		}
	}
}	
?>
<!--Akhir proses tambah alat-->

<!-- proses ubah alat-->
<?php
if (isset($_GET['proses2']))
{
	$proses2 = $_GET['proses2'];
	if ($proses2=='ubah_alat')
	{
		$link=koneksidb();
		$id_alat = $_POST['id_alat'];
		$id_proyek = $_POST['id_proyek'];
		$nama_alat = $_POST['nama_alat'];
		$harga_bahan = str_replace(',', '.',str_replace('.', '',$_POST['biaya']));
		$satuan = $_POST['satuan'];

		$querynilai = mysql_query("SELECT nilai_proyek FROM proyek where id_proyek = '$id_proyek'");
		$ceknilai = mysql_fetch_array($querynilai);
		$np = $ceknilai['nilai_proyek'];
		
		if ($harga_bahan < 100 || $harga_bahan > $np)
		{
			?>
			<script language ="javascript">
				document.location='alat.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal';
			</script>
		  <?php
		}
		else
		{
			$sql=("UPDATE bahan_material SET nama_bahan='$nama_alat',
											 harga_bahan='$harga_bahan',
											 satuan='$satuan'
											 WHERE id_bahan='$id_alat'");
									 
			$query_edit = mysql_query($sql);
	
			if ($query_edit)
				{
					$page = "alat.php?id_proyek=$id_proyek&edit=sukses";
					echo redirectPage($page);	
				}	
				else
				{
					$page = "alat.php?edit=gagal";
					echo redirectPage($page);
				
				}
					mysql_close($open);	
		}
	}
}
?>
<!--akhir ubah alat-->

<!--proses hapus alat-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_alat') 
		{
			$link=koneksidb();
			$id_proyek = $_GET['id_proyek'];
			$id_alat = $_GET['id_alat'];
			
			$sql2= mysql_query("delete from bahan_material where id_bahan='$id_alat'")or die(mysql_error());

			$page = "alat.php?id_proyek=$id_proyek&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses hapus alat-->

<!--Proses Tambah bahan-->
<?php
if (isset($_GET['proses']))
{
	$proses = $_GET['proses'];
	if ($proses=='tambah_bahan')
	{
		$link=koneksidb();
		$id_proyek = $_POST['id_proyek'];
		$satuan = $_POST['satuan'];
		$nama_bahan = $_POST['nama_bahan'];
		$kode = $_POST['kode'];
		$harga_bahan = str_replace(',', '.',str_replace('.', '',$_POST['biaya']));
		
		$querynilai = mysql_query("SELECT nilai_proyek FROM proyek where id_proyek = '$id_proyek'");
		$ceknilai = mysql_fetch_array($querynilai);
		$np = $ceknilai['nilai_proyek'];
		
		if ($harga_bahan < 100 || $harga_bahan > $np)
		{
			?>
			<script language ="javascript">
				document.location='bahan.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal';
			</script>
		  <?php
		}
		else
		{
		   $input = "INSERT INTO bahan_material (id_bahan, id_proyek, satuan, kode, nama_bahan, harga_bahan)
		             VALUES(' ','$id_proyek', '$satuan', '$kode', '$nama_bahan', '$harga_bahan')";
		   
		   $query_input = mysql_query($input);

	   		if ($query_input)
	   		{
	   			$page = "bahan.php?id_proyek=$id_proyek&pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "bahan.php?pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);
		}
	}
}	
?>
<!--Akhir proses tambah bahan-->
<!-- proses ubah bahan-->
<?php
if (isset($_GET['proses2']))
{
	$proses2 = $_GET['proses2'];
	if ($proses2=='ubah_bahan')
	{
		$link=koneksidb();
		$id_bahan = $_POST['id_bahan'];
		$id_proyek = $_POST['id_proyek'];
		$nama_bahan = $_POST['nama_bahan'];
		$harga_bahan = str_replace(',', '.',str_replace('.', '',$_POST['biaya']));
		$satuan = $_POST['satuan'];
		
		$querynilai = mysql_query("SELECT nilai_proyek FROM proyek where id_proyek = '$id_proyek'");
		$ceknilai = mysql_fetch_array($querynilai);
		$np = $ceknilai['nilai_proyek'];
		
		if ($harga_bahan < 100 || $harga_bahan > $np)
		{
			?>
			<script language ="javascript">
				document.location='bahan.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal';
			</script>
		  <?php
		}
		else
		{
			$sql=("UPDATE bahan_material SET nama_bahan='$nama_bahan',
											 harga_bahan='$harga_bahan',
											 satuan='$satuan'
											 WHERE id_bahan='$id_bahan'");
									 
			$query_edit = mysql_query($sql);
	
			if ($query_edit)
				{
					$page = "bahan.php?id_proyek=$id_proyek&edit=sukses";
					echo redirectPage($page);	
				}	
				else
				{
					$page = "bahan.php?edit=gagal";
					echo redirectPage($page);
				
				}
					mysql_close($open);	
		}
	}
}
?>
<!--akhir ubah bahan-->

<!--proses hapus bahan-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_bahan') 
		{
			$link=koneksidb();
			$id_proyek = $_GET['id_proyek'];
			$id_bahan = $_GET['id_bahan'];
			
			$sql2= mysql_query("delete from bahan_material where id_bahan='$id_bahan'")or die(mysql_error());

			$page = "bahan.php?id_proyek=$id_proyek&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses hapus bahan-->


<!--Proses Tambah pekerjaan-->
<?php
if (isset($_GET['proses']))
{
	$proses = $_GET['proses'];
	if ($proses=='tambah_pekerjaan')
	{
		$link=koneksidb();
		$id_jenis = $_POST['id_jenis'];
		$kode_pekerjaan = $_POST['kode_pekerjaan'];
		$nama_pekerjaan = $_POST['nama_pekerjaan'];
			
		   $input = "INSERT INTO pekerjaan (id_pekerjaan, id_jenis, kode_pekerjaan, nama_pekerjaan)
		             VALUES(' ','$id_jenis', '$kode_pekerjaan','$nama_pekerjaan')";
		   
		   $query_input = mysql_query($input);

	   		if ($query_input)
	   		{
	   			$page = "pekerjaan.php?id_jenis=$id_jenis&pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "pekerjaan.php?pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);
	}
}	
?>
<!--Akhir proses tambah pekerjaan-->

<!-- proses ubah pekerjaan-->
<?php
if (isset($_GET['proses2']))
{
	$proses2 = $_GET['proses2'];
	if ($proses2=='ubah_pekerjaan')
	{
		$link=koneksidb();
		$id_pekerjaan = $_POST['id_pekerjaan'];
		$id_jenis = $_POST['id_jenis'];
		$nama_pekerjaan = $_POST['nama_pekerjaan'];

		$sql=("UPDATE pekerjaan SET nama_pekerjaan='$nama_pekerjaan'
								 WHERE id_pekerjaan='$id_pekerjaan'");
								 
	 	$query_edit = mysql_query($sql);

	 	if ($query_edit)
	   		{
	   			$page = "pekerjaan.php?id_jenis=$id_jenis&edit=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "pekerjaan.php?edit=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);	
	}
}
?>
<!--akhir ubah pekerjaan-->

<!--proses hapus pekerjaan-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_pekerjaan') 
		{
			$link=koneksidb();
			$id_jenis = $_GET['id_jenis'];
			$id_pekerjaan = $_GET['id_pekerjaan'];
			
			$sql2= mysql_query("delete from pekerjaan where id_pekerjaan='$id_pekerjaan'")or die(mysql_error());

			$page = "pekerjaan.php?id_jenis=$id_jenis&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses hapus pekerjaan-->

<!--Proses Tambah subpekerjaan-->
<?php
if (isset($_GET['proses_tambah_sub']))
{
		$link=koneksidb();
		$id_jenis = $_POST['id_jenis'];
		$id_pekerjaan = $_POST['id_pekerjaan'];
		$kode_sub = $_POST['kode_sub'];
		$nama_sub = $_POST['nama_sub'];
		
		$sql = mysql_query("SELECT kode_pekerjaan FROM pekerjaan where id_pekerjaan = $id_pekerjaan");
		$r = mysql_fetch_array($sql);
		$cek = $r['kode_pekerjaan'];
		
		if ($cek != 1)
		{
			$satuan = $_POST['satuan'];
			
			$input = "insert into master_sub_pekerjaan (id_pekerjaan,satuan, kode_sub, nama_sub)
				  	  values ('$id_pekerjaan','$satuan','$kode_sub','$nama_sub')";
		}
		else
		{
			$id = "ls";
		
			$input = "insert into master_sub_pekerjaan (id_pekerjaan,satuan, kode_sub, nama_sub)
				  	  values ('$id_pekerjaan','$id','$kode_sub','$nama_sub')";
		}
		
		
		$query_input = mysql_query($input);

		if ($query_input)
		{
			$page = "sub_pekerjaan.php?id_jenis=$id_jenis&id_pekerjaan=$id_pekerjaan&pesan=sukses";
			echo redirectPage($page);	
		}	
		else
		{
			$page = "sub_pekerjaan.php?id_jenis=$id_jenis&id_pekerjaan=$id_pekerjaan&pesan=gagal";
			echo redirectPage($page);
		
		}
			mysql_close($open);

	
}
?><!--Akhir proses tambah subpekerjaan-->

<!-- proses ubah subpekerjaan-->
<?php
if (isset($_GET['proses2']))
{
	$proses2 = $_GET['proses2'];
	if ($proses2=='ubah_sub')
	{
		$link=koneksidb();
		$id_sub = $_POST['id_master_sub'];
		$id_jenis = $_POST['id_jenis'];
		$id_pekerjaan = $_POST['id_pekerjaan'];
		$nama_sub = $_POST['nama_sub'];

		$sql=("UPDATE master_sub_pekerjaan SET nama_sub='$nama_sub'
								           WHERE id_master_sub='$id_sub'");
								 
	 	$query_edit = mysql_query($sql);

	 	if ($query_edit)
	   		{
	   			$page = "sub_pekerjaan.php?id_jenis=$id_jenis&id_pekerjaan=$id_pekerjaan&edit=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "sub_pekerjaan.php?id_jenis=$id_jenis&id_pekerjaan=$id_pekerjaan&edit=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);	
	}
}
?>
<!--akhir ubah subpekerjaan-->

<!--proses hapus subpekerjaan-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_sub') 
		{
			$link=koneksidb();
			$id_jenis = $_GET['id_jenis'];
			$id_pekerjaan = $_GET['id_pekerjaan'];
			$id_sub = $_GET['id_sub'];
			
			$sql2= mysql_query("delete from master_sub_pekerjaan where id_master_sub='$id_sub'")or die(mysql_error());

			$page = "sub_pekerjaan.php?id_jenis=$id_jenis&id_pekerjaan=$id_pekerjaan&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses hapus subpekerjaan-->

<!--tambah detail pekerjaan-->
	<?php
	
	if (isset($_GET['proses_tambah_detail']))
	{
		$link=koneksidb();
		$id_proyek = $_GET['id_proyek'];
		$id_sub = $_POST['id_sub'];
		$id_bahan = $_POST['id_bahan'];
		$kuantitas = $_POST['kuantitas'];
		
		$getbahan = mysql_query("SELECT harga_bahan FROM bahan_material WHERE id_bahan = $id_bahan");
		$hargabahan = mysql_fetch_array($getbahan);
		$harga = $hargabahan['harga_bahan'];
		
		$jumlah = $harga * $kuantitas;
		
		$input ="INSERT into detail_sub (id_sub,id_bahan,kuantitas,jumlah) VALUES ('$id_sub','$id_bahan','$kuantitas','$jumlah')";

		$query_input = mysql_query($input);

		if ($query_input)
	   		{
			  
	 	   		$page = "detail_pekerjaan.php?id_proyek=$id_proyek&id_sub=$id_sub&pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "detail_pekerjaan.php?id_proyek=$id_proyek&id_sub=$id_sub&pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open); 
            
	}
	?>
<!--end Tambah detail pekerjaan-->

<!--tambah detail pekerjaan (tenaga)-->
	<?php
	
	if (isset($_GET['proses_tambah_detail_tenaga']))
	{
		$link=koneksidb();
		$id_proyek = $_GET['id_proyek'];
		$id_sub = $_POST['id_sub'];
		$id_upah = $_POST['id_bahan'];
		$kuantitas = $_POST['kuantitas'];
		
		$getbahan = mysql_query("SELECT upah FROM tenaga WHERE id_tenaga = $id_upah");
		$hargabahan = mysql_fetch_array($getbahan);
		$harga = $hargabahan['upah'];
		
		$jumlah = $harga * $kuantitas;
		
		$input ="INSERT into detail_sub (id_sub,id_tenaga,kuantitas,jumlah) VALUES ('$id_sub','$id_upah','$kuantitas','$jumlah')";

		$query_input = mysql_query($input);

		if ($query_input)
	   		{
			  
	 	   		$page = "detail_pekerjaan.php?id_proyek=$id_proyek&id_sub=$id_sub&pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "detail_pekerjaan.php?id_proyek=$id_proyek&id_sub=$id_sub&pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open); 
            
	}
	?>
<!--end Tambah detail pekerjaan (tenaga)-->


<!--hapus detail pekerjaan-->
<?php
	if (isset($_GET['proses_hapus_detail'])) 
		{
			$proses_hapus_detail=$_GET['proses_hapus_detail'];
			if ($proses_hapus_detail =='hapus_detail') 
			{
				$link=koneksidb();
				$id_proyek=$_GET['id_proyek'];
				$id_sub = $_GET['id_sub'];
				$id_detail = $_GET['id_detail'];
				$sql3= mysql_query("delete from detail_sub where id_detail='$id_detail'")or die(mysql_error());
				
				$page = "detail_pekerjaan.php?id_proyek=$id_proyek&id_sub=$id_sub";
				echo redirectPage($page);
			}
		}	
?>
<!--end hapus detail pekerjaan-->

<!---Tambah Jadwal-->
<?php
if (isset($_GET['proses_tambah_j']))
{
	$proses_tambah_j = $_GET['proses_tambah_j'];
	if ($proses_tambah_j =='tambah_jadwal')
	{
		$link=koneksidb();
		$id_proyek = $_POST['id_proyek'];
		$id_sub=$_POST['id_sub'];
		$tanggal_mulai_j = date('Y-m-d',strtotime($_POST['tanggal_mulai_j']));
		$durasix = $_POST['durasi_kegiatan'] - 1;
		$jam =  $_POST['jam'];
		$durasi_kegiatan = $_POST['durasi_kegiatan'];
		$durasi_kegiatan1 = round($durasix/$jam);
		$tanggal_selesai_j = date('Y-m-d',strtotime('+'.$durasi_kegiatan1.'days',strtotime($tanggal_mulai_j)));

		   $input = "INSERT INTO jadwal (id_proyek, id_sub, tanggal_mulai_j, tanggal_selesai_j, durasi_kegiatan) VALUES ('$id_proyek','$id_sub','$tanggal_mulai_j','$tanggal_selesai_j','$durasi_kegiatan')";
		   $query_input = mysql_query($input);

	   		if ($query_input)
	   		{
	   			$id_pek_pendahulu = $_POST['id_pek_pendahulu'];

	   			foreach ($id_pek_pendahulu as $row)
				 {
	   				if ($row == 'TIDAK') {
	   				//inpurt sub jadwal
	   				$getBobot = mysql_query("SELECT * FROM jadwal JOIN sub_pekerjaan ON (sub_pekerjaan.id_sub =jadwal.id_sub) WHERE sub_pekerjaan.id_sub = $id_sub");
	   				$row1 = mysql_fetch_row($getBobot);
					$bobotPek = $row1[1];
	   				$id_jadwal = $row1[2];
	   				$volumePek = $row1[3];
	   				
	   				if ($durasi_kegiatan < 7) 
	   					{
	   						$mingguDurasi = 1;
	   					}
	   					else
	   					{
	   						$mingguDurasi = $durasi_kegiatan / 7;
	   					}	

	   				$tglMulai_a = $tanggal_mulai_j;
	   				$minggu = 6;
	   				for ($i=0; $i < $mingguDurasi; $i++) 
                	{
                    $mingguTanggal = date('Y-m-d',strtotime('+'.$minggu.' days',strtotime($tanggal_mulai_j)));
                    $mingguBobot  = $bobotPek / $mingguDurasi;
                    $mingguVolume = $volumePek / $mingguDurasi;

                    $simpan_sub_jadwal = "INSERT INTO sub_jadwal VALUES(NULL,'$id_jadwal','$tglMulai_a','$mingguTanggal','$mingguBobot','$mingguVolume')";

                    mysql_query($simpan_sub_jadwal);

                    $minggu = $minggu + 7;
                    $tglMulai_a = date('Y-m-d',strtotime('+1 days',strtotime($mingguTanggal)));    
               		}

	   				}
	   				//end sub jadwal
	   			}
				$p = mysql_query("SELECT id_jadwal FROM jadwal ORDER BY id_jadwal DESC LIMIT 1");
				$row = mysql_fetch_row($p);

				$id_jadwal = $row[0];
				$id_pek_pendahulu = $_POST['id_pek_pendahulu'];

				foreach ($id_pek_pendahulu as $pendahulu) 
				{
					//tambah pendahulu
					if ($pendahulu !=='TIDAK') {
						$input1 = mysql_query( "INSERT INTO pendahulu (id_jadwal,id_sub,id_pek_pendahulu) VALUES ('$id_jadwal','$id_sub','$pendahulu')");
						
					}
					//end pendahulu
				
				}
				$p1= mysql_query("SELECT sub_pekerjaan.id_sub, sub_pekerjaan.kode_sub,
									jadwal.id_jadwal, jadwal.es, jadwal.ef, jadwal.sl, jadwal.ls,
									jadwal.lf, pendahulu.id_pendahulu, pendahulu.id_sub,
									pendahulu.id_pek_pendahulu,
									(SELECT kode_sub FROM sub_pekerjaan WHERE id_sub = pendahulu.id_pek_pendahulu)AS kodependahulu,
									(SELECT durasi_kegiatan FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS durasi_pendahulu,
									(SELECT es FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS es_pendahulu,
									(SELECT ef FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS ef_pendahulu,
									(SELECT sl FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS sl_pendahulu,
									(SELECT ls FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS ls_pendahulu,
									(SELECT lf FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS lf_pendahulu
									FROM sub_pekerjaan
									JOIN jadwal ON (sub_pekerjaan.id_sub = jadwal.id_sub)
									JOIN pendahulu ON (jadwal.id_jadwal=pendahulu.id_jadwal)
									WHERE(sub_pekerjaan.id_proyek='$id_proyek' AND sub_pekerjaan.id_sub=$id_sub)");


					$sp2= mysql_num_rows($p1);
					if($sp2 < 1){
					$es = 0;
					$ef = $es + $durasi_kegiatan;

					$input2 = mysql_query("UPDATE jadwal SET es='$es',ef='$ef' WHERE id_jadwal='$id_jadwal'");

					}
					else
					{
					
					$data = array();
					while ($sp3= mysql_fetch_array($p1))
					{
						$data[] = $sp3['ef_pendahulu'];
						$es = $sp3['es'];
						$efpendahulu = $sp3['ef_pendahulu'];
						$sl = (int)$es - (int)$efpendahulu; 
					}

					$es = max($data); // dari nilai EF pendahulu terbesar
					$ef = $es + $durasi_kegiatan;

					$uptade1 = mysql_query("UPDATE jadwal set es='$es',ef='$ef' WHERE id_jadwal='$id_jadwal' ");

					//mencari nilai sl

					$cpm= mysql_query("SELECT sub_pekerjaan.id_sub, sub_pekerjaan.kode_sub,
										jadwal.id_jadwal, jadwal.es, jadwal.ef, jadwal.sl, jadwal.ls,
										jadwal.lf, pendahulu.id_pendahulu, pendahulu.id_sub,
										pendahulu.id_pek_pendahulu,
										(SELECT kode_sub FROM sub_pekerjaan WHERE id_sub = pendahulu.id_pek_pendahulu)AS kodependahulu,
										(SELECT durasi_kegiatan FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS durasi_pendahulu,
										(SELECT es FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS es_pendahulu,
										(SELECT ef FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS ef_pendahulu,
										(SELECT sl FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS sl_pendahulu,
										(SELECT ls FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS ls_pendahulu,
										(SELECT lf FROM jadwal WHERE id_sub = pendahulu.id_pek_pendahulu)AS lf_pendahulu
										FROM sub_pekerjaan
										JOIN jadwal ON (sub_pekerjaan.id_sub = jadwal.id_sub)
										JOIN pendahulu ON (jadwal.id_jadwal=pendahulu.id_jadwal)
										WHERE(sub_pekerjaan.id_proyek='$id_proyek' AND sub_pekerjaan.id_sub='$id_sub')");

					while ($sp4= mysql_fetch_array($cpm)) {
						$es = $sp4['es'];
						$ef_pendahulu = $sp4['ef_pendahulu'];
						$es_pendahulu = $sp4['es_pendahulu'];
						$durasi_pendahulu = $sp4['durasi_pendahulu'];
						$sl = (int)$es - (int)$ef_pendahulu;
						$ls = (int)$es_pendahulu + (int)$sl;
						$lf = (int)$ls + $durasi_pendahulu;
						$id_sub_pen = $sp4['id_pek_pendahulu'];
						

				
					$nilaibaru = mysql_query("SELECT es,ef FROM jadwal WHERE jadwal.id_sub='$id_sub'");
					$ambilnilaibaru = mysql_fetch_array($nilaibaru);
					$nbes = $ambilnilaibaru['es'];
					$nbef = $ambilnilaibaru['ef'];
					$sl_akhir = (int)$es - (int)$nbes;
					
					mysql_query("UPDATE jadwal SET sl='$sl_akhir',ls='$nbes',lf='$nbef' WHERE jadwal.id_sub='$id_sub'");
					mysql_query("UPDATE jadwal SET sl='$sl',ls='$ls',lf='$lf' WHERE jadwal.id_sub='$id_sub_pen'");
				
				}

				}
			    $page = "jadwal.php?id_proyek=$id_proyek&pesan=sukses";
				echo redirectPage($page);
			}
			else
			{
				$page = "jadwal.php?id_proyek=$id_proyek&pesan=gagal";
				echo redirectPage($page);
			}
				mysql_close($open);
	}
}	
?>
<!--end proses tambah jadwal-->


<!--hapus Jadwal-->
<?php
	if (isset($_GET['proses_hapus_jadwal'])) 
		{
			$proses_hapus_jadwal=$_GET['proses_hapus_jadwal'];
			if ($proses_hapus_jadwal =='hapus_jadwal') 
			{
				$link=koneksidb();
				$id_proyek= $_GET['id_proyek'];
				$id_jadwal = $_GET['id_jadwal'];
				$sql= mysql_query("DELETE FROM jadwal WHERE id_jadwal = '$id_jadwal'")or die(mysql_error());

				$page = "jadwal.php?id_proyek=$id_proyek";
				echo redirectPage($page);
			}
		}	
?>
<!--end hapus Jadwal-->

<!--reset Jadwal-->
<?php
	if (isset($_GET['proses_reset_jadwal'])) 
		{
			$proses_reset_jadwal=$_GET['proses_reset_jadwal'];
			if ($proses_reset_jadwal =='reset_jadwal') 
			{
				$link=koneksidb();
				$id_proyek= $_GET['id_proyek'];
				$sql= mysql_query("DELETE FROM jadwal WHERE id_proyek = '$id_proyek'")or die(mysql_error());

				$page = "jadwal.php?id_proyek=$id_proyek";
				echo redirectPage($page);
			}
		}	
?>
<!--end reset Jadwal-->
<!-- proses ubah status-->
<?php
if (isset($_GET['proses2']))
{
	$proses2 = $_GET['proses2'];
	if ($proses2=='ubah_status')
	{
		$link=koneksidb();
		$id_proyek =$_GET['id_proyek'];
		
		$sql=("UPDATE proyek SET baca = 'Y' WHERE id_proyek = '$id_proyek'");	
									
								 
	 	$query_edit = mysql_query($sql);

	 	if ($query_edit)
	   		{
	   			$page = "index.php?id_proyek=$id_proyek";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "index.php?id_proyek=$id_proyek";
				echo redirectPage($page);
			
			}
				mysql_close($open);	
	}
}
?>
<!--akhir ubah status-->


<!--Proses Tambah user-->
<?php
if (isset($_GET['proses']))
{
	$proses = $_GET['proses'];
	if ($proses=='tambah_user')
	{
		$link=koneksidb();
		$user = $_POST['username'];
		$pass = $_POST['password'];
		$nama = $_POST['nama'];
		$jabatan = $_POST['jabatan'];
		$email = $_POST['email'];
		
			
		$cek = mysql_num_rows(mysql_query("select username from user where username = '$_POST[username]'"));
		if ($cek > 0)
		{
			?>
			<script language ="javascript">
				document.location='user.php?pesan=gagal';
			</script>
		  <?php
		}
		elseif ($jabatan != 'kosong')
		{
		   $input = "insert into `user`(`username`,`password`,`nama_user`,`jabatan`,`email`)
		   			 values ('$user','$pass','$nama','$jabatan','$email')";
		   
		   $query_input = mysql_query($input);
	   	   $page = "user.php?username=$user&pesan=sukses";
		   echo redirectPage($page);		
		}
		else
		{
		  $page = "user.php?username=$user&pesan=gagal";
		  echo redirectPage($page);
		}
		mysql_close($open);
	}
}	
?>
<!--end proses tambah user-->
<!--proses ubah user-->
<?php
if (isset($_GET['proses_ubah_user']))
{
		$link=koneksidb();
		$proses_ubah_user = $_GET['proses_ubah_user'];
		$username = $_POST['username'];
		$nama = $_POST['nama'];
		$jabatan = $_POST['jabatan'];
		$email = $_POST['email'];
		
		if($jabatan!='kosong')
		{
			$sql= mysql_query("update user set nama_user ='$nama',
													 jabatan ='$jabatan',
													 email ='$email'
													 where username ='$username'")or die(mysql_error());
		 
			$page = "user.php?username=$username&edit=sukses";
			echo redirectPage($page);
		}
		else
		{
			$page = "user.php?username=$username&edit=gagal";
			echo redirectPage($page);
		}
}
?>
<!--end proses ubah user-->
<!--proses hapus user-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_user') 
		{
			$link=koneksidb();
			$username = $_GET['username'];
			$sql2= mysql_query("delete from user where username ='$username'")or die(mysql_error());

			$page = "user.php?username=$username&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--end proses hapus user-->

<!--Proses Tambah progres-->
<?php
if (isset($_GET['proses']))
{
	$proses = $_GET['proses'];
	if ($proses=='tambah_progres')
	{
		$link=koneksidb();
		$id_proyek = $_POST['id_proyek'];
		$minggu = $_POST['minggu'];
		$progres = $_POST['progres'];
		
		$proyek = mysql_query("select jumlah from progres where id_proyek = '$id_proyek'");
		$total = mysql_fetch_array($proyek);
		$nilai = $total['jumlah'];
		
		if($nilai > 0)
		{
			$q = mysql_query("select jumlah from progres where id_proyek = '$id_proyek' order by minggu desc limit 1");
			$j = mysql_fetch_array($q);
			$jumlah = $j['jumlah'] + $progres;
			
		}else
		{
			$jumlah = $progres;
		}
		
		
		$cek = mysql_num_rows(mysql_query("select minggu,jumlah from progres where minggu = '$minggu' and id_proyek = '$id_proyek'"));
		$q2 = mysql_query("select jumlah from progres where id_proyek = '$id_proyek' order by minggu desc limit 1");
		$j2 = mysql_fetch_array($q2);
		$np = $j2['jumlah']+ $progres;
		
		if ($cek > 0)
		{
			?>
			<script language ="javascript">
			   document.location='progres.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal';
			</script>
		  <?php
		}else if($np > 100)
		{
			?>
			<script language ="javascript">
			   document.location='progres.php?id_proyek=<?=$_POST['id_proyek']?>&pesan=gagal_jumlah';
			</script>
		  <?php
		}
		
		else
		{
			
	       $input_progres = "insert into `progres`(`id_progres`,`id_proyek`,`minggu`,`jumlah`,`bobot_rencana`)
			    	 		 values (' ','$id_proyek','$minggu','$jumlah','$progres')";
		
		   $query = mysql_query($input_progres);
		   
		   if($query)
		   {
			   $page = "progres.php?id_proyek=$id_proyek&pesan=sukses";
			   echo redirectPage($page);	
		   }
		   else
		   {
			  $page = "progres.php?id_proyek=$id_proyek&pesan=gagal";
			  echo redirectPage($page);
		   }
		      mysql_close($open);
		 }
	}
}	
?>
<!--end proses tambah user-->

<!--proses hapus progres-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_progres') 
		{
			$link=koneksidb();
			$id_progres = $_GET['id_progres'];
			$id_proyek = $_GET['id_proyek'];
			$sql2= mysql_query("delete from progres where id_progres ='$id_progres'")or die(mysql_error());

			$page = "progres.php?id_proyek=$id_proyek&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--end proses hapus progres-->

<!--tambah percepatan-->
<?php
if (isset($_GET['proses_tambah_percepatan']))
	{
			$link=koneksidb();
			$id_proyek = $_GET['id_proyek'];
			$id_jadwal = $_GET['id_jadwal'];
			$id_sub = $_GET['id_sub'];
			
			$sql = mysql_query("SELECT durasi_kegiatan, volume, jumlah FROM jadwal 
							    JOIN sub_pekerjaan ON jadwal.id_sub = sub_pekerjaan.id_sub
							    WHERE id_jadwal= '$id_jadwal' and jadwal.id_sub = '$id_sub' and jadwal.id_proyek = '$id_proyek'");
							   
			$get = mysql_fetch_array($sql);
			$durasi_normal = $get['durasi_kegiatan'];
			$volume = $get['volume'];
			$biaya_normal = $get['jumlah'];
			$produktivitas_normal = $volume/$durasi_normal;
			$prod_normal_perjam = $produktivitas_normal / 8;
			$produktivitas_lembur = (1 * 0.9) * $prod_normal_perjam;
			$produktivitas_percepatan = $produktivitas_normal + $produktivitas_lembur;
			
			$sql2 = mysql_query("SELECT SUM(upah) biaya_upah FROM detail_sub 
			 					 JOIN tenaga ON detail_sub.id_tenaga = tenaga.id_tenaga  
								 WHERE id_sub = '$id_sub' AND tenaga.id_proyek = '$id_proyek'");
			$getupah = mysql_fetch_array($sql2);
			$biaya_upah = $getupah['biaya_upah'];
		
			$sql3 = mysql_query("SELECT SUM(harga_bahan) hb FROM detail_sub 
			                     JOIN bahan_material ON detail_sub.id_bahan = bahan_material.id_bahan 
			                     WHERE id_sub = '$id_sub' AND kode LIKE 'M0%' AND bahan_material.id_proyek = '$id_proyek'");
			$gethb = mysql_fetch_array($sql3);
			$biaya_bahan = $gethb['hb'];
		
			
			$sql4 = mysql_query("SELECT SUM(harga_bahan) ha FROM detail_sub 
			                     JOIN bahan_material ON detail_sub.id_bahan = bahan_material.id_bahan 
			                     WHERE id_sub = '$id_sub' AND kode LIKE 'E0%' AND bahan_material.id_proyek = '$id_proyek'");
			$getha = mysql_fetch_array($sql4);
			$biaya_alat = $getha['ha'];
					
			$cd = floor($volume/ $produktivitas_percepatan);
		
			$upah_normal_hari = 8 * $biaya_upah;
			$upah_lembur_hari = (1.5 * 1) * $biaya_upah;
			$biaya_upah_hari = $upah_normal_hari + $upah_lembur_hari;
			$tu = $cd * $biaya_upah_hari;
			$ta = $biaya_alat;
			$tb = $biaya_bahan;
			
			$cc = $tu + $ta + $tb + $biaya_normal;  
			
			$input = "INSERT INTO percepatan (id_percepatan,id_jadwal,crash_duration,crash_cost)VALUES(' ','$id_jadwal','$cd','$cc')";
	   		$query_input = mysql_query($input);

	   		if ($query_input)
	   		{
				$ubah_status= mysql_query("update evaluasi set status ='Y'
													   where id_proyek ='$id_proyek'")or die(mysql_error());
				
	   			$page = "percepatan.php?id_proyek=$id_proyek&pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "percepatan.php?id_proyek=$id_proyek&pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);
		
	}
?>
<!--end tambah percepatan-->

<!--hapus percepatan-->
<?php
	if (isset($_GET['proses_hapus'])) 
		{
			$proses_hapus=$_GET['proses_hapus'];
			if ($proses_hapus =='hapus_percepatan') 
			{
				$link=koneksidb();
				$id_proyek= $_GET['id_proyek'];
				$id_percepatan = $_GET['id_percepatan'];
				$sql= mysql_query("DELETE FROM percepatan WHERE id_percepatan = '$id_percepatan'")or die(mysql_error());
				$ubah_status= mysql_query("update evaluasi set status ='T'
													   where id_proyek ='$id_proyek'")or die(mysql_error());
				
				
				$page = "percepatan.php?id_proyek=$id_proyek&hapus=sukses";
				echo redirectPage($page);
			}
		}	
?>
<!--end hapus percepatan-->


<!--Proses Tambah Jenis-->
<?php
if (isset($_GET['proses']))
{
	$proses = $_GET['proses'];
	if ($proses=='tambah_jenis')
	{
		$link=koneksidb();
		$nama_jenis = $_POST['nama_jenis'];
			
		   $input = "INSERT INTO jenis_proyek (id_jenis,nama_jenis)
		             VALUES(' ','$nama_jenis')";
		   
		   $query_input = mysql_query($input);

	   		if ($query_input)
	   		{
	   			$page = "jenis_proyek.php?pesan=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "jenis_proyek.php?pesan=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);
	}
}	
?>
<!--Akhir proses tambah jenis-->
<!-- proses ubah jenis-->
<?php
if (isset($_GET['proses2']))
{
	$proses2 = $_GET['proses2'];
	if ($proses2=='ubah_jenis')
	{
		$link=koneksidb();
		$id_jenis = $_POST['id_jenis'];
		$nama_jenis = $_POST['nama_jenis'];

		$sql=("UPDATE jenis_proyek SET nama_jenis='$nama_jenis' WHERE id_jenis='$id_jenis'");
								 
	 	$query_edit = mysql_query($sql);

	 	if ($query_edit)
	   		{
	   			$page = "jenis_proyek.php?edit=sukses";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "jenis_proyek.php?edit=gagal";
				echo redirectPage($page);
			
			}
				mysql_close($open);	
	}
}
?>

<!--akhir ubah jenis-->

<!--proses hapus  jenis-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='hapus_jenis') 
		{
			$link=koneksidb();
			$id_jenis = $_GET['id_jenis'];
			
			$sql2= mysql_query("delete from jenis_proyek where id_jenis='$id_jenis'")or die(mysql_error());

			$page = "jenis_proyek.php?id_jenis=$id_jenis&hapus=sukses";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses hapus jenisn-->

