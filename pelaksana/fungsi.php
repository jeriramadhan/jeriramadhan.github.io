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

<!--proses ubah baca-->
<?php
	if (isset($_GET['proses_hapus'])) 
	{
		$proses_hapus=$_GET['proses_hapus'];
		if ($proses_hapus =='ubah_baca') 
		{
			$link=koneksidb();
			$id_proyek = $_GET['id_proyek'];
			$sql2= mysql_query("update proyek set baca = 'Y' where id_proyek='$id_proyek'")or die(mysql_error());

			$page = "progres.php?id_proyek=$id_proyek";
			echo redirectPage($page);
		}
	}	
?>
<!--akhir proses ubah baca-->

<!--proses tambah detail-->
<?php
	if (isset($_GET['proses_tambah_detail']))
	{
		$link=koneksidb();
		$id_proyek = $_GET['id_proyek'];
		$id_sub = $_POST['id_sub'];
		$id_progres = $_GET['id_progres'];
		$persen_r = $_POST['persen_r'];
		$biaya_r = str_replace(',', '.',str_replace('.', '',$_POST['biaya_r']));
		$tgl_r =  date("Y-m-d");
		
		
		$getbobot = mysql_query("SELECT bobot,volume FROM sub_pekerjaan WHERE id_sub = $id_sub");
		$r = mysql_fetch_array($getbobot);
		$b = $r['bobot'];
		$v = $r['volume'];
		
		$volume_r = ($persen_r/100)*$v;
		$bobot_r = ($persen_r/100)*$b;  
		
		
		$cektotal = mysql_query("SELECT SUM(persen_realisasi) as ps from detail_progres
								  JOIN progres ON progres.id_progres = detail_progres.id_progres
								  WHERE id_sub = $id_sub and id_proyek= '$id_proyek'");
		
		$tp = mysql_fetch_array($cektotal);
		$ps = $tp['ps'];
		
		$tper = $ps + $persen_r; 
		
		
		$cek = mysql_num_rows(mysql_query("select id_progres, id_sub from detail_progres where id_sub = '$_POST[id_sub]' and id_progres = '$id_progres'"));
		if ($cek > 0 && tper <= 100)
		{ 
			$sql= mysql_query("update detail_progres set volume_realisasi ='$volume_r',
														 persen_realisasi ='$persen_r',
														 bobot_realisasi ='$bobot_r',
														 biaya_realisasi ='$biaya_r',
														 tanggal_realisasi ='$tgl_r'
														 where id_progres ='$id_progres' and id_sub = '$id_sub'")or die(mysql_error());
 
			$page = "tambah_progres.php?id_proyek=$id_proyek&id_progres=$id_progres";
			echo redirectPage($page);		 
		}
		
		if($cek < 1 && $tper <= 100)
		{
			$input =mysql_query("INSERT into detail_progres (id_progres,id_sub,volume_realisasi,persen_realisasi,bobot_realisasi, biaya_realisasi,tanggal_realisasi)
			                     VALUES ('$id_progres','$id_sub','$volume_r','$persen_r','$bobot_r','$biaya_r','$tgl_r')");
			
			$page = "tambah_progres.php?id_proyek=$id_proyek&id_progres=$id_progres";
			echo redirectPage($page);
		
		}
		else
		{
			$page = "tambah_progres.php?id_proyek=$id_proyek&id_progres=$id_progres";
			echo redirectPage($page);
		
		}
			mysql_close($open); 
				
	}
?>
<!--end Tambah detail pekerjaan-->

<!--hapus detail pekerjaan-->
<?php
	if (isset($_GET['proses_hapus_detail'])) 
		{
			$proses_hapus_detail=$_GET['proses_hapus_detail'];
			if ($proses_hapus_detail =='hapus_detail') 
			{
				$link=koneksidb();
				$id_proyek=$_GET['id_proyek'];
				$id_progres = $_GET['id_progres'];
				$id_detail=$_GET['id_detail_pro'];
				
				$sql3= mysql_query("delete from detail_progres where id_detail_pro ='$id_detail'")or die(mysql_error());
				
					
				$page = "tambah_progres.php?id_proyek=$id_proyek&id_progres=$id_progres";
				echo redirectPage($page);
			}
		}	
?>
<!--end hapus detail pekerjaan-->
<!--proses tambah evaluasi-->
<?php
	if (isset($_GET['proses_tambah'])) 
	{
		$proses_tambah=$_GET['proses_tambah'];
		if ($proses_tambah =='tambah_aktual') 
		{
			$link=koneksidb();
			$id_proyek = $_GET['id_proyek'];
			$id_progres = $_GET['id_progres'];
			$bobot_aktual = number_format ($_GET['bobot_realisasi'],3);
			$biaya_aktual = $_GET['biaya_realisasi'];
			
			$sql2 = mysql_query("UPDATE progres set bobot_aktual = '$bobot_aktual', 
								 					biaya_aktual = '$biaya_aktual'
								 					WHERE id_progres = '$id_progres' and id_proyek='$id_proyek'")or die(mysql_error());

			
			$pro = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
			$pro2 = mysql_fetch_array($pro);
			$bac = $pro2['biaya'];
			$ote = $pro2['durasi_proyek'];
			
			$r = mysql_query("select * from progres where id_progres = '$id_progres'");
			$r2 = mysql_fetch_array($r);
			$bobot_rencana = $r2['bobot_rencana'];
			
			$pv = ($bobot_rencana * $bac) / 100;
			$ev = ($bobot_aktual * $bac)/100;
					 
			$cv	= $ev - $biaya_aktual;
			$sv	= $ev - $pv;
			
			$cpi = $ev / $biaya_aktual;
			$spi = $ev / $pv;
			
			$eac = $bac / $cpi;
			$etc = $ote/ $spi;
			
			
			$nilai = mysql_query("select pv_komulatif, ev_komulatif, ac_komulatif from evaluasi where id_proyek = '$id_proyek'");
			$kom = mysql_fetch_array($nilai);
			$pv_kom = $kom['pv_komulatif'];
			$ev_kom = $kom['ev_komulatif'];
			$ac_kom = $kom['ac_komulatif'];
			
				if($pv_kom > 0)
				{
					$q = mysql_query("select pv_komulatif, ev_komulatif, ac_komulatif from evaluasi join progres on evaluasi.id_progres = progres.id_progres
									 where evaluasi.id_proyek = '$id_proyek' order by minggu desc limit 1");
					$j = mysql_fetch_array($q);
					$pv_komulatif = $j['pv_komulatif'] + $pv;
					$ev_komulatif = $j['ev_komulatif'] + $ev;
					$ac_komulatif = $j['ac_komulatif'] + $biaya_aktual;
					
				}else
				{
					$pv_komulatif = $pv;
					$ev_komulatif = $ev;
					$ac_komulatif = $biaya_aktual;
				}
				
			$cek = mysql_num_rows(mysql_query("select id_proyek, id_progres from evaluasi where id_proyek = '$id_proyek' and id_progres = '$id_progres'"));
			
			if ($cek > 0)
			{ 
				
				$sql= mysql_query("update evaluasi set pv ='$pv',pv_komulatif ='$pv_komulatif',ev ='$ev',ev_komulatif ='$ev_komulatif',ac ='$biaya_aktual',
													   ac_komulatif ='$ac_komulatif',sv ='$sv',cv ='$cv',spi ='$spi',cpi ='$cpi',eac ='$eac',etc ='$etc'
													   where id_progres ='$id_progres' and id_proyek = '$id_proyek'")or die(mysql_error());
	 				
				$page = "progres.php?id_proyek=$id_proyek";
				echo redirectPage($page);	 
			}
			
			if($cek < 1)
			{
				
				$evm =mysql_query("INSERT into `evaluasi`(`id_evaluasi`,`id_proyek`,`id_progres`,`pv`,`pv_komulatif`,`ev`,`ev_komulatif`,
													      `ac`,`ac_komulatif`,`sv`,`cv`,`spi`,`cpi`,`eac`,`etc`)
											       VALUES(' ','$id_proyek','$id_progres','$pv','$pv_komulatif','$ev','$ev_komulatif',
											              '$biaya_aktual','$ac_komulatif','$sv','$cv','$spi','$cpi','$eac','$etc')");
														  				
				$page = "progres.php?id_proyek=$id_proyek";
				echo redirectPage($page);
			
			}
			else
			{
				
				$page = "progres.php?id_proyek=$id_proyek";
				echo redirectPage($page);
			
			}
		}
	}	
?>
<!--akhir proses tambah evaluasi-->
<!--proses hapus evaluasi-->
<?php
if (isset($_GET['proses_hapus']))
{
	$proses_hapus = $_GET['proses_hapus'];
	if ($proses_hapus=='hapus_aktual')
	{
		$link=koneksidb();
		$id_proyek = $_GET['id_proyek'];
		$id_progres = $_GET['id_progres'];
		
		$sql=("UPDATE progres SET bobot_aktual = ' ', biaya_aktual = ' ' WHERE id_proyek = '$id_proyek' and id_progres = '$id_progres'");	
									
								 
	 	$query_edit = mysql_query($sql);

	 	if ($query_edit)
	   		{
				mysql_query("delete from evaluasi where id_proyek = '$id_proyek' and id_progres = '$id_progres'")or die(mysql_error());
				$sql4= mysql_query("delete from detail_progres where id_progres ='$id_progres'")or die(mysql_error());
				
	   			$page = "progres.php?id_proyek=$id_proyek";
				echo redirectPage($page);	
			}	
			else
			{
				$page = "progres.php?id_proyek=$id_proyek";
				echo redirectPage($page);
			
			}
				mysql_close($open);	
	}
}
?>
<!--akhir proses hapus evaluasi-->
