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
                  $id=$_GET['id_proyek'];
                  $data=mysql_query("SELECT * FROM proyek WHERE id_proyek='$id'");
                  $r=mysql_fetch_array($data);
              ?>
            <!-- form start -->
            <form role="form" action="fungsi.php?proses2=ubah_proyek" method="POST" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Id Proyek : </label>
                  <div class="col-sm-2">
                    <input type="text" class="form-control" value="<?php echo $id ?>" disabled>
                    <input type="hidden" class="form-control" name="id_proyek" value="<?php echo $id ?>">
                  </div>
				 </div>
     			 <div class="form-group">
					<label class="col-sm-2 control-label">No. SPK : </label>
				    <div class="col-sm-4">
					  <input type="text" class="form-control" name="no_spk" value="<?php echo $r['no_spk']?>" disabled="disabled">
				   </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label">Jenis Proyek : </label>
					 <div class="col-sm-3">
					   <select class="form-control select2" style="width: 100%;" name="id_jenis" required>
						<option></option>
						<?php 
						  $getjenis = mysql_query("select * from jenis_proyek")
						?>
						  <?php while ($row=mysql_fetch_array($getjenis)) { ?>
						  <option <?php if($r['id_jenis'] == $row['id_jenis']) echo 'selected' ?> value="<?php echo $row['id_jenis']; ?>"> <?php echo $row['nama_jenis'];  ?></option>
						  <?php } ?>
					  </select>
				  </div>
				</div>
			    <div class="form-group">
				 <label class="col-sm-2 control-label">Nama Proyek : </label>
				 <div class="col-sm-3">
					 <textarea style="resize:none;width:300px;height:80px;" name="nama_proyek" required><?php echo $r['nama_proyek']?></textarea>
				 </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Tanggal Mulai: </label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                        <input type="text" class="form-control pull-right" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo date('m/d/Y',strtotime($r['tanggal_mulai'])); ?>" required>
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Durasi: </label>
                  <div class="col-sm-2">
                    <div class="input-group">
                      <input type="number" min="1" pattern=" >1" class="form-control" name="durasi_proyek" value="<?php echo $r['durasi_proyek'] ?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" requiredrequired>
                      <span class="input-group-addon">Hari</span>
                    </div>  
                  </div>
                </div>
				
				  <div class="form-group">
                  <label class="col-sm-2 control-label">Biaya: </label>
                  <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon">Rp.</span>
                        <input id="harga_bahan" type="text" class="form-control" name="biaya" value="<?php echo number_format($r['biaya'],2,',','.') ?>" required>
                    </div>
                  </div>
                </div>
				
				<div class="form-group">
                  <label class="col-sm-2 control-label">Pemilik Proyek : </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" name="pemilik" value="<?php echo $r['pemilik'] ?>" onkeyup="this.value=this.value.replace(/[^a-z or A-Z]/g,'')"required>
                  </div>
                </div>
				<div class="form-group">
				<label class="col-sm-2 control-label">Lokasi Proyek </label>
        <div class="col-sm-4">
                    <input type="text" class="form-control" name="lokasi" value="<?php echo $r['lokasi'] ?>" onkeyup="this.value=this.value.replace(/[^a-z or A-Z]/g,'')"required>
                  </div>
				</div>

              <!-- /.box-body -->

              <div class="box-footer">
                <input type="submit" value="Ubah" class="btn btn-danger btn-fill btn-wd"></input>
                <a href="proyek.php" class="btn btn-info btn-fill btn-wd">Batal</a>
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