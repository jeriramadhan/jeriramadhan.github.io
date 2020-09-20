<?php
session_start();
if(empty($_SESSION)){
  header("Location: ../index.php");
}

include"../koneksi.php";
$link=koneksidb();
$username=$_SESSION['username'];
$sql=mysql_query("SELECT * FROM user WHERE username ='$username' ");
$q=mysql_fetch_array($sql);		
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CPM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../style/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../style/plugins/datepicker/datepicker3.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../style/plugins/select2/select2.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../style/plugins/datatables/dataTables.bootstrap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../style/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" type="text/css" href="../sweetalert-master/dist/sweetalert.css">
  <script type="text/javascript" src="../sweetalert-master/dist/sweetalert.min.js"></script>
  <link rel="stylesheet" href="../style/dist/css/skins/_all-skins.min.css">
  <script type="text/javascript" src="../fusioncharts/js/fusioncharts.js"></script>
  <script type="text/javascript" src="../fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>
  <!-- ECharts -->
  <script src="../style/echarts/dist/echarts.min.js"></script>
  <meta name="description"
    content="A PERT chart: a diagram for visualizing and analyzing task dependencies and bottlenecks." />
  <!-- Copyright 1998-2017 by Northwoods Software Corporation. -->
  <meta charset="UTF-8">
  <script src="../style/go.js"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script src="../style/go.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini skin-green" onLoad="init()">
  <div class="wrapper">
    <header class="main-header">
      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">
          <font size="4px" color="#FFFFFF" face="berlin Sans FB" style="font-variant:small-caps;font-weight:800">BU
          </font>
        </span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          <font size="5px" color="#FFFFFF" face="berlin Sans FB" style="font-variant:small-caps;font-weight:800">CPM
          </font>
        </span>
      </a>
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-bell fa-lg text-red"></i>

                <?php
			  
			  			$getid = mysql_query("SELECT id_proyek FROM proyek");
						$cek_id = mysql_fetch_array($getid);
						$id = $cek_id['id_proyek'];
						
				  		$proyek = mysql_query("SELECT COUNT( DISTINCT evaluasi.id_proyek) as jumlah 
											   FROM `proyek` 
											   JOIN evaluasi ON proyek.id_proyek = evaluasi.id_proyek 
											   WHERE status = 'T'
											   AND etc > durasi_proyek OR eac > nilai_proyek");
											   	
						while($r=mysql_fetch_array($proyek))
						{
						   
						   $j = $r['jumlah'];
						   
						   if ($j > 0)
						   {
			                  ?>
                <span class="label">
                  <i class="fa fa-certificate text-orange"></i>
                </span>
                <?php
						   }
						   else
						   {
							 ?>
                <span class="label ">
                  <?php  echo " ";?>
                </span>
                <?php
						   }
						}
				  ?>
              </a>

              <ul class="dropdown-menu">
                <li class="header">Pemberitahuan</li>

                <br>
                <li>
                  <?php
					      $proyek2 = mysql_query("SELECT proyek.id_proyek, max(eac),max(etc) 
						                          FROM `proyek` 
												  JOIN evaluasi ON proyek.id_proyek = evaluasi.id_proyek 
												  JOIN jadwal ON proyek.id_proyek = jadwal.id_proyek 
												  WHERE id_jadwal NOT IN(SELECT id_jadwal FROM percepatan)
												  AND proyek.id_proyek NOT IN(SELECT proyek.id_proyek FROM percepatan WHERE proyek.id_proyek = '$id')
												  AND etc > durasi_proyek OR eac > nilai_proyek");
												  
						  $row = mysql_fetch_array($proyek2);
						  
						?>

                  <?php
					   	  if($j > 0)
						  {
							?>
                  <a href="percepat_pekerjaan.php?id_proyek=<?=$row['id_proyek']?>">
                    <?php
						  }
					    ?>

                    <?php
							$proyek = mysql_query("SELECT COUNT( DISTINCT evaluasi.id_proyek) as jumlah 
											   	   FROM `proyek` 
											       JOIN evaluasi ON proyek.id_proyek = evaluasi.id_proyek 
											       WHERE status = 'T'
											       AND etc > durasi_proyek OR eac > nilai_proyek");
						?>

                    <?php 
							while($r = mysql_fetch_array($proyek))
							{
							
							   if ($r['jumlah'] > 0)
						       {
							       ?> <i class="fa fa-warning text-orange"></i> <?php echo"$r[jumlah]"." Proyek harus dipercepat";
							   }
							   else
							   {
							       ?> <div align="center"><code><?php  echo" Proyek berjalan sesuai dengan rencana"; ?></code></div> <?php
							   }
							}
						  ?>
                  </a>
                </li>

                <li class="divider"></li>
              </ul>
            <!-- </li> -->

            <?php  
			if(isset($_GET['id_proyek'])) 
			{ 
			     $id_proyek = $_GET['id_proyek'];
			}
			else
			{
				 $id_proyek = 0;
			}	
		    ?>

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../style/dist/img/avatar1.png" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $q['nama_user'] ?></span>
              </a>
              <ul class="dropdown-menu" s>
                <!-- User image -->
                <li>&nbsp;</li>
                <li><a href="edit_password.php?id_proyek=<?php echo $id_proyek?>"><span class="fa fa-wrench"></span> Ubah Password</a></li>
			  <li class="divider"></li>
                <li><a href="user.php?id_proyek=<?php echo $id_proyek?>"><span class="fa fa-users"></span>Olah Pengguna</a></li>
			  <li class="divider"></li>
                <li><a href="../logout.php"><span class="fa fa-power-off"></span> Keluar</a></li>
                <li class="divider"></li>
                <li class="user-footer">
                  <img src="../style/dist/img/avatar1.png" class="user-image" alt="User Image">
                  <?php echo $q['nama_user']; ?></li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="../style/dist/img/avatar1.png" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $q['nama_user']; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->

        <?php  
			if(isset($_GET['id_proyek'])) 
			{ 
			     $id_proyek = $_GET['id_proyek'];
			}
			else
			{
				 $id_proyek = 0;
			}	
		?>
        <?php  
			if(isset($_GET['id_jenis'])) 
			{ 
			     $id_jenis = $_GET['id_jenis'];
			}
			else
			{
				 $id_jenis = 0;
			}	
		?>

        <ul class="sidebar-menu">
          <li class="header">MENU UTAMA</li>
          <br>
          <li>
            <a href="index.php?id_proyek=<?php echo $id_proyek?>" style="border-radius:40px"><i class="fa fa-home"></i>
              <span>Beranda</span></a></li>
          <li>
            <a href="proyek.php?id_proyek=<?php echo $id_proyek?>" style="border-radius:40px"><i
                class="fa  fa-building-o"></i> <span>Data Proyek</span></a></li>
          <li>
            <a href="jenis_proyek.php" style="border-radius:40px"><i class="fa  fa-database"></i> <span>Data
                Kegiatan</span></a></li>
          <li class="treeview">
            <a href="#" style="border-radius:40px">
              <i class="fa  fa-book"></i> <span>Data Harga</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="border-radius:40px">
              <li><a href="tenaga.php?id_proyek=<?php echo $id_proyek?>"><i class="fa fa-money"></i> Tenaga</a></li>
              <li><a href="alat.php?id_proyek=<?php echo $id_proyek?>"><i class="fa fa-wrench"></i>Alat</a></li>
              <li><a href="bahan.php?id_proyek=<?php echo $id_proyek?>"><i class="fa fa-book"></i>Bahan Material</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="pekerjaan_proyek.php?id_proyek=<?php echo $id_proyek?>" style="border-radius:40px"><i
                class="fa fa-gavel"></i> <span>Pekerjaan Proyek</span></a></li>
          <li class="treeview">
            <a href="#" style="border-radius:40px">
              <i class="fa  fa-calendar-check-o"></i> <span>Jadwal Pekerjaan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" style="border-radius:40px">
              <li><a href="jadwal.php?id_proyek=<?php echo $id_proyek?>"><i class="fa  fa-calendar"></i> <span>Data
                    Jadwal</span></a></li>
              <li><a href="percepatan.php?id_proyek=<?php echo $id_proyek?>"><i
                    class="fa fa-calendar-plus-o"></i>Percepatan</a></li>
            </ul>
          </li>

          <li><a href="progres.php?id_proyek=<?php echo $id_proyek?>"><i class="fa fa-check-square-o"></i>Data Progres</a></li>
          <li><a href="progres_pelaksana.php?id_proyek=<?php echo $id_proyek?>"><i class="fa fa-check-square-o"></i>Data Progres Pelaksana</a></li>

          <!-- <li class="treeview">
            <a href="#" style="border-radius:40px">
              <i class="fa fa-bar-chart-o"></i> <span>Progress Proyek</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right "></i>
              </span>
            </a>
            <ul class="treeview-menu" style="border-radius:40px">
              <li><a href="evaluasi.php?id_proyek=<?php echo $id_proyek?>"><i class="fa fa-area-chart"></i> <span>Data Evaluasi</span></a></li>
              <li><a href="progres.php?id_proyek=<?php echo $id_proyek?>"><i class="fa fa-check-square-o"></i>Data Progres</a></li>
              <li><a href="progres_pelaksana.php?id_proyek=<?php echo $id_proyek?>"><i class="fa fa-check-square-o"></i>Data Progres Pelaksana</a></li>
            </ul>
          </li> -->




          <!-- <li class="header">DATA MASTER</li>
		
		<li>
          <a href="satuan.php?id_proyek=<?php echo $id_proyek?>"style="border-radius:40px"><i class="fa fa-pencil"></i><span> Satuan</span></a></li> 
		 
		<br>
		<li>
		  <a href="jenis_proyek.php"style="border-radius:40px"><i class="fa  fa-database"></i> <span>Jenis Proyek</span></a></li>  -->
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
