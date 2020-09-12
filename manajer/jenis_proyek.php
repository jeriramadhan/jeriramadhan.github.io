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
        <li><a href="#"><i class="fa fa-database"></i>Jenis Proyek</a></li>
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
              <h3 class="box-title">Data Jenis Proyek</h3>
			</div><!-- /.box-header -->
			
		 <div class="box-body">			
		  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#lihat_kegiatan" data-toggle="tab">Lihat Jenis Proyek</a></li>
              <li><a href="#tambah_kegiatan" data-toggle="tab">Tambah Jenis Proyek</a></li>
            </ul>
			
			<div class="tab-content">
              <div class="tab-pane" id="tambah_kegiatan">
                <!-- Post -->
                <div class="post">
                    <br />
					    <div class="box-header with-border">
						  <h3 class="box-title">Form Tambah Jenis Proyek</h3>
						</div>
						<!-- /.box-header -->				
						<!-- form start -->
						<form role="form" action="fungsi.php?proses=tambah_jenis" method="POST" class="form-horizontal" id="tambah">					
						  <div class="form-group">
							 <label class="col-sm-2 control-label">Nama Jenis Proyek : </label>
							 <div class="col-sm-3">
								<input type="text" class="form-control" name="nama_jenis" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
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
					  <h2 class="box-title">Data Jenis Proyek</h2>
					</div>
				
					<!-- /.box-header -->
					<div class="box-body">
					   <table id="tabel1" class="table table-bordered table-striped">
					      <thead>
							<tr>
							  <th width="20">No</th>
							  <th width="112">Nama Jenis Proyek</th>
							  <th width="109">Aksi</th>
							</tr>
						  </thead>
						  <tbody>
						   <?php
						   		    $kegiatan = mysql_query("SELECT * FROM jenis_proyek order by nama_jenis");
									$no=0;
									while($r=mysql_fetch_array($kegiatan))
									{
									  $n=1;
									  $no=$no+$n;
									
									  echo"
										<tr>
										  <td align='left'>$no</td>
										   <td>$r[nama_jenis]</td>"
									?>
									    <td>
									  
									 <a href='pekerjaan.php?id_jenis=<?=$r['id_jenis']?>' class='btn btn-success btn-fill btn-xs' >Pekerjaan</a>
									 <a href='edit_jenis.php?id_jenis=<?=$r['id_jenis']?>'class='btn btn-info btn-fill btn-xs' >Ubah</a>
                                    <botton class="btn btn-danger btn-fill btn-wd btn-xs" data-toggle="modal" data-target="#myModal" data-whatever="fungsi.php?proses_hapus=hapus_jenis&id_jenis=<?=$r['id_jenis']?>">Hapus</botton>
									
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