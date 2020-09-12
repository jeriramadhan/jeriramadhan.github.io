<?php
include "header.php";

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-bar-chart-o"></i>Progres</a></li>
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
              <h3 class="box-title">Data Progres</h3>
			  
			   <div class="form-group">
			   <br />
                <form action="?" method="GET">
					<div class="input-group input-group-sm">
					  <select name="id_proyek" class="form-control select2" style="width: 100%;">
						<option selected="selected">--Pilih Proyek--</option>
						 <?php
							$query = "SELECT * FROM proyek";
							$result = mysql_query($query);
							while($row = mysql_fetch_array($result))
							{		
							  ?>
								  <option <?php if (isset($_GET['id_proyek'])){ if (($row['id_proyek'] == $_GET['id_proyek'])) { echo 'selected'; }} ?> 
								  value="<?php echo $row['id_proyek']; ?>"> <?php echo $row['nama_proyek'];  ?></option>
							  <?php 
							}
						  ?>
					  </select>
					  <span class="input-group-btn">
						  <button type="submit" class="btn btn-info btn-flat">Pilih</button>
					  </span>
					</div>
					</form>
              </div>
            </div><!-- /.box-header -->
		 <div class="box-body">
				<br />
					<div class="box-header with-border">
					  <h2 class="box-title">Progres Mingguan</h2>
					</div>
				
					<!-- /.box-header -->
					<div class="box-body">
					   <table id="tabel1" class="table table-bordered table-striped">
					      <thead>
							<tr>
							  <th width="20">Minggu ke</th>
							  <th width="112">Bobot Rencana</th>
							  <th width="112">Bobot Aktual</th>
							  <th width="112">Biaya Aktual</th>
							  <th width="109">Aksi</th>
							</tr>
						  </thead>
						  <tbody>
						   <?php
			  					if(isset($_GET['id_proyek'])) 
								{ 
									$id_proyek = $_GET['id_proyek'];
									$kegiatan = mysql_query("select * from progres where id_proyek = '$id_proyek'");
									$no=0;
									while($r=mysql_fetch_array($kegiatan))
									{
									  
									  echo"
										<tr>
										   <td align='left'>$r[minggu]</td>
										 "
							 ?>
							 			   <td><?php echo number_format($r['bobot_rencana'],2) ?> %</td>
										   <td><?php echo number_format($r['bobot_aktual'],2) ?> %</td>
										   <td><?php echo 'Rp. '. number_format($r['biaya_aktual'],2) ?></td>
										   <td>
											   
											  <?php if ($r['bobot_aktual']==NULL || $r['bobot_aktual']== 0) { ?>
											   <a href='tambah_progres.php?id_proyek=<?=$r['id_proyek']?>&id_progres=<?=$r['id_progres']?>'
									           class='btn btn-success btn-fill btn-sm' >Tambah Progres</a>
											  <?php } else { ?>
												  <botton class="btn btn-success btn-fill btn-sm" disabled>Tambah Progres</botton>
											  <?php } ?>
											  
											  
                                  				   <a href="detail_progres.php?&id_proyek=<?=$_GET['id_proyek']?>&id_progres=<?=$r['id_progres']?>"
											       class="btn btn-primary btn-fill btn-sm">Lihat</a>
											  
											   
											  <?php
											   $gethapus = mysql_query("SELECT id_progres FROM progres where bobot_aktual > 0 ORDER BY id_progres DESC LIMIT 1");
                                			   $j2 = mysql_fetch_array($gethapus);
                                			   if ($r['id_progres']== $j2['id_progres'])
											   {?>
                                  				   <a href="fungsi.php?proses_hapus=hapus_aktual&id_proyek=<?=$_GET['id_proyek']?>&id_progres=<?=$r['id_progres']?>"
								                   class="btn btn-warning btn-fill btn-sm">Hapus</a>
											   <?php
											   } ?>
										   </td>
										</tr> 
						      <?php 
								     }
								}
							  ?>
						  </tbody>
					    </table>
				    </div>
			  </div>
            <!-- /.tab-content -->
		 </div>
       </div>
        </section>
      </div>
	
		 
<?php
include "footer.php";
?>