<!DOCTYPE html>

<html lang="es-MX">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url("resources/css/password/index.css") ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

    <title>Marcos REDESLA</title>

</head>

<body>

    <style>
        .card {
            width: 450px;
            margin: auto;
            height: 50%;
        }

        .card h2 {
            margin: 0 0 6px 0;
            text-align: center;
        }

        .card .twibbon {
            width: 450px;
            height: 450px;
            margin: auto;
            position: fixed;
            overflow: hidden;
        }

        img#twibbon {
            width: 100%;
        }

        img#photo {
            top: -1px;
            z-index: -1;
            position: absolute;
        }

        .card a {
            display: block;
            text-align: center;
        }
    </style>


    <section class="text-center">
        <img src="<?= base_url("resources/img/logos_con_letras/Letras_Redesla.png"); ?>" width="50%" alt="Redesla - Red de Estudios Latinoamericanos">
        <hr>
        <h2>Marco para fotos</h2>
    </section>

    <section class="text-left">
        <label for="">Seleccione una red</label>
        <select id="twibbonimg" class="form-control" required>
            <?php
            foreach ($redes as $r) {
                if($r == 'Relep'){
                    ?>
                    <option value="<?= base_url('resources/img/marcos/' . $r . '.png') ?>" selected><?= $r ?></option>
                    <?php
                }else{
                    ?>
                    <option value="<?= base_url('resources/img/marcos/' . $r . '.png') ?>"><?= $r ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <label for="">Ingrese su foto a la que desea añadir un marco</label>
        <input type="file" name="photoimg" id="photoimg" class="form-control" required accept=".png">
        <hr>
        <h2 class="text-center">Previsualización</h2>
        <div class="card">
            <div class="twibbon">
                <img src="" id="twibbon" alt="">
                <img src="" id="photo" alt="">
            </div>
            <hr>
        </div>
        <hr>
        <a href="#" class="btn btn-block btnPrimary" id="download">Descargar imagen</a>
    </section>

    <script type="text/javascript">
        var photoimg = "";
        // Upload image to the directory
        $(document).ready(function() {
            $('#photoimg').change(function() {
                var formData = new FormData();
                var files = $('#photoimg')[0].files;
                formData.append('photo', files[0]);
                $.ajax({
                    url: "<?= base_url('getMarco') ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        photoimg = response;
                        //console.log(response);
                    }
                });
            });
        });

        // Real time preview twibbon
        setInterval(function() {
            preview();
        }, 1000);

        function preview() {
            var twibbonimg = $('#twibbonimg').val();
            var width = $('#width').val();
            var height = $('#height').val();
            var top = $('#top').val();
            var left = $('#left').val();
            $("#photo").attr("src", photoimg);
            $('#twibbon').attr("src", twibbonimg);
            $('#photo').css("width", width);
            $('#photo').css("height", height);
            $('#photo').css("top", top);
            $('#photo').css("left", left);
        }

        // Download twibbon
        var element = $(".twibbon");
        $("#download").on('click', function() {
            html2canvas(element, {
                onrendered: function(canvas) {
                    var imageData = canvas.toDataURL("image/png");
                    var newData = imageData.replace(/^data:image\/png/, "data:application/octet-stream");
                    $("#download").attr("download", "image.png").attr("href", newData);
                }
            });
        });
    </script>

</body>

</html>
<!--
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Twibbon</title>
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js">
    </script>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>

    Twibbon
    <select id = "twibbonimg">
    <?php
    foreach ($redes as $r) {
    ?>
                <option value="<?= base_url('resources/img/marcos/' . $r . '.png') ?>"><?= $r ?></option>
                <?php
            }
                ?>
    </select>
    <br>
    Photo <input type="file" id="photoimg" name="photoimg" value=""> <br>
    Width <input type="text" id = "width" value="100%">
    Height <input type="text" id = "height" value="100%">
    Top <input type="text" id = "top" value="0px">
    Left <input type="text" id = "left" value="0px">

    <hr>

    <div class="card">
      <h2>Pick A Photo</h2>
      <div class="twibbon">
        <img src="" id = "twibbon" alt="">
        <img src="" id = "photo" alt="">
      </div>
      <hr>
    </div>
    <a href="#" id = "download">Download</a>

    <script type="text/javascript">
      var photoimg = "";
      // Upload image to the directory
      $(document).ready(function() {
          $('#photoimg').change(function(){
              var formData = new FormData();
              var files = $('#photoimg')[0].files;
              formData.append('photo', files[0]);
              $.ajax({
                  url: "<?= base_url('getMarco') ?>",
                  type: "POST",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(response){
                    photoimg = response;
                    //console.log(response);
                  }
              });
          });
      });

      // Real time preview twibbon
      setInterval(function(){
        preview();
      }, 1000);

      function preview(){
        var twibbonimg = $('#twibbonimg').val();
        var width = $('#width').val();
        var height = $('#height').val();
        var top = $('#top').val();
        var left = $('#left').val();
        $("#photo").attr("src", photoimg);
        $('#twibbon').attr("src", twibbonimg);
        $('#photo').css("width", width);
        $('#photo').css("height", height);
        $('#photo').css("top", top);
        $('#photo').css("left", left);
      }

      // Download twibbon
      var element = $(".twibbon");
      $("#download").on('click', function(){
        html2canvas(element, {
          onrendered: function(canvas) {
            var imageData = canvas.toDataURL("image/png");
            var newData = imageData.replace(/^data:image\/png/, "data:application/octet-stream");
            $("#download").attr("download", "image.png").attr("href", newData);
          }
        });
      });
    </script>
  </body>
</html>