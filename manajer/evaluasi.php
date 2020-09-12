<?php 
  include "header.php";
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="index.php?id_proyek=<?=$_GET['id_proyek']?>"><i class="fa fa-home"></i>Beranda</a></li>
        <li class="active">Data Evaluasi</li>
      </ol>
    </section>
	
	<br />
<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Data Evaluasi</h3>
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
					  
					 <table id="tabel2" class="table table-bordered table-striped">
						<thead>
			                    <tr>
								  <th rowspan="2">Minggu Ke-</th>
								  <th rowspan="2">Komulatif Planned Value (PV)</th>
								  <th rowspan="2">Komulatif Earned Value (EV)</th>
								  <th rowspan="2">Komulatif Actual Cost (AC)</th>
								  <th colspan="2"><center>Analisis Variance</center></th>
								  <th colspan="2"><center>Analisis Kinerja</center></th>
								  <th colspan="2"><center>Analisis Estimasi</center></th>
								</tr>
								<tr>
								  <th>Schedule Variance(SV)</th>
								  <th>Cost Variance(CV)</th>
								  <th>Schedule Performance Index (SPI)</th>
								  <th>Cost Performance Index (CPI)</th>
								  <th>Estimate at Completion (EAC)</th>
								  <th>Estimate to Complete (ETC)</th>
								</tr>
					    </thead>
							  <tbody>
							  <?php
			  					if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$detail = mysql_query("select * from evaluasi join progres on evaluasi.id_progres = progres.id_progres where progres.id_proyek = '$id_proyek' order by minggu");
								while($row=mysql_fetch_array($detail))
								{
								  echo"
									<tr>
									  <td align='center'>$row[minggu]</td>
									  <td>Rp. ".number_format(round($row['pv_komulatif'],2),2,',','.')."</td>
									  <td>Rp. ".number_format(round($row['ev_komulatif'],2),2,',','.')."</td>
									  <td>Rp. ".number_format(round($row['ac_komulatif'],2),2,',','.')."</td>
									  <td>$row[sv]</td>
									  <td>$row[cv]</td>
									  <td>".number_format ($row['spi'],2)."</td>
									  <td>".number_format ($row['cpi'],2)."</td>
									  <td>Rp. ".number_format(round($row['eac'],2),2,',','.')."</td>
									  <td>".number_format ($row['etc'],2)."</td>
							          "; 
									?>
									</tr> 
								  <?php
								}
							  }
							  ?>
							  </tbody>
					  </table>
					  
					  <?php
					  if(isset($_GET['id_proyek'])) 
					   { 
						  $id_proyek = $_GET['id_proyek'];
					  
					      $query = mysql_query("select * from evaluasi join progres on evaluasi.id_progres = progres.id_progres where progres.id_proyek = '$id_proyek' order by minggu DESC limit 1");
						  $evaluasi= mysql_fetch_array($query);
						  $CV = $evaluasi['cv'];
						  $SV = $evaluasi['sv'];
						  $CPI = $evaluasi['cpi'];
						  $SPI = $evaluasi['spi'];
						  $periode = $evaluasi['minggu'];
						  ?>
							<div class="panel-heading">
							  <?php
									   if($CV>0 AND $CPI>1)
									   {
										 $penilaiancv = "Lebih rendah dari anggaran";
									   }
									   else if ($CV==0 AND $CPI==1)
									   {
										$penilaiancv = "Pengeluaran = Biaya rencana";
									   }
									   else if ($CV<0 AND $CPI<1)
									   {
										$penilaiancv = "Lebih besar dari anggaran";
									   }
									   else{
									       $penilaiancv = " ";
									   }
					
									   if ($SV>0 AND $SPI>1)
									   {
										$penilaiansv = "Pengerjaan lebih cepat dari jadwal rencana";
									   }
									   else if ($SV==0 AND $SPI==1)
									   {
										$penilaiansv = "Sesuai jadwal";
									   }
									   else if ($SV<0 AND $SPI<1)
									   {
										 $penilaiansv = "Pengerjaan lebih lambat dari jadwal rencana";
									   }
									   else{$penilaiansv = " ";}
								  ?>
						    <?php 
						    }
							?>
							
								<br />
							<div class="col-md-4">				
								<div class="box box-solid box-info">
									<div class="box-header with-border">
									  <h3 class="box-title">Keterangan</h3>
					
									  <div class="box-tools pull-right">
										<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
										</button>
										<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
										</button>
									  </div>
									</div>
									<!-- /.box-header -->
									<div class="box-body no-padding">
										 <?php
											   echo "  Pada Minggu Ke- $periode <br>";
											   echo "  Biaya $penilaiancv dan <br>";
											   echo "  Waktu $penilaiansv";
										  ?>
									</div>
									<!-- /.box-body -->
								</div>
						  </div>
						
				   </div>
              </div>
           </div>
     </section>
    </div>
<?php
include "footer.php";
?>