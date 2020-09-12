<?php include "header.php"; 
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
      </ol>
    </section>
	

<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form Ubah Jenis Proyek</h3>
            </div>
            <!-- /.box-header -->
              <?php 
                  $link=koneksidb();
                  $id=$_GET['id_jenis'];
                  $data=mysql_query("SELECT * FROM jenis_proyek WHERE id_jenis='$id'");
                  $r=mysql_fetch_array($data);
              ?>
            <!-- form start -->
            <form role="form" action="fungsi.php?proses2=ubah_jenis" method="POST" class="form-horizontal">
              <div class="box-body">
			     <input type="hidden" class="form-control" name="id_jenis" value="<?php echo $id ?>">
     			 <div class="form-group">
					<label class="col-sm-2 control-label">Jenis Proyek : </label>
				    <div class="col-sm-4">
					  <input type="text" class="form-control" name="nama_jenis" value="<?php echo $r['nama_jenis']?>" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
				   </div>
               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" value="Ubah" class="btn btn-danger btn-fill btn-wd"></input>
                <a href="jenis_proyek.php" class="btn btn-info btn-fill btn-wd">Batal</a>
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