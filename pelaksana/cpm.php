<?php
include "header.php";
include "fungsi_romawi.php";
$link=koneksidb();
$id_proyek = $_GET['id_proyek'];
$getjadwal = mysql_query("SELECT pekerjaan.kode_pekerjaan kode_h,pekerjaan.id_pekerjaan id_h,
                          sub_pekerjaan.id_sub id_sub,sub_pekerjaan.kode_sub,nama_sub,tanggal_mulai_j,tanggal_selesai_j,es,ef,durasi_kegiatan,ls,lf,sl
                          FROM jadwal
						  JOIN sub_pekerjaan ON (jadwal.id_sub = sub_pekerjaan.id_sub)
                          JOIN master_sub_pekerjaan ON (master_sub_pekerjaan.id_master_sub=sub_pekerjaan.id_master_sub)
						  JOIN pekerjaan ON (master_sub_pekerjaan.id_pekerjaan = pekerjaan.id_pekerjaan)
                          WHERE sub_pekerjaan.id_proyek = '$id_proyek'");
		  
$getpendahulu = mysql_query("SELECT * FROM pendahulu JOIN jadwal ON pendahulu.`id_sub` = jadwal.`id_sub`");
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
		 
	    $(go.Shape, "Circle",{ fill: "Lime" , stroke: "black", spot1: new go.Spot(0, 0, 5, 5), spot2: new go.Spot(1, 1, -5, -5)}),	
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

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php?id_proyek=<?php echo $id_proyek; ?>"><i class="fa fa-home"></i>Beranda</a></li>
        <li class="active">Jaringan CPM</li>
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
              <h3 class="box-title">Jaringan CPM</h3>
            </div>
            <div class="box-header"><a href='index.php?id_proyek=<?php echo $id_proyek; ?>' class='btn btn-info btn-fill btn-wd btn-xs full-right' >Kembali</a></div>
            <!-- /.box-header -->
            <div id="myDiagramDiv" style="background-color: whitesmoke; border: solid 1px black; width: 100%; height: 600px"></div>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<?php include "footer.php"; ?>