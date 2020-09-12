<?php
include "header.php";
  $link=koneksidb();
  $id=$_GET['id_proyek'];
  $data=mysql_query("SELECT id_proyek,nama_proyek FROM proyek");
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <section class="content-header">
      <br />
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-building"></i>Detail CPM</a></li>
      </ol>
  </section>
  <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Detail Critical Path Methode (CPM)</h3>
              <div class="form-group">
              </div>
            </div>
    <?php
        if(isset($_GET['id_proyek'])) 
		{ 
          $id_proyek = $_GET['id_proyek'];
          $jadwal = mysql_query("SELECT jadwal.id_proyek,jadwal.id_sub,nama_sub,id_jadwal,tanggal_mulai_j,tanggal_selesai_j,durasi_kegiatan,es,ef,ls,lf,sl
		                         FROM jadwal
								 JOIN sub_pekerjaan ON (sub_pekerjaan.id_sub=jadwal.id_sub)
								 JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub=sub_pekerjaan.id_master_sub)
								 WHERE jadwal.id_proyek='$id_proyek'");
    ?>

            <!-- /.box-header -->
            <div class="box-body">
            <div class="pull-right">
              <a href="index.php?id_proyek=<?php echo $_GET['id_proyek'];?>" class="btn btn-primary btn-fill btn-sm" style="margin-bottom: 10px; margin-top: -30px;">Kembali</a>
</div>
              <table id="tabel1" class="table table-bordered table-striped">
                <thead>
     
                        <tr>
                          <th>No</th>
                          <th>Nama Pekerjaan</th>
                          <th>Earliest Start</th>
                          <th>Earliest Finish</th>
                          <th>Slack</th>
                          <th>Latest Start</th>
                          <th>Latest Finish</th>
                          <!--<th> Aksi</th>-->
                        </tr>
                      </thead>
                      <tbody>
                      <?php
    
                        $no=0;
                        while($r=mysql_fetch_array($jadwal)){
                          $n=1;
                          $no=$no+$n;
                          echo"
                            <tr>
                              <td align='center'>$no</td>
                              <td>$r[nama_sub]</td>
                              <td>$r[es]</td>
                              <td>$r[ef]</td>
                              <td>$r[sl]</td>
                              <td>$r[ls]</td>
                              <td>$r[lf]</td>
                              <!--<td>
                              <a href='' class='btn btn-info btn-fill btn-sm' >Ubah</a>
                              <a href='' class='btn btn-danger btn-fill btn-sm'>Hapus</a></td>-->
                            </tr>
                          ";
                        $n++; }
                      ?>
                      </tbody>
                        </table>
                      </div>

    <?php } ?>
            
                  </div>
              </div>
          </div>
        </section>
      </div>
<?php
include "footer.php";
?>