<?php
include "header_cetak.php";
$sql=mysql_query("SELECT * FROM proyek ORDER BY id_proyek DESC LIMIT 10");
 $data=mysql_fetch_array($sql);
 $now = date("mdY");
 $kodeawal=substr($data['id_proyek'],1,3)+1;
 if($kodeawal<10){
  $kode='P00'.$kodeawal.$now;
 }elseif($kodeawal > 9 && $kodeawal <=99){
  $kode='P0'.$kodeawal.$now;
 }else{
  $kode='P0'.$kodeawal.$now;
 }
?>

<script type="text/javascript">
  function cetak() {
    var tombol = document.getElementById("tombol");
    tombol.innerHTML = '';
    window.print();
  }
</script>
<br><br><br>
<div class="pull-right">
  <!-- <a href="" onclick="javascript:cetak()" id="tombol"><i class="fa fa-print"></i> cetak kuitansi</a> -->
  <button onClick="javascript:cetak()" id="tombol"><i class="fa fa-print"></i>Cetak Data Proyek</button>
</div>
<?php
$link=koneksidb();
?>
<!-- Content Wrapper. Contains page content -->
<!-- <div class="content-wrapper"> -->
  <!-- Content Header (Page header) -->

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="nav-tabs-custom">
            <div class="active tab-pane" id="lihat_proyek">
              <!-- Post -->
              <div class="post">
                <br />
                <div class="box-header with-border">
                  <h2 class="box-title">Data Proyek</h2>
                </div>

                <!-- /.box-header -->
                <div class="box-body">
                  <table id="tabel1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th rowspan="2">Id Proyek</th>
                        <th rowspan="2">No. SPK</th>
                        <th rowspan="2">Nama Proyek</th>
                        <th rowspan="2">Durasi (Hari)</th>
                        <th rowspan="2">Tanggal Mulai</th>
                        <th rowspan="2">Tanggal Selesai</th>
                        <th rowspan="2">Nilai Kontrak (Rp)</th>
                        <th rowspan="2">Pemilik Proyek</th>
                        <th rowspan="2">Lokasi</th>
                        <!-- <th rowspan="2">Aksi</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <?php
      
												$proyek = mysql_query("SELECT * FROM proyek GROUP BY id_proyek");
												if (!$proyek) { // add this check.
    die('Invalid query: ' . mysql_error());
}
                        $no=0;
                        while($r=mysql_fetch_array($proyek)){
                          $n=1;
                          $no=$no+$n;
                        
                          echo"
                            <tr>
                              <td>$r[id_proyek]</td>
							  <td>$r[no_spk]</td>
                              <td>$r[nama_proyek]</td>
                              <td>$r[durasi_proyek]</td>
							  <td>".date ("d/m/Y", strtotime($r['tanggal_mulai']))."</td>
                              <td>".date ("d/m/Y", strtotime($r['tanggal_selesai']))."</td>
                              <td>".number_format($r['nilai_proyek'],2,',','.')."</td>
								<td>$r[pemilik]</td>
								<td>$r[lokasi]</td>
							 ";
                          ?>
                      <!-- <td>
												<a href="edit_proyek.php?id_proyek=<?php echo $r['id_proyek']?>"
													class="btn btn-info btn-fill btn-sm">Ubah</a>
												<botton class="btn btn-danger btn-fill btn-sm" data-toggle="modal" data-target="#myModal"
													data-whatever="fungsi.php?proses_hapus=hapus_proyek&id_proyek=<?=$r['id_proyek']?>">Hapus
												</botton>
											</td> -->
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


<?php
include "footer.php";
?>