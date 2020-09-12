<?php
include "header.php";
include "fungsi_romawi.php";
$link=koneksidb();
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-building"></i>Percepatan</a></li>
      </ol>
  </section>
  <section class="content-header">
  </section>
  
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
		  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#lihat_kegiatan" data-toggle="tab">Percepatan</a></li>
            </ul>
			
			<div class="tab-content">		  
			   <div class="active tab-pane" id="lihat_kegiatan">
                <!-- Post -->
                <div class="post">
				<br />
				 
				  <?php
					if(isset($_GET['id_proyek'])) 
				   { 
						$id_proyek = $_GET['id_proyek'];
							$proyek = mysql_query("SELECT * FROM proyek
												    
												   WHERE id_proyek = '$id_proyek'");
							
							
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
									  <div><i class="fa fa-map-o text-green"></i> Lokasi : <?php echo " $r[lokasi]" ?></div><p>
									</b></h5>
							<?php
						}
				  }
				  ?>
				
				<br />
					<div class="box-header with-border">
					  <h2 class="box-title">Data Pekerjaan Yang Terlambat</h2>
					</div>
				   <br />
					<!-- /.box-header -->
					<div class="box-body">
					 <?php
					  $id_proyek = $_GET['id_proyek'];
					  $sub_pekerjaan = mysql_query("SELECT sub_pekerjaan.id_proyek,id_jadwal,sub_pekerjaan.id_sub,kode_pekerjaan,sub_pekerjaan.kode_sub,nama_sub,jumlah,volume,
													durasi_kegiatan,satuan,bobot,SUM(bobot_realisasi) AS bobot_r
					  								FROM sub_pekerjaan
					                                JOIN master_sub_pekerjaan ON (sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub)
                                                    JOIN jadwal ON (jadwal.id_sub = sub_pekerjaan.id_sub)
					                                JOIN pekerjaan ON (pekerjaan.id_pekerjaan = master_sub_pekerjaan.id_pekerjaan)
													JOIN detail_progres ON (sub_pekerjaan.id_sub = detail_progres.id_sub)
													WHERE sub_pekerjaan.id_proyek = '$id_proyek' and bobot_realisasi < bobot and sl = 0 GROUP BY detail_progres.id_sub");
				      ?>
			
						<!-- /.box-header -->
						<div class="box-body">
						  <div class="pull-right">
							<a href="index.php?id_proyek=<?php echo $_GET['id_proyek']; ?>"
							class="btn btn-info btn-fill btn-sm" style="margin-bottom: 10px; margin-top: -30px;"> <i class="fa  fa-reply "></i> <span>Kembali</span></a>                          </div>
				            <table id="tabel1" class="table table-bordered table-striped">
					          <thead>
								<tr>
								  <th>Kode Pekerjaan</th>
								  <th>Nama Pekerjaan</th>
								  <th>Biaya Pekerjaan</th>
								  <th>Volume Pekerjaan</th>
								  <th>Durasi Pekerjaan</th>
								  <th>Bobot Rencana</th>
								  <th>Bobot Realisasi</th>
								  <th width="200"> Aksi</th>
								</tr>
							  </thead>
							  <tbody>
							  <?php
			
								$no=0;
								while($r=mysql_fetch_array($sub_pekerjaan)){
								  $n=1;
								  $no=$no+$n;
								  echo"
									<tr>
									  <td>".Romawi($r['kode_pekerjaan']).".".$r['kode_sub']."</td>
									  <td>$r[nama_sub]</td>
									  <td>".number_format($r['jumlah'],2,',','.')."</td>
									  <td>".number_format($r['volume'],2,',','.')." ".$r['satuan']."</td>
									  <td>$r[durasi_kegiatan]</td>
									  <td>".number_format($r['bobot'],3,',','.')."</td>
									  <td>".number_format($r['bobot_r'],3,',','.')."</td>
									  <td>";
									  ?>
									  
									   <?php
									      $query = mysql_query("SELECT id_jadwal from percepatan");
										  $cek = mysql_fetch_array($query);
										?>
										
										<?php
									       if ($r['id_jadwal'] != $cek['id_jadwal'])
										   {
										    ?>
											 <a href='fungsi.php?proses_tambah_percepatan&id_proyek=<?=$r['id_proyek']?>&id_jadwal=<?=$r['id_jadwal']?>&id_sub=<?=$r['id_sub']?>'
									         class='btn btn-danger btn-fill btn-sm' >Percepat Pekerjaan</a>
										    <?php
										   }
										   else
										   {
										     ?>  
											  <a>Sudah dipercepat</a>
										    <?php
									  	   }
										  ?>
									 </tr>
								  <?php
								  }
								 ?>
							  </tbody>
                           </table>
						   </div>
						   
					<?php
					  $id_proyek = $_GET['id_proyek'];
					  $sub_pekerjaan = mysql_query("SELECT kode_pekerjaan,sub_pekerjaan.kode_sub,nama_sub,harga_satuan,jumlah,
													durasi_kegiatan, crash_cost, crash_duration
					  								FROM sub_pekerjaan
                                                    JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub)
					                                JOIN jadwal ON (jadwal.id_sub = sub_pekerjaan.id_sub)
					                                JOIN pekerjaan ON (pekerjaan.id_pekerjaan = master_sub_pekerjaan.id_pekerjaan)
													JOIN percepatan ON (jadwal.id_jadwal = percepatan.id_jadwal)
													WHERE sub_pekerjaan.id_proyek = '$id_proyek' order by id_percepatan");
				      ?>
			
						<!-- /.box-header -->
						<div class="box-body">
						 <div class="divider"></div>
						 <h4>Pekerjaan Yang Telah Dipercepat</h4>
						  <table id="tabel2" class="table table-bordered table-striped">
					          <thead>
								<tr>
								  <th>Kode Pekerjaan</th>
								  <th>Nama Pekerjaan</th>
								  <th>Biaya Pekerjaan (Normal)</th>
								  <th>Durasi Pekerjaan (Normal)</th>
								  <th>Biaya Pekerjaan (Dipercepat)</th>
								  <th>Durasi Pekerjaan (Dipercepat)</th>
								</tr>
							  </thead>
							  <tbody>
							  <?php
			
								$no=0;
								while($r=mysql_fetch_array($sub_pekerjaan)){
								  $n=1;
								  $no=$no+$n;
								  echo"
									<tr>
									  <td>".Romawi($r['kode_pekerjaan']).".".$r['kode_sub']."</td>
									  <td>$r[nama_sub]</td>
									  <td>".number_format($r['jumlah'],2,',','.')."</td>
									  <td>$r[durasi_kegiatan]</td>
									  <td>".number_format($r['crash_cost'],2,',','.')."</td>
									  <td>$r[crash_duration]</td>
									  ";
									  ?>
								   </tr>
								  <?php
								  }
								 ?>
							  </tbody>
                           </table>
				    </div>
			       </div>
                </div>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
			  </div>
            <!-- /.tab-content -->
		 </div>
       </div>
       </div>
        </section>
      </div>
  	
		  <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Konfirmasi Hapus</h4>
			  </div>
			  <div class="modal-body">
				<p>Anda yakin ingin menghapus data ini?</p>
			  </div>
			  
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				<a href="#" id="delete_link" class="btn btn-primary">Hapus </a>
			  </div>
			</div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


<?php
include "footer.php";
?>