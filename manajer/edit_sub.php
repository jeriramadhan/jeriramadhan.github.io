<?php include "header.php"; 
include "fungsi_romawi.php";
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
              <h3 class="box-title">Form Ubah Subpekerjaan</h3>
            </div>
            <!-- /.box-header -->
              <?php 
                  $link=koneksidb();
                  $id=$_GET['id_sub'];
                  $data=mysql_query("SELECT * FROM master_sub_pekerjaan
				  					 JOIN pekerjaan ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
									 WHERE id_master_sub='$id'");
                  $r=mysql_fetch_array($data);
              ?>
            <!-- form start -->
            <form role="form" action="fungsi.php?proses2=ubah_sub" method="POST" class="form-horizontal">
              <div class="box-body">
			     <input type="hidden" class="form-control" name="id_master_sub" value="<?php echo $id ?>">
				  <input type="hidden" class="form-control" name="id_jenis" value="<?php echo $_GET['id_jenis']?>" required>
				  <input type="hidden" class="form-control" name="id_pekerjaan" value="<?php echo $_GET['id_pekerjaan']?>" required>
     			 <div class="form-group">
					<label class="col-sm-2 control-label">Kode Sub Pekerjaan : </label>
				    <div class="col-sm-4">
					  <input type="text" class="form-control" value="<?php echo Romawi($r['kode_pekerjaan'])?>.<?php echo $r['kode_sub']?>" disabled="disabled">
				   </div>
                 </div>
				 <div class="form-group">
					<label class="col-sm-2 control-label">Nama Sub Pekerjaan : </label>
				    <div class="col-sm-4">
					  <input type="text" class="form-control" name="nama_sub" value="<?php echo $r['nama_sub']?>" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
				   </div>
                 </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" value="Ubah" class="btn btn-danger btn-fill btn-wd"></input>
                <a href="sub_pekerjaan.php?id_jenis=<?=$_GET['id_jenis']?>&id_pekerjaan=<?=$_GET['id_pekerjaan']?>" class="btn btn-info btn-fill btn-wd">Batal</a>
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