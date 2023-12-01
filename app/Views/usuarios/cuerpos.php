<!-- <p id="user" class="txt anim-text-flow">Bienvenido <?= $_SESSION["nombre"]; ?>, bienvenido a RedesLA</p>

<div class="text-center">

    <h2 class="text-center txt">Seleccione la convocatoria a gestionar</h2>

</div>

<div class="row" style="margin-left: 2%; margin-right: 2%;">

        <?php
        $array_red = array();
        $array_ca = array();
        $array = $_SESSION["redesCA"];
        foreach ($array as $redesCA) {

            if ($redesCA["redCueCa"] == $redesCA["redCueCa"]) {

                array_push($array_red, $redesCA["redCueCa"]);

                array_push($array_ca, $redesCA["cuerpoAcademico"]);

                $red = $redesCA["redCueCa"];

        ?>
        <div class="col-md-3" style="margin-bottom: 30%; float: none; margin: 0 auto;">

            <a href="<?= base_url('/inicio/' . $red . '/' . $redesCA['cuerpoAcademico']) ?>">
                <img src="<?= base_url("resources/img/isotipos/Mapa_$red.png"); ?>" alt="" style="width:100%; ">
            </a>

            <h1 style="text-align:center;" class="txt"><?= $red ?></h1>

            <h2 style="text-align:center;" class="txt"><?= $redesCA["cuerpoAcademico"] ?></h2>

            <input type="text" hidden id="red" name="red" value="relayn">

        </div>

        <?php
            }
        }

        ?>
</div>

<div class='row'>

    <div class='col-md-12' style="padding-left: 50px; padding-right:50px; padding-bottom:20px;">

        <a href="<?= base_url("logout") ?>" class='btn btn-block btn-danger'>Cerrar sesión</a>

    </div>

</div>

    </body> -->
    
<div class="content">
    <div class="row">
        <div class="col-md-6 col-sm-12 col-lg-4 justifyCenterColumn text-center userInfo">
            <?php
            if (session('profile_pic') !== NULL) {
            ?>
                <img src="<?php echo base_url("resources/img/profiles/" . session('profile_pic')) ?>" alt="" class="profile_pic">
            <?php
            } else {
            ?>
                <img src="<?php echo base_url("resources/img/profiles/avatar.png") ?>" alt="" class="profile_pic">
            <?php
            }
            ?>
            <span class="bienvenido">BIENVENIDO A REDESLA</span>
            <span class="username"><?= session('nombre_completo') ?></span>
            <div class="logout">
                <a href='<?= base_url("logout") ?>' class="btn btn-danger btn-sm">Cerrar sesión <i class="fa-solid fa-right-from-bracket iconlogout"></i></a>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-lg-8 justifyCenterColumn text-center">
            <span class="seleccionar">Seleccione el grupo y red a gestionar</span>
            <div class="select-menu">
                <div class="select-btn">
                    <span class="sBtn-text">Seleccione una opción</span>
                    <input type="hidden" id="red">
                    <input type="hidden" id="ca">
                    <i class="bx bx-chevron-down"></i>
                </div>
                <ul class="options">
                    <?php
                    $array_red = array();
                    $array_ca = array();
                    $array = $_SESSION["redesCA"];
                    foreach ($array as $redesCA) {

                        if ($redesCA["redCueCa"] == $redesCA["redCueCa"]) {

                            array_push($array_red, $redesCA["redCueCa"]);

                            array_push($array_ca, $redesCA["cuerpoAcademico"]);

                            $red = $redesCA["redCueCa"];
                            //<?= base_url('/inicio/' . $red . '/' . $redesCA['cuerpoAcademico'])
                    ?>

                            <li class="option" data-red='<?= $red ?>' data-ca='<?= $redesCA["cuerpoAcademico"] ?>'>

                                <span class="option-text">
                                    <img src="<?= base_url("resources/img/isotipos/Mapa_$red.png"); ?>" alt="">
                                    <?= $redesCA["cuerpoAcademico"] ?> - <?= $red ?>
                                </span>
                            </li>

                    <?php
                        }
                    }

                    ?>
                </ul>
            </div>
            
            <h3 id="titleMiembros">Miembros</h3>
            <div class="miembros"></div>

            <button type="button" class="btn btn-md" id="btnGo">Vamos <i class="fa-solid fa-sort-up"></i></button>

            <!-- <span class="seleccionar">Seleccione el grupo y red a gestionar</span>
            <div class="row" style="margin-left: 2%; margin-right: 2%;">
                <?php
                $array_red = array();
                $array_ca = array();
                $array = $_SESSION["redesCA"];
                foreach ($array as $redesCA) {

                    if ($redesCA["redCueCa"] == $redesCA["redCueCa"]) {

                        array_push($array_red, $redesCA["redCueCa"]);

                        array_push($array_ca, $redesCA["cuerpoAcademico"]);

                        $red = $redesCA["redCueCa"];

                ?>
                        <div class="col-md-6 col-sm-12 col-lg-4 text-center divImage">

                            <a href="<?= base_url('/inicio/' . $red . '/' . $redesCA['cuerpoAcademico']) ?>">
                                <img src="<?= base_url("resources/img/isotipos/Mapa_$red.png"); ?>" alt="">
                            </a>
                            <br>
                            <span style="text-align:center;" class="txt"><?= $red ?></span><br>
                            <span style="text-align:center;" class="txt"><?= $redesCA["cuerpoAcademico"] ?></span>
                            <input type="text" hidden id="red" name="red" value="relayn">

                        </div>

                <?php
                    }
                }

                ?>
            </div> -->
        </div>
    </div>


</div>

<script>
    const base_url = '<?= base_url() ?>';
    const btnGo = document.getElementById('btnGo');
    document.getElementById('btnGo').disabled = true;
    const optionMenu = document.querySelector(".select-menu"),
        selectBtn = optionMenu.querySelector(".select-btn"),
        options = optionMenu.querySelectorAll(".option"),
        sBtn_text = optionMenu.querySelector(".sBtn-text");

    selectBtn.addEventListener("click", () => optionMenu.classList.toggle("active"));

    options.forEach(option => {
        option.addEventListener("click", () => {
            let selectedOption = option.querySelector(".option-text").innerText;

            let red = option.dataset.red
            let ca = option.dataset.ca
            document.getElementById("red").value = red;
            document.getElementById("ca").value = ca;
            document.getElementById('btnGo').disabled = false;
            getMiembros(red, ca)
            sBtn_text.innerText = selectedOption;

            optionMenu.classList.remove("active");
        });
    });

    btnGo.addEventListener('click', (e) => {
        e.preventDefault()
        let red = document.getElementById('red').value
        let ca = document.getElementById('ca').value;

        if (red == '' || ca == '') {
            return;
        }
        window.location.href = `${base_url}/inicio/${red}/${ca}`
    })

    function getMiembros(red, ca) {
        $.ajax({
            url: './getMiembrosCuerpo',
            method: 'post',
            dataType: 'json',
            data: {
                red: red,
                ca: ca
            },
            success: function(data) {
                $('.miembros').empty()
                var htmlMiembros = '';
                data.forEach(element => {
                    htmlMiembros += `
                        <div class='miembro'>
                            <img src='${base_url}/resources/img/profiles/${element.img_user}' class='profile_pic' >
                            <span>${element.nombreCompleto}</span>
                            ${element.lider == 1 ? '<i class="fa-solid fa-crown" title="Líder"></i>' : '<i class="fa-solid fa-user" title="Miembro"></i>'}
                        </div>
                        `
                });
                $("#btnGo").removeClass(function(index, className) {
                    // Elimina todas las clases que comienzan con "bg-"
                    return (className.match(/(^|\s)bg-\S+/g) || []).join(' ');
                });
                $("#btnGo").addClass('bg-'+red);
                $("#titleMiembros").css('display','block')
                $('.miembros').html(htmlMiembros)
            },
            error: function(jqXHR) {
                console.log(jqXHR);
            },
            done: function() {
                console.log(Hola);
            }
        })
    }
</script>