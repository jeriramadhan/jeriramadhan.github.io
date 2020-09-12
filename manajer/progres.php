<?php
include "header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bar-chart-o"></i>Progres</a></li>
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
               Data Sudah Terisi, Silahkan Hapus dahulu...
          </div>           
<?php }
	elseif ($pesan == 'gagal_jumlah') 
      { ?>
	  <br />
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Jumlah Melebihi 100%...
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
               Data Progres Berhasil Ubah...
          </div>

<?php }
      elseif ($pesan == 'gagal') 
      { ?>
	  <br />
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Data Progres gagal Diubah...
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
              <h3 class="box-title">Data Progres</h3>
			  
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
			<br />
			
		  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#lihat_kegiatan" data-toggle="tab">Lihat Progres</a></li>
              <li><a href="#tambah_kegiatan" data-toggle="tab">Tambah Progres</a></li>
            </ul>
			
			<div class="tab-content">
              <div class="tab-pane" id="tambah_kegiatan">
                <!-- Post -->
                <div class="post">
                    <br />
				
					<div class="box-header with-border">
					  <h3 class="box-title">Form Tambah Progres</h3>
					</div>
						<!-- /.box-header -->				
						<!-- form start -->
					  <form role="form" action="fungsi.php?proses=tambah_progres" method="POST" class="form-horizontal" id="tambah">					
					   <input type="hidden" class="form-control" name="id_proyek" value="<?=$_GET['id_proyek'] ?>">
						<div class="box-body">
						   <?php
						      $id_proyek = $_GET['id_proyek'];
						   	  $getminggu = mysql_query("SELECT minggu,jumlah FROM progres WHERE id_proyek = '$id_proyek' ORDER BY minggu DESC LIMIT 1");
							  $rows = mysql_fetch_array($getminggu);
						   ?>
					  
						   <div class="form-group">
							<label class="col-sm-2 control-label">Jumlah Saat ini : </label>
							 <div class="col-sm-2">
							    <div class="input-group">
									<input type="text" class="form-control" value="<?=$rows['jumlah'] ?>" disabled="disabled">
								    <span class="input-group-addon">%</span>
							    </div>
							 </div>
						   </div>
						   <br />
							<div class="form-group">
							 <label class="col-sm-2 control-label">Periode :</label>
							  <div class="col-sm-8">
								
									<select class="form-control select2" style="width:30%" name="minggu">
									  <?php
										  $id = $_GET['id_proyek'];
										  $dur = mysql_query("select durasi_proyek from proyek where id_proyek = '$id'");
										  $r = mysql_fetch_array($dur);
										  $j = $r['durasi_proyek'] / 7;
										  for ($i=1; $i <= $j; $i++)
										  { 
										?>
										
											<option value="<?=$i?>">Minggu ke-<?=$i?></option>
									  <?php 
									      }
									  ?>
									</select>
								</div>
							  </div>
						 
							  
						   <div class="form-group">
							 <label class="col-sm-2 control-label">Bobot Rencana : </label>
							 <div class="col-sm-2">
							    <div class="input-group">
									<input type="text" class="form-control" name="progres" maxlength="6" required>
								    <span class="input-group-addon">%</span>
							    </div>
							 </div>
						   </div>
						  </div>
						  
						  <!-- /.box-body -->
						  <div class="box-footer">
							<div align="right">
							  <input type="submit" value="Simpan" class="btn btn-warning btn-fill btn-wd">
							  </input>
							  <input type="reset" value="Reset" class="btn btn-danger btn-fill btn-wd">
							  </input>
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
					  <h2 class="box-title">Data Progres</h2>
					</div>
				
					<!-- /.box-header -->
					<div class="box-body">
					   <table id="tabel1" class="table table-bordered table-striped">
					      <thead>
							<tr>
							  <th width="20">Minggu ke</th>
							  <th width="112">progres</th>
							  <th width="173">jumlah</th>
							  <th width="109">Aksi</th>
							</tr>
						  </thead>
						  <tbody>
						   <?php
			  					if(isset($_GET['id_proyek'])) 
								{ 
									$id_proyek = $_GET['id_proyek'];
									$kegiatan = mysql_query("select * from progres where id_proyek = '$id_proyek'");
									$no=0;
									while($r=mysql_fetch_array($kegiatan))
									{
									  
									  echo"
										<tr>
										   <td align='left'>$r[minggu]</td>
										   <td>$r[bobot_rencana] %</td>
										   <td>$r[jumlah] %</td>"
							 ?>
							 			    <td>
											     <?php 
													$getprogres = mysql_query("SELECT id_progres FROM progres ORDER BY id_progres DESC LIMIT 1");
													$j = mysql_fetch_array($getprogres);
													if ($r['id_progres']==$j['id_progres'])
													 {?>
													   <botton class="btn btn-danger btn-fill btn-wd btn-sm" data-toggle="modal" data-target="#myModal"
											            data-whatever="fungsi.php?proses_hapus=hapus_progres&id_progres=<?=$r['id_progres']?>&id_proyek=<?=$_GET['id_proyek']?>">Hapus
											          </botton>
													 <?php 
													 } 
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