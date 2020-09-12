<?php
include "header.php";
$link=koneksidb();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <ol class="breadcrumb"></ol>
	  
    <?php

    if (isset($_GET['pesan']))
    {
        $pesan = $_GET['pesan'];
      if ($pesan == 'sukses') 
      { ?>
        
          <div class="alert alert-success alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Proyek Berhasil Disimpan...
          </div>

<?php }elseif ($pesan == 'gagal') 
      { ?>
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Proyek Gagal Disimpan...
          </div>           
<?php }
    }
    else if (isset($_GET['hapus']))
    {
        $pesan = $_GET['hapus'];
      if ($pesan == 'sukses') 
      { ?>
        
          <div class="alert alert-success alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Proyek Berhasil Dihapus...
          </div>

<?php }
    }
    elseif (isset($_GET['edit']))
    {
        $pesan = $_GET['edit'];
      if ($pesan == 'sukses') 
      { ?>
        
          <div class="alert alert-success alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Proyek Berhasil Ubah...
          </div>

<?php }
      elseif ($pesan == 'gagal') 
      { ?>
       <div class="alert alert-danger alert-dismissible" style="margin-bottom: -10px;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
               Proyek gagal Diubah...
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
              <li class="active"><a href="#lihat_proyek" data-toggle="tab">Lihat Proyek</a></li>
            </ul>
			
			<div class="tab-content">
              <div class="active tab-pane" id="lihat_proyek">
                <!-- Post -->
                <div class="post">
				<br />
					<div class="box-header with-border">
					  <h2 class="box-title">Data Proyek</h2>
					</div>
				
					<!-- /.box-header -->
					<div class="box-body">
					  <table id="tabel1" class="table table-bordered table-striped" width="100%">
                <thead>
    				    <tr>
						  <th rowspan="2">No. SPK</th>
						  <th rowspan="2">Nama Proyek</th>
						  <th rowspan="2">Durasi (Hari)</th>
						  <th rowspan="2">Tanggal Mulai</th>
						  <th rowspan="2">Tanggal Selesai</th>
						  <th rowspan="2">Nilai Kontrak (Rp)</th>
						  <th rowspan="2">Pemilik Proyek</th>
						  <th colspan="3"><center>Lokasi</center></th>
						  <th rowspan="2">Aksi</th>
						</tr>
						<tr>
						  <th>Kecamatan</th>
						  <th>Kabupaten/Kota</th>
						  <th>Provinsi</th>
						</tr>
                      </thead>
                      <tbody>
                      <?php
      
						$proyek = mysql_query("SELECT * FROM proyek
											   JOIN prov ON proyek.id_prov = prov.id_prov
											   JOIN kabkot ON proyek.id_kabkot = kabkot.id_kabkot
											   JOIN kec ON proyek.id_kec = kec.id_kec 
											   WHERE baca = 'T'");
                        $no=0;
                        while($r=mysql_fetch_array($proyek)){
                          $n=1;
                          $no=$no+$n;
                           
						   $id = $r['id_proyek'];
                          echo"
                            <tr>
                              <td>$r[no_spk]</td>
                              <td>$r[nama_proyek]</td>
                              <td>$r[durasi_proyek]</td>
							  <td>".date ("d/m/Y", strtotime($r['tanggal_mulai']))."</td>
                              <td>".date ("d/m/Y", strtotime($r['tanggal_selesai']))."</td>
                              <td>".number_format($r['nilai_proyek'],2,',','.')."</td>
							  <td>$r[pemilik]</td>
							  <td>$r[nama_kec]</td>
							  <td>$r[nama_kabkot]</td>
							  <td>$r[nama_prov]</td>
							 ";
                          ?>
                          <td>
                              <a href="fungsi.php?proses_hapus=ubah_baca&id_proyek=<?=$r['id_proyek']?>" class="btn btn-info btn-fill btn-sm">Tambah Progres</a>
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