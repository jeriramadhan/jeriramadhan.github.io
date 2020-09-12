<?php 
  include "header.php";
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="user.php?id_user=<?=$_GET['id_user']?>"><i class="fa fa-user"></i>Pengguna</a></li>
        <li class="active">Ubah Pengguna</li>
      </ol>
    </section>
	
	<br />
<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form Ubah Pengguna</h3>
            </div>
            <!-- /.box-header -->
            <?php 
                  $link=koneksidb();
                  $id=$_GET['username'];
                  $data=mysql_query("select * from user WHERE username='$id'");
                  $r=mysql_fetch_array($data);
              ?>
             <!-- form start -->
            <form role="form" action="fungsi.php?proses_ubah_user" method="POST" class="form-horizontal">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Username : </label>
                  <div class="col-sm-2">
                     <input type="hidden" class="form-control" name="username" value="<?php echo $r['username'] ?>">
                     <input type="text" class="form-control" value="<?php echo $r['username'] ?>" disabled>
                  </div>
				 </div>
				 <div class="form-group">
					<label class="col-sm-2 control-label">Nama : </label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="nama" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" value="<?php echo $r['nama_user'] ?>" required>
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
						<input type="email" class="form-control" name="email" value="<?php echo $r['email'] ?>" required>
					</div>
				 </div> 
             
              <!-- /.box-body -->

              <div class="box-footer">
			     <input type="submit" value="Simpan" class="btn btn-info btn-fill btn-wd"></input>
                 <a href="user.php?" class="btn btn-danger btn-fill btn-wd">Batal</a>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<?php include "footer.php"; ?>