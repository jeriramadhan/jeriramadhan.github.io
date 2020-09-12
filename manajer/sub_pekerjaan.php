<?php
include "header.php";
include "fungsi_romawi.php";
$link=koneksidb();
$id_jenis = $_GET['id_jenis'];
$id_pekerjaan = $_GET['id_pekerjaan'];
$getbahan = mysql_query("select * from bahan_material");
$getbahan1 = mysql_query("select * from bahan_material");
$get = mysql_fetch_array($getbahan1);

 $sql=mysql_query("SELECT * FROM master_sub_pekerjaan 
                   JOIN pekerjaan ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
				   WHERE id_jenis = '$id_jenis' AND pekerjaan.id_pekerjaan = '$id_pekerjaan' order by kode_sub DESC LIMIT 1");
 $data=mysql_fetch_array($sql);
 //get kode h pekerjaan
 $getkode = mysql_query("SELECT kode_pekerjaan from pekerjaan where id_pekerjaan = $id_pekerjaan");
 $row = mysql_fetch_array($getkode);
 $kodeawal=$row['kode_pekerjaan'];

 $cek = mysql_num_rows($sql);
 if($cek == NULL)
 {
    $newID = Romawi($kodeawal).'.1';
    $kode1=1;
 }
 else
 {
     $kode= $data['kode_sub'];
     $kode1=$kode + 1;
     $newID = Romawi($kodeawal).'.'.$kode1;
 }

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-building"></i>Sub Pekerjaan</a></li>
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
          <div class="alert alert-warning alert-dismissible" style="margin-bottom: -10px;">
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
		  <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#lihat_kegiatan" data-toggle="tab">Lihat Sub Pekerjaan</a></li>
              <li><a href="#tambah_kegiatan" data-toggle="tab">Tambah Sub Pekerjaan</a></li>
            </ul>
			
			<div class="tab-content">
			<br />
			 <?php
					$id_jenis = $_GET['id_jenis'];
					$id_pekerjaan = $_GET['id_pekerjaan'];
					$jenis = mysql_query("SELECT nama_jenis, nama_pekerjaan
										  FROM jenis_proyek 
										  JOIN pekerjaan ON jenis_proyek.id_jenis = pekerjaan.id_jenis
										  WHERE jenis_proyek.id_jenis = '$id_jenis' and id_pekerjaan = $id_pekerjaan");
					
					
					while($r=mysql_fetch_array($jenis))
					{
					   ?>
							<h5><b> 
							  <div><i class="fa fa-building text-red"></i> Jenis Proyek : <code><?php echo " $r[nama_jenis]" ?></code></div><p>
							  <div><i class="fa fa-book text-yellow"></i> Pekerjaan : <?php echo " $r[nama_pekerjaan]" ?></div><p>
							</b></h5>
							<br />
					<?php	  
					}
			  ?>
              <div class="tab-pane" id="tambah_kegiatan">
                <!-- Post -->
                <div class="post">
                    <br />
					    <div class="box-header with-border">
						  <h3 class="box-title">Form Tambah Sub Pekerjaan (Master)</h3>
						</div>
						<!-- /.box-header -->				
						<!-- form start -->
					    
						<form role="form" action="fungsi.php?proses_tambah_sub" method="POST" class="form-horizontal" id="tambah">
						  <input type="hidden" class="form-control" name="id_jenis" value="<?=$_GET['id_jenis'] ?>">
						   <input type="hidden" class="form-control" name="id_pekerjaan" value="<?=$_GET['id_pekerjaan'] ?>">
						     <div class="box-body">
							  <div class="form-group">
								  <label class="col-sm-2 control-label">Kode Pekerjaan : </label>
								  <div class="col-sm-2">
									<input type="hidden" class="form-control" name="kode_sub" value="<?php echo $kode1;?>">
								  <input type="text" class="form-control" value="<?php echo $newID;?>" disabled>
								  </div>
							   </div>
							   <div class="form-group">
								  <label class="col-sm-2 control-label">Nama Sub Pekerjaan : </label>
								  <div class="col-sm-3">
									<input type="text" class="form-control" name="nama_sub" onkeyup="this.value=this.value.replace(/[^\\a-z\\A-Z\\ \\]/g, '')" required>
								  </div>
								</div>
								<?php
								
									$id_pekerjaan = $_GET['id_pekerjaan'];
									$sql = mysql_query("SELECT kode_pekerjaan FROM pekerjaan where id_pekerjaan = $id_pekerjaan");
									$r = mysql_fetch_array($sql);
									$cek = $r['kode_pekerjaan'];
									
									if ($cek != 1)
									{?>
										<div class="form-group">
										  <label class="col-sm-2 control-label">Satuan : </label>
										  <div class="col-sm-2">
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
									 	
							   <?php } ?>
							  </div>
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
					  <h2 class="box-title">Data Sub Pekerjaan (Master)</h2>
					</div>
				   <br />
					<!-- /.box-header -->
					<div class="box-body">
					<?php
					  $id_jenis = $_GET['id_jenis'];
					  $id_pekerjaan = $_GET['id_pekerjaan'];
					  $sub_pekerjaan = mysql_query("SELECT * FROM master_sub_pekerjaan
					                                JOIN pekerjaan ON (pekerjaan.id_pekerjaan = master_sub_pekerjaan.id_pekerjaan)
													WHERE pekerjaan.id_jenis = '$id_jenis' AND master_sub_pekerjaan.id_pekerjaan='$id_pekerjaan'");
			 	    ?>
			
						<!-- /.box-header -->
						<div class="box-body">
						  <div class="pull-right">
							<a href="pekerjaan.php?id_jenis=<?php echo $_GET['id_jenis']; ?>"
							class="btn btn-info btn-fill btn-sm" style="margin-bottom: 10px; margin-top: -30px;"> <i class="fa  fa-reply "></i> <span>Kembali</span></a>                          </div>
				            <table id="tabel1" class="table table-bordered table-striped">
					          <thead>
								<tr>
								  <th>Kode</th>
								  <th>Nama Sub Pekerjaan</th>
								  <th>Satuan</th>
								  <th width="200"> Aksi</th>
								</tr>
							  </thead>
							  <tbody>
							  <?php
			
								$no=0;
								while($r=mysql_fetch_array($sub_pekerjaan)){
								  $n=1;
								  $no=$no+$n;
								  echo"
									<tr>
									  <td>".Romawi($r['kode_pekerjaan']).".".$r['kode_sub']."</td>
									  <td>$r[nama_sub]</td>
									  <td>$r[satuan]</td>
									  <td>";
									  ?>
						  
									  <a href='edit_sub.php?id_jenis=<?=$_GET['id_jenis']?>&id_pekerjaan=<?=$r['id_pekerjaan']?>&id_sub=<?=$r['id_master_sub']?>'class='btn btn-info btn-fill btn-sm' >Ubah</a>
									  <botton class="btn btn-danger btn-fill btn-sm" data-toggle="modal" data-target="#myModal" data-whatever="fungsi.php?proses_hapus=hapus_sub&id_pekerjaan=<?=$_GET['id_pekerjaan']?>&id_jenis=<?=$_GET['id_jenis']?>&id_sub=<?=$r['id_master_sub']?>">Hapus</botton> </td>
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