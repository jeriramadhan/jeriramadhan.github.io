  <!-- /.content-wrapper -->
  <footer class="main-footer" style="margin-left: 0px;"></footer>

  
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="../style/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../style/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="../style/plugins/select2/select2.full.min.js"></script>
<!-- DataTables -->
<script src="../style/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../style/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../style/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../style/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../style/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../style/dist/js/demo.js"></script>
<!-- bootstrap datepicker -->
<script src="../style/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- money min-->
<script src="../style/jquery.maskMoney.min.js"></script>
<!-- page script -->
<script src="../style/jquery.easypiechart.min.js"></script>

<script type="text/javascript">
  $('#nilai_kontrak').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#harga_pek').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#harga_pek2').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#volume').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#volume2').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#nilai_kontrak2').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#harga').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#harga2').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#harga_bahan').maskMoney({thousands:'.', decimal:',', affixesStay: true});
  $('#harga_bahan2').maskMoney({thousands:'.', decimal:',', affixesStay: true});
</script>
<script>
  $(function () {
    $("#tabel1").DataTable();
  });
   $(function () {
    $("#tabel2").DataTable();
  });
  $(function () {
    $("#tabel3").DataTable();
  });
  $(function () {
    $("#tabel4").DataTable();
  });
  //Initialize Select2 Elements
    $(".select2").select2({placeholder: "Pilih disini",allowClear: true});
  //Date picker
    $('#tanggal_mulai').datepicker({autoclose: true});
	$('#tanggal_selesai').datepicker({autoclose: true});
	$('#tanggal_lahir').datepicker({autoclose: true});
</script>
<script type="text/javascript">
  $('#myModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  document.getElementById('delete_link').setAttribute('href' , recipient)
  var modal = $(this)
  modal.find('.modal-footer a').val(recipient)
  modal.find('.modal-body input').val(recipient)
});

$('#myModal_hapus').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  document.getElementById('link').setAttribute('href' , recipient)
  var modal = $(this)
  modal.find('.modal-footer a').val(recipient)
  modal.find('.modal-body input').val(recipient)
});

$('#myModal_edit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  document.getElementById('edit').setAttribute('href' , recipient)
  var modal = $(this)
  modal.find('.modal-footer a').val(recipient)
  modal.find('.modal-body input').val(recipient)
});

$('#myModal_tambah').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  document.getElementById('tambah').setAttribute('href' , recipient)
  var modal = $(this)
  modal.find('.modal-footer a').val(recipient)
  modal.find('.modal-body input').val(recipient)
});

$(document).on("click", ".open-AddBookDialog", function () {
     var myBookId = $(this).data('id');
     $(".modal-body #bookId").val( myBookId );
     // As pointed out in comments, 
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});

$(document).on("click", ".open-AddBookDialog_edit", function () {
     var myBookId = $(this).data('id');
     var penanganan = $(this).data('penanganan');
     var test = document.getElementById("textarea_pen").innerHTML =
   '<textarea rows="8" name="penanganan" cols="60" required>'+ penanganan +'</textarea>';
     $(".modal-body #bookId").val( myBookId );
     $(".modal-body #textarea_pen");
     // As pointed out in comments, 
     // it is superfluous to have to manually call the modal.
     // $('#addBookDialog').modal('show');
});
</script>
<script src="js/jquery.js" ></script>
<script>
$('#numberbox').keyup(function(){
  if ($(this).val() > 100){
    alert("Maksimal 100");
    $(this).val('100');
  }
});

</script>
</body>
</html>
