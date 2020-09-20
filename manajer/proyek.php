<?php
include "header.php";
 $sql=mysql_query("SELECT * FROM proyek ORDER BY id_proyek DESC LIMIT 10");
 $data=mysql_fetch_array($sql);
 $now = date("mdY");
 $kodeawal=substr($data['id_proyek'],1,3)+1;
 if($kodeawal<10){
  $kode='P00'.$kodeawal.$now;
 }elseif($kodeawal > 9 && $kodeawal <=99){
  $kode='P0'.$kodeawal.$now;
 }else{
  $kode='P0'.$kodeawal.$now;
 }
?>
<?php
$link=koneksidb();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<ol class="breadcrumb"></ol>

		<?php

    if (isset($_GET['pesan']))
    {
        $pesan = $_GET['pesan'];
      if ($pesan == 'sukses') 
      { ?>

		<div class="alert alert-success alert-dismissible" style="margin-bottom: -10px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-check"></i> Alert!</h4>
			Data Berhasil Disimpan...
		</div>

		<?php }elseif ($pesan == 'gagal') 
      { ?>
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

		<div class="alert alert-success alert-dismissible" style="margin-bottom: -10px;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h4><i class="icon fa fa-check"></i> Alert!</h4>
			Data Berhasil Ubah...
		</div>

		<?php }
      elseif ($pesan == 'gagal') 
      { ?>
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
				<div class="nav-tabs-custom">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#lihat_proyek" data-toggle="tab">Lihat Proyek</a></li>
						<li><a href="#tambah_proyek" data-toggle="tab">Tambah Proyek</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane" id="tambah_proyek">
							<!-- Post -->
							<div class="post">
								<br />

								<div class="box-header with-border">
									<h3 class="box-title">Form Tambah Proyek</h3>
								</div>
								<!-- /.box-header -->
								<!-- form start -->
								<?php
								$link=koneksidb();
								$username=$_SESSION['username'];
								$sql=mysql_query("SELECT username FROM user WHERE username ='$username' ");
								$q=mysql_fetch_array($sql);
									
							?>
								<!-- <form role="form" action="fungsi.php?proses=tambah_proyek" method="POST" class="form-horizontal" id="tambah">
							   <input type="hidden" class="form-control" name="id_proyek" value="<?php echo $kode;?>">
							   <input type="hidden" class="form-control" value="<?php echo $kode;?>" disabled>
							   <input type="hidden" class="form-control" name="username" value="<?=$_SESSION['username']?>">
							    <input type="hidden" class="form-control"  value="<?=$_SESSION['username']?>"disabled>
								<div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">Jenis Proyek : </label>
								     <div class="col-sm-3">
									   <select class="form-control select2" style="width: 100%;" name="id_jenis" required>
										<option></option>
										<?php 
										  $getjenis = mysql_query("select * from jenis_proyek")
										?>
										  <?php while ($row=mysql_fetch_array($getjenis)) { ?>
										  <option value="<?php echo $row['id_jenis']; ?>"> <?php echo $row['nama_jenis'];  ?></option>
										  <?php } ?>
									  </select>
								  </div>
								  <label class="col-sm-2 control-label">Durasi: </label>
								  <div class="col-sm-3">
									<div class="input-group">
									  <input type="number" min="1" pattern=" >1" class="form-control" name="durasi_proyek" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" required>
									  <span class="input-group-addon">Hari</span>
									</div>  
								  </div>
								</div>
							 
								<div class="form-group">
								 <label class="col-sm-2 control-label">Nama Proyek : </label>
								 <div class="col-sm-3">
									 <textarea style="resize:none;width:300px;height:80px;" name="nama_proyek" required></textarea>
								 </div>
								 <label class="col-sm-2 control-label">Tanggal Mulai: </label>
								  <div class="col-sm-3">
									<div class="input-group date">
									  <div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									  </div>
										<input type="text" class="form-control pull-right" id="tanggal_mulai" name="tanggal_mulai" required>
									  </div>
									</div>
								</div>
								
								<div class="form-group">
								 <label class="col-sm-2 control-label">Pemilik Proyek : </label>
								 <div class="col-sm-3">
									<input type="text" class="form-control" name="pemilik" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
								 </div>
								</div>
								<label class="col-sm-2 control-label">Jumlah Biaya: </label>
							    <div class="col-sm-3">
								  <div class="input-group">
									<span class="input-group-addon">Rp.</span>
									<input id="harga_bahan" type="text" class="form-control" name="biaya" required>
								  </div>
							    </div>
								</div>
								<div class="form-group">
                  <label class="col-sm-2 control-label">Lokasi : </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="lokasi" required>
                  </div>
                </div>
     					 </div>
								
							   
							  
				
							  <div class="box-footer">
								 <div class="box-tools pull-right">
									<input type="submit" value="Simpan" class="btn btn-warning btn-fill btn-wd" />
									<input type="reset" value="Reset" class="btn btn-danger btn-fill btn-wd" />
								 </div>
							  </div>
							</form> -->
								<form role="form" action="fungsi.php?proses=tambah_proyek" method="POST" class="form-horizontal"
									id="tambah">
									<input type="hidden" class="form-control" name="id_proyek" value="<?php echo $kode;?>">
									<input type="hidden" class="form-control" value="<?php echo $kode;?>" disabled>
									<input type="hidden" class="form-control" name="username" value="<?=$_SESSION['username']?>">
									<input type="hidden" class="form-control" value="<?=$_SESSION['username']?>" disabled>
									<div class="box-body">
										<div class="form-group">
											<label class="col-sm-2 control-label">Jenis Proyek : </label>
											<div class="col-sm-3">
												<select class="form-control select2" style="width: 100%;" name="id_jenis" required>
													<option></option>
													<?php 
										  $getjenis = mysql_query("select * from jenis_proyek")
										?>
													<?php while ($row=mysql_fetch_array($getjenis)) { ?>
													<option value="<?php echo $row['id_jenis']; ?>"> <?php echo $row['nama_jenis'];  ?></option>
													<?php } ?>
												</select>
											</div>
											<label class="col-sm-2 control-label">Durasi: </label>
											<div class="col-sm-3">
												<div class="input-group">
													<input type="number" min="1" pattern=" >1" class="form-control" name="durasi_proyek"
														onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" required>
													<span class="input-group-addon">Jam</span>
												</div>
											</div>
										</div>


										<div class="form-group">
											<label class="col-sm-2 control-label">Nama Proyek : </label>
											<div class="col-sm-3">
												<textarea style="resize:none;width:300px;height:80px;" name="nama_proyek" required></textarea>
											</div>
											<label class="col-sm-2 control-label">Tanggal Mulai: </label>
											<div class="col-sm-3">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right" id="tanggal_mulai" name="tanggal_mulai"
														required>
												</div>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 control-label">Pemilik Proyek : </label>
											<div class="col-sm-3">
												<input type="text" class="form-control" name="pemilik"
													onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
											</div>
										</div>
										<label class="col-sm-2 control-label">Jumlah Biaya: </label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">Rp.</span>
												<input id="harga_bahan" type="text" class="form-control" name="biaya" required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Lokasi Proyek </label>
										<div class="col-sm-4">
											<input type="text" class="form-control" name="lokasi" required>
										</div>
									</div>
																			<div class="form-group">
										<label class="col-sm-2 control-label">Jam Kerja/Hari: </label>
										<div class="col-sm-3">
												<div class="input-group">
													<input type="number" min="1" pattern=" >1" class="form-control" name="jam"
														onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" required>
													<span class="input-group-addon">Jam</span>
												</div>
											</div>
										</div>

									<!-- /.box-body -->

									<div class="box-footer">
										<div class="box-tools pull-right">
											<input type="submit" value="Simpan" class="btn btn-warning btn-fill btn-wd" />
											<input type="reset" value="Reset" class="btn btn-danger btn-fill btn-wd" />
										</div>
									</div>
								</form>
							</div>
							<!-- /.post -->
						</div>
						<!-- /.tab-pane -->

						<div class="active tab-pane" id="lihat_proyek">
							<!-- Post -->
							<div class="post">
								<br />
								<div class="box-header with-border">
									<h2 class="box-title">Data Proyek</h2>								
								<div class="pull-right">
<a href="cetakproyek.php" class="btn btn-info btn-fill btn-sm">Cetak <i class="fa fa-print"></i></a>
</div>
</div>

								<!-- /.box-header -->
								<div class="box-body">
									<table id="tabel1" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th rowspan="2">Id Proyek</th>
												<th rowspan="2">No. SPK</th>
												<th rowspan="2">Nama Proyek</th>
												<th rowspan="2">Durasi (Jam)</th>
												<th rowspan="2">Tanggal Mulai</th>
												<th rowspan="2">Tanggal Selesai</th>
												<th rowspan="2">Nilai Kontrak (Rp)</th>
												<th rowspan="2">Pemilik Proyek</th>
												<th rowspan="2">Lokasi</th>
												<th rowspan="2">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
      
												$proyek = mysql_query("SELECT * FROM proyek GROUP BY id_proyek");
												if (!$proyek) { // add this check.
    die('Invalid query: ' . mysql_error());
}
                        $no=0;
                        while($r=mysql_fetch_array($proyek)){
                          $n=1;
                          $no=$no+$n;
                        
                          echo"
                            <tr>
                              <td>$r[id_proyek]</td>
							  <td>$r[no_spk]</td>
                              <td>$r[nama_proyek]</td>
                              <td>$r[durasi_proyek]</td>
							  <td>".date ("d/m/Y", strtotime($r['tanggal_mulai']))."</td>
                              <td>".date ("d/m/Y", strtotime($r['tanggal_selesai']))."</td>
                              <td>".number_format($r['nilai_proyek'],2,',','.')."</td>
								<td>$r[pemilik]</td>
								<td>$r[lokasi]</td>
							 ";
                          ?>
											<td>
												<a href="edit_proyek.php?id_proyek=<?php echo $r['id_proyek']?>"
													class="btn btn-info btn-fill btn-sm">Ubah</a>
												<botton class="btn btn-danger btn-fill btn-sm" data-toggle="modal" data-target="#myModal"
													data-whatever="fungsi.php?proses_hapus=hapus_proyek&id_proyek=<?=$r['id_proyek']?>">Hapus
												</botton>
											</td>
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

<div class="modal fade" tabindex="-1" role="dialog" id="myModal">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Konfirmasi Hapus</h4>
			</div>
			<div class="modal-body">
				<p>Anda yakin ingin menghapus data ini?</p>
			</div>

			<div class="modal-footer">
				<buontton type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					<a href="#" id="delete_link" class="btn btn-primary">Hapus </a>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php
include "footer.php";
?>