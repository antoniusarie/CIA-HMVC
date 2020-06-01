<!-- Select2 -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/select2/js/select2.full.min.js" ?>"></script>

<!-- DataTables -->
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables/jquery.dataTables.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-responsive/js/dataTables.responsive.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/dataTables.buttons.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/buttons.html5.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/buttons.print.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/datatables-buttons/js/buttons.colVis.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/jszip/jszip.min.js" ?>"></script>
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
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/overlayScrollbars/js/OverlayScrollbars.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/icheck/icheck.min.js" ?>"></script>
<script type="text/javascript" src="<?php echo base_url() . "assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js" ?>"></script>
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
    load_all();
    load_msg();
  };

  function load_msg() {
    /* Toaster */
    <?php echo (empty(@$message) ? toastr_msg(@$this->session->flashdata('message'), @$this->session->flashdata('type')) : @$message) ?>

    /* alert messages 1 */
    // $('#alert-message').slideDown(1500)
    // $('#alert-message').delay(2500).slideUp(1500)
  }

  function load_all() {
    $(document).ready(function() {
      var table = $("#mytable").DataTable({
        // "dom": '<"row" <"col-auto" l><"col ml-auto" B>rf> t <"row" <"col" i>p>', // .dataTable()
        "responsive": true,
        "pageLength": 20,
        "lengthMenu": [
          [10, 20, 50, -1],
          [10, 20, 50, "All"]
        ],
        "buttons": [{
            extend: 'copy',
            text: '<b><i class="fas fa-copy"></i> Copy</b>',
            className: 'btn-sm btn-info'
          },
          {
            extend: 'excel',
            text: '<b><i class="fas fa-file-excel"></i> Excel</b>',
            className: 'btn-sm btn-success',
          },
          {
            extend: 'pdf',
            text: '<b><i class="fas fa-file-pdf"></i> PDF</b>',
            className: 'btn-sm btn-danger',
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
      // append buttons to length wrapper & add class auto column/margin
      table.buttons().container().appendTo('#mytable_length').addClass('col-auto ml-auto'); // .DataTable() - capital D
    }); // document ready

    /* fontawesome iconpicker */
    $(".iconpicker").iconpicker({
      hideOnSelect: true,
      animation: true,
    });

    /* URL auto fill */
    if ($('#url').val.length === 0) {
      $('#url').val('#');
    };

    /* BS File Input */
    bsCustomFileInput.init();

    $(".btn-delete").on("click", function(e) {
      $('#confirm-delete').modal('hide');
    });

    /* Toastr Option */
    toastr.options = {
      'closeButton': true,
      'positionClass': 'toast-top-right',
      'timeOut': '4000',
    }

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

  }; // load_all()
</script>