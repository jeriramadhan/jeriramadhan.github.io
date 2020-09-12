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
		  <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Data Percepatan</h3>
			  
			   <div class="form-group">
			   <br />
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
								  value="<?php echo $row['id_proyek']; ?>"> <?php echo $row['nama_proyek'];  ?></option>
							  <?php 
							}
						  ?>
					  </select>
					  <span class="input-group-btn">
						  <button type="submit" class="btn btn-info btn-flat">Pilih</button>
					  </span>
					</div>
					</form>
              </div>
            </div><!-- /.box-header -->
			
		 <div class="box-body">
			<div class="tab-content">		  
					<div class="box-header with-border">
					  <h2 class="box-title">Data Pekerjaan</h2>
					</div>
				   <br />
					<!-- /.box-header -->
					<div class="box-body">
					 <?php
					  if (isset($_GET['id_proyek']))
					  { 
					  $id_proyek = $_GET['id_proyek'];
					  $sub_pekerjaan = mysql_query("SELECT sub_pekerjaan.id_proyek,id_jadwal,sub_pekerjaan.id_sub,kode_pekerjaan,sub_pekerjaan.kode_sub,nama_sub,jumlah,
													durasi_kegiatan
					  								FROM sub_pekerjaan
					                                JOIN jadwal ON (jadwal.id_sub = sub_pekerjaan.id_sub)
													JOIN master_sub_pekerjaan ON (sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub)
					                                JOIN pekerjaan ON (pekerjaan.id_pekerjaan = master_sub_pekerjaan.id_pekerjaan)
													WHERE sub_pekerjaan.id_proyek = '$id_proyek' AND sl = 0 AND kode_pekerjaan > 1");
				     
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
								  <th>Durasi Pekerjaan</th>
								  <th width="200"> Aksi</th>
								</tr>
							  </thead>
							  <tbody>
							  <?php
			
								$no=0;
								while($r=mysql_fetch_array($sub_pekerjaan))
								{
								  $n=1;
								  $no=$no+$n;
								  echo"
									<tr>
									  <td>".Romawi($r['kode_pekerjaan']).".".$r['kode_sub']."</td>
									  <td>$r[nama_sub]</td>
									  <td>Rp. ".number_format($r['jumlah'],2,',','.')."</td>
									  <td>$r[durasi_kegiatan] Hari</td>
									  <td>";
									  ?>
									  
									   <?php
									      $id = $r['id_jadwal']; 
									      $query = mysql_query("SELECT id_jadwal from percepatan where id_jadwal = '$id'");
										  $cek = mysql_fetch_array($query);
										?>
										
										<?php
									       if ($r['id_jadwal'] != $cek['id_jadwal'])
										   {
										    ?>
											 <a href='fungsi.php?proses_tambah_percepatan&id_proyek=<?=$r['id_proyek']?>&id_jadwal=<?=$r['id_jadwal']?>&id_sub=<?=$r['id_sub']?>'
									         class='btn btn-warning btn-fill btn-sm' >Percepat Pekerjaan</a>
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
							    }
								 ?>
							  </tbody>
                           </table>
						   </div>
						   
					<?php
					if (isset($_GET['id_proyek']))
					{
					  $id_proyek = $_GET['id_proyek'];
					  $sub_pekerjaan = mysql_query("SELECT id_percepatan,kode_pekerjaan,sub_pekerjaan.kode_sub,nama_sub,jumlah,
													durasi_kegiatan, crash_cost, crash_duration
					  								FROM sub_pekerjaan
					                                JOIN jadwal ON (jadwal.id_sub = sub_pekerjaan.id_sub)
					                                JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub)
													JOIN pekerjaan ON (pekerjaan.id_pekerjaan = master_sub_pekerjaan.id_pekerjaan)
													JOIN percepatan ON (jadwal.id_jadwal = percepatan.id_jadwal)
													WHERE sub_pekerjaan.id_proyek = '$id_proyek' order by id_percepatan");
				      ?>
			
						<!-- /.box-header -->
						<div class="box-body">
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
								  <th>Penambahan Biaya Perhari</th>
								  <th>Aksi</th>
								</tr>
							  </thead>
							  <tbody>
							  <?php
			
								$no=0;
								while($r=mysql_fetch_array($sub_pekerjaan))
								{
									$cost_slope = ($r['crash_cost'] - $r['jumlah']) / ($r['durasi_kegiatan'] - $r['crash_duration']);
								
								  $n=1;
								  $no=$no+$n;
								  echo"
									<tr>
									  <td>".Romawi($r['kode_pekerjaan']).".".$r['kode_sub']."</td>
									  <td>$r[nama_sub]</td>
									  <td>Rp. ".number_format($r['jumlah'],2,',','.')."</td>
									  <td>$r[durasi_kegiatan] Hari</td>
									  <td>Rp. ".number_format($r['crash_cost'],2,',','.')."</td>
									  <td>$r[crash_duration] Hari</td>
									  <td>Rp. ".number_format($cost_slope,2,',','.')."</td>
									  ";
									  ?>
									  <td>
                              			  <a href="fungsi.php?proses_hapus=hapus_percepatan&id_proyek=<?=$_GET['id_proyek']?>&id_percepatan=<?=$r['id_percepatan']?>" class="btn btn-danger btn-fill btn-sm" >Hapus</a>
                              		  </td>
								   </tr>
								  <?php
								  }
					           }
						   ?>
							  </tbody>
                           </table>
				    </div>
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