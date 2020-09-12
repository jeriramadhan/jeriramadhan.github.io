<?php
include "fungsi_romawi.php"; 
?>
<div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
		  <div class="box" style="background-color:#f7f5f6">
            <div class="box-header"><h3 class="box-title">Info Proyek</h3>
			   <div class="box-tools pull-right">
			      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			   </div>
			</div>
           	<div class="box-body">
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
								  value="<?php echo $row['id_proyek']; ?>"><?php echo $row['nama_proyek'];  ?></option>
							  <?php 
							}
						  ?>
					  </select>
					      <span class="input-group-btn"><button type="submit" class="btn btn-info btn-flat">Pilih</button></span>
					</div>
				</form>
				 <br>
				  <!--isi konten -->
				 
				 
		   <div class="row">
			<!-- Left col -->
			   								
			  <div class="col-md-4">
			  <!-- Info Boxes Style 2 -->
			    <div class="info-box" style="background-color:#fff">
				    <div class="info-box-content" style="margin-left:5px">
					   <i class="fa  fa-user text-orange"> </i><span> Pemilik Proyek</span>
						  <span class="info-box-number">
						  	  <?php
			  				   if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									 $pemilik = $r['pemilik'];
									  echo $pemilik;
									 
									}
							   }
							  ?>
						  </span>
						  <div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
						  </div>
						  <span class="progress-description">
						   
						   <i class="fa  fa-map-o text-blue"> </i><span> Lokasi Proyek</span>
						   <span class="info-box-number">
							 <?php
			  				   if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("SELECT * FROM proyek
														 JOIN prov ON proyek.id_prov = prov.id_prov
														 JOIN kabkot ON proyek.id_kabkot = kabkot.id_kabkot
														 JOIN kec ON proyek.id_kec = kec.id_kec 
														 WHERE id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									  echo"Kec.$r[nama_kec], <br>";
									  echo"$r[nama_kabkot] - ";
									  echo"$r[nama_prov]";
									 
									}
							   }
							  ?>
							  </span>
						  </span>
						  
						  <div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
						  </div>
						  <span class="progress-description">
						   
						   <i class="fa  fa-money"> </i><span> Nilai Proyek</span>
						   <span class="info-box-number">
							<?php
			  				   if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									 $biaya = number_format($r['nilai_proyek'],2,',','.');
									  echo"Rp. $biaya";
									 
									}
							   }
							  ?>
							  </span>
						  </span>
						  
						  <div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
						  </div>
						  <span class="progress-description">
						   
						   <i class="fa  fa-list-alt text-red"> </i><span> No. SPK</span>
						   <span class="info-box-number">
							<?php
			  				   if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									  echo" $r[no_spk]";
									 
									}
							   }
							  ?>
							  </span>
						  </span>
						  
						  <br />
						  <i class="fa  fa-calendar text-green"> </i><span> Tanggal Mulai</span>
						  <span class="info-box-number">
						  	  <?php
			  				   if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select * from proyek where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									  echo date ("d/m/Y", strtotime($r['tanggal_mulai'])); 
									}
							   }
							  ?>
						  </span>
						  <div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
						  </div>
						  <span class="progress-description">
						   
						   <i class="fa  fa-calendar text-green"> </i><span> Tanggal Selesai</span>
						   <span class="info-box-number">
							<?php
			  				   if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									  echo date ("d/m/Y", strtotime($r['tanggal_selesai']));
									}
							   }
							  ?>
							  </span>
						  </span>
						  
						  <div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
						  </div>
						  <span class="progress-description">
						   
						   <i class="fa  fa-repeat"> </i><span> Durasi Proyek</span>
						   <span class="info-box-number">
							<?php
			  				   if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									  echo" $r[durasi_proyek]"." hari";
									 
									}
							   }
							  ?>
							  </span>
						  </span>
						  
						  <div class="progress">
							<div class="progress-bar" style="width: 100%"></div>
						  </div>
						  <span class="progress-description">
						   
						  <i class="fa fa-pencil-square-o text-red"> </i><span> ID Proyek</span>
						   <span class="info-box-number">
							<?php
			  				   if(isset($_GET['id_proyek'])) 
							   { 
							    $id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select * from proyek  where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									  echo" $r[id_proyek]";
									 
									}
							   }
							  ?>
							  </span>
						  </span>
							
				   <!-- /.info-box-content -->
				</div>
			    <!-- /.info-box -->
			</div>
			</div>
			
				 
		    <div class="col-md-8">
			     <div class="box box-solid box-default">
				   <div class="box-body">  
				      <i class="fa fa-sitemap text-navy"> </i><span> Diagram Jaringan (Pekerjaan)</span>
					   <div align="right">
						   <a href="detail.php?id_proyek=<?=$_GET['id_proyek']?>" class="btn bg-navy btn-sm" ><span class="fa fa-external-link-square"></span>  Detail CPM</a>
						</div>
					  <br />
					     <?php
						 if (isset($_GET['id_proyek']))
						 {
							$id_proyek = $_GET['id_proyek'];
							$getjadwal = mysql_query("SELECT pekerjaan.kode_pekerjaan kode_h,pekerjaan.id_pekerjaan id_h,
													  sub_pekerjaan.id_sub id_sub,sub_pekerjaan.kode_sub,nama_sub,tanggal_mulai_j,tanggal_selesai_j,es,ef,durasi_kegiatan,ls,lf,sl
													  FROM jadwal
													  JOIN sub_pekerjaan ON (jadwal.id_sub = sub_pekerjaan.id_sub)
													  JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub=sub_pekerjaan.id_master_sub)
													  JOIN pekerjaan ON (master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan)
													  WHERE sub_pekerjaan.id_proyek = '$id_proyek'");
									  
							$getpendahulu = mysql_query("SELECT * FROM pendahulu JOIN jadwal ON pendahulu.`id_sub` = jadwal.`id_sub`");
						 }
							?>
							<script id="code">
							  // This variation on ForceDirectedLayout does not move any selected Nodes
							  // but does move all other nodes (vertexes).
							  function ContinuousForceDirectedLayout() {
								go.ForceDirectedLayout.call(this);
								this._isObserving = false;
							  }
							  go.Diagram.inherit(ContinuousForceDirectedLayout, go.ForceDirectedLayout);
							
							  /** @override */
							  ContinuousForceDirectedLayout.prototype.isFixed = function(v) {
								return v.node.isSelected;
							  }
							
							  // optimization: reuse the ForceDirectedNetwork rather than re-create it each time
							  /** @override */
							  ContinuousForceDirectedLayout.prototype.doLayout = function(coll) {
								if (!this._isObserving) {
								  this._isObserving = true;
								  // cacheing the network means we need to recreate it if nodes or links have been added or removed or relinked,
								  // so we need to track structural model changes to discard the saved network.
								  var lay = this;
								  this.diagram.addModelChangedListener(function (e) {
									// modelChanges include a few cases that we don't actually care about, such as
									// "nodeCategory" or "linkToPortId", but we'll go ahead and recreate the network anyway.
									// Also clear the network when replacing the model.
									if (e.modelChange !== "" ||
										(e.change === go.ChangedEvent.Transaction && e.propertyName === "StartingFirstTransaction")) {
									  lay.network = null;
									}
								  });
								}
								var net = this.network;
								if (net === null) {  // the first time, just create the network as normal
								  this.network = net = this.makeNetwork(coll);
								} else {  // but on reuse we need to update the LayoutVertex.bounds for selected nodes
								  this.diagram.nodes.each(function (n) {
									var v = net.findVertex(n);
									if (v !== null) v.bounds = n.actualBounds;
								  });
								}
								// now perform the normal layout
								go.ForceDirectedLayout.prototype.doLayout.call(this, coll);
								// doLayout normally discards the LayoutNetwork by setting Layout.network to null;
								// here we remember it for next time
								this.network = net;
							  }
							  // end ContinuousForceDirectedLayout
							
							
							  function init() {
								if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
								var $ = go.GraphObject.make;  // for conciseness in defining templates
							
								myDiagram =
								  $(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
									{
									  initialAutoScale: go.Diagram.Uniform,  // an initial automatic zoom-to-fit
									  contentAlignment: go.Spot.Center,  // align document to the center of the viewport
									  layout:
										$(ContinuousForceDirectedLayout,  // automatically spread nodes apart while dragging
										  { defaultSpringLength: 30, defaultElectricalCharge: 100 }),
									  // do an extra layout at the end of a move
									  "SelectionMoved": function(e) { e.diagram.layout.invalidateLayout(); }
									});
							
								// dragging a node invalidates the Diagram.layout, causing a layout during the drag
								myDiagram.toolManager.draggingTool.doMouseMove = function() {
								  go.DraggingTool.prototype.doMouseMove.call(this);
								  if (this.isActive) { this.diagram.layout.invalidateLayout(); }
								}
							
								// define each Node's appearance
								myDiagram.nodeTemplate =
								  $(go.Node, "Auto",  // the whole node panel
									// define the node's outer shape, which will surround the TextBlock
									
									//cpm
									 
									$(go.Shape, "Circle",{ fill: "#ccffcc" , stroke: "black", spot1: new go.Spot(0, 0, 5, 5), spot2: new go.Spot(1, 1, -5, -5)}),	
									$(go.TextBlock, new go.Binding("text", "slack"),{ row: 2, column: 1, margin: 5, textAlign: "right" }),
									$(go.TextBlock, { font: "bold 10pt helvetica, bold arial, sans-serif", textAlign: "center", maxSize: new go.Size(100, NaN) },new go.Binding("text", "text"))	  
								  );
								// the rest of this app is the same as samples/conceptMap.html
							
								// replace the default Link template in the linkTemplateMap
								myDiagram.linkTemplate =
								  $(go.Link,  // the whole link panel
									$(go.Shape,  // garis
									  { stroke: "black" }	
									  ),
									$(go.Shape,  // the arrowhead
									  { toArrow: "standard", stroke: null }),
									$(go.Panel, "Auto",
									  $(go.Shape,  // the label background, which becomes transparent around the edges
										{ fill: $(go.Brush, "Radial", { 0: "rgb(240, 240, 240)", 0.3: "rgb(240, 240, 240)", 1: "rgba(240, 240, 240, 0)" }),
										  stroke: null }),
									  $(go.TextBlock,  // the label text
										{ textAlign: "center",
										  font: "10pt helvetica, arial, sans-serif",
										  stroke: "#555555",
										  margin: 4 },
										new go.Binding("text", "text"))
									)
								  );
							
								// create the model for the concept map
								
								var nodeDataArray = [
								  <?php while ($r = mysql_fetch_array($getjadwal)) { ?>
								  { key:"<?php echo $r['id_sub'] ?>", text: "<?php echo $r['nama_sub'] ?>"},
								  <?php } ?>
								];
								var linkDataArray = [
								  <?php while ($row = mysql_fetch_array($getpendahulu)) 
								  { ?>
									{ from: "<?php echo $row['id_pek_pendahulu'] ?>",
									  to: "<?php echo $row['id_sub'] ?>",
									  text:"<?php echo $row['durasi_kegiatan']?>"
									},
								  <?php 
								  } 
								  ?> 
								];
								myDiagram.model = new go.GraphLinksModel(nodeDataArray, linkDataArray);
							  }
							
							  function reload() {
								//myDiagram.layout.network = null;
								var text = myDiagram.model.toJson();
								myDiagram.model = go.Model.fromJson(text);
								//myDiagram.layout =
								//  go.GraphObject.make(ContinuousForceDirectedLayout,  // automatically spread nodes apart while dragging
								//    { defaultSpringLength: 30, defaultElectricalCharge: 100 });
							  }
							</script>
							
							<div id="myDiagramDiv" style="background-color: whitesmoke; border: solid 1px black; width: 100%; height: 420px"></div>
					 </div>
				 </div>
		       </div> <!--akhir isi konten -->  
            </div>
            
			 <div class="col-md-8">
			  <!-- Info Boxes Style 2 -->
			     <div class="box">
					<div class="box-header with-border">
					  <div align="right">
					     <a href="gantt-chart.php?id_proyek=<?=$_GET['id_proyek'];?>" class="btn btn-danger btn-fill btn-sm"> <i class="fa fa-bar-chart-o "></i><span> Gantt Chart</span></a>
					   </div>					  
					</div>		
					<!-- /.box-header -->
					<div class="box-body">
					<h4><i class="fa fa-sort-amount-asc"></i><span> Jadwal Pekerjaan</span></h4> <br />
					   <table id="tabel1" class="table table-bordered table-striped">
					      <thead>
						  <tr>
							<td width="10%"><b>No</b></td>
							<td width="25%"><b>Nama Pekerjaan</b></td>
							<td width="10%"><b>Durasi</b></td> 
							<td width="10%"><b>Tanggal Mulai</b></td> 
							<td width="10%"><b>Tanggal Selesai</b></td>
							<td width="20%"><i><b>Predecessor</b></i></td>
							<td width="15%"><b>Progres Pekerjaan</b></td>
						</tr>
						</thead>
						<tbody>
						   <?php
							if(isset($_GET['id_proyek'])) 
							{ 
								   $id_proyek = $_GET['id_proyek'];
								  error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
								  
								  $sql = mysql_query("select * from pekerjaan join proyek on pekerjaan.id_jenis = proyek.id_jenis where id_proyek ='$id_proyek' order by kode_pekerjaan");	  
								  while($r = mysql_fetch_array($sql))
								  {
								 ?>	
								 <tr>	
								     <td>
										<dd><b><?php echo Romawi($r['kode_pekerjaan']) ?></b></dd>
								     </td>
								     <td>
									  	<b><?php echo $r['nama_pekerjaan']; ?></b>
										 <td>&nbsp;</td>
										 <td>&nbsp;</td>
										 <td>&nbsp;</td>
										 <td>&nbsp;</td>
										 <td>&nbsp;</td>
										 <td>&nbsp;</td>	
								     </td> 
								        <?php
									
									    $sql2 = mysql_query ("SELECT kode_pekerjaan,kode_sub,nama_sub,id_master_sub
										                      FROM `master_sub_pekerjaan`
															  JOIN pekerjaan 
															  ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
															  Where master_sub_pekerjaan.id_pekerjaan = '".$r['id_pekerjaan']."' order by kode_sub");
										if($sql2)
										{
											while($s=mysql_fetch_array($sql2))
										    {
										    ?>
						                     <tr>
										         <td>
											       <dd><i><center><?php echo Romawi($s['kode_pekerjaan']).'.'.$s['kode_sub']; ?></center></i></dd>
							                     </td>
											     <td>
												   <i><?php echo $s['nama_sub']; ?></i>
												    
										         </td>
											     <td>
												     <?php
													   
													   $id = $s['id_master_sub'];
													  
													   $sub = "SELECT id_jadwal FROM jadwal
													           JOIN sub_pekerjaan ON sub_pekerjaan.id_sub = jadwal.id_sub
															   JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub
															   WHERE sub_pekerjaan.id_master_sub = '$id' AND jadwal.id_proyek = '$id_proyek'";
															   
													   $res= mysql_query($sub);
													 ?>
													 
													  <table border="1" > 
                         							    <?php
													       while($detail=mysql_fetch_array($res))
														   {
														   		?>
																<tr> 
																   <?php 
																	  $id = $detail['id_jadwal'];
																	  $sql4 = mysql_query ("SELECT * from jadwal where id_jadwal = '$id'")or die(mysql_error());
																	  $s4=mysql_fetch_array($sql4);
																	?>
																	 <?php echo $s4['durasi_kegiatan']." hari"?>
																	 
																</tr>
													   <?php  }?>
                     								 </table>     
										         </td>
											      <td>
											   		<?php
													   $id = $s['id_master_sub'];
													   $sub2 = "SELECT id_jadwal FROM jadwal
													           JOIN sub_pekerjaan ON sub_pekerjaan.id_sub = jadwal.id_sub
															   JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub
															   WHERE sub_pekerjaan.id_master_sub = '$id' AND jadwal.id_proyek = '$id_proyek'";
													   $res2= mysql_query($sub2);
													 ?>
													 
													  <table border="1" > 
                         							    <?php
													       while($detail2=mysql_fetch_array($res2))
														   {
														   		?>
																<tr> 
																   <?php 
																	  $id = $detail2['id_jadwal'];
																	  $sql5 = mysql_query ("SELECT * from jadwal where id_jadwal = '$id'")or die(mysql_error());
																	  $s5=mysql_fetch_array($sql5);
																	?>
																	  <?php echo date('d/m/Y',strtotime($s5['tanggal_mulai_j']))?>
																	 
																</tr>
													   <?php  }?>
                     								 </table>     
											     </td>
												 
										  	     <td>
											       <?php
													   $id = $s['id_master_sub'];
													  
													   $sub3 = "SELECT id_jadwal FROM jadwal
													           JOIN sub_pekerjaan ON sub_pekerjaan.id_sub = jadwal.id_sub
															   JOIN master_sub_pekerjaan ON sub_pekerjaan.id_master_sub = master_sub_pekerjaan.id_master_sub
															   WHERE sub_pekerjaan.id_master_sub = '$id' AND jadwal.id_proyek = '$id_proyek'";
													   $res3= mysql_query($sub3);
													 ?>
													 
													  <table border="1" > 
                         							    <?php
													       while($detail3=mysql_fetch_array($res3))
														   {
														   		?>
																<tr> 
																   <?php 
																	  $id = $detail3['id_jadwal'];
																	  $sql6 = mysql_query ("SELECT * from jadwal where id_jadwal = '$id'")or die(mysql_error());
																	  $s6=mysql_fetch_array($sql6);
																	?>
																	    <?php echo date('d/m/Y',strtotime($s6['tanggal_selesai_j']))?>
																	 
																</tr>
													   <?php  }?>
                     								 </table>     
											   </td>
											   <td>
											      <?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													
													$id = $s['id_master_sub'];
													$sub4 = "SELECT * from sub_pekerjaan WHERE id_master_sub = '$id' AND id_proyek = '$id_proyek'";
													$res4= mysql_query($sub4);
													
														while($cek=mysql_fetch_array($res4))
														{
														  ?>
														    <?php
															   $id = $cek['id_sub'];
															   $subpek = "SELECT * from pendahulu Where id_sub = '$id'";
															   $resub= mysql_query($subpek);
															  ?>
															  
																<?php
																   while($idpek=mysql_fetch_array($resub))
																   {
																		?>
																		
																		   <?php 
																			  $id = $idpek['id_pek_pendahulu'];
																			  $sql4 = mysql_query("SELECT * from sub_pekerjaan
																			   					   JOIN master_sub_pekerjaan
																			                       ON master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub
																				                   JOIN pekerjaan 
																								   ON master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan
																								   WHERE sub_pekerjaan.id_sub = '$id'")or die(mysql_error());
																			  $s4=mysql_fetch_array($sql4);
																			?>
																			<i>
																			
																			<?php echo $s4['nama_sub']?><br />
																		   </i>
															   <?php  }?>
														    <?php 
														    }
											            }
													?>
											   </td>
											   <td> 
											     <?php
												   if(isset($_GET['id_proyek'])) 
												   { 
													$id_proyek = $_GET['id_proyek'];
													
													$id = $s['id_master_sub'];
													$sub4 = "SELECT * from sub_pekerjaan WHERE id_master_sub = '$id' AND id_proyek = '$id_proyek'";
													$res4= mysql_query($sub4);
													
														while($cek=mysql_fetch_array($res4))
														{
														  ?>
														    
														  <?php	
															$id = $cek['id_sub'];
													        $kegiatan = mysql_query("select sum(persen_realisasi) bobot 
																					 from detail_progres 
																					 join progres on detail_progres.id_progres = progres.id_progres
																					 where progres.id_proyek = '$id_proyek' and id_sub = $id");
																					 
													        while($r=mysql_fetch_array($kegiatan))
														    {
															?>
															 <div class="progress">
																<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" 
																aria-valuemax="100" style="width:<?php echo $r['bobot']?>%">
																	<?php echo number_format($r['bobot']) ?> %
																 </div>
															</div>
														    <?php 
														    }
													   }
												   }
												?>
											   </td>  
						                    </tr>
										  <?php
										} 
									}else 
									{
									   
									}
								  ?>
									
								<?php
								}
							  }
								?>	
								</tr>
							 </tbody>	
					    </table>
					  </div><!-- /.-box -->
			    </div>
			</div>	
			
				 
		    <div class="col-md-4">
			    <div class="box box-solid box-default">
				   <div class="box-body">  
					   <i class="fa fa-pencil-square-o text-navy"> </i><span> Progres Proyek</span>
					   <br />
						  <center>
						   <?php
							   if(isset($_GET['id_proyek'])) 
							   { 
								$id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select sum(bobot_aktual) bobot from progres where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									   echo" <h2><b> ".number_format($r['bobot'],2)." % </b></h2>"; 
									}
							   }
							?>
						  </center>
						<div class="progress">
						  <?php
							   if(isset($_GET['id_proyek'])) 
							   { 
								$id_proyek = $_GET['id_proyek'];
								$kegiatan = mysql_query("select sum(bobot_aktual) bobot_a from progres where id_proyek = '$id_proyek'");
								
									while($r=mysql_fetch_array($kegiatan))
									{
									  ?>
										 <div class="progress">
										   <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" 
											 aria-valuemax="100" style="width:<?php echo $r['bobot_a']?>%">
										   </div>
										</div>
									 <?php 
									}
							   }
							?>
						</div>
						<?php
						   
						 if(isset($_GET['id_proyek'])) 
						 { 
							 $id_proyek = $_GET['id_proyek'];
							 $query = mysql_query("select * from evaluasi join progres on evaluasi.id_progres = progres.id_progres 
												   where progres.id_proyek = '$id_proyek' order by minggu DESC limit 1");
							 $evaluasi= mysql_fetch_array($query);
							 $CV = $evaluasi['cv'];
							 $SV = $evaluasi['sv'];
							 $CPI = $evaluasi['cpi'];
							 $SPI = $evaluasi['spi'];
							 $periode = $evaluasi['minggu'];
						  ?>
							
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
							else
							{
							 $periode = " 0";
							 $penilaiancv = "0";
							 $penilaiansv = "0";
							} 
							?>
							
					
							<?php
							   echo "  Pada Minggu Ke- $periode <br>";
							   echo "  Biaya <code>".$penilaiancv."</code><br>";
							   echo "  Waktu <code>".$penilaiansv."</code>";
							?>
						 
						<br />
								
						<div class="box-header with-border">
						   <i class="fa fa-pencil-square-o"></i> Keterangan
					   </div>
					<div class="box-body">
					<?php
			  		if(isset($_GET['id_proyek'])) 
					{ 
					   $id_proyek = $_GET['id_proyek'];
					   $cek = mysql_query("select max(ef) as jumlah from jadwal where id_proyek ='$id_proyek'");
					   $jalur = mysql_fetch_array($cek);
					   $cpm = $jalur['jumlah'];
					 
					}else
					{
					   $cpm = " ";
					}
					?>
					
				  <div class="col-lg-12">
				     <!-- small box -->
						  <div class="small-box" style="background-color:#fff; color:#000000">
							<div class="inner">
    						  <p>Jumlah Durasi Jalur Kritis</p>
							  <p><h3><?php echo "$cpm" ?> Hari</h3></p>
							</div>
							<div class="icon">
							  <i class="ion ion-stats-bars"></i>
							</div>
				         </div>
				  </div>
					
					<div class="col-lg-12">
					   <!-- small box -->
						  <div class="small-box " style="background-color:#fff; color:#000000">
							<div class="inner">
							  <p><h4>Pekerjaan Kritis</h4></p>
							  <?php
							      	if(isset($_GET['id_proyek'])) 
									{ 
									   $id_proyek = $_GET['id_proyek'];
									   $cek2 = mysql_query("select nama_sub from jadwal 
														   join sub_pekerjaan on jadwal.id_sub = sub_pekerjaan.id_sub
														   join master_sub_pekerjaan on master_sub_pekerjaan.id_master_sub = sub_pekerjaan.id_master_sub
														   where jadwal.id_proyek ='$id_proyek' and jadwal.sl =0");
									   
										
									  while($nama = mysql_fetch_array($cek2))
									  {
									      $kegiatan = $nama['nama_sub'];
   							   ?>  
									     	<i class="fa  fa-check-square-o"> </i> <b><?php echo $kegiatan ?></b><br>
					 		  <?php  
									  }
								    }
							  ?>
							       
							</div>
							<div class="icon">
							  <i class="ion ion-stats-bars"></i>
							</div>
				      </div>
					</div>	
					
				   </div>			
				 </div>
			   </div><!--akhir isi konten -->  
		  </div>
			
		  <?php /*?>
		   <div class="col-md-12">
				 <!-- MAP & BOX PANE -->
				  <div class="box box-danger">
					<div class="box-header">
						<div align="right">
						   <a href="detail_evm.php?id_proyek=<?=$_GET['id_proyek']?>" class="btn bg-maroon btn-sm" ><span class="fa fa-external-link"></span>  Detail EVM</a>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
					<h4><i class="fa  fa-bar-chart-o"></i><span> Kurva-S</span></h4>
					<?php 
						$link=koneksidb();
						if(isset($_GET['id_proyek'])) 
					    { 
							$id_proyek = $_GET['id_proyek'];
							$query = mysql_query("SELECT * FROM evaluasi JOIN progres ON evaluasi.id_progres = progres.id_progres 
												  WHERE evaluasi.id_proyek = '$id_proyek' ORDER BY minggu ASC");
							$query2 = mysql_query("SELECT * FROM evaluasi JOIN progres ON evaluasi.id_progres = progres.id_progres
												   WHERE evaluasi.id_proyek = '$id_proyek' ORDER BY minggu ASC");
							$query3 = mysql_query("SELECT * FROM evaluasi JOIN progres ON evaluasi.id_progres = progres.id_progres 
												   WHERE evaluasi.id_proyek = '$id_proyek' ORDER BY minggu ASC");
							$query4 = mysql_query("SELECT * FROM evaluasi JOIN progres ON evaluasi.id_progres = progres.id_progres 
											       WHERE evaluasi.id_proyek = '$id_proyek' ORDER BY minggu ASC");
						}
					?>
					<div id="echart_line" style="height:400%; width:auto; margin:0 auto; max-width:100%"></div>
					<script>
					  var theme = {
						  color: [
							  '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
							  '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
						  ],
				
						  title: {
							  itemGap: 8,
							  textStyle: {
								  fontWeight: 'normal',
								  color: '#408829'
							  }
						  },
				
						  dataRange: {
							  color: ['#1f610a', '#97b58d']
						  },
				
						  toolbox: {
							  color: ['#408829', '#408829', '#408829', '#408829']
						  },
				
						  tooltip: {
							  backgroundColor: 'rgba(0,0,0,0.5)',
							  axisPointer: {
								  type: 'line',
								  lineStyle: {
									  color: '#408829',
									  type: 'dashed'
								  },
								  crossStyle: {
									  color: '#408829'
								  },
								  shadowStyle: {
									  color: 'rgba(200,200,200,0.3)'
								  }
							  }
						  },
				
						  dataZoom: {
							  dataBackgroundColor: '#eee',
							  fillerColor: 'rgba(64,136,41,0.2)',
							  handleColor: '#408829'
						  },
						  grid: {
							  borderWidth: 0
						  },
				
						  categoryAxis: {
							  axisLine: {
								  lineStyle: {
									  color: '#408829'
								  }
							  },
							  splitLine: {
								  lineStyle: {
									  color: ['#eee']
								  }
							  }
						  },
				
						  valueAxis: {
							  axisLine: {
								  lineStyle: {
									  color: '#408829'
								  }
							  },
							  splitArea: {
								  show: true,
								  areaStyle: {
									  color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
								  }
							  },
							  splitLine: {
								  lineStyle: {
									  color: ['#eee']
								  }
							  }
						  },
						  timeline: {
							  lineStyle: {
								  color: '#408829'
							  },
							  controlStyle: {
								  normal: {color: '#408829'},
								  emphasis: {color: '#408829'}
							  }
						  },
				
						  k: {
							  itemStyle: {
								  normal: {
									  color: '#68a54a',
									  color0: '#a9cba2',
									  lineStyle: {
										  width: 1,
										  color: '#408829',
										  color0: '#86b379'
									  }
								  }
							  }
						  },
						  textStyle: {
							  fontFamily: 'Arial, Verdana, sans-serif'
						  }
					  };
					  
					  var echartLine = echarts.init(document.getElementById('echart_line'), theme);
				
					  echartLine.setOption({
						title: {
						
						  subtext: 'Total Pengeluaran'
						},
						tooltip: {
						  trigger: 'axis'
						},
						legend: {
						  x: 220,
						  y: 40,
						  data: ['Biaya Rencana (PV) (Rp.)', 'Earned Value (EV) (Rp.)','Biaya Aktual (AC) (Rp.)']
						},toolbox: {
						  show: true
						},
						calculable: true,
						xAxis: [{
						  type: 'category',
						  boundaryGap: false,
						  data: [
						  <?php 
								while ($rencana = mysql_fetch_array($query)) {
									echo '"Minggu ke-'.$rencana['minggu'].'",';   
								}
							?>
						  ]
						}],
						yAxis: [{
						  type: 'value'
						}],
						series: [{
						  name: 'Biaya Rencana (PV) (Rp.)',
						  type: 'line',
						  smooth: true,
						  itemStyle: {
							normal: {
							  areaStyle: {
								type: 'default'
							  }
							}
						  },
						  data: [
						  <?php 
								while ($rencana2 = mysql_fetch_array($query2)) {
										$pv = round($rencana2['pv_komulatif'],-2);
										echo $pv.',';            
							} ?>
						  ]
						}, {
						  name: 'Earned Value (EV) (Rp.)',
						  type: 'line',
						  smooth: true,
						  itemStyle: {
							normal: {
							  areaStyle: {
								type: 'default'
							  }
							}
						  },
						  data: [
						  <?php 
								while ($rencana3 = mysql_fetch_array($query3)) {
									$ev = round($rencana3['ev_komulatif'],-2);
									echo $ev.',';            
								}
							?>
						  ]
						}, {
						  name: 'Biaya Aktual (AC) (Rp.)',
						  type: 'line',
						  smooth: true,
						  itemStyle: {
							normal: {
							  areaStyle: {
								type: 'default'
							  }
							}
						  },
						  data: [
						  <?php 
							   while ($rencana4 = mysql_fetch_array($query4)) {
									$ac = round($rencana4['ac_komulatif'],-2);
									echo $ac.',';            
								}
							?>
						  ]
						}]
					  });
					</script>
					
					 <?php 
					 $nilai_keterangan = "Belum pilih proyek";
					 if(isset($_GET['id_proyek'])) 
					    { 
						  $id = $_GET['id_proyek'];
					 	  $sql_nilai = mysql_query("SELECT * FROM evaluasi WHERE id_proyek = '$id'");
						  $row_nilai = mysql_fetch_array($sql_nilai);
						  
						  $pk = $row_nilai['pv_komulatif'];
						  $ek = $row_nilai['ev_komulatif'];
						  $ak = $row_nilai['ac_komulatif'];
						  
						  if ($ak < $pk)
						  {
						  	$nilai_keterangan = " Biaya realisasi proyek lebih kecil dari biaya rencana";
						  }
						  else
						  {
						  	$nilai_keterangan = " Biaya realisasi proyek lebih besar dari biaya rencana";
						  }
					 	}
					 ?>
					
					<h4>Keterangan:</h4>
					 <i class="fa fa-circle-o"> </i> <code><b><?php echo $nilai_keterangan ?></b></code><br>
					</div>
				  </div>
			 </div>
		   <?php */?>
		 </div>
      </div>
     </div>
  </section>
</div>


  <!-- /.content-wrapper -->