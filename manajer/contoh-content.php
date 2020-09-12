<?php
include "fungsi_romawi.php"; 
?>
<div class="content-wrapper">
    <section class="content">
      <div class="row">
      	 <div class="box-body">
			<br />
		  
		  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#info_proyek" data-toggle="tab">
								<!-- <i class="fa  fa-building text-green"> </i> -->
								 Info Proyek</a></li>
              <li><a href="#perbandingan" data-toggle="tab">
								<!-- <i class="fa  fa-warning text-red"> -->
									 </i> Perkiraan Biaya dan Waktu Proyek</a></a></li>
			  <li><a href="#perbandingan_percepatan" data-toggle="tab">
					<!-- <i class="fa fa-check-circle-o text-yellow"> </i> -->
					 Hasil Percepatan Proyek</a></a></li>
            </ul>
			
			<div class="tab-content">
              <div class="tab-pane" id="perbandingan"><!-- Post -->
                 <div class="post">
				     <br />
					  <div class="box-body">
					    <br />
						  <table id="tabel1" class="table table-bordered table-striped">
								 <thead>
									<tr>
									  <th rowspan="2">No</th>
									  <th rowspan="2">Nama Proyek</th>
									  <th colspan="2"><center>Tanggal</center></th>
									  <th rowspan="2">Nilai Kontrak</th>
									  <th rowspan="2">Pemilik Proyek</th>
									  <th rowspan="2">Status Proyek</th>
									  <th colspan="4"><center>Perkiraan</center></th>
									</tr>
									<tr>
									  <th>Mulai</th>
									  <th>Selesai</th>
									  <th>Biaya Penyelesaian</th>
									  <th>Tanggal Penyelesaiaan</th>
									  <th>Denda</th>
									  <th>Biaya Total</th>
									</tr>
									</thead>
								  <tbody>
								  <?php
									$proyek = mysql_query("SELECT * FROM proyek");
									$no=0;
									while($r=mysql_fetch_array($proyek)){
									  $n=1;
									  $no=$no+$n;
									
									  echo"
										<tr>
										  <td>$no</td>
										  <td>$r[nama_proyek]</td>
										  <td>".date ("d/m/Y", strtotime($r['tanggal_mulai']))."</td>
										  <td>".date ("d/m/Y", strtotime($r['tanggal_selesai']))."</td>
										  <td>Rp.".number_format($r['nilai_proyek'],2,',','.')."</td>
										  <td>$r[pemilik]</td>
										 ";
									 ?>
										  <td>
											 <?php
												$id_proyek = $r['id_proyek'];
												$sub4 = "select sum(bobot_aktual) bobot from progres where id_proyek = '$id_proyek'";
												$res4= mysql_query($sub4);
						 
													while($row=mysql_fetch_array($res4))
													{
													  if ($row['bobot'] < 100)
													  {
														 echo" <h4><b> Berjalan </b></h4>"; 
													  }
													  else
													  {
														 echo" <h4><b> Selesai </b></h4>"; 
													  }
													}
												?>
										  </td>
											  <?php
												$query = mysql_query("select * from evaluasi join progres on evaluasi.id_progres = progres.id_progres 
																	  where progres.id_proyek = '$id_proyek' order by minggu DESC limit 1");
												$evaluasi= mysql_fetch_array($query);
				
												$gettgl = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
												$tgl = mysql_fetch_array($gettgl);
											   
												$etc1 = (int) $evaluasi['etc'] - 1 ;
												$eac1 = $evaluasi['eac'];
												$tgl_mulai = $tgl['tanggal_mulai'];
												$tgl2 = $tgl['tanggal_selesai'];
												$denda = $tgl['nilai_proyek'] / 1000;
												$terlambat = (int)$evaluasi['etc'] - $tgl['durasi_proyek'];
												$biaya = $tgl['biaya'] * 0.1;
												$np = $tgl['nilai_proyek'];
											   
												if ($terlambat < 1)
												{
													$tgl_selesai = date('Y-m-d',strtotime($tgl2));
													$total = $np;
													$totaldenda = 0;
													$total_biaya = $np + $totaldenda;	
												}
												else
												{
													$tgl_selesai = date('Y-m-d',strtotime('+'.$etc1.'days',strtotime($tgl_mulai)));
													$total = $biaya + $eac1;
													$totaldenda = $terlambat * $denda;
													$total_biaya = $np + $totaldenda;	
												}	
											?>
										  <td><?php echo"<code> Rp.".number_format($total,0,',','.')."</code>"?></td>
										  <td><?php echo"<code> ".date('d/m/Y',strtotime($tgl_selesai))."</code>"?></td>
										  <td><?php echo"<code> Rp.".number_format($totaldenda,0,',','.')."</code>"?></td>
										  <td><?php echo"<code> Rp.".number_format($total_biaya,0,',','.')."</code>"?></td>
										</tr>
									  <?php 
									}
								  ?>
							    </tbody>
						    </table>
					  </div>               
				 </div><!-- /.post -->
              </div><!-- /.tab-pane -->
			  
              <div class="tab-pane" id="perbandingan_percepatan">
                <!-- Post -->
                <div class="post">
					 <br />
					  <div class="box-body">
					    <br />
						  <table id="tabel2" class="table table-bordered table-striped">
								 <thead>
									<tr>
									  <th><center>No</center></th>
									  <th><center>Proyek</center></th>
									  <th><center>Durasi (Hari)</center></th>
									  <th><center>Nilai Proyek (Rp.)</center></th>
									  <th><center>Biaya Percepatan</center></th>
									  <th><center>Terlambat (Hari)</center></th>
									  <th><center>Denda (Rp.)</center></th>
									  <th><center>Biaya Total (Rp.)</center></th>
									</tr>
									</thead>
								  <tbody>
								  <?php
									$proyek = mysql_query("SELECT * FROM proyek WHERE id_proyek IN (SELECT id_proyek FROM percepatan)");
									$no=0;
									while($r=mysql_fetch_array($proyek)){
									  $n=1;
									  $no=$no+$n;
									
									  echo"
										<tr>
										  <td>$no</td>
										  <td>$r[nama_proyek]</td>
										  <td>$r[durasi_proyek]</td>
										  <td>Rp.".number_format($r['nilai_proyek'],2,',','.')."</td>
										 ";
									 ?>
											<?php
											    $id_proyek = $r['id_proyek'];
												$query = mysql_query("select * from evaluasi join progres on evaluasi.id_progres = progres.id_progres 
																	  where progres.id_proyek = '$id_proyek' order by minggu DESC limit 1");
												$evaluasi= mysql_fetch_array($query);
				
												$gettgl = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
												$tgl = mysql_fetch_array($gettgl);
												
												$getbiaya = mysql_query("SELECT id_percepatan,kode_pekerjaan,sub_pekerjaan.kode_sub,nama_sub,jumlah,
																		 durasi_kegiatan, crash_cost, crash_duration
																		 FROM sub_pekerjaan
																		 JOIN jadwal ON (jadwal.id_sub = sub_pekerjaan.id_sub)
																		 JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub)
																		 JOIN pekerjaan ON (pekerjaan.id_pekerjaan = master_sub_pekerjaan.id_pekerjaan)
																		 JOIN percepatan ON (jadwal.id_jadwal = percepatan.id_jadwal)
																		 WHERE sub_pekerjaan.id_proyek = '$id_proyek' order by id_percepatan");
												$biaya_pekerjaan = mysql_fetch_array($getbiaya);
												
											
												$etc1 = (int) $evaluasi['etc'] - 1 ;
												$eac1 = $evaluasi['eac'];
												$tgl_mulai = $tgl['tanggal_mulai'];
												$tgl2 = $tgl['tanggal_selesai'];
												$denda = $tgl['nilai_proyek'] / 1000;
												$terlambat = (int)$evaluasi['etc'] - $tgl['durasi_proyek'];
												$biaya = $tgl['biaya'] * 0.1;
												$np = $tgl['nilai_proyek'];
												$bp = $biaya_pekerjaan['jumlah'];
												$cc = $biaya_pekerjaan['crash_cost'];
												$biaya_percepatan = $cc - $bp; 
											   
												if ($terlambat < 1)
												{
													$tgl_selesai = date('Y-m-d',strtotime($tgl2));
													$total = $np;
													$totaldenda = 0;
													$total_biaya = 0;
													$terlambat = 0;	
												}
												else
												{
													$tgl_selesai = date('Y-m-d',strtotime('+'.$etc1.'days',strtotime($tgl_mulai)));
													$total = $biaya + $eac1;
													$totaldenda = 0;
													$total_biaya = $np + $biaya_percepatan;	
													$terlambat = 0;	
												}	
										 ?>
										  <td><?php echo"<code>  Rp.".number_format($biaya_percepatan,0,',','.')."</code>"?></td>
										  <td><?php echo $terlambat ?></td>
										  <td><?php echo"<code>  Rp.".number_format($totaldenda,0,',','.')."</code>"?></td>
										  <td><?php echo"<code> Rp.".number_format($total_biaya,0,',','.')."</code>"?></td>
										</tr>
									  <?php 
									}
								  ?>
							    </tbody>
						    </table>
					  </div>    
				</div><!-- /.post -->
              </div><!-- /.tab-pane -->
			  
			   <div class="active tab-pane" id="info_proyek">
                <!-- Post -->
                <div class="post">
				<br />
					<div class="box-header with-border">
					</div>
					<!-- /.box-header -->
					<div class="box-body">
							  <div class="box" style="background-color:#f7f5f6">
								<div class="box-header">
								   <form action="?" method="GET">
									   <div class="input-group input-group-sm">
										  <select name="id_proyek" class="form-control select2" style="width: 100%;">
											<option selected="selected">--Pilih Proyek--</option>
											 <?php
												$query = "SELECT * FROM proyek";
												$result = mysql_query($query);
												while($row = mysql_fetch_array($result))
												{		
												  ?>
													  <option <?php if (isset($_GET['id_proyek'])){ if (($row['id_proyek'] == $_GET['id_proyek'])) { echo 'selected'; }} ?> 
													  value="<?php echo $row['id_proyek']; ?>"><?php echo $row['nama_proyek'];  ?></option>
												  <?php 
												}
											  ?>
										  </select>
											  <span class="input-group-btn"><button type="submit" class="btn btn-info btn-flat">Pilih</button></span>
										</div>
									</form>
								  
							      <!--isi konten -->
							    </div>
							   <div class="box-body"><!--isi konten -->
							   <div class="row">
								<!-- Left col -->
																
								  <div class="col-md-4">
								  <!-- Info Boxes Style 2 -->
									<div class="info-box" style="background-color:#fff">
										<div class="info-box-content" style="margin-left:5px">
											 <!-- <i class="fa  fa-user text-orange"> </i> -->
											 <span> Pemilik Proyek</span>
											  <span class="info-box-number">
												  <?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														  echo" $r[pemilik]";
														 
														}
												   }
												  ?>
											  </span>
											  <div class="progress">
												<div class="progress-bar" style="width: 100%"></div>
											  </div>
											  <span class="progress-description">
											   
												 <!-- <i class="fa  fa-map-o text-blue"> </i> -->
												 <span> Lokasi Proyek</span>
											   <span class="info-box-number">
												<code>
												<?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("SELECT * FROM proyek
																			 WHERE id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														  echo"$r[lokasi] <br>";
														 
														}
												   }
												  ?>
												 </code>
											   </span>
											  </span>
											  
											  <div class="progress">
												<div class="progress-bar" style="width: 100%"></div>
											  </div>
											  <span class="progress-description">
											   
												 <!-- <i class="fa  fa-money"> </i> -->
												 <span> Nilai Proyek</span>
											   <span class="info-box-number">
												<?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														 $biaya = number_format($r['nilai_proyek'],2,',','.');
														  echo"Rp. $biaya";
														 
														}
												   }
												  ?>
												  </span>
											  </span>
											  
											  <div class="progress">
												<div class="progress-bar" style="width: 100%"></div>
											  </div>
											  <span class="progress-description">
											   
											   <!-- <i class="fa  fa-list-alt text-red">  -->

												 </i><span> No. SPK</span>
											   <span class="info-box-number">
												<?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														  echo" $r[no_spk]";
														 
														}
												   }
												  ?>
												  </span>
											  </span>
												
									   <!-- /.info-box-content -->
									</div>
									<!-- /.info-box -->
								</div>
								</div>
									  
									  
								   <div class="col-md-3">
									 <!-- MAP & BOX PANE -->
									   <div class="info-box" style="background-color:#fff">
										<div class="info-box-content" style="margin-left:20px">
										   <!-- <i class="fa  fa-calendar text-green"> -->
												  </i><span> Tanggal Mulai</span>
											  <span class="info-box-number">
												  <?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														  echo date ("d/m/Y", strtotime($r['tanggal_mulai'])); 
														}
												   }
												  ?>
											  </span>
											  <div class="progress">
												<div class="progress-bar" style="width: 100%"></div>
											  </div>
											  <span class="progress-description">
											   
											   <!-- <i class="fa  fa-calendar text-green">  -->

												 </i><span> Tanggal Selesai</span>
											   <span class="info-box-number">
												<?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														  echo date ("d/m/Y", strtotime($r['tanggal_selesai']));
														}
												   }
												  ?>
												  </span>
											  </span>
											  
											  <div class="progress">
												<div class="progress-bar" style="width: 100%"></div>
											  </div>
											  <span class="progress-description">
											   
												 <!-- <i class="fa  fa-repeat"> </i> -->
												 <span> Durasi Proyek</span>
											   <span class="info-box-number">
												<?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														  echo" $r[durasi_proyek]"." hari";
														 
														}
												   }
												  ?>
												  </span>
											  </span>
											  
											  <div class="progress">
												<div class="progress-bar" style="width: 100%"></div>
											  </div>
											  <span class="progress-description">
											   
												<!-- <i class="fa fa-pencil-square-o text-red"> </i> -->
												<span> ID Proyek</span>
											   <span class="info-box-number">
												<?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														  echo" $r[id_proyek]";
														 
														}
												   }
												  ?>
												  
												 <br />     
												  &nbsp;
												  </span>
											  </span>
									   </div>
									</div>
								</div>
								
									 
								   <div class="col-md-5">
									 <div class="box box-solid box-default">
									   <div class="box-body">  
											 <!-- <i class="fa fa-pencil-square-o text-navy"> </i> -->
											 <span> Progres Proyek</span>
										   <br />
											  <center>
											   <?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select sum(bobot_aktual) bobot from progres where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														   echo" <h2><b> ".number_format($r['bobot'],2)." % </b></h2>"; 
														}
												   }
												?>
											  </center>
											<div class="progress">
											  <?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													$kegiatan = mysql_query("select sum(bobot_aktual) bobot_a from progres where id_proyek = '$id_proyek'");
													
														while($r=mysql_fetch_array($kegiatan))
														{
														  ?>
															 <div class="progress">
															   <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" 
																 aria-valuemax="100" style="width:<?php echo $r['bobot_a']?>%">
															   </div>
															</div>
														 <?php 
														}
												   }
												?>
											</div>
											<?php
											   
											 if(isset($_GET['id_proyek'])) 
											 { 
												 $id_proyek = $_GET['id_proyek'];
												 $query = mysql_query("select * from evaluasi join progres on evaluasi.id_progres = progres.id_progres 
																	   where progres.id_proyek = '$id_proyek' order by minggu DESC limit 1");
												 $evaluasi= mysql_fetch_array($query);
												 $cv = $evaluasi['cv'];
												 $sv = $evaluasi['sv'];
												 $cpi = $evaluasi['cpi'];
												 $spi = $evaluasi['spi'];
												 $periode = $evaluasi['minggu'];
											  ?>
												
												  <?php
														   if($cv>0 AND $cpi>1)
														   {
															 $penilaiancv = "Lebih rendah dari anggaran";
														   }
														   else if ($cv==0 AND $cpi==1)
														   {
															$penilaiancv = "Pengeluaran = Biaya rencana";
														   }
														   else if ($cv<0 AND $cpi<1)
														   {
															$penilaiancv = "Lebih besar dari anggaran";
														   }
														   else{
															   $penilaiancv = " ";
														   }
										
														   if ($sv>0 AND $spi>1)
														   {
															$penilaiansv = "Pengerjaan lebih cepat dari jadwal rencana";
														   }
														   else if ($sv==0 AND $spi==1)
														   {
															$penilaiansv = "Sesuai jadwal";
														   }
														   else if ($sv<0 AND $spi<1)
														   {
															 $penilaiansv = "Pengerjaan lebih lambat dari jadwal rencana";
														   }
														   else{$penilaiansv = " ";}
													  ?>
												<?php 
												}
												else
												{
												 $periode = " 0";
												 $penilaiancv = "0";
												 $penilaiansv = "0";
												} 
												?>
												
										
												<?php
												   echo "  Pada Minggu Ke- $periode <br>";
												   echo "  Biaya <code>".$penilaiancv."</code><br>";
												   echo "  Waktu <code>".$penilaiansv."</code>";
												?>
												
												<div align="left">
												<br />
												  <!-- <a href="detail_evm.php?id_proyek=<?=$_GET['id_proyek']?>" class="btn bg-orange btn-sm" style="border-radius:40px" ><span class="fa fa-external-link"></span>  Lihat Selengkapnya</a> -->
												</div>
									   </div>			
									 </div>
								   </div>
					
									  <!--akhir isi konten -->  
							  </div>
						   
							
								  <div class="col-md-8">
									 <!-- MAP & BOX PANE -->
									  <div class="box box-danger">
										<!-- /.box-header -->
										<div class="box-body">
										<h4><i class="fa  fa-bar-chart-o"></i><span> Data CPM</span></h4>
										 <div align="right">
										   <a href="gantt-chart.php?id_proyek=<?=$_GET['id_proyek'];?>" class="btn btn-danger btn-fill btn-sm" style="border-radius:40px"> <i class="fa fa-bar-chart-o "></i><span> Gantt Chart</span></a>
										
										   <a href="cpm.php?id_proyek=<?=$_GET['id_proyek']?>" class="btn bg-olive btn-sm" style="border-radius:40px"><span class="fa fa-sitemap"></span>  Diagram Jaringan</a>
										   <a href="detail.php?id_proyek=<?=$_GET['id_proyek']?>" class="btn bg-navy btn-sm" style="border-radius:40px"><span class="fa fa-external-link-square"></span>  Detail CPM</a>  
										 </div>
										
										<?php 
											$link=koneksidb();
											if(isset($_GET['id_proyek'])) 
											{ 
												$id_proyek = $_GET['id_proyek'];
												$query = mysql_query("SELECT * FROM evaluasi JOIN progres ON evaluasi.id_progres = progres.id_progres 
																	  WHERE evaluasi.id_proyek = '$id_proyek' ORDER BY minggu ASC");
												$query2 = mysql_query("SELECT * FROM evaluasi JOIN progres ON evaluasi.id_progres = progres.id_progres
																	   WHERE evaluasi.id_proyek = '$id_proyek' ORDER BY minggu ASC");
												$query3 = mysql_query("SELECT * FROM evaluasi JOIN progres ON evaluasi.id_progres = progres.id_progres 
																	   WHERE evaluasi.id_proyek = '$id_proyek' ORDER BY minggu ASC");
												$query4 = mysql_query("SELECT * FROM evaluasi JOIN progres ON evaluasi.id_progres = progres.id_progres 
																	   WHERE evaluasi.id_proyek = '$id_proyek' ORDER BY minggu ASC");
											}
										?>
										<!-- <div id="echart_line" style="height:400%; width:auto; margin:0 auto; max-width:100%"></div>
										<script>
										  var theme = {
											  color: [
												  '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
												  '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
											  ],
									
											  title: {
												  itemGap: 8,
												  textStyle: {
													  fontWeight: 'normal',
													  color: '#408829'
												  }
											  },
									
											  dataRange: {
												  color: ['#1f610a', '#97b58d']
											  },
									
											  toolbox: {
												  color: ['#408829', '#408829', '#408829', '#408829']
											  },
									
											  tooltip: {
												  backgroundColor: 'rgba(0,0,0,0.5)',
												  axisPointer: {
													  type: 'line',
													  lineStyle: {
														  color: '#408829',
														  type: 'dashed'
													  },
													  crossStyle: {
														  color: '#408829'
													  },
													  shadowStyle: {
														  color: 'rgba(200,200,200,0.3)'
													  }
												  }
											  },
									
											  dataZoom: {
												  dataBackgroundColor: '#eee',
												  fillerColor: 'rgba(64,136,41,0.2)',
												  handleColor: '#408829'
											  },
											  grid: {
												  borderWidth: 0
											  },
									
											  categoryAxis: {
												  axisLine: {
													  lineStyle: {
														  color: '#408829'
													  }
												  },
												  splitLine: {
													  lineStyle: {
														  color: ['#eee']
													  }
												  }
											  },
									
											  valueAxis: {
												  axisLine: {
													  lineStyle: {
														  color: '#408829'
													  }
												  },
												  splitArea: {
													  show: true,
													  areaStyle: {
														  color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
													  }
												  },
												  splitLine: {
													  lineStyle: {
														  color: ['#eee']
													  }
												  }
											  },
											  timeline: {
												  lineStyle: {
													  color: '#408829'
												  },
												  controlStyle: {
													  normal: {color: '#408829'},
													  emphasis: {color: '#408829'}
												  }
											  },
									
											  k: {
												  itemStyle: {
													  normal: {
														  color: '#68a54a',
														  color0: '#a9cba2',
														  lineStyle: {
															  width: 1,
															  color: '#408829',
															  color0: '#86b379'
														  }
													  }
												  }
											  },
											  textStyle: {
												  fontFamily: 'Arial, Verdana, sans-serif'
											  }
										  };
										  
										  var echartLine = echarts.init(document.getElementById('echart_line'), theme);
									
										  echartLine.setOption({
											title: {
											
											  subtext: 'Total Pengeluaran'
											},
											tooltip: {
											  trigger: 'axis'
											},
											legend: {
											  x: 220,
											  y: 40,
											  data: ['Biaya Rencana (PV) (Rp.)', 'Earned Value (EV) (Rp.)','Biaya Aktual (AC) (Rp.)']
											},toolbox: {
											  show: true
											},
											calculable: true,
											xAxis: [{
											  type: 'category',
											  boundaryGap: false,
											  data: [
											  <?php 
													while ($rencana = mysql_fetch_array($query)) {
														echo '"Minggu ke-'.$rencana['minggu'].'",';   
													}
												?>
											  ]
											}],
											yAxis: [{
											  type: 'value'
											}],
											series: [{
											  name: 'Biaya Rencana (PV) (Rp.)',
											  type: 'line',
											  smooth: true,
											  itemStyle: {
												normal: {
												  areaStyle: {
													type: 'default'
												  }
												}
											  },
											  data: [
											  <?php 
													while ($rencana2 = mysql_fetch_array($query2)) {
															$pv = round($rencana2['pv_komulatif'],-2);
															echo $pv.',';            
												} ?>
											  ]
											}, {
											  name: 'Earned Value (EV) (Rp.)',
											  type: 'line',
											  smooth: true,
											  itemStyle: {
												normal: {
												  areaStyle: {
													type: 'default'
												  }
												}
											  },
											  data: [
											  <?php 
													while ($rencana3 = mysql_fetch_array($query3)) {
														$ev = round($rencana3['ev_komulatif'],-2);
														echo $ev.',';            
													}
												?>
											  ]
											}, {
											  name: 'Biaya Aktual (AC) (Rp.)',
											  type: 'line',
											  smooth: true,
											  itemStyle: {
												normal: {
												  areaStyle: {
													type: 'default'
												  }
												}
											  },
											  data: [
											  <?php 
												   while ($rencana4 = mysql_fetch_array($query4)) {
														$ac = round($rencana4['ac_komulatif'],-2);
														echo $ac.',';            
													}
												?>
											  ]
											}]
										  });
										</script> -->
										
										 <div class="col-md-12">
											  <div class="box collapsed-box">
												<div class="box-header with-border">
												  <h4>Keterangan:</h4>
												  <div class="box-tools pull-right">
													<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
													</button>
												  </div>
												  <!-- /.box-tools -->
												</div>
												<!-- /.box-header -->
												<div class="box-body" style="display: none;">
													 <?php 
														if(isset($_GET['id_proyek'])) 
														{ 
														  $id = $_GET['id_proyek'];
														  $sql_nilai = mysql_query("SELECT * FROM evaluasi 
																					JOIN progres ON evaluasi.id_progres = progres.id_progres
																					WHERE evaluasi.id_proyek = '$id'");
														
														
															while ($row_nilai = mysql_fetch_array($sql_nilai))
															{ 
																
															  $pk = round($row_nilai['pv_komulatif']);
															  $ek = round($row_nilai['ev_komulatif']);
															  $ak = round($row_nilai['ac_komulatif']);
															  $spi = $row_nilai['spi'];
															  
															  if ($ak < $pk)
															  {
																$nilai_keterangan = " Biaya realisasi proyek lebih kecil dari biaya rencana, dan ";
															  }
															  else if ($ak == $pk)
															  {
																$nilai_keterangan = "Biaya realisasi proyek sama dengan biaya rencana, dan ";
															  }
															  else
															  {
																$nilai_keterangan = " Biaya realisasi proyek lebih besar dari biaya rencana, dan ";
															  }
															  
															  if ($spi>1)
															  {
																$penilaiansv = "kinerja proyek baik";
															  }
															  else if ($spi==1)
															  {
																$penilaiansv = "kinerja proyek baik";
															  }
															  else if ($spi<1)
															  {
																 $penilaiansv = "kinerja proyek buruk";
															  }
															   else{$penilaiansv = " ";}
													   ?>
															
															<i class="fa  fa-circle-o"><b><?php echo "  Pada Minggu Ke- $row_nilai[minggu]"?></b></i>
															<?php 
															 if ($spi < 1)
															  {
															 ?> 
																<code><?php echo $nilai_keterangan ?><?php echo $penilaiansv ?><br></code>
															 <?php 
															 }
															 else
															 {
															 ?>
																<?php echo $nilai_keterangan ?><?php echo $penilaiansv ?><br>
															 
															 <?php
															  }
															 ?>  
															
													   <?php
														}
													   }
													 ?>
												</div><!-- /.box-body -->
											 </div><!-- /.box -->
										   </div>
										</div>
									</div>
								 </div>
								 
								 <div class="col-md-4">
									 <!-- MAP & BOX PANE -->
									  <div class="box box-primary" style="background-color:#ffff">
										<!-- /.box-header -->
										   <div class="box-header">
											   <i class="fa fa-pencil-square-o"></i> Keterangan
										   </div>
										<div class="box-body">
										<?php
										if(isset($_GET['id_proyek'])) 
										{ 
										   $id_proyek = $_GET['id_proyek'];
										   $cek = mysql_query("select max(ef) as jumlah from jadwal where id_proyek ='$id_proyek'");
										   $jalur = mysql_fetch_array($cek);
										   $cpm = $jalur['jumlah'];
										 
										}else
										{
										   $cpm = " ";
										}
										?>
										
									  <div class="col-lg-12">
										 <!-- small box -->
											  <div class="small-box" style="background-color:#339999">
												<div class="inner">
												  <p>Jumlah Durasi Jalur Kritis</p>
												  <p><h3><?php echo "$cpm" ?> Hari</h3></p>
												</div>
												<div class="icon">
												  <i class="ion ion-stats-bars"></i>
												</div>
											 </div>
									  </div>
										
										<div class="col-lg-12">
										   <!-- small box -->
											  <div class="small-box " style="background-color:#CC9999">
												<div class="inner">
												  <p><h4>Pekerjaan Kritis</h4></p>
												  <?php
														if(isset($_GET['id_proyek'])) 
														{ 
														   $id_proyek = $_GET['id_proyek'];
														   $cek2 = mysql_query("select nama_sub from jadwal 
																			   join sub_pekerjaan on jadwal.id_sub = sub_pekerjaan.id_sub
																			   join master_sub_pekerjaan on master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub
																			   where jadwal.id_proyek ='$id_proyek' and jadwal.sl =0");
														   
															
														  while($nama = mysql_fetch_array($cek2))
														  {
															  $kegiatan = $nama['nama_sub'];
												   ?>  
																<i class="fa  fa-check-square-o"> </i> <b><?php echo $kegiatan ?></b><br>
												  <?php  
														  }
														}
												  ?>
													   
												</div>
												<div class="icon">
												  <i class="ion ion-stats-bars"></i>
												</div>
										  </div>
										</div>	
												
										<!-- <div class="col-lg-12">
										  <div class="small-box" style="background-color:#FF6666">
											<div class="inner">
											 <?php
												if(isset($_GET['id_proyek'])) 
												{ 
												   $id_proyek = $_GET['id_proyek'];
												   $cek3 = mysql_query("SELECT eac FROM evaluasi JOIN progres on evaluasi.id_progres = progres.id_progres
																		WHERE evaluasi.id_proyek ='$id_proyek' order by minggu desc limit 1");
																		
												   $total_biaya = mysql_query("SELECT biaya FROM proyek WHERE id_proyek = '$id_proyek' ");
												   $row = mysql_fetch_array($total_biaya);
												   $ppn = ($row['biaya'] * 0.1);
												   
													
												   while($r = mysql_fetch_array($cek3))
												   {
													  $eac = number_format($r['eac'],2,',','.');
													  $total = $eac + $ppn;
													  $biaya = number_format($total,2,',','.');
														  
												   ?>  
														
														<h3><b><?php echo"Rp. $eac"?></b></h3>
												 <?php  
													}
												}
											 ?>
									
											 <p>Estimate At Completion (EAC)</p>
											 
											</div>
											<div class="icon">
											  <i class="ion ion-pie-graph"></i>
											</div>
										 </div>
										</div>	 -->
										
										<!-- <div class="col-lg-12">
										  <div class="small-box" style="background-color:#CCFFCC">
											<div class="inner">
											  <?php
												if(isset($_GET['id_proyek'])) 
												{ 
												   $id_proyek = $_GET['id_proyek'];
												   $cek3 = mysql_query("select etc from evaluasi join progres on evaluasi.id_progres = progres.id_progres
																		where evaluasi.id_proyek ='$id_proyek' order by minggu desc limit 1");
													
												   while($r = mysql_fetch_array($cek3))
												   {
													  $waktu = number_format($r['etc'],0,',','.');
														  
												   ?>  
														
														<h3><b><?php echo"$waktu Hari"?></b></h3>
												 <?php  
													}
												}
											 ?>
											  <p>Estimate Time Completion (ETC)</p>
											</div>
											<div class="icon">
											  <i class="ion ion-pie-graph"></i>
											</div>
										 </div>
										</div> -->
									   </div>
									</div>
								  </div>
								  
								  <div class="col-md-12">
								  <!-- Info Boxes Style 2 -->
									 <div class="box box-info">
									 <!-- /.box-header -->
										<div class="box-body">
										<h4><i class="fa fa-sort-amount-asc"></i><span> Jadwal Pekerjaan</span></h4> <br />
										   <table id="tabel1" class="table table-bordered">
											 <thead>
											  <tr>
												<td width="10%"><b>No</b></td>
												<td width="25%"><b>Nama Pekerjaan</b></td>
												<td width="10%"><b>Durasi</b></td> 
												<td width="10%"><b>Tanggal Mulai</b></td> 
												<td width="10%"><b>Tanggal Selesai</b></td>
												<td width="20%"><i><b>Predecessor</b></i></td>
												<td width="15%"><b>Progres Pekerjaan</b></td>
											</tr>
											</thead>
											<tbody>
											   <?php
												if(isset($_GET['id_proyek'])) 
												{ 
													   $id_proyek = $_GET['id_proyek'];
													  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
													  
													  $sql = mysql_query("select * from pekerjaan join proyek on pekerjaan.id_jenis = proyek.id_jenis where id_proyek ='$id_proyek' order by kode_pekerjaan");	  
													  while($r = mysql_fetch_array($sql))
													  {
													 ?>	
													 <tr>	
														 <td>
															<dd><b><?php echo Romawi($r['kode_pekerjaan']) ?></b></dd>
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
														
															$sql2 = mysql_query ("SELECT kode_pekerjaan,kode_sub,nama_sub,id_master_sub
																				  FROM `master_sub_pekerjaan`
																				  JOIN pekerjaan 
																				  ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
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
																		   
																		   $id = $s['id_master_sub'];
																		  
																		   $sub = "SELECT id_jadwal FROM jadwal
																				   JOIN sub_pekerjaan ON sub_pekerjaan.id_sub = jadwal.id_sub
																				   JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub
																				   WHERE sub_pekerjaan.id_master_sub = '$id' AND jadwal.id_proyek = '$id_proyek'";
																				   
																		   $res= mysql_query($sub);
																		 ?>
																		 
																		  <table border="1" > 
																			<?php
																			   while($detail=mysql_fetch_array($res))
																			   {
																					?>
																					<tr> 
																					   <?php 
																						  $id = $detail['id_jadwal'];
																						  $sql4 = mysql_query ("SELECT * from jadwal where id_jadwal = '$id'")or die(mysql_error());
																						  $s4=mysql_fetch_array($sql4);
																						?>
																						 <?php echo $s4['durasi_kegiatan']." hari"?>
																						 
																					</tr>
																		   <?php  }?>
																		 </table>     
																	 </td>
																	  <td>
																		<?php
																		   $id = $s['id_master_sub'];
																		   $sub2 = "SELECT id_jadwal FROM jadwal
																				   JOIN sub_pekerjaan ON sub_pekerjaan.id_sub = jadwal.id_sub
																				   JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub
																				   WHERE sub_pekerjaan.id_master_sub = '$id' AND jadwal.id_proyek = '$id_proyek'";
																		   $res2= mysql_query($sub2);
																		 ?>
																		 
																		  <table border="1" > 
																			<?php
																			   while($detail2=mysql_fetch_array($res2))
																			   {
																					?>
																					<tr> 
																					   <?php 
																						  $id = $detail2['id_jadwal'];
																						  $sql5 = mysql_query ("SELECT * from jadwal where id_jadwal = '$id'")or die(mysql_error());
																						  $s5=mysql_fetch_array($sql5);
																						?>
																						  <?php echo date('d/m/Y',strtotime($s5['tanggal_mulai_j']))?>
																						 
																					</tr>
																		   <?php  }?>
																		 </table>     
																	 </td>
																	 
																	 <td>
																	   <?php
																		   $id = $s['id_master_sub'];
																		  
																		   $sub3 = "SELECT id_jadwal FROM jadwal
																				   JOIN sub_pekerjaan ON sub_pekerjaan.id_sub = jadwal.id_sub
																				   JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub
																				   WHERE sub_pekerjaan.id_master_sub = '$id' AND jadwal.id_proyek = '$id_proyek'";
																		   $res3= mysql_query($sub3);
																		 ?>
																		 
																		  <table border="1" > 
																			<?php
																			   while($detail3=mysql_fetch_array($res3))
																			   {
																					?>
																					<tr> 
																					   <?php 
																						  $id = $detail3['id_jadwal'];
																						  $sql6 = mysql_query ("SELECT * from jadwal where id_jadwal = '$id'")or die(mysql_error());
																						  $s6=mysql_fetch_array($sql6);
																						?>
																							<?php echo date('d/m/Y',strtotime($s6['tanggal_selesai_j']))?>
																						 
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
																				   $subpek = "SELECT * from pendahulu Where id_sub = '$id'";
																				   $resub= mysql_query($subpek);
																				  ?>
																				  
																					<?php
																					   while($idpek=mysql_fetch_array($resub))
																					   {
																							?>
																							
																							   <?php 
																								  $id = $idpek['id_pek_pendahulu'];
																								  $sql4 = mysql_query("SELECT * from sub_pekerjaan
																													   JOIN master_sub_pekerjaan
																													   ON master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub
																													   JOIN pekerjaan 
																													   ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
																													   WHERE sub_pekerjaan.id_sub = '$id'")or die(mysql_error());
																								  $s4=mysql_fetch_array($sql4);
																								?>
																								<i>
																								
																								<?php echo $s4['nama_sub']?><br />
																							   </i>
																				   <?php  }?>
																				<?php 
																				}
																			}
																		?>
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
									   <!-- /.-box -->
									</div>
								</div>	 
							 </div>
						  </div>
				     </div>
                 </div><!-- /.post -->
              </div><!-- /.tab-pane -->
			</div>
	  </div>
  </section>
</div><!-- /.content-wrapper -->