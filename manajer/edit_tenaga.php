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
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
              <?php 
                  $link=koneksidb();
                  $id=$_GET['id_tenaga'];
                  $data=mysql_query("SELECT * FROM tenaga WHERE id_tenaga='$id'");
                  $r=mysql_fetch_array($data);
				 
              ?>
            <!-- form start -->
            <form role="form" action="fungsi.php?proses2=ubah_upah" method="POST" class="form-horizontal">
              <div class="box-body">
			     <input type="hidden" class="form-control" name="id_tenaga" value="<?php echo $id ?>">
				 <input type="hidden" class="form-control" name="id_proyek" value="<?php echo $r['id_proyek']?>" required>
		
		         <div class="form-group">
					<label class="col-sm-2 control-label">Kode Tenaga: </label>
				    <div class="col-sm-4">
					  <input type="text" class="form-control" name="kode_tenaga" value="<?php echo $r['kode_tenaga']?>" readonly>
				   </div>
				   </div>
     			 <div class="form-group">
					<label class="col-sm-2 control-label">Jenis Tenaga : </label>
				    <div class="col-sm-4">
					  <input type="text" class="form-control" name="jenis_tenaga" value="<?php echo $r['jenis_tenaga']?>" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
				   </div>
				   </div>
				   <div class="form-group">
				     <label class="col-sm-2 control-label">Upah : </label>
				     <div class="col-sm-4">
					  <div class="input-group">
				   	   <span class="input-group-addon">Rp.</span>
					  	  <input id="harga_bahan" type="text"  class="form-control" name="upah" value="<?php echo number_format($r['upah'],2,',','.');?>" required>
					   <span class="input-group-addon">/Jam</span>
				      </div>
					  <font><code>*minimal upah Rp. 1000 / Jam </code></font>
				     </div>	
				   </div>
				   
               </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" value="Ubah" class="btn btn-danger btn-fill btn-wd"></input>
                <a href="tenaga.php?id_proyek=<?=$_GET['id_proyek']?>" class="btn btn-info btn-fill btn-wd">Batal</a>
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