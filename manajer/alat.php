<?php
include "header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-building"></i>Alat</a></li>
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
              <h3 class="box-title">Data Alat</h3>
			  
			   <div class="form-group">
			   <br />
                <form action="?" method="GET">
					<div class="input-group input-group-sm">
					  <select name="id_proyek" class="form-control select2" style="width: 100%;">
						<option selected="selected">--Pilih Proyek--</option>
						<?php
							$query = "SELECT * FROM proyek";
							$result = mysql_query($query);
							
							$sql = mysql_query("SELECT * FROM proyek where id_proyek NOT IN(SELECT id_proyek FROM upah)
							                    OR id_proyek NOT IN(SELECT id_proyek FROM pekerjaan) 
												OR id_proyek NOT IN(SELECT id_proyek FROM bahan_material)");
							$r = mysql_fetch_array($sql);
							$proyek = $r['id_proyek'];
							
							while($row = mysql_fetch_array($result))
							{		
							  ?>
								  <option 
								  <?php
								       if (isset($_GET['id_proyek']))
								       { 
									      if (($row['id_proyek'] == $_GET['id_proyek']))
										  {
										    echo 'selected';
										  }
									   } 
								   ?> 
								       <?php
									      if ($row['id_proyek'] == $proyek)
									   	  {
									   ?>
									       value="<?php echo $row['id_proyek']; ?>"> <?php echo $row['nama_proyek'];?>
										   <a> (Baru)</a>
										<?php	  
										  }
										?>  
								 </option>
								 <option 
								 
								       <?php
									      if ($row['id_proyek'] != $proyek)
									   	  {
										  	  if (($row['id_proyek'] == $_GET['id_proyek']))
										  	  {
										   		echo 'selected';
										  	  }
									   ?>
									     value="<?php echo $row['id_proyek']; ?>"> <?php echo $row['nama_proyek'];  ?>
									  <?php	  
										  }
										?>  
								</option>
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
              <li class="active"><a href="#lihat_kegiatan" data-toggle="tab">Lihat Alat</a></li>
              <li><a href="#tambah_kegiatan" data-toggle="tab">Tambah Alat</a></li>
            </ul>
			
			<div class="tab-content">
              <div class="tab-pane" id="tambah_kegiatan">
                <!-- Post -->
                <div class="post">
                    <br />
					
						<div class="box-header with-border">
						  <h3 class="box-title">Form Tambah Alat</h3>
						</div>
						<!-- /.box-header -->				
						<!-- form start -->
						   <form role="form" action="fungsi.php?proses=tambah_alat" method="POST" class="form-horizontal" id="tambah">
								<div class="box-body">
								<input type="hidden" class="form-control" name="id_proyek" value="<?=$_GET['id_proyek'] ?>">
								  <div class="form-group">
									 <label class="col-sm-2 control-label">Kode : </label>
									 <div class="col-sm-3">
										 <?php
										 		$id_proyek = $_GET['id_proyek'];
												error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); 
												$sql=mysql_query("SELECT kode FROM bahan_material WHERE id_proyek = '$id_proyek' AND kode LIKE 'E0%' order by kode DESC LIMIT 0,1");
												$data=mysql_fetch_array($sql);
												$kodeawal=substr($data['kode'],1,2)+1; 
												$kode='E0'.$kodeawal;							
										 ?>
											 <input type="hidden" class="form-control" name="kode" value="<?php echo $kode;?>">
											 <input type="text" class="form-control" value="<?php echo $kode;?>" disabled>
									 </div>
								   </div>
									  
								   <div class="form-group">
									 <label class="col-sm-2 control-label">Nama Alat : </label>
									 <div class="col-sm-3">
										<input type="text" class="form-control" name="nama_bahan" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
									 </div>
								   </div>
								   
								   <div class="form-group">
									 <label class="col-sm-2 control-label">Harga Satuan Alat : </label>
									   <div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">Rp.</span>
											<input id="harga_bahan" type="text" class="form-control" name="biaya" required>
										</div>
										<font><code>*minimal harga Rp. 100</code></font>
									  </div>
									</div>
									
								   
								   <div class="form-group">
									 <label class="col-sm-2 control-label">Satuan : </label>
									 <div class="col-sm-3">
										 <select  class="form-control" name="satuan" style="width: 100%;">
											 <option value="kosong" selected="selected" required>-Pilih-</option>
											 <option value="ls">ls</option>
											 <option value="m3">m3</option>
											 <option value="m2">m2</option>
											 <option value="m">m</option>
											 <option value="liter">liter</option>
											 <option value="bh">bh</option>
											 <option value="pcs">pcs</option>
											 <option value="kg">kg</option>
											 <option value="jam">jam</option>
											 <option value="unit">unit</option>
											 <option value="ton">ton</option>
											 <option value="ls">ls</option>
										</select>
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
					  <h2 class="box-title">Data Alat</h2>
					</div>
				
					<!-- /.box-header -->
					<div class="box-body">
					  <table id="tabel1" class="table table-bordered table-striped">
					      <thead>
							<tr>
							  <th>No</th>
							  <th>Kode</th>
							  <th>Nama Alat</th>
							  <th>Harga Satuan Alat</th>
							  <th>Satuan</th>
							  <th width="100">Aksi</th>
							</tr>
						  </thead>
						  <tbody>
						   <?php
			  					if(isset($_GET['id_proyek'])) 
								{ 
									$id_proyek = $_GET['id_proyek'];
									$kegiatan = mysql_query("SELECT * from bahan_material
															 WHERE bahan_material.id_proyek = '$id_proyek' AND bahan_material.kode LIKE 'E0%'");
									$no=0;
									while($r=mysql_fetch_array($kegiatan)){
									  $n=1;
									  $no=$no+$n;
									
									  echo"
										<tr>
										  <td align='left'>$no</td>
										  <td>$r[kode]</td>
										  <td>$r[nama_bahan]</td>"
									?>
										  <td><?php echo "Rp ". number_format(round($r['harga_bahan'],2),2,',','.')?></td>
										  <td><?php echo $r['satuan']?></td>
										  <td>
									  
									 <a href='edit_alat.php?id_proyek=<?=$_GET['id_proyek']?>&id_alat=<?=$r['id_bahan']?>'class='btn btn-info btn-fill btn-xs' >Ubah</a>
                                    <botton class="btn btn-danger btn-fill btn-wd btn-xs" data-toggle="modal" data-target="#myModal" data-whatever="fungsi.php?proses_hapus=hapus_alat&id_alat=<?=$r['id_bahan']?>&id_proyek=<?=$_GET['id_proyek']?>">Hapus</botton>
									
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