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
        <li><a href="#"><i class="fa fa-building"></i>Pekerjaan</a></li>
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
              <h3 class="box-title">Data Master Pekerjaan</h3>
			  
			   <div class="form-group">
			   <br />
                <form action="?" method="GET">
					<div class="input-group input-group-sm">
					  <select name="id_jenis" class="form-control select2" style="width: 100%;">
						<option selected="selected">--Pilih Jenis Proyek--</option>
						 <?php
							$query = "SELECT * FROM jenis_proyek";
							$result = mysql_query($query);
							
							$sql = mysql_query("SELECT * FROM jenis_proyek where id_jenis NOT IN(SELECT id_jenis FROM pekerjaan)");
							$r = mysql_fetch_array($sql);
							$jenis = $r['id_jenis'];
							
							while($row = mysql_fetch_array($result))
							{		
							  ?>
								  <option 
								  <?php
								       if (isset($_GET['id_jenis']))
								       { 
									      if (($row['id_jenis'] == $_GET['id_jenis']))
										  {
										    echo 'selected';
										  }
									   } 
								   ?> 
								       <?php
									      if ($row['id_jenis'] == $jenis)
									   	  {
									   ?>
									       value="<?php echo $row['id_jenis']; ?>"> <?php echo $row['nama_jenis'];?>
										<?php	  
										  }
										?>  
								 </option>
								 <option 
								 
								       <?php
									      if ($row['id_jenis'] != $jenis)
									   	  {
										  	  if (($row['id_jenis'] == $_GET['id_jenis']))
										  	  {
										   		echo 'selected';
										  	  }
									   ?>
									     value="<?php echo $row['id_jenis']; ?>"> <?php echo $row['nama_jenis'];  ?>
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
						if(isset($_GET['id_jenis'])) 
					   { 
							$id_jenis = $_GET['id_jenis'];
							$jenis = mysql_query("select * from jenis_proyek where id_jenis = '$id_jenis'");
							
							
							while($r=mysql_fetch_array($jenis))
							{
							   ?>
									<br>
									<br>
									<h5><b> 
									  <div><i class="fa fa-building text-red"></i> Jenis Proyek : <code><?php echo " $r[nama_jenis]" ?></code></div><p>
								    </b></h5>
							<?php	  
							}
					  }
					  ?>
					  
					  <div class="pull-right">
						<a href="jenis_proyek.php"
						class="btn btn-info btn-fill btn-sm" style="margin-bottom: 10px; margin-top: -30px;"> <i class="fa  fa-reply "></i> <span>Kembali</span></a>                    </div>
					
              </div>
			  
            </div><!-- /.box-header -->
			
			
		 <div class="box-body">			
		  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#lihat_kegiatan" data-toggle="tab">Lihat Pekerjaan</a></li>
              <li><a href="#tambah_kegiatan" data-toggle="tab">Tambah Pekerjaan</a></li>
            </ul>
			
			<div class="tab-content">
              <div class="tab-pane" id="tambah_kegiatan">
                <!-- Post -->
                <div class="post">
                    <br />
					
						<div class="box-header with-border">
						  <h3 class="box-title">Form Tambah Pekerjaan</h3>
						</div>
						<!-- /.box-header -->				
						<!-- form start -->
						<?php
							$id_jenis = $_GET['id_jenis'];

							 //get kode pekerjaan
							 $getkode = mysql_query("SELECT kode_pekerjaan from pekerjaan where id_jenis = '$id_jenis' order by kode_pekerjaan DESC Limit 1");
							 $row = mysql_fetch_array($getkode);
							 $kodeawal=$row['kode_pekerjaan'];
							
							 $cek = mysql_num_rows($getkode);
							 if($cek == NULL)
							 {
								$kode1 = 1;
								$newID = Romawi($kode1);
							 }
							 else
							 {
								 $kode= $row['kode_pekerjaan'];
								 $kode1=$kode + 1;
								 $newID = Romawi($kode1);
							 }						
						?>
					
						<form role="form" action="fungsi.php?proses=tambah_pekerjaan" method="POST" class="form-horizontal" id="tambah">					
						 <input type="hidden" class="form-control" name="id_jenis" value="<?=$_GET['id_jenis'] ?>">
							<input type="hidden" value="<?=$kode1?>" name="kode_pekerjaan"></input>
							   <div class="box-body">
								<div class="form-group">
								  <label class="col-sm-2 control-label">Kode Pekerjaan : </label>
								  <div class="col-sm-1">
									<input class="form-control" value="<?=$newID ?>" disabled>
								  </div>
							   </div>
							  
						   <div class="form-group">
							 <label class="col-sm-2 control-label">Nama Pekerjaan : </label>
							 <div class="col-sm-3">
								<input type="text" class="form-control" name="nama_pekerjaan" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
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
					  <h2 class="box-title">Data Pekerjaan</h2>
					</div>
				    <!-- /.box-header -->
					<div class="box-body">
					   <table id="tabel1" class="table table-bordered table-striped">
					      <thead>
							<tr>
							  <th width="20">No</th>
							  <th width="173">Kode Pekerjaan</th>
							  <th width="112">Nama Pekerjaan</th>
							  <th width="109">Aksi</th>
							</tr>
						  </thead>
						  <tbody>
						   <?php
			  					if(isset($_GET['id_jenis'])) 
								{ 
									$id_jenis = $_GET['id_jenis'];
									$kegiatan = mysql_query("select * from pekerjaan where id_jenis = '$id_jenis'");
									$no=0;
									while($r=mysql_fetch_array($kegiatan)){
									  $n=1;
									  $no=$no+$n;
									
									  echo"
										<tr>
										  <td align='left'>$no</td>
										   <td>".Romawi($r['kode_pekerjaan'])."</td>
										  <td>$r[nama_pekerjaan]</td>"
									?>
									      <td>
									  
									 <a href='sub_pekerjaan.php?id_jenis=<?=$r['id_jenis']?>&id_pekerjaan=<?=$r['id_pekerjaan']?>' class='btn btn-success btn-fill btn-xs' >Sub Pekerjaan</a>
									 <a href='edit_pekerjaan.php?id_jenis=<?=$_GET['id_jenis']?>&id_pekerjaan=<?=$r['id_pekerjaan']?>'class='btn btn-info btn-fill btn-xs' >Ubah</a>
                                    <botton class="btn btn-danger btn-fill btn-wd btn-xs" data-toggle="modal" data-target="#myModal" data-whatever="fungsi.php?proses_hapus=hapus_pekerjaan&id_pekerjaan=<?=$r['id_pekerjaan']?>&id_jenis=<?=$_GET['id_jenis']?>">Hapus</botton> </td>
									
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