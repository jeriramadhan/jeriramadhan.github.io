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
                  $id=$_GET['id_alat'];
				  $id_proyek=$_GET['id_proyek'];
                  $data=mysql_query("SELECT * FROM bahan_material WHERE id_bahan='$id'");
                  $r=mysql_fetch_array($data);
              ?>
            <!-- form start -->
            <form role="form" action="fungsi.php?proses2=ubah_alat" method="POST" class="form-horizontal">
              <div class="box-body">
			     <input type="hidden" class="form-control" name="id_alat" value="<?php echo $id ?>">
				 <input type="hidden" class="form-control" name="id_proyek" value="<?php echo $id_proyek ?>">
     			 <div class="form-group">
					<label class="col-sm-2 control-label">Nama Alat : </label>
				    <div class="col-sm-4">
					  <input type="text" class="form-control" name="nama_alat" value="<?php echo $r['nama_bahan']?>" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
				   </div>
               </div>
			   <div class="form-group">
				 <label class="col-sm-2 control-label">Harga Satuan Alat : </label>
				 <div class="col-sm-4">
				  <div class="input-group">
				   <span class="input-group-addon">Rp.</span>
					  <input id="harga_bahan" type="text"  class="form-control" name="biaya" value="<?php echo number_format($r['harga_bahan'],2,',','.');?>" required>
				  </div>
				  <font><code>*minimal harga Rp. 100</code></font>
				 </div>	
			   </div>
			    <div class="form-group">
                  <label class="col-sm-2 control-label">Satuan : </label>
                  <div class="col-xs-2">
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
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" value="Ubah" class="btn btn-danger btn-fill btn-wd"></input>
                <a href="alat.php?id_proyek=<?=$_GET['id_proyek']?>" class="btn btn-info btn-fill btn-wd">Batal</a>
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