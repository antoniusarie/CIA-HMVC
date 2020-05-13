<!-- Select2 -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/select2/js/select2.full.min.js" ?>"></script>

<!-- DataTables -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables/jquery.dataTables.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-responsive/js/dataTables.responsive.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/dataTables.buttons.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/dataTables.html5.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/dataTables.print.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/dataTables.colVis.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/pdfmake/pdfmake.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/pdfmake/vfs_fonts.js" ?>"></script>

<!-- SlimScroll -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/slimScroll/jquery.slimscroll.min.js" ?>"></script>

<!-- FastClick -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/fastclick/fastclick.min.js" ?>"></script>

<!-- Datepicker -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datepicker/js/bootstrap-datepicker.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datepicker/locales/bootstrap-datepicker.id.min.js" ?>"></script>

<!-- Others -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/printThis/printThis.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/moment/moment.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/moment/locale/id.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/fontawesome-iconpicker/dist/js/fontawesome-iconpicker.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/iCheck/icheck.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/toastr/toastr.min.js" ?>"></script>

<!-- Sweetalert 2 -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/sweetalert2/sweetalert2.all.min.js" ?>"></script>

<!-- Admin LTE 3 -->
<script type="text/javascript" src="<?php echo base_url() . "assets/dist/js/adminlte.js" ?>"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- custom script -->
<script type="text/javascript">
  window.onload = function() {
    showAll();
    effect_msg();
  };

  function effect_msg() {
    /* alert messages 1 */
    $('#alert-message').slideDown(1500)
    $('#alert-message').delay(2500).slideUp(1500)
  }

  function showAll() {
    $(document).ready(function() {
      var table = $("#mytable").dataTable({
        // "dom": '<"col-xs-2" l>Brft<"col-xs-1" i>p',
        "responsive": true,
        "pageLength": 20,
        "lengthMenu": [
          [10, 20, 50, -1],
          [10, 20, 50, "All"]
        ],
        "buttons": [{
            extend: 'colvis',
            text: '<b><i class="fas fa-bars"></i> Kolom</b>',
            className: 'font-orange',
            // exportOptions:
            // {
            //     columns: [0,1,2,3,4,5]
            // },
          },
          {
            extend: 'excelHtml5',
            text: '<b><i class="fas fa-file-excel"></i> Excel</b>',
            className: 'font-green',
            exportOptions: {
              columns: ':visible'
            },
          },
        ],
        "language": {
          /*Indonesia*/
          "search": "",
          "lengthMenu": "Tampil _MENU_ baris",
          "searchPlaceholder": "Cari...",
          "loadingRecords": "&nbsp;",
          "zeroRecords": "Tidak ada data",
          "processing": "Memproses...",
          "infoEmpty": "Tidak ada data ",
          "info": "<strong>_TOTAL_</strong> Data | baris <strong>_START_</strong> s/d <strong>_END_</strong>",
          "infoFiltered": "| disaring dari total <strong id='red'>_MAX_</strong> baris",
          "paginate": {
            "previous": "<i class='fas fa-chevron-left'></i>",
            "next": "<i class='fas fa-chevron-right'></i>"
          }
        },
      });

      /* fontawesome iconpicker */
      $(".iconpicker").iconpicker({
        hideOnSelect: true,
        animation: true,
      });

      /* URL auto fill */
      if ($('#url').val().length === 0) {
        $('#url').val('#');
      };

    }); // document ready
  }; // ShowAll()

  $(".btn-delete").on("click", function(e) {
    $('#confirm-delete').modal('hide');
  });

  /* Select2 */
  $(".select2").select2();

  /* iCheck */
  $('input').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue',
    increaseArea: '20%' // optional
  });

  $("#check-password").on('ifChecked', function() {
    $("#password, #password_confirm").prop("disabled", false);
    $("#password, #password_confirm").val('');
  });

  $("#check-password").on('ifUnchecked', function() {
    $("#password, #password_confirm").val('');
    $("#password, #password_confirm").prop("disabled", true);
  });

  /* Toastr */
</script>