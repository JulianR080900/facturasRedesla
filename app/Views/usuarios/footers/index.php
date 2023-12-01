<!-- BOOTSTRAP 4 -->
<script src="<?= base_url('resources/bootstrap4/js/bootstrap.min.js') ?>"></script> <!-- V. 3.7.1 -->

<script src="<?= base_url('resources/js/inicio/index.js') ?>"></script> <!-- INDEX PRINCIPAL -->

<script src="<?php echo base_url("resources/js/e_usuarios.js"); ?>"></script>

<script src="<?= base_url('resources/bootstrap4/js/popper.min.js') ?>"></script>

<script src="<?= base_url('resources/js/Sortable.min.js') ?>"></script>

<script src="<?= base_url('resources/datatables/jquery.dataTables.min.js') ?>"></script>

<script src="<?= base_url('resources/datatables/dataTables.responsive.min.js') ?>"></script>

<script src="<?= base_url('resources/select2/dist/js/select2.min.js') ?>"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">

</script> -->

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">

</script> -->

<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> -->

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->

<!-- <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script> -->

<script type="text/javascript">
    $(document).ready(function() {

        <?php if (session()->getFlashdata('icon')) { ?>
            Swal.fire({
                icon: '<?= session()->getFlashdata('icon') ?>',
                title: '<?= session()->getFlashdata('title') ?>',
                text: '<?= session()->getFlashdata('text') ?>',
            })
        <?php } ?>

        $('#example').DataTable({
            "scrollX": true,
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros"
            }
        });

        $('#example2').DataTable({
            "scrollX": true,
            responsive: true,
            "language": {
                "lengthMenu": "Mostrar _MENU_ registros"
            }
        });
    });
</script>


</body>

</html>