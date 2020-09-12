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
        <li><a href="#"><i class="fa fa-building"></i>Pekerjaan</a></li>
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
               Data Pekerjaan Berhasil Disimpan...
          </div>

<?php }elseif ($pesan == 'gagal') 
      { ?>
	  <br />
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Data Pekerjaan Gagal Disimpan...
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
               Data Pekerjaan Berhasil Dihapus...
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
               Data Pekerjaan Berhasil Ubah...
          </div>

<?php }
      elseif ($pesan == 'gagal') 
      { ?>
	  <br />
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Data Pekerjaan gagal Diubah...
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
              <h3 class="box-title">Data Pekerjaan</h3>
			  
			   <div class="form-group">
			   <br />
                <form action="?" method="GET">
					<div class="input-group input-group-sm">
					  <select name="id_proyek" class="form-control select2" style="width: 100%;">
						<option selected="selected">--Pilih Proyek--</option>
						 <?php
							$query = "SELECT * FROM proyek";
							$result = mysql_query($query);
							
							$sql = mysql_query("SELECT * FROM proyek where id_proyek NOT IN(SELECT id_proyek FROM upah)
							                    OR id_proyek NOT IN(SELECT id_proyek FROM pekerjaan) 
												OR id_proyek NOT IN(SELECT id_proyek FROM bahan_material)");
							$r = mysql_fetch_array($sql);
							$proyek = $r['id_proyek'];
							
							while($row = mysql_fetch_array($result))
							{		
							  ?>
								  <option 
								  <?php
								       if (isset($_GET['id_proyek']))
								       { 
									      if (($row['id_proyek'] == $_GET['id_proyek']))
										  {
										    echo 'selected';
										  }
									   } 
								   ?> 
								       <?php
									      if ($row['id_proyek'] == $proyek)
									   	  {
									   ?>
									       value="<?php echo $row['id_proyek']; ?>"> <?php echo $row['nama_proyek'];?>
										   <a> (Baru)</a>
										<?php	  
										  }
										?>  
								 </option>
								 <option 
								 
								       <?php
									      if ($row['id_proyek'] != $proyek)
									   	  {
										  	  if (($row['id_proyek'] == $_GET['id_proyek']))
										  	  {
										   		echo 'selected';
										  	  }
									   ?>
									     value="<?php echo $row['id_proyek']; ?>"> <?php echo $row['nama_proyek'];  ?>
									  <?php	  
										  }
										?>  
								</option>
							  <?php 
							}
						  ?>
					  </select>
					  <span class="input-group-btn">
						  <button type="submit" class="btn btn-info btn-flat">Pilih</button>
					  </span>
					</div>
					</form>
					
					   <?php
						if(isset($_GET['id_proyek'])) 
					   { 
							$id_proyek = $_GET['id_proyek'];
							$proyek = mysql_query("SELECT * FROM proyek
												   WHERE id_proyek = '$id_proyek'");
							
							
							while($r=mysql_fetch_array($proyek))
							{
							  $biaya = number_format($r['nilai_proyek'],2,',','.');
							   ?>
									<br>
									<br>
									<h5><b> 
									  <div><i class="fa fa-building text-red"></i> Proyek : <code><?php echo " $r[nama_proyek]" ?></code></div><p>
									  <div><i class="fa fa-user text-blue"></i> Pemilik : <?php echo " $r[pemilik]" ?></div><p>
									  <div><i class="fa fa-money text-yellow"></i> Biaya : <?php echo"Rp. $biaya" ?></div><p>
									  <div><i class="fa fa-map-o text-green"></i> Lokasi : <?php echo " $r[lokasi]" ?></div><p>
									</b></h5>
							<?php	  
							}
					  }
					  ?>
					  
				  <br />  
				  <div class="box-body">
				    <h4> Lihat Data Pekerjaan</h4> <br />
					<div class="pull-right">
						<botton class="btn btn-primary btn-fill btn-wd btn-sm" data-toggle="modal" data-target="#myModal_tambah" style="margin-bottom: 10px; margin-top: -30px;"> Tambah</botton>
				      </div>   
					   <table id="tabel1" class="table table-bordered">
						 <thead>
						  <tr>
							<td width="5%"><b>No</b></td>
							<td width="30%"><b>Uraian Pekerjaan</b></td>
							<td width="10%"><b>Volume</b></td> 
							<td width="15%"><b>Harga Satuan</b></td> 
							<td width="15%"><b>Biaya</b></td>
							<td width="20%"><b>Aksi</b></td>
						</tr>
						</thead>
						<tbody>
						   <?php
							if(isset($_GET['id_proyek'])) 
							{ 
								  $id_proyek = $_GET['id_proyek'];
								  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
								  
								  $sql = mysql_query("select * from pekerjaan join proyek on pekerjaan.id_jenis = proyek.id_jenis where id_proyek ='$id_proyek' order by kode_pekerjaan");	  
								  while($r = mysql_fetch_array($sql))
								  {
								 ?>	
								 <tr>	
								     <td>
										<dd><b><?php echo Romawi($r['kode_pekerjaan']) ?></b></dd>
								     </td>
								     <td>
									  	<b><?php echo $r['nama_pekerjaan']; ?></b>
										 <td>&nbsp;</td>
										 <td>&nbsp;</td>
										 <td>&nbsp;</td>
										 <td>&nbsp;</td>	
										
											
								     </td> 
								        <?php
									
									    $sql2 = mysql_query ("SELECT DISTINCT kode_pekerjaan,master_sub_pekerjaan.kode_sub,nama_sub,satuan,id_jenis,pekerjaan.id_pekerjaan,
										                      sub_pekerjaan.id_master_sub 
										                      FROM `master_sub_pekerjaan`
															  LEFT JOIN sub_pekerjaan on master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub
															  JOIN pekerjaan on master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
															  WHERE master_sub_pekerjaan.id_pekerjaan = '".$r['id_pekerjaan']."' order by kode_sub");
										if($sql2)
										{
											while($s=mysql_fetch_array($sql2))
										    {
										    ?>
						                     <tr>
										         <td>
											       <dd><i><center><?php echo Romawi($s['kode_pekerjaan']).'.'.$s['kode_sub']; ?></center></i></dd>
							                     </td>
											     <td><i><?php echo $s['nama_sub']; ?></i></td>
											     <td>  
												<?php
													   $id = $s['id_master_sub'];
													   $sub = "SELECT * from sub_pekerjaan WHERE id_master_sub = '$id' AND id_proyek = '$id_proyek'";
													   $res= mysql_query($sub);
													 ?>
													 
													  <table border="1" > 
                         							    <?php
													       $detail=mysql_fetch_array($res);
														   
														   		?>
																<tr> 
																   <?php 
																	  $id = $detail['id_sub'];
																	  $sqllalu = mysql_query ("SELECT volume,satuan,harga_satuan,jumlah from sub_pekerjaan
																	  						   JOIN master_sub_pekerjaan 
																							   ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub 
																							   WHERE id_sub = '$id' AND id_proyek = '$id_proyek'")or die(mysql_error());
																	  
																	?>
																	<!-- volume-->
																	 <?php while ($r1=mysql_fetch_array($sqllalu))
																	 {
																	   echo $r1['volume']; echo " "; echo $r1['satuan'];
																	 }
																	 ?>
																</tr>
													   <?php  ?>
                     								</table>    
												 </td>
											     <td>
												    <?php
													   $id = $s['id_master_sub'];
													   $sub = "SELECT * from sub_pekerjaan WHERE id_master_sub = '$id' AND id_proyek = '$id_proyek'";
													   $res= mysql_query($sub);
													 ?>
													 
													  <table border="1" > 
                         							    <?php
													       $detail=mysql_fetch_array($res);
														   
														   		?>
																<tr> 
																   <?php 
																	  $id = $detail['id_sub'];
																	  $sql3 = mysql_query ("SELECT volume,satuan,harga_satuan,jumlah from sub_pekerjaan
																	  						   JOIN master_sub_pekerjaan 
																							   ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub 
																							   WHERE id_sub = '$id' AND id_proyek = '$id_proyek'")or die(mysql_error());
																	  
																	?>
																	<!-- volume-->
																	 <?php while ($r2=mysql_fetch_array($sql3))
																	 {
																	   echo "Rp. ". number_format($r2['harga_satuan'],2);
																	 }
																	 ?>
																</tr>
													   <?php  ?>
                     								</table>    
												 </td>
												 <td>
												    <?php
													   $id = $s['id_master_sub'];
													   $sub = "SELECT * from sub_pekerjaan WHERE id_master_sub = '$id' AND id_proyek = '$id_proyek'";
													   $res= mysql_query($sub);
													 ?>
													 
													  <table border="1" > 
                         							    <?php
													       $detail=mysql_fetch_array($res);
														   
														   		?>
																<tr> 
																   <?php 
																	  $id = $detail['id_sub'];
																	  $sql4 = mysql_query ("SELECT volume,satuan,harga_satuan,jumlah from sub_pekerjaan
																	  						   JOIN master_sub_pekerjaan 
																							   ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub 
																							   WHERE id_sub = '$id' AND id_proyek = '$id_proyek'")or die(mysql_error());
																	  
																	?>
																	<!-- volume-->
																	 <?php while ($r3=mysql_fetch_array($sql4))
																	 {
																	   echo "Rp. ". number_format($r3['jumlah'],2);
																	 }
																	 ?>
																</tr>
													   <?php  ?>
                     								</table>    
												 </td>
											     <td>
													  
													  <?php
													  
													      $id = $s['id_master_sub'];
													      $cek_sub = mysql_query("SELECT * from sub_pekerjaan WHERE id_master_sub = '$id' AND id_proyek = '$id_proyek' ");
													      $row = mysql_fetch_array($cek_sub);
													 
														if ($row['id_sub'] > 1)
														{
														?>
														  <botton class="btn btn-danger btn-fill btn-wd btn-sm"
													  	  data-toggle="modal" data-target="#myModal" 
													  	  data-whatever="fungsi.php?proses_hapus=hapus_pp&id_proyek=<?=$_GET['id_proyek']?>&id_sub=<?=$row['id_sub']?>"
													  	  >Hapus</botton>														  
													  <?php
														}
													  ?> 
													  
													  <?php
														if ($s['kode_pekerjaan'] > 1 && $row['id_sub'] > 1)
														{
														?>
														  <a href='detail_pekerjaan.php?id_proyek=<?=$_GET['id_proyek']?>&id_sub=<?=$row['id_sub']?>'class='btn btn-success btn-fill btn-sm' >Analisis Harga Satuan</a>
														  
													  <?php
														}
													  ?> 
													  
												</td>	 
						                    </tr>
										  <?php
										} 
									}else 
									{
									   
									}
								  ?>
									
								<?php
								}
							  }
								?>
									
								</tr>
							 </tbody>	
						</table>
					 </div>
				   <!-- /.-box -->
					  
              </div>
          </div><!-- /.box-header -->
       </div>
      </section>
    </div>
	
	
<!--modal tambah-->
<?php
$link=koneksidb();
$id_proyek = $_GET['id_proyek'];

$sql=mysql_query("SELECT * FROM proyek where id_proyek = '$id_proyek'");
$data=mysql_fetch_array($sql);
$m = $data['id_proyek'];
$jenis = $data['id_jenis'];
?>
 <form role="form" action="fungsi.php?proses_tambah_pekerjaan_proyek" method="POST" class="form-horizontal">
  <input type="hidden" input class="form-control" name="id_proyek" value="<?=$m ?>">
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal_tambah">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
		  <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Tambah Harga & Volume Pekerjaan</h4>
          </div>  
			  <div class="box-body">
				   <div class="form-group">
					 <label class="col-sm-3 control-label">Pekerjaan : </label>
					  <div class="col-md-8">
					   <select class="form-control select2" style="width: 100%;" name="id_master_sub">
						  <?php
							$getbahan1 = mysql_query("SELECT master_sub_pekerjaan.id_master_sub,nama_sub 
													  FROM master_sub_pekerjaan 
													  JOIN pekerjaan ON pekerjaan.id_pekerjaan = master_sub_pekerjaan.id_pekerjaan 
													  WHERE master_sub_pekerjaan.id_master_sub NOT IN(SELECT id_master_sub from sub_pekerjaan WHERE id_proyek = '$m')
													  AND pekerjaan.id_jenis = $jenis");
						  ?>
						  <?php while ($row=mysql_fetch_array($getbahan1)) { ?>
							<option value="<?php echo $row['id_master_sub']; ?>"> <?php echo $row['nama_sub'];  ?></option>
						  <?php } ?>
					   </select>
					  </div>
					</div>
				   	 <div class="form-group">   
					 <label class="col-sm-3 control-label">Harga Satuan: </label>
					  <div class="col-sm-4">
						<div class="input-group">
							<span class="input-group-addon">Rp.</span>
							<input id="harga_bahan" type="text" class="form-control" name="harga_satuan" required>
						</div>
					  </div>
					</div>
					<div class="form-group">
					  <label class="col-sm-3 control-label">Volume Pekerjaan </label>
					  <div class="col-sm-3">
						<input id="volume" type="text" class="form-control" name="volume" required>
					  </div>
					</div>  
				   
				   
          </div> 
            
          <div class="modal-footer">
		  	<input type="submit" value="Simpan" id="tambah" class="btn btn-info btn-fill btn-wd"></input>
            <button type="button" class="btn btn-danger btn-fill btn-wd" data-dismiss="modal">Batal</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>
<!-- akhir modal tambah -->	
	
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