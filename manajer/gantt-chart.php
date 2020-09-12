<?php include "header.php";
    $link=koneksidb();
    $id_proyek = $_GET['id_proyek']; 
    $isi = mysql_query("SELECT proyek.id_proyek,nama_proyek,tanggal_mulai,tanggal_selesai,jadwal.id_sub,nama_sub,
	                    id_jadwal,tanggal_mulai_j as tanggal_mulai_j,tanggal_selesai_j
					    FROM proyek
						JOIN jadwal ON (jadwal.`id_proyek`=proyek.`id_proyek`)
						JOIN sub_pekerjaan ON (sub_pekerjaan.id_sub=jadwal.id_sub)
						JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub=sub_pekerjaan.id_master_sub)
						WHERE jadwal.id_proyek='$id_proyek'");

    $isi1 = mysql_query("SELECT proyek.id_proyek,nama_proyek,tanggal_mulai,tanggal_selesai,jadwal.id_sub,nama_sub,
	                    id_jadwal,tanggal_mulai_j as tanggal_mulai_j,tanggal_selesai_j
						FROM proyek
						JOIN jadwal ON (jadwal.`id_proyek`=proyek.`id_proyek`)
						JOIN sub_pekerjaan ON (sub_pekerjaan.id_sub=jadwal.id_sub)
						JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub=sub_pekerjaan.id_master_sub)
						WHERE jadwal.id_proyek='$id_proyek'");

    $isi2 = mysql_query("SELECT proyek.id_proyek,nama_proyek,tanggal_mulai,tanggal_selesai,jadwal.id_sub,nama_sub,id_jadwal,
	                     date_format(tanggal_mulai_j,'%d/%m/%Y') as tanggal_mulai_j, date_format(tanggal_selesai_j,'%d/%m/%Y')as tanggal_selesai_j 
						 FROM proyek
						 JOIN jadwal ON (jadwal.`id_proyek`=proyek.`id_proyek`)
						 JOIN sub_pekerjaan ON (sub_pekerjaan.id_sub=jadwal.id_sub)
						 JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub=sub_pekerjaan.id_master_sub)
						 WHERE jadwal.id_proyek='$id_proyek'");

    $isi3 = mysql_query("SELECT proyek.id_proyek,nama_proyek,tanggal_mulai,tanggal_selesai,jadwal.id_sub,nama_sub,
	                     id_jadwal,date_format(tanggal_mulai_j,'%d/%m/%Y') as tanggal_mulai_j, date_format(tanggal_selesai_j,'%d/%m/%Y')as tanggal_selesai_j 
						 FROM proyek
						 JOIN jadwal ON (jadwal.`id_proyek`=proyek.`id_proyek`)
						 JOIN sub_pekerjaan ON (sub_pekerjaan.id_sub=jadwal.id_sub)
						 JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub=sub_pekerjaan.id_master_sub)
						 WHERE jadwal.id_proyek='$id_proyek'");

    $row = mysql_fetch_array($isi);

    $isi4 = mysql_query("SELECT * FROM proyek WHERE id_proyek = '$id_proyek'");
    $proyek = mysql_fetch_array($isi4);
    $tgl_mulai_proyek = $proyek['tanggal_mulai'];
    $tgl_selesai_proyek = $proyek['tanggal_selesai'];
    $durasi_proyek = $proyek['durasi_proyek'];
    $jumlahMinggu1 = ceil($durasi_proyek/7);
?>
 <script type="text/javascript">
  FusionCharts.ready(function(){
    var revenueChart = new FusionCharts({
        "type": 'gantt',
        "renderAt": "chartContainer",
        width: '100%',
        height: '500',
        "dataFormat": "json",
        "dataSource":  {
        "chart": {
        "dateformat": "dd/mm/yyyy",
        "caption": "<?php echo "Proyek ". $row['nama_proyek'] ?>",
        "subcaption": "<?php echo date ('d/m/Y',strtotime($row['tanggal_mulai'])).' - ' .date ('d/m/Y',strtotime($row['tanggal_selesai'])); ?>",
        "ganttpaneduration": "3",
        "ganttpanedurationunit": "m",
        "showborder": "0"
        },
    "categories": [{
            "category": [ <?php
                // inisialisasi tanggal mulai dan tanggal selesai untuk minggu pertama. 
                $tglMulaiPeriode = $tgl_mulai_proyek;
                $tglSelesaiPeriode = date('Y-m-d',strtotime('+6 days',strtotime($tglMulaiPeriode)));

                // mengelompokan tanggal mulai dan tanggal selesai per periode minggu ke dalam array.
                $periode = array();
                for ($i=0; $i < $jumlahMinggu1; $i++) { 
                    $periode[$i]['tglMulai'] = date('d/m/Y',strtotime($tglMulaiPeriode));
                    $periode[$i]['tglSelesai'] = date('d/m/Y',strtotime($tglSelesaiPeriode));

                    $tglMulaiPeriode = date('Y-m-d',strtotime('+1 days',strtotime($tglSelesaiPeriode)));
                    $tglSelesaiPeriode = date('Y-m-d',strtotime('+6 days',strtotime($tglMulaiPeriode))); 
                        
                }

                // memasukan data periode ke dalam gantt chart.
                $n = 1;
                for ($i=0; $i < $jumlahMinggu1; $i++) { ?>
                    {
                        "start": "<?=$periode[$i]['tglMulai']?>",
                        "end": "<?=$periode[$i]['tglSelesai']?>",
                        "label": "Minggu <?=$n?>"
                    },
                <?php 
                    $n++; 
                } ?>
            ]
        }],
    "processes": {
        "fontsize": "10",
        "isbold": "1",
        "align": "left",
        "headertext": "Pekerjaan",
        "headerfontsize": "12",
        "headervalign": "bottom",
        "headeralign": "left",
        "process": [
                <?php while ($row=mysql_fetch_array($isi1)) { ?>
                    {
                    "label":"<?=$row['nama_sub']?>"
                    },

                <?php } ?>
        ]
    },
    "datatable": {
        "headervalign": "bottom",
        "datacolumn": [{
                "headertext": "Tanggal",
                "headerfontsize": "12",
                "headervalign": "bottom",
                "headeralign": "right",
                "align": "left",
                "fontsize": "10",
                "text": [

                <?php  while ($row=mysql_fetch_array($isi2)) { ?>

                    {
                        "label": "<?=$row['tanggal_mulai_j'].' - '.$row['tanggal_selesai_j']?>"
                    },

            <?php } ?>

                ]
            }
        ]
    },
    "tasks": {
        "color":"#7FFFD4",
        "task": [
            <?php while ($row1=mysql_fetch_array($isi3)) { ?>
                
                {
                    "start": "<?=$row1['tanggal_mulai_j']?>",
                    "end": "<?=$row1['tanggal_selesai_j']?>"
                },

            <?php } ?>

        ]
    }
  }

});
revenueChart.render();
});
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-home"></i>Beranda</a></li>
        <li class="active">Gantt Chart</li>
      </ol>
    </section>

<!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Gantt Chart</h3>
            </div>
            <div class="box-header"><a href='index.php?id_proyek=<?php echo $id_proyek; ?>' class='btn btn-info btn-fill btn-wd btn-xs full-right' >Kembali</a></div>
            <!-- /.box-header -->
            <div id="chartContainer"></div>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<?php include "footer.php"; ?>