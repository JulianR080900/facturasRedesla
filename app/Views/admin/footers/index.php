<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
  </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->


<!-- MODALS -->

<div class="modal fade" id="modalProfilePic" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cambiar foto de perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBodyProfilePic">
        <div class="row" style="display: flex; align-items: center; justify-content: center;">
          <img id="profile_pic_preview" src="<?= file_exists(base_url('/resources/img/profiles/').session('profile_pic')) ? base_url('/resources/img/profiles/').session('profile_pic') : base_url('/resources/img/profiles/avatar.png') ?>" alt="" width="60%" height="60%" style="border-radius: 50%;">
        </div>
        <div class="row" style="display: flex; align-items: center; justify-content: center;">
          <button type="button" class="btn btn-md btn-info">Seleccionar foto de perfil</button>
          <input type="file" name="profile_pic" id="" hidden>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<!-- plugins:js -->
<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/progressbar.js/progressbar.min.js"></script>
<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?= base_url('/resources/admin/') ?>/assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?= base_url('/resources/admin/') ?>/assets/js/off-canvas.js"></script>
<script src="<?= base_url('/resources/admin/') ?>/assets/js/hoverable-collapse.js"></script>
<script src="<?= base_url('/resources/admin/') ?>/assets/js/misc.js"></script>
<script src="<?= base_url('/resources/admin/') ?>/assets/js/settings.js"></script>
<script src="<?= base_url('/resources/admin/') ?>/assets/js/todolist.js"></script>
<script src="<?= base_url('/resources/admin/') ?>/assets/js/file-upload.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="<?= base_url('/resources/admin/') ?>/assets/js/dashboard.js"></script>

<!-- DATATABLES -->
<script src="<?= base_url('/resources/datatables/admin/JSZip-2.5.0/jszip.min.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/pdfmake-0.1.36/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/pdfmake-0.1.36/vfs_fonts.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/bootstrap/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/bootstrap/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/Buttons-2.3.5/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/Buttons-2.3.5/js/buttons.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/Buttons-2.3.5/js/buttons.colVis.min.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/Buttons-2.3.5/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('/resources/datatables/admin/Buttons-2.3.5/js/buttons.print.min.js') ?>"></script>


<!--<script src="<?php // base_url('/resources/datatables/datatables.min.js') ?>"></script>-->


<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script> -->
<script src="<?= base_url('resources/sweetalert/sweetalert2.all.min.js') ?>"></script>
<script>
  base_url = "<?= base_url() ?>";
</script>
<script src="<?= base_url("resources/js/form-validation/inputs.js") ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    <?php if (session()->getFlashdata('icon')) { ?>
      Swal.fire({
        icon: '<?= session()->getFlashdata('icon') ?>',
        title: '<label style="color:#545454"><?= session()->getFlashdata('title') ?></label>',
        html: '<label style="color:#545454"><?= session()->getFlashdata('text') ?></label>',
      })
    <?php } ?>
    $("#loader").hide()
  })
</script>
<!-- End custom js for this page -->
</body>

</html>