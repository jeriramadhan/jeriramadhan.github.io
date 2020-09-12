<?php 
 include "header.php";
 include "fungsi_romawi.php";
 $link=koneksidb();
 $id_proyek = $_GET['id_proyek'];
 $id_sub = $_GET['id_sub'];
 $getsub = mysql_query("SELECT pekerjaan.id_pekerjaan,kode_pekerjaan,master_sub_pekerjaan.kode_sub,nama_sub,id_sub
                        FROM master_sub_pekerjaan JOIN pekerjaan
						ON (master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan)
						JOIN sub_pekerjaan
						ON (master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub)
          				WHERE sub_pekerjaan.id_proyek = '$id_proyek' AND sub_pekerjaan.id_sub = '$id_sub'");
 $get = mysql_fetch_array($getsub);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><i class="fa fa-building"></i>Sub_Pekerjaan</li>
        <li class="active">Analisis Harga Satuan</li>
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
			  <?php
			  	$nama = mysql_query("SELECT nama_proyek FROM proyek WHERE id_proyek = '$id_proyek'");
				$proyek = mysql_fetch_array($nama);
				$nama_proyek = $proyek['nama_proyek'];
			  ?>
			
              <h3 class="box-title">Analisis Harga Satuan <?php echo $nama_proyek ?> </h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="fungsi.php?proses_tambah_hpk" method="POST" class="form-horizontal">
               <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Kode Pekerjaan : </label>
                  <div class="col-sm-1">
                    <input class="form-control" value="<?=Romawi($get['kode_pekerjaan']).".".$get['kode_sub']?>" disabled>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-sm-2 control-label">Nama Pekerjaan : </label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" value="<?=$get['nama_sub']?>" disabled>
                  </div>
                </div>
              <!-- /.box-body -->
            </form>
               <div class="box-body">
			      <div class="pull-right">
							<a href="pekerjaan_proyek.php?id_proyek=<?php echo $_GET['id_proyek']?>"
							class="btn btn-info btn-fill btn-sm" style="margin-bottom: 10px; margin-top: -30px;"> <i class="fa  fa-reply "></i> <span>Kembali</span></a>                  </div>
               </div>               
              <?php  
                $getbahan = mysql_query("SELECT id_detail,tenaga.id_tenaga,jenis_tenaga,kode_tenaga,upah,kuantitas,jumlah
										FROM detail_sub
										JOIN tenaga ON (tenaga.id_tenaga = detail_sub.id_tenaga)
										WHERE detail_sub.id_sub ='$get[id_sub]' AND kode_tenaga LIKE 'L0%'");
              ?>
              <div class="box-body">
			  <h4>Tabel Tenaga</h4>
              <table class="table table-bordered table-striped">
             <thead>
     
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Kode</th>
                          <th>Kuantitas</th>
                          <th>Satuan</th>
						  <th>Harga Satuan</th>
                          <th>Jumlah</th>
                          <th>
						  	<div align="right">
						  	  <botton class="btn btn-success btn-fill btn-wd btn-sm" data-toggle="modal" data-target="#myModal" >Tambah Tenaga</botton>
						  	</div>
						  </th>
                        </tr>
                      </thead>
                      <?php
    
                        $no=0;
                        while($r=mysql_fetch_array($getbahan)){
                          $n=1;
                          $no=$no+$n;
                          echo"
                            <tr>
                              <td align='center'>$no</td>
                           	  <td>$r[jenis_tenaga]</td>
							  <td>$r[kode_tenaga]</td>
							  <td>$r[kuantitas]</td>
							  <td>jam</td>
                              <td>Rp.".number_format($r['upah'],2,',','.')."</td>
                              <td>Rp.".number_format($r['jumlah'],3,',','.')."</td>
                              ";
                              ?>
                              <td>
                              <botton class="btn btn-danger btn-fill btn-wd btn-sm"
                              data-toggle="modal" data-target="#myModal_hapus" data-whatever="fungsi.php?proses_hapus_detail=hapus_detail&id_proyek=<?=$_GET['id_proyek']?>&id_sub=<?=$_GET['id_sub']?>&id_detail=<?=$r['id_detail']?>"
                              >Hapus</botton></td>
                          
                         <?php }?>
						 
                      <?php $getbahan1 = mysql_query("SELECT sum(jumlah) total
													FROM detail_sub JOIN tenaga
													ON (tenaga.id_tenaga = detail_sub.id_tenaga)
													WHERE detail_sub.id_sub = '$get[id_sub]' and kode_tenaga like 'L0%'");
						    $r1 = mysql_fetch_array($getbahan1);
					    ?>
                      </tr>
                            <tr>
								<td><b>Total</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b><?='Rp.'.number_format($r1['total'],2,',','.')?></b></td>
								<td></td>
							</tr>
                      </tbody>
                        </table>
                   </div>
				                    
              <?php  
                $getbahan = mysql_query("SELECT bahan_material.id_bahan,kode,nama_bahan,harga_bahan,id_detail,kuantitas,jumlah,satuan
										FROM detail_sub JOIN bahan_material
										ON (bahan_material.id_bahan = detail_sub.id_bahan)
										WHERE detail_sub.id_sub = '$get[id_sub]' AND kode LIKE 'M0%'");
              ?>
              <div class="box-body">
			  <h4>Tabel Bahan</h4>
              <table class="table table-bordered table-striped">
                <thead>
     
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Kode</th>
                          <th>Kuantitas</th>
                          <th>Satuan</th>
						  <th>Harga Satuan</th>
                          <th>Jumlah</th>
                          <th>
						  	<div align="right">
						  	  <botton class="btn btn-success btn-fill btn-wd btn-sm" data-toggle="modal" data-target="#myModal_tambah" >Tambah Bahan</botton>
						  	</div>
						  </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
    
                        $no=0;
                        while($r=mysql_fetch_array($getbahan)){
                          $n=1;
                          $no=$no+$n;
                          echo"
                            <tr>
                              <td align='center'>$no</td>
                              <td>$r[nama_bahan]</td>
                              <td>$r[kode]</td>
                              <td>$r[kuantitas]</td>
                              <td>$r[satuan]</td>
							  <td>Rp.".number_format($r['harga_bahan'],2,',','.')."</td>
                              <td>Rp.".number_format($r['jumlah'],3,',','.')."</td>
                              ";
                              ?>
                              <td>
                              <botton class="btn btn-danger btn-fill btn-wd btn-sm"
                              data-toggle="modal" data-target="#myModal_hapus" data-whatever="fungsi.php?proses_hapus_detail=hapus_detail&id_proyek=<?=$_GET['id_proyek']?>&id_sub=<?=$_GET['id_sub']?>&id_detail=<?=$r['id_detail']?>"
                              >Hapus</botton></td>
                          
                         <?php } 
                      ?>
                      <?php $getbahan1 = mysql_query("SELECT sum(jumlah) total
													FROM detail_sub JOIN bahan_material
													ON (bahan_material.id_bahan = detail_sub.id_bahan)
													WHERE detail_sub.id_sub = '$get[id_sub]' and kode like 'M0%' ");
						    $r1 = mysql_fetch_array($getbahan1);
					    ?>
                      </tr>
                            <tr>
								<td><b>Total</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b><?='Rp.'.number_format($r1['total'],2,',','.')?></b></td>
								<td></td>
								</tr>
                      </tbody>
                        </table>
                   </div>     
                                 
              <?php  
                $getbahan = mysql_query("SELECT bahan_material.id_bahan,kode,nama_bahan,harga_bahan,id_detail,kuantitas,jumlah,satuan
										FROM detail_sub JOIN bahan_material
										ON (bahan_material.id_bahan = detail_sub.id_bahan)
										WHERE detail_sub.id_sub = '$get[id_sub]' AND kode LIKE 'E0%'");
			   ?>
              <div class="box-body">
			  <h4>Tabel Alat</h4>
              <table class="table table-bordered table-striped">
                <thead>
     
                        <tr>
                          <th>No</th>
                          <th>Nama</th>
                          <th>Kode</th>
                          <th>Kuantitas</th>
                          <th>Satuan</th>
                          <th>Harga Satuan</th>
                          <th>Jumlah</th>
                          <th>
						     <div align="right">
						  	   <botton class="btn btn-success btn-fill btn-wd btn-sm" data-toggle="modal" data-target="#myModal_tambah2">Tambah Alat</botton>
						  	 </div>
						  </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
    
                        $no=0;
                        while($r=mysql_fetch_array($getbahan)){
                          $n=1;
                          $no=$no+$n;
                          echo"
                            <tr>
                              <td align='center'>$no</td>
                              <td>$r[nama_bahan]</td>
                              <td>$r[kode]</td>
                              <td>$r[kuantitas]</td>
                              <td>$r[satuan]</td>
							  <td>Rp.".number_format($r['harga_bahan'],2,',','.')."</td>
                              <td>Rp.".number_format($r['jumlah'],2,',','.')."</td>
                              ";
                              ?>
                              <td>
                              <botton class="btn btn-danger btn-fill btn-wd btn-sm"
                              data-toggle="modal" data-target="#myModal_hapus" data-whatever="fungsi.php?proses_hapus_detail=hapus_detail&id_proyek=<?=$_GET['id_proyek']?>&id_sub=<?=$_GET['id_sub']?>&id_detail=<?=$r['id_detail']?>"
                              >Hapus</botton></td>
                          
                         <?php } 
                      ?>
                      <?php $getbahan1 = mysql_query("SELECT sum(jumlah) total
													  FROM detail_sub JOIN bahan_material
													  ON (bahan_material.id_bahan = detail_sub.id_bahan)
													  WHERE detail_sub.id_sub = '$get[id_sub]' and kode like 'E0%' ");
						    $r1 = mysql_fetch_array($getbahan1);
					  ?>
                      </tr>
                            <tr>
								<td><b>Total</b></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><b><?='Rp.'.number_format($r1['total'],2,',','.')?></b></td>
								<td></td>
                            </tr>
                      </tbody>
                        </table>
                      </div>  
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


<!--tambah Bahan-->
<form role="form" action="fungsi.php?proses_tambah_detail_tenaga&id_proyek=<?=$_GET['id_proyek']?>" method="POST" class="form-horizontal">
<input type="hidden" name="id_sub" value="<?=$id_sub?>">
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tambah Tenaga</h4>
          </div>
          <div class="modal-body">
               <div class="box-body">
               <div class="form-group">
                  <label class="col-sm-3 control-label">Tenaga : </label>
                  <div class="col-sm-8">
                    <?php
                      $getbahan1 = mysql_query("SELECT * FROM tenaga WHERE id_proyek = '$id_proyek'");
                    ?>
                   <select class="form-control select2" style="width: 70%;" name="id_bahan">
                   <option></option>
                          <?php while ($row=mysql_fetch_array($getbahan1)) { ?>
                          <option value="<?php echo $row['id_tenaga']; ?>"> <?php echo $row['jenis_tenaga'];  ?></option>
                          <?php } ?>
                   </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Kuantitas : </label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="kuantitas" onkeyup="this.value=this.value.replace(/[^\\0-9\\.\\]/g, '')" required>
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

<!--tambah Bahan-->
<form role="form" action="fungsi.php?proses_tambah_detail&id_proyek=<?=$_GET['id_proyek']?>" method="POST" class="form-horizontal">
<input type="hidden" name="id_sub" value="<?=$id_sub?>">
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal_tambah">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tambah Bahan Material</h4>
          </div>
          <div class="modal-body">
               <div class="box-body">
               <div class="form-group">
                  <label class="col-sm-3 control-label">Nama Bahan : </label>
                  <div class="col-sm-8">
                    <?php
                      $getbahan1 = mysql_query("SELECT * FROM bahan_material WHERE id_proyek = '$id_proyek' AND kode LIKE 'M0%'");
                    ?>
                   <select class="form-control select2" style="width: 70%;" name="id_bahan">
                   <option></option>
                          <?php while ($row=mysql_fetch_array($getbahan1)) { ?>
                          <option value="<?php echo $row['id_bahan']; ?>"> <?php echo $row['nama_bahan'];  ?></option>
                          <?php } ?>
                   </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Kuantitas : </label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="kuantitas" onkeyup="this.value=this.value.replace(/[^\\0-9\\.\\]/g, '')" required>
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

<!--tambah Alat-->
<form role="form" action="fungsi.php?proses_tambah_detail&id_proyek=<?=$_GET['id_proyek']?>" method="POST" class="form-horizontal">
<input type="hidden" name="id_sub" value="<?=$id_sub?>">
  <div class="modal fade" tabindex="-1" role="dialog" id="myModal_tambah2">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tambah Alat</h4>
          </div>
          <div class="modal-body">
               <div class="box-body">
               <div class="form-group">
                  <label class="col-sm-3 control-label">Nama Alat : </label>
                  <div class="col-sm-8">
                   <select class="form-control select2" style="width: 70%;" name="id_bahan">
					  <?php
						$getbahan1 =mysql_query("SELECT * FROM bahan_material WHERE id_proyek = '$id_proyek' AND kode LIKE 'E0%'");
					  ?>
					  <?php while ($row=mysql_fetch_array($getbahan1)) { ?>
						<option value="<?php echo $row['id_bahan']; ?>"> <?php echo $row['nama_bahan'];  ?></option>
					  <?php } ?>
                   </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Kuantitas : </label>
                  <div class="col-sm-3">
                    <input type="text" class="form-control" name="kuantitas" onkeyup="this.value=this.value.replace(/[^\\0-9\\.\\]/g, '')" required>
                  </div>
               </div>
              </div> 
          </div>
              <!-- /.box-body -->
            
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <input type="submit" value="Simpan" id="tambah" class="btn btn-info btn-fill btn-wd"></input>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</form>
<!--end tambah Alat-->    

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