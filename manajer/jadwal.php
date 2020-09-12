<?php
include "header.php";
include "fungsi_romawi.php";
  $link=koneksidb();
  $id=$_GET['id_proyek'];
  $getpekerjaan = mysql_query("SELECT id_sub,kode_pekerjaan,sub_pekerjaan.kode_sub,nama_sub 
  							   FROM master_sub_pekerjaan
							   JOIN pekerjaan
							   ON (pekerjaan.id_pekerjaan=master_sub_pekerjaan.id_pekerjaan)
							   JOIN sub_pekerjaan
							   ON (sub_pekerjaan.id_master_sub=master_sub_pekerjaan.id_master_sub)
							   WHERE sub_pekerjaan.id_proyek ='$id' AND sub_pekerjaan.id_sub NOT IN (SELECT id_sub FROM jadwal WHERE id_proyek = '$id')");

  $getpekerjaan1 = mysql_query("SELECT * FROM master_sub_pekerjaan
								JOIN pekerjaan
								ON (pekerjaan.id_pekerjaan=master_sub_pekerjaan.id_pekerjaan)
								JOIN sub_pekerjaan
							    ON (sub_pekerjaan.id_master_sub=master_sub_pekerjaan.id_master_sub)
								WHERE sub_pekerjaan.id_proyek ='$id'");

  $getproyek = mysql_query("SELECT tanggal_selesai,tanggal_mulai FROM proyek WHERE id_proyek = '$id' ");
  $p = mysql_fetch_array($getproyek);
  $tgl_mulai = date('m/d/Y',strtotime($p['tanggal_mulai']));
  $tgl_selesai = date('m/d/Y',strtotime($p['tanggal_selesai']));
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-building"></i>Jadwal</a></li>
      </ol>
  </section>
  <section class="content-header">
    <?php

    if (isset($_GET['pesan']))
    {
        $pesan = $_GET['pesan'];
      if ($pesan == 'sukses') 
      { ?>
        <br />
          <div class="alert alert-success alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Data Berhasil Disimpan...
          </div>

<?php }elseif ($pesan == 'gagal') 
      { ?>
	  <br />
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Data Gagal Disimpan...
          </div>           
<?php }
    }
    else if (isset($_GET['hapus']))
    {
        $pesan = $_GET['hapus'];
      if ($pesan == 'sukses') 
      { ?>
        <br />
          <div class="alert alert-success alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Data Berhasil Dihapus...
          </div>

<?php }
    }
    elseif (isset($_GET['edit']))
    {
        $pesan = $_GET['edit'];
      if ($pesan == 'sukses') 
      { ?>
        <br />
          <div class="alert alert-warning alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Data Berhasil Ubah...
          </div>

<?php }
      elseif ($pesan == 'gagal') 
      { ?>
	  <br />
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Data gagal Diubah...
          </div>
<?php }
    }
    ?>

  </section>
  
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
		   <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Data Jadwal</h3>
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

              </div>
            </div><!-- /.box-header -->
		 <div class="box-body">
			<br /> 
		  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#lihat_kegiatan" data-toggle="tab">Lihat Jadwal</a></li>
              <li><a href="#tambah_kegiatan" data-toggle="tab">Tambah Jadwal</a></li>
            </ul>
			
			<div class="tab-content">
              <div class="tab-pane" id="tambah_kegiatan">
                <!-- Post -->
                <div class="post">
                    <br />				
						<!-- form start -->
						<div class="box-body">
						 <h4> Tambah Jadwal</h4>
						<!-- form start -->
						  <form role="form" action="fungsi.php?proses_tambah_j=tambah_jadwal" method="POST" class="form-horizontal">
						  <div class="box-body">
						  <input type="hidden" class="form-control" name="id_proyek" value="<?=$_GET['id_proyek'] ?>">
							<div class="form-group">
							  <label class="col-sm-3 control-label">Nama Pekerjaan : </label>
							  <div class="col-sm-4">
								<select class="form-control select2" style="width: 100%;" name="id_sub">
								  <?php while ($row=mysql_fetch_array($getpekerjaan)) { ?>
								  <option value="<?php echo $row['id_sub']; ?>"> <?php echo Romawi($row['kode_pekerjaan']).'.'.$row['kode_sub'].' - '.$row['nama_sub'];  ?></option>
								  <?php } ?>
								</select>
							  </div>
						   </div>
							<div class="form-group">
							  <label class="col-sm-3 control-label">Tanggal Mulai Pekerjaan : </label>
							  <div class="col-sm-2">
								<div class="input-group date">
								  <div class="input-group-addon">
									<i class="fa fa-calendar"></i>
								  </div>
									<input type="text" class="form-control pull-right" id="tanggal_mulai" name="tanggal_mulai_j" required>
								  </div>
								</div>
							</div>
							<div class="form-group">
							  <label class="col-sm-3 control-label">Durasi Pekerjaan : </label>
							  <div class="col-sm-2">
								<div class="input-group">
								  <input type="text" minlength="1" maxlength="3" class="form-control" name="durasi_kegiatan" onkeyup="this.value=this.value.replace(/[^\\0-9\\]/g, '')" required>
								  <span class="input-group-addon">Hari</span>
								</div>  
							  </div>
							</div>
							<div class="form-group">
							  <label class="col-sm-3 control-label">Pekerjaan Pendahulu : </label>
							  <div class="col-sm-6">
								  <select class="form-control select2" multiple="multiple" data-placeholder="--Pilih Pekerjaan--" style="width: 100%;" name="id_pek_pendahulu[]">
								  <option value="TIDAK">Tidak ada Pendahulu</option>
								  <?php while ($r=mysql_fetch_array($getpekerjaan1)) { ?>
								  <option value="<?php echo $r['id_sub']; ?>"> <?php echo Romawi($r['kode_pekerjaan']).'.'.$r['kode_sub'].' - '.$r['nama_sub'];  ?></option>
								  <?php } ?>
								  <option value=""></option>
								  </select>
								</div>  
							  </div>
							</div>
						   </div>
						  <!-- /.box-body -->
			
						  <div class="box-footer">
							<div align="right">
							  <input type="submit" value="Simpan" class="btn btn-warning btn-fill btn-wd"></input>
							  <input type="reset" value="Reset" class="btn btn-danger btn-fill btn-wd"></input>
							 </div>
						 </div>
						</form>
                 </div>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
			  
			   <div class="active tab-pane" id="lihat_kegiatan">
                <!-- Post -->
                <div class="post">
				<br />
					<div class="box-header with-border">
					  <h2 class="box-title">Data Jadwal</h2>
					</div>
				
					<!-- /.box-header -->
					<div class="box-body">
					   <br />
						   <div class="pull-right">
								<botton class="btn btn-danger btn-fill btn-wd btn-sm" style="margin-bottom: 10px; margin-top: -30px;"
								 data-toggle="modal" data-target="#myModal"
								 data-whatever="fungsi.php?proses_reset_jadwal=reset_jadwal&id_proyek=<?=$_GET['id_proyek']?>">Reset Jadwal</botton>
							</div>
					   <table id="tabel1" class="table table-bordered table-striped">
						<thead>
								  
								<tr>
								  <th>No</th>
								  <th>Nama Pekerjaan</th>
								  <th>Tanggal Mulai</th>
								  <th>Tanggal Selesai</th>
								  <th>Durasi Kegiatan</th>
								  <th> Aksi</th>
								</tr>
							  </thead>
							  <tbody>
							  <?php					        
								 if(isset($_GET['id_proyek']))
								 { 
									$id_proyek = $_GET['id_proyek'];
									$jadwal = mysql_query("SELECT jadwal.id_proyek,jadwal.id_sub,nama_sub,id_jadwal,tanggal_mulai_j,tanggal_selesai_j,durasi_kegiatan
														   FROM jadwal
														   JOIN sub_pekerjaan ON (sub_pekerjaan.id_sub=jadwal.id_sub)
														   JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub=sub_pekerjaan.id_master_sub)
														   WHERE jadwal.id_proyek='$id_proyek'");
			
									$no=0;
									while($r=mysql_fetch_array($jadwal)){
									$n=1;
									$no=$no+$n;
									echo"
										<tr>
										  <td align='center'>$no</td>
										  <td>$r[nama_sub]</td>
										";
								   ?>
										  <td><?php echo date ("d/m/Y", strtotime($r['tanggal_mulai_j']))?></td>
										  <td><?php echo date ("d/m/Y", strtotime($r['tanggal_selesai_j']))?></td>
										  <td><?php echo $r['durasi_kegiatan']?> hari</td>
										  <td>
							 
								   <?php 
										$getjadwal = mysql_query("SELECT id_jadwal FROM jadwal ORDER BY id_jadwal DESC LIMIT 1");
										$j = mysql_fetch_array($getjadwal);
										if ($r['id_jadwal']==$j['id_jadwal'])
										 {?>
											<a href='fungsi.php?proses_hapus_jadwal=hapus_jadwal&id_proyek=<?=$_GET['id_proyek']?>&id_jadwal=<?=$r['id_jadwal']?>' class='btn btn-danger btn-fill btn-sm'>Hapus</a>
										 <?php } 
									?>
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
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
			  </div>
            <!-- /.tab-content -->
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
				<p>Anda yakin ingin menghapus semua data ini?</p>
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