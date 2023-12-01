<!DOCTYPE html>
<html lang="es'MX">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenidos a REDESLA - Plataforma de miembros RedesLA</title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('/resources/img/favicon/') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('/resources/img/favicon/') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('/resources/img/favicon/') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('/resources/img/favicon/') ?>/site.webmanifest">
    <!-- FONTAWSOME 6 -->
    <link rel="stylesheet" href="<?= base_url('resources/fontawesome/css/all.css') ?>">
    </link>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        *,
        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(to right, #434343 0%, black 100%);
        }

        .container {
            width: 80vw;
            height: auto;
            display: grid;
            grid-template-columns: 100%;
            grid-template-areas: "login";
            box-shadow: 0 0 17px 10px rgb(0 0 0 / 30%);
            border-radius: 20px;
            background: white;
            overflow: hidden;
        }

        .design {
            grid-area: design;
            display: none;
            position: relative;
        }

        .rotate-45 {
            transform: rotate(-45deg);
        }

        .design .pill-1 {
            bottom: 0;
            left: -40px;
            position: absolute;
            width: 80px;
            height: 200px;
            background: linear-gradient(#bf272d, #88181a, #bf272d);
            /* border-radius: 40px; */
        }

        .design .pill-2 {
            top: -100px;
            left: -80px;
            position: absolute;
            height: 450px;
            width: 220px;
            background: linear-gradient(#ff6c0e, #bc4700, #ff6c0e);
            /* border-radius: 200px; */
        }

        .design .pill-3 {
            top: -100px;
            left: 160px;
            position: absolute;
            height: 200px;
            width: 100px;
            background: linear-gradient(#6db13e, #0e7263, #6db13e);
            /* border-radius: 70px; */
        }

        .design .pill-4 {
            bottom: -180px;
            left: 220px;
            position: absolute;
            height: 300px;
            width: 120px;
            background: linear-gradient(#E75396, #F1A2C7, #E75396);
            /* border-radius: 70px; */
        }

        .design .pill-5 {
            bottom: -180px;
            left: 400px;
            position: absolute;
            height: 300px;
            width: 120px;
            background: linear-gradient(#40277E, #5A2B7F, #40277E);
            /* border-radius: 70px; */
        }

        .login {
            grid-area: login;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            background: white;
            height: 100%;
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .login h3.title {
            margin: 15px 0;
        }

        .text-input {
            background: #e6e6e6;
            height: 40px;
            display: flex;
            width: 60%;
            align-items: center;
            border-radius: 10px;
            padding: 0 15px;
            margin: 5px 0;
        }

        .text-input input {
            background: none;
            border: none;
            outline: none;
            width: 100%;
            height: 100%;
            margin-left: 10px;
        }

        .text-input i {
            color: #686868;
        }

        ::placeholder {
            color: #9a9a9a;
        }

        .login-btn {
            width: 68%;
            padding: 10px;
            color: white;
            background: linear-gradient(to right, #434343 0%, black 100%);
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin-top: 10px;
        }

        a {
            font-size: 12px;
            color: #9a9a9a;
            cursor: pointer;
            user-select: none;
            text-decoration: none;
        }

        a.forgot {
            margin-top: 15px;
        }

        .create {
            /* position: absolute; */
            /* Establece el posicionamiento absoluto */
            bottom: 1rem;
            /* Coloca "create" en la parte inferior del contenedor "login" */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 10px;
        }

        .create h6 {
            font-weight: 700;
        }

        .create p,
        .create a {
            margin: 1px;
            font-size: 15px;
        }

        .create i {
            color: #9a9a9a;
            margin-left: 10px;
        }

        .container {
            padding-right: 0px !important;
        }

        .fa-whatsapp {
            color: #25d366 !important;
        }

        #mapas img {
            width: 30px;
            height: 40px;
        }

        #redesla {
            display: none;
        }

        .informesMobile{
            display: none;
        }

        .show {
            cursor: pointer;
        }

        /* @media (min-width: 768px) {
            .container {
                grid-template-columns: 30% 70%;
                grid-template-areas: "design login";
            }

            .design {
                display: block;
            }
        } */

        @media (max-width: 1150px) {
            #mapas{
                margin-top: 0.5rem;
            }
        }

        @media (max-width: 768px) {

            .container {
                height: 80vh;
            }

            .create {
                padding-left: 10px;
                padding-right: 20px;
            }

            #mapas {
                display: none;
            }

            #redesla {
                display: block;
                margin-top: 1rem;
            }

            #redesla img {
                width: 100%;
                height: 10vh;
            }

            .title {
                display: none;
            }

            .informesDesktop{
                display: none;
            }

            .informesMobile{
                display: block;
                text-align: center;
            }
        }

        /* VIDEO */
        .design img {
            height: 100%;
            width: 100%;
        }

        .container {
            padding-left: 0px !important;
        }

        

        /* BARRAS */

        /* .design .bar1 {
            bottom: 400px;
            left: 0px;
            position: absolute;
            height: 80px;
            width: 300px;
            background: linear-gradient(#E75396, #F1A2C7, #E75396);
        }

        .design .bar1::after{
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            content: 'Releg';
            color: #ffffff;
            text-transform: uppercase;
            font-weight: 800;
            font-size: 3rem;
        }

        .design .bar2 {
            bottom: 300px;
            left: 0px;
            position: absolute;
            height: 80px;
            width: 300px;
            background: linear-gradient(#E75396, #F1A2C7, #E75396);
        }

        .design .bar3 {
            bottom: 200px;
            left: 0px;
            position: absolute;
            height: 80px;
            width: 300px;
            background: linear-gradient(#E75396, #F1A2C7, #E75396);
        }

        .design .bar4 {
            bottom: 100px;
            left: 0px;
            position: absolute;
            height: 80px;
            width: 300px;
            background: linear-gradient(#E75396, #F1A2C7, #E75396);
        }
        
        .design .bar5 {
            bottom: 0px;
            left: 0px;
            position: absolute;
            height: 80px;
            width: 300px;
            background: linear-gradient(#E75396, #F1A2C7, #E75396);
        } */
    </style>
</head>

<body>
    <div class="container">
        <div class="design">
            <!-- <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
            <div class="bar4"></div>
            <div class="bar5"></div> -->

            <!-- <div class="pill-1 rotate-45"></div>
            <div class="pill-2 rotate-45"></div>
            <div class="pill-3 rotate-45"></div>
            <div class="pill-4 rotate-45"></div>
            <div class="pill-5 rotate-45"></div> -->

        </div>
        <form method="post" action="./login">
            <div class="login">
                <div id="mapas">
                    <div class="row text-center">
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <img src="<?= base_url('resources/img/isotipos/Mapa_Relayn.png') ?>" alt="Plataforma miembros Relayn" title='Relayn'>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <img src="<?= base_url('resources/img/isotipos/Mapa_Relep.png') ?>" alt="Plataforma miembros Relep" title="Relep">
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <img src="<?= base_url('resources/img/isotipos/Mapa_Relen.png') ?>" alt="Plataforma miembros Relen" title="Relen">
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                            <img src="<?= base_url('resources/img/isotipos/Mapa_Releg.png') ?>" alt="Plataforma miembros Releg" title="Releg">
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-4 col-6">
                            <img src="<?= base_url('resources/img/isotipos/Mapa_Releem.png') ?>" alt="Plataforma miembros Releem" title="Releem">
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-4 col-6">
                            <img src="<?= base_url('resources/img/isotipos/Mapa_Redesla.png') ?>" alt="Plataforma miembros Redesla" title="RedesLA">
                        </div>
                    </div>
                </div>

                <div id="redesla">
                    <img src="<?= base_url('resources/img/logos_con_letras/Letras_Redesla.png') ?>" alt="Plataforma miembros Redesla">
                </div>

                <h3 class="title">Facturas RedesLA</h3>
                <span>¡Bienvenido!</span>

                <div class="text-input">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" placeholder="Correo electrónico" name="correo" value="<?= get_cookie('correo');  ?>" required>
                </div>
                <div class="text-input">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" id="password" placeholder="Contraseña" value="<?= get_cookie('pass');  ?>" required>
                    <i class="fa-solid fa-eye show" id="showIcon"></i>
                </div>
                <div class="div">
                    <label>
                        <input type="checkbox" name="remember" id="remember">
                        Recordar contraseña
                    </label>
                </div>
                <button class="login-btn" type="submit">Iniciar sesión <i class="fa-solid fa-circle-arrow-right"></i></button>
            </div>
        </form>
    </div>

    <script>
        $(".show").on('click', function() {
            const input = $("#password");
            let type = input.attr('type')

            if (type == 'password') {
                input.attr('type', 'text')
                $("#showIcon").removeClass('fa-eye').addClass('fa-eye-slash')
            } else {
                input.attr('type', 'password')
                $("#showIcon").removeClass('fa-eye-slash').addClass('fa-eye')
            }
        })

        $(document).ready(function() {
            <?php if (session()->getFlashdata('icon')) { ?>
                Swal.fire({
                    icon: '<?= session()->getFlashdata('icon') ?>',
                    title: '<?= session()->getFlashdata('title') ?>',
                    text: '<?= session()->getFlashdata('text') ?>',
                })
            <?php } ?>
        })
    </script>
</body>

</html>