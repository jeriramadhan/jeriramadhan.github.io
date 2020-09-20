<?php 
 include "header.php";
 include "fungsi_romawi.php";
 $link=koneksidb();
 $id_proyek = $_GET['id_proyek'];
 $id_progres = $_GET['id_progres'];
 $query = mysql_query("SELECT  nama_proyek, minggu, bobot_rencana FROM progres JOIN proyek ON proyek.id_proyek = progres.id_proyek
                       WHERE id_progres = '$id_progres' AND progres.id_proyek = '$id_proyek' ");
 $get = mysql_fetch_array($query);
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><i class="fa fa-bar-chart-o"></i> progres</li>
        <li class="active">Tambah Progres</li>
      </ol>
    </section>

<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
		<br />
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Lihat Detail Progres</h3>
			  <br />
			    <div class="pull-right">
					<a href="progres.php?id_proyek=<?php echo $_GET['id_proyek']?>&id_progres=<?php echo $_GET['id_progres'];?>"
					class="btn btn-info btn-fill btn-sm" style="margin-bottom: 10px; margin-top: -30px;"> <i class="fa  fa-reply "></i> <span>Kembali</span></a>                  				     			</div>
            </div>
            <!-- /.box-header -->
            <form role="form" action=" " method="POST" class="form-horizontal">
               <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Proyek  : </label>
                  <div class="col-sm-4">
                    <input class="form-control" value="<?=$get['nama_proyek']?>" disabled>
                  </div>
               </div>
			   <div class="form-group">
                  <label class="col-sm-2 control-label">Minggu ke -  : </label>
                  <div class="col-sm-1">
                    <input class="form-control" value="<?=$get['minggu']?>" disabled>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-sm-2 control-label">Bobot Rencana : </label>
                  <div class="col-sm-2">
                     <div class="input-group">
						<input type="text" class="form-control" value="<?=$get['bobot_rencana']?>" disabled>
                  	 	 <span class="input-group-addon">%</span>
					 </div>
				  </div>
                </div>
              <!-- /.box-body -->
            </form>
                       
               <?php  
                $getbahan = mysql_query("SELECT kode_pekerjaan, sub_pekerjaan.kode_sub, nama_sub,
				                         volume,bobot,volume_realisasi,persen_realisasi,bobot_realisasi,biaya_realisasi,id_detail_pro
				                         FROM sub_pekerjaan
										 LEFT JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub 
										 LEFT JOIN pekerjaan ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
										 LEFT JOIN detail_progres ON sub_pekerjaan.id_sub = detail_progres.id_sub
										 WHERE sub_pekerjaan.id_proyek = '$id_proyek' and detail_progres.id_progres = $id_progres ");
              ?>
              <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                        <tr>
                          <th>No</th>
                          <th>Pekerjaan</th>
						  <th>volume</th>
                          <th>Bobot</th>
						  <th>Volume yang dikerjakan</th>
                          <th>Selesai</th>
                          <th>Bobot Realisasi</th>
                          <th>Biaya Realisasi</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
    
                        $no=0;
                        while($r=mysql_fetch_array($getbahan))
						{
                          echo"
                            <tr>
								<td>".Romawi($r['kode_pekerjaan']).".".$r['kode_sub']."</td>
                                <td>$r[nama_sub]</td>
							  ";
                              ?>
                                <td><?=number_format($r['volume'],3).' %'?></td>
								<td><?=number_format($r['bobot'],3).' %'?></td>
								<td><?=number_format($r['volume_realisasi'],3).' %'?></td>
                                <td><?=number_format($r['persen_realisasi'],0).' %'?></td>
								<td><?=number_format($r['bobot_realisasi'],3).' %'?></td>
                              	<td><?='Rp. '.number_format($r['biaya_realisasi'],2,',','.')?></td>
							</tr>
                         <?php 
						 } 
                      ?>
					  
					   
                      <?php 
					  		//$minggu_ini = $id_progres - 1;
							
							$getbahan1 = mysql_query("SELECT sum(bobot_realisasi) total,sum(biaya_realisasi) total2, bobot_aktual
													  FROM sub_pekerjaan
													  JOIN detail_progres ON sub_pekerjaan.id_sub = detail_progres.id_sub
													  JOIN progres ON detail_progres. id_progres = progres.id_progres
													  WHERE sub_pekerjaan.id_proyek = '$id_proyek' and progres.id_progres = $id_progres");
						    $r1 = mysql_fetch_array($getbahan1);
							
					  ?>
                           <tr>
							    <td>&nbsp;</td>
							</tr>
                            <tr>
								<td><b>Total minggu ini</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b><?=number_format($r1['total'],3).' %'?></b></td>
							   <td><b><?='Rp. '.number_format($r1['total2'],2,',','.')?></b></td>
								
                            </tr>
						</tbody>
                    </table>
                   </div>     
                       
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>



<!--tambah Bahan-->
<form role="form" action="fungsi.php?proses_tambah_detail&id_proyek=<?=$_GET['id_proyek']?>&id_progres=<?=$_GET['id_progres']?> " method="POST" class="form-horizontal">
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tambah Progres Proyek</h4>
          </div>
          <div class="modal-body">
               <div class="box-body">
				  <div class="form-group">
				    <label class="col-sm-3 control-label">Sub Pekerjaan :</label>
				      <div class="col-sm-8">
						 <select class="form-control select2" style="width:100%" name="id_sub">
						  <?php
							  $getbahan1 = mysql_query("SELECT * FROM sub_pekerjaan WHERE id_proyek = '$id_proyek'");
						  ?>
						  
                          <?php while ($row=mysql_fetch_array($getbahan1)) { ?>
                          <option value="<?php echo $row['id_sub']; ?>"> <?php echo $row['nama_sub'];  ?> <?php echo " == [".number_format($row['bobot'],3)." % ]" ; ?></option>
                          <?php } ?>
                   </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Bobot Realisasi : </label>
                  <div class="col-sm-3">
				    <div class="input-group">
                       <input type="text" class="form-control" name="bobot_r" required>
					   <span class="input-group-addon">%</span>
					</div>
                  </div>
               </div>
			   <div class="form-group">
                  <label class="col-sm-3 control-label">Biaya Realisasi : </label>
                  <div class="col-sm-6">
				    <div class="input-group">
                        <span class="input-group-addon">Rp. </span>
						<input id="harga_bahan" type="text" class="form-control" name="biaya_r" style="width:100%" required>
					</div>
                  </div>
               </div>
              </div> 
          </div>
              <!-- /.box-body -->
            
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" value="Simpan" id="delete_link" class="btn btn-info btn-fill btn-wd"></input>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>
<!--end tambah bahan-->


<!--modal hapus-->
<div class="modal fade" tabindex="-1" role="dialog" id="myModal_hapus">
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
            <a href="#" id="link" class="btn btn-primary">Hapus </a>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
 <!--end modal hapus-->

<?php include "footer.php"; ?>