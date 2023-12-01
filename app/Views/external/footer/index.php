<script>
    $(document).ready(function(){
        <?php if( session()->getFlashdata('icon') ){ ?>
            Swal.fire({
                icon: '<?= session()->getFlashdata('icon') ?>',
                title: '<?= session()->getFlashdata('title') ?>',
                text: '<?= session()->getFlashdata('text') ?>',
            })
        <?php } ?>
    })
</script>
<script src="<?= base_url('/resources/datatables/datatables.min.js') ?>"></script>
<script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>