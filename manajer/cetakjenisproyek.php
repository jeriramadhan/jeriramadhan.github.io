<?php
include "header_cetak.php";
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
					  <h2 class="box-title">Data Jenis Kegiatan</h2>
					</div>
				
					<!-- /.box-header -->
					<div class="box-body">
					   <table class="table table-bordered table-striped">
					      <thead>
							<tr>
							  <th width="20">No</th>
							  <th width="112">Nama Jenis Kegiatan</th>
							  <!-- <th width="109">Aksi</th> -->
							</tr>
						  </thead>
						  <tbody>
						   <?php
						   		    $kegiatan = mysql_query("SELECT * FROM jenis_proyek order by nama_jenis");
									$no=0;
									while($r=mysql_fetch_array($kegiatan))
									{
									  $n=1;
									  $no=$no+$n;
									
									  echo"
										<tr>
										  <td align='left'>$no</td>
										   <td>$r[nama_jenis]</td>"
									?>
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