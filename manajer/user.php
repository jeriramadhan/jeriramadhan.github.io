<?php
include "header.php";
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i>Tambah User</a></li>
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
            <h4><i class="icon fa fa-check"></i> Pemberitahuan!</h4>
               Data Berhasil Disimpan...
          </div>

<?php }elseif ($pesan == 'gagal') 
      { ?>
	  <br />
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Pemberitahuan!</h4>
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
            <h4><i class="icon fa fa-check"></i> Pemberitahuan!</h4>
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
          <div class="alert alert-success alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Pemberitahuan!</h4>
               Data Berhasil Ubah...
          </div>

<?php }
      elseif ($pesan == 'gagal') 
      { ?>
	  <br />
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Pemberitahuan!</h4>
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
              <li class="active"><a href="#lihat_kegiatan" data-toggle="tab">Lihat Pengguna</a></li>
              <li><a href="#tambah_kegiatan" data-toggle="tab">Tambah Pengguna</a></li>
            </ul>
			
			<div class="tab-content">
              <div class="tab-pane" id="tambah_kegiatan">
                <!-- Post -->
                <div class="post">
                    <br />
					
						<div class="box-header with-border">
						  <h3 class="box-title">Form Tambah Pengguna</h3>
						</div>
						<!-- /.box-header -->				
						<!-- form start -->
						<form role="form" action="fungsi.php?proses=tambah_user" method="POST" class="form-horizontal" id="tambah">
						  <div class="box-body">
						   <div class="form-group">
							  <label class="col-sm-2 control-label">Username : </label>
							  <div class="col-sm-3">
								<input type="text" class="form-control" maxlength="10" name="username" title="Username diisi dengan min. 6 karakter, diawali dengan huruf tanpa spasi" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{5,11}$" required>
							  </div>
						   </div>
						   <div class="form-group">
							  <label class="col-sm-2 control-label">Password : </label>
							  <div class="col-sm-3">
								<input type="text" class="form-control" maxlength="10" name="password" title="Password diisi dengan min. 6 karakter, diawali dengan huruf tanpa spasi" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{5,11}$" required>
							  </div>
						   </div>
						   <div class="form-group">
							  <label class="col-sm-2 control-label">Nama : </label>
							  <div class="col-sm-3">
								<input type="text" class="form-control" name="nama" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
							  </div>
						   </div>
						   <div class="form-group">
							  <label class="col-sm-2 control-label">Jabatan : </label>
							  <div class="col-sm-2">
							   <select  class="form-control select2" name="jabatan" style="width: 100%;">
									 <option value="kosong" selected="selected" required>-Pilih-</option>
									 <option value="Manajer">Manajer</option>
									 <option value="Pelaksana">Pelaksana</option>
								</select>
							   </div>
							</div>
							 <div class="form-group">
							  <label class="col-sm-2 control-label">Email : </label>
							  <div class="col-sm-3">
								<input type="email" class="form-control" name="email" required>
							  </div>
						   </div>
						  </div>
						  <!-- /.box-body -->
			
						  <div class="box-footer">
							<div align="right">
							  <input type="submit" value="Simpan" class="btn btn-info btn-fill btn-wd">
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
					  <h2 class="box-title">Data Pengguna</h2>
					</div>
				
					<!-- /.box-header -->
					<div class="box-body">
					  <table id="tabel1" class="table table-bordered table-striped">
						<thead>
			 
								<tr>
								  <th>No</th>
								  <th>Username</th>
								  <th>Nama</th>
								  <th>Jabatan</th>
								  <th>Email</th>
								  <th><center>Aksi</center></th>
								</tr>
					    </thead>
						   <tbody>
							  <?php
			  
								$user = mysql_query("select * from user order by jabatan");
								$no=0;
								while($r=mysql_fetch_array($user)){
								  $n=1;
								  $no=$no+$n;
								
								  echo"
									<tr>
									  <td align='center'>$no</td>
									  <td>$r[username]</td>
									  <td>$r[nama_user]</td>
									  <td>$r[jabatan]</td>
									  <td>$r[email]</td>
								      <td align = 'center'>";
								  	  
								     ?>
									
					                <a href='edit_user.php?username=<?=$r['username']?>'class='btn btn-info btn-fill btn-xs' >Ubah</a>
                                    <botton class="btn btn-danger btn-fill btn-wd btn-xs" data-toggle="modal" data-target="#myModal" data-whatever="fungsi.php?proses_hapus=hapus_user&username=<?=$r['username']?>">Hapus</botton>
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
            <p>Hapus data ini ?</p>
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