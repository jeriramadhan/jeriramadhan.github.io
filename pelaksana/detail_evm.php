<?php 
  include "header.php";
  include "fungsi_romawi.php";
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="index.php?id_proyek=<?=$_GET['id_proyek']?>"><i class="fa fa-home"></i>Beranda</a></li>
        <li class="active">Detail EVM</li>
      </ol>
    </section>
	
	<br />
<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Proyek (EVM)</h3>
                 <div class="box-tools pull-left">
					 <a href="index.php?id_proyek=<?=$_GET['id_proyek'] ?>" class="btn btn-primary btn-fill btn-sm"><span>Kembali</span></a>
				  </div>
				  
				  <?php
					if(isset($_GET['id_proyek'])) 
				   { 
						$id_proyek = $_GET['id_proyek'];
						$proyek = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
						
						
						while($r=mysql_fetch_array($proyek))
						{
						  $biaya = number_format($r['nilai_proyek'],2,',','.');
						   ?>
						        <br>
								<br>
								<h5><b> 
								  <div><i class="fa fa-building text-red"></i> Proyek : <code><?php echo " $r[nama_proyek]" ?></code></div><p>
								  <div><i class="fa fa-user text-blue"></i> Pemilik : <?php echo " $r[pemilik]" ?></div><p>
								  <div><i class="fa fa-money text-yellow"></i> Biaya : <?php echo"Rp. $biaya" ?></div><p>
								  <div><i class="fa fa-map-o text-green"></i> Lokasi : <?php echo "Desa $r[desa], "." Kecamatan $r[kecamatan]"." - $r[kabupaten]" ?></div><p>
								  <div><i class="fa fa-repeat"></i> Durasi : <?php echo " $r[durasi_proyek]" ?></div><p>
								  <div><i class="fa fa-calendar text-navy"></i> Tanggal Mulai: <?php  echo date ("d/m/Y", strtotime($r['tanggal_mulai']))?></div><p>
								  <div><i class="fa fa-calendar text-green"></i> Tanggal Selesai: <?php  echo date ("d/m/Y", strtotime($r['tanggal_selesai']))?></div><p>
								</b></h5>
						<?php	  
						}
				  }
				  ?>
	
		           <!-- /.box-header -->
				  <div class="box-body">
					<br />
					  
					 <table id="tabel2" class="table table-bordered table-striped">
						<thead>
			                    <tr>
								  <th width="68" rowspan="2">Minggu Ke-</th>
								  <th width="133" rowspan="2">Komulatif Planned Value (PV)</th>
								  <th width="131" rowspan="2">Komulatif Earned Value (EV)</th>
								  <th width="137" rowspan="2">Komulatif Actual Cost (AC)</th>
								  <th colspan="2"><center>Analisis Variance</center></th>
								  <th colspan="2"><center>Analisis Kinerja</center></th>
								  <th colspan="2"><center>Analisis Estimasi</center></th>
								</tr>
								<tr>
								  <th width="153">Schedule Variance(SV)</th>
								  <th width="128">Cost Variance(CV)</th>
								  <th width="119">Schedule Performance Index (SPI)</th>
								  <th width="119">Cost Performance Index (CPI)</th>
								  <th width="139">Estimate at Completion (EAC)</th>
								  <th width="129">Estimate to Complete (ETC)</th>
								</tr>
					    </thead>
							  <tbody>
							  <?php
			  					if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$detail = mysql_query("select * from evaluasi join progres on evaluasi.id_progres = progres.id_progres where progres.id_proyek = '$id_proyek' order by minggu");
									while($row=mysql_fetch_array($detail))
								{
								  echo"
									<tr>
									  <td align='center'>$row[minggu]</td>
									  <td>Rp. ".number_format(round($row['pv_komulatif']),2,',','.')."</td>
									  <td>Rp. ".number_format(round($row['ev_komulatif']),2,',','.')."</td>
									  <td>Rp. ".number_format(round($row['ac_komulatif']),2,',','.')."</td>
									  <td>Rp. ".number_format(round($row['sv']),0,',','.')."</td>
									  <td>Rp. ".number_format(round($row['cv']),2,',','.')."</td>
									  <td>".number_format ($row['spi'],2)."</td>
									  <td>".number_format ($row['cpi'],2)."</td>
									  <td>Rp. ".number_format(round($row['eac']),2,',','.')."</td>
									  <td>".number_format ($row['etc'],0)."</td>
							          "; 
									?>
									</tr> 
								  <?php
								}
							  }
							  ?>
							  </tbody>
					  </table>
					  
					  <?php
					  if(isset($_GET['id_proyek'])) 
					   { 
						  $id_proyek = $_GET['id_proyek'];
					  
					      $query = mysql_query("select * from evaluasi join progres on evaluasi.id_progres = progres.id_progres where progres.id_proyek = '$id_proyek' order by minggu DESC limit 1");
						  $evaluasi= mysql_fetch_array($query);
						  $CV = $evaluasi['cv'];
						  $SV = $evaluasi['sv'];
						  $CPI = $evaluasi['cpi'];
						  $SPI = $evaluasi['spi'];
						  $periode = $evaluasi['minggu'];
						  ?>
							<div class="panel-heading">
							  <?php
									   if($CV>0 AND $CPI>1)
									   {
										 $penilaiancv = "Lebih rendah dari anggaran";
									   }
									   else if ($CV==0 AND $CPI==1)
									   {
										$penilaiancv = "Pengeluaran = Biaya rencana";
									   }
									   else if ($CV<0 AND $CPI<1)
									   {
										$penilaiancv = "Lebih besar dari anggaran";
									   }
									   else{
									       $penilaiancv = " ";
									   }
					
									   if ($SV>0 AND $SPI>1)
									   {
										$penilaiansv = "Pengerjaan lebih cepat dari jadwal rencana";
									   }
									   else if ($SV==0 AND $SPI==1)
									   {
										$penilaiansv = "Sesuai jadwal";
									   }
									   else if ($SV<0 AND $SPI<1)
									   {
										 $penilaiansv = "Pengerjaan lebih lambat dari jadwal rencana";
									   }
									   else{$penilaiansv = " ";}
								  ?>
						    <?php 
						    }
							?>
							
							<br />
							<?php
							   echo "  Pada Minggu Ke- $periode <br>";
							   echo "  Biaya <code>".$penilaiancv."</code><br>";
							   echo "  Waktu <code>".$penilaiansv."</code><br>";
							?> 
						    <br /> 
							<?php
							   $id_proyek = $_GET['id_proyek'];
							   $gettgl = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
							   $tgl = mysql_fetch_array($gettgl);
							   $etc1 = (int) $evaluasi['etc'] - 1 ;
							   $eac1 = $evaluasi['eac'];
							   $tgl_mulai = $tgl['tanggal_mulai'];
							   $denda = $tgl['nilai_proyek'] / 1000;
							   $terlambat = (int)$evaluasi['etc'] - $tgl['durasi_proyek'];
							   $biaya = $tgl['biaya'] * 0.1;
							   $np = $tgl['nilai_proyek'];
							   
							   $tgl_selesai = date('Y-m-d',strtotime('+'.$etc1.'days',strtotime($tgl_mulai)));
							   $total = $biaya + $eac1;
							   $totaldenda = $terlambat * $denda;
							   $total_biaya = $np + $totaldenda;
							   
							   
							   echo "  Perkiraan durasi akhir proyek adalah <code>".number_format($evaluasi['etc'],0)."</code> hari, ";
							   echo "  mengalami keterlambatan selama <code>".number_format($terlambat,0)."</code> hari dan";
							   echo "  selesai pada tanggal <code>".date('d/m/Y',strtotime($tgl_selesai))."</code><br>";
							   echo "  Denda proyek sebesar <code> Rp.".number_format($denda,0,',','.')."</code> / hari <br>";
							   echo "  Perkiraan biaya akhir proyek sebesar <code> Rp.".number_format($total,0,',','.')."</code>, jika ditambahkan dengan Denda maka";
							   echo "  total biaya proyek adalah sebesar <code> Rp.".number_format($total_biaya,2,',','.')."</code>";
							?>
				   </div>
				   
				   <br />
				   <div class="col-md-12">
						  <div class="box box-default collapsed-box">
							<div class="box-header with-border">
							  <h3 class="box-title">Lihat Progres Selengkapnya</h3>
				
							  <div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
								</button>
							  </div>
							  <!-- /.box-tools -->
							</div>
							<!-- /.box-header -->
							<div class="box-body" style="display: none;">
							  <table id="tabel1" class="table table-bordered">
								 <thead>
								  <tr>
									<td width="5%"><b>Minggu ke-</b></td>
									<td width="30%"><b>Nama Pekerjaan</b></td>
									<td width="10%"><b>Bobot Pekerjaan (Rencana)</b></td> 
									<td width="10%"><b>Bobot Pekerjaan (Realisasi)</b></td> 
									<td width="10%"><b>Volume (Rencana)</b></td>
									<td width="10%"><b>Volume (Realisasi)</b></td>
									<td width="30%"><b>Progres Pekerjaan</b></td>
								</tr>
								</thead>
								<tbody>
								   <?php
									if(isset($_GET['id_proyek'])) 
									{ 
										   $id_proyek = $_GET['id_proyek'];
										  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
										  
										  $sql = mysql_query("SELECT DISTINCT progres.minggu, pekerjaan.kode_pekerjaan,nama_pekerjaan,pekerjaan.id_pekerjaan 
															  FROM progres 
															  JOIN detail_progres ON progres.id_progres = detail_progres.id_progres
															  JOIN sub_pekerjaan ON detail_progres.id_sub = sub_pekerjaan.id_sub
															  JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub
															  JOIN pekerjaan ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
															  WHERE progres.id_proyek ='$id_proyek' order by minggu");
																  
										  while($r = mysql_fetch_array($sql))
										  {
										 ?>	
										 <tr>	
											 <td>
												<dd><b><?php echo $r['minggu'] ?></b></dd>
											 </td>
											 <td>
												<b><?php echo $r['nama_pekerjaan']; ?></b>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>
												 <td>&nbsp;</td>	
											 </td> 
												<?php
											
												$sql2 = mysql_query ("SELECT kode_pekerjaan,sub_pekerjaan.kode_sub,nama_sub,sub_pekerjaan.id_master_sub,sub_pekerjaan.id_sub
																	  FROM `detail_progres`
																	  JOIN sub_pekerjaan ON detail_progres.id_sub = sub_pekerjaan.id_sub
																	  JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub
																	  JOIN pekerjaan ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
																	  Where master_sub_pekerjaan.id_pekerjaan = '".$r['id_pekerjaan']."' order by kode_sub");
												if($sql2)
												{
													while($s=mysql_fetch_array($sql2))
													{
													?>
													 <tr>
														 <td>
														   <dd><i><center><?php echo Romawi($s['kode_pekerjaan']).'.'.$s['kode_sub']; ?></center></i></dd>
														 </td>
														 <td>
														   <i><?php echo $s['nama_sub']; ?></i>
															
														 </td>
														 <td>
															 <?php
															   
															   $id = $s['id_sub'];
															  
															   $sub = "SELECT bobot FROM sub_pekerjaan
																	   WHERE id_sub = '$id' AND id_proyek = '$id_proyek'";
																	   
															   $res= mysql_query($sub);
															 ?>
															 
															  <table border="1" > 
																<?php
																   while($detail=mysql_fetch_array($res))
																   {
																		?>
																		<tr> 
																		   <?php echo number_format($detail['bobot'],3)." %"?>
																		</tr>
															   <?php  }?>
															 </table>     
														 </td>
														  <td>
															<?php
															   $id = $s['id_sub'];
															   $sub2 = "SELECT bobot_realisasi FROM detail_progres
															   			JOIN sub_pekerjaan ON detail_progres.id_sub = sub_pekerjaan.id_sub
																	    WHERE sub_pekerjaan.id_sub = '$id' AND id_proyek = '$id_proyek'"; 
															   $res2= mysql_query($sub2);
															 ?>
															 
															  <table border="1" > 
																<?php
																   while($detail2=mysql_fetch_array($res2))
																   {
																		?>
																		<tr> 
																		   <?php echo number_format($detail2['bobot_realisasi'],3)." %"?>
																		</tr>
															   <?php  }?>
															 </table>     
														 </td>
														 
														 <td>
														   <?php
															   $id = $s['id_sub'];
															  
															   $sub3 = "SELECT volume FROM sub_pekerjaan
																	    WHERE id_sub = '$id' AND id_proyek = '$id_proyek'";
															   $res3= mysql_query($sub3);
															 ?>
															 
															  <table border="1" > 
																<?php
																   while($detail3=mysql_fetch_array($res3))
																   {
																		?>
																		<tr> 
																		   <?php echo number_format($detail3['volume'],3)." %"?>
																		</tr>
															   <?php  }?>
															 </table>     
													   </td>
													   <td>
														<?php
															   $id = $s['id_sub'];
															   $sub5 = "SELECT volume_realisasi FROM detail_progres
															   			JOIN sub_pekerjaan ON detail_progres.id_sub = sub_pekerjaan.id_sub
																	    WHERE sub_pekerjaan.id_sub = '$id' AND id_proyek = '$id_proyek'"; 
															   $res5= mysql_query($sub5);
															 ?>
															 
															  <table border="1" > 
																<?php
																   while($detail5=mysql_fetch_array($res5))
																   {
																		?>
																		<tr> 
																		   <?php echo number_format($detail5['volume_realisasi'],3)." %"?>
																		</tr>
															   <?php  }?>
															  </table>
													   </td>
													   <td> 
														 <?php
														   if(isset($_GET['id_proyek'])) 
														   { 
															$id_proyek = $_GET['id_proyek'];
															
															$id = $s['id_master_sub'];
															$sub4 = "SELECT * from sub_pekerjaan WHERE id_master_sub = '$id' AND id_proyek = '$id_proyek'";
															$res4= mysql_query($sub4);
															
																while($cek=mysql_fetch_array($res4))
																{
																  ?>
																	
																  <?php	
																	$id = $cek['id_sub'];
																	$kegiatan = mysql_query("select sum(persen_realisasi) bobot 
																							 from detail_progres 
																							 join progres on detail_progres.id_progres = progres.id_progres
																							 where progres.id_proyek = '$id_proyek' and id_sub = $id");
																							 
																	while($r=mysql_fetch_array($kegiatan))
																	{
																	?>
																	 <div class="progress">
																		<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" 
																		aria-valuemax="100" style="width:<?php echo $r['bobot']?>%">
																			<?php echo number_format($r['bobot']) ?> %
																		 </div>
																	</div>
																	<?php 
																	}
															   }
														   }
														?>
													   </td>  
													</tr>
												  <?php
												} 
											}else 
											{
											   
											}
										  ?>
											
										<?php
										}
									  }
										?>	
										</tr>
									 </tbody>	
								</table>
							</div>
							<!-- /.box-body -->
						  </div>
						  <!-- /.box -->
						</div>
              </div>
           </div>
     </section>
    </div>
<?php
include "footer.php";
?>