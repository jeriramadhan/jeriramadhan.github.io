<?php 
  include "header.php";
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-building"></i>Ubah Password</a></li>
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
              <h3 class="box-title">Form Ubah Password</h3>
            </div>
            <!-- /.box-header -->
             <!-- /.box-header -->

					<form method="post">
					 <div class="box-body">
					 	<?php
							echo "<h3> Username ".$_SESSION['username']."</h3>";
							?>
							<form method="post">
							<label>Password Lama</label>
							<input type="password" name="old_password">
							<label>Password Baru</label>
							<input type="password" name="new_password">
							<p></p>
							<input type="submit" class="btn btn-info" name="button" value="Ubah">
							</form>
							<?php
							if(isset($_POST['button']))
							{
								$username = $_SESSION['username'];
								$sc1=sprintf("Select * from user where username='%s' and password='%s'",$_SESSION['username'],($_POST['old_password']));
								
								$q1=mysql_query($sc1);
								$rc1=mysql_num_rows($q1);
								if($rc1==1)
								{
									$sc2=sprintf("Update user Set password='%s' Where username='%s'",($_POST['new_password']),$_SESSION['username']);
									$q2=mysql_query($sc2);
									if($q2)
									{
										echo "<script>alert('Password berhasil diubah,silahkan login kembali untuk melihat perubahan'); window.location.href = 'index.php';</script>";
									}
								}else{
									echo "<script>alert('Verifikasi Password lama salah')</script>";
								}
							}
							?>
					 
					  </div>
					</form>
					
						
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

<?php include "footer.php"; ?>