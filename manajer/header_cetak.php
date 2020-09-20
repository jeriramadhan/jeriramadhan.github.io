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
