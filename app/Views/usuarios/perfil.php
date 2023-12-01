<div class="content">
	<div class="row desktop-profile">
		<div class="col-md-12">
			<div class="card card-perfil">
				<div class="row">
					<div class="col-md-6 bg-<?= $_SESSION['red'] ?>" id="profile-card-left">
						<img src="<?= base_url('resources/img/isotipos/Mapa blanco.png') ?>" alt="">
					</div>
					<div class="col-md-6 bg-<?= $_SESSION['red'] ?>" id="profile-text-right">
						<p class="upper">
							<label style="font-size: 80px;"><?= $_SESSION['red'] ?></label><br>
							<?= $fullname_red ?>
						</p>
					</div>
				</div>
				<!--<div class="bg-presentacion bg-<?= $_SESSION['red'] ?>"></div>-->
				<div class="profile_pic">
					<?php
					if ($usuario["profile_pic"] !== NULL) {
					?>
						<img src="<?php echo base_url("resources/img/profiles/" . $usuario["profile_pic"]) ?>" alt="">
					<?php
					} else {
					?>
						<img src="<?php echo base_url("resources/img/svg/avatar.png") ?>" alt="">
					<?php
					}
					?>
				</div>
				<div class="main-text">
					<h2><?= $usuario['nombre'] . ' ' . $usuario['ap_paterno'] . ' ' . $usuario['ap_materno'] ?></h2>
					<h3><i class="fas fa-user-graduate">&nbsp</i><?= $usuario['grado_academico'] ?> en <?= $usuario['especialidad'] ?></h3>
				</div>
				<hr>
				<div class="socials">

					<i class="fa-solid fa-envelope"></i><?= $usuario["correo"] ?><br><br>

					<i class="fa-solid fa-envelope"></i><?= $usuario["correo_institucional"] ?><br><br>

					<i class="fa-solid fa-mobile"></i><?= $usuario['telefono'] ?><br>

				</div>

				<a class="btn btn-block btn-warning" id="editarDatos" href="./editar">Editar datos <i class="fa-solid fa-user-pen"></i></a><br>
			</div>
		</div>
	</div>

	<div class="mobile-profile">
		<div class="col-md-12">
			<div class="card card-perfil">
				<div class="row">
					<div class="col bg-<?= $_SESSION['red'] ?>" id="profile-card-left">
						<img src="<?= base_url('resources/img/isotipos/Mapa blanco.png') ?>" alt="">
					</div>
					<div class="col bg-<?= $_SESSION['red'] ?>" id="profile-text-right">
						<p class="upper">
							<label class="abreviacion_red"><?= $_SESSION['red'] ?></label>
							<label class="nombre_completo_red"><?= $fullname_red ?></label>
						</p>
					</div>
				</div>
				<!--<div class="bg-presentacion bg-<?= $_SESSION['red'] ?>"></div>-->
				<div class="profile_pic">
					<?php
					if ($_SESSION["profile_pic"] !== NULL) {
					?>
						<img src="<?php echo base_url("resources/img/profiles/" . $_SESSION["profile_pic"]) ?>" alt="">
					<?php
					} else {
					?>
						<img src="<?php echo base_url("resources/img/svg/avatar.png") ?>" alt="">
					<?php
					}
					?>
				</div>
				<div class="main-text">
					<h2><?= $usuario['nombre_completo'] ?></h2>
					<h3><i class="fas fa-user-graduate">&nbsp</i><?= $usuario['grado_academico'] ?> en <?= $usuario['especialidad'] ?></h3>
				</div>
				<hr>
				<div class="socials">

					<i class="fa-solid fa-envelope"></i><?= $usuario["correo"] ?><br><br>

					<i class="fa-solid fa-envelope"></i><?= $usuario["correo_institucional"] ?><br><br>

					<i class="fa-solid fa-mobile"></i><?= $usuario['telefono'] ?><br>

				</div>

				<a class="btn btn-block btn-warning" href="./editar">Editar datos <i class="fa-solid fa-user-pen"></i></a><br>
			</div>
		</div>
	</div>
	<hr>





	<!--Seccion de constancias-->
	<div class="row">

		<div class="col-md-12" style="margin-bottom: 2rem;">

			<?php

			if (empty($constancias)) {

			?>

				<hr>

				<h3>Aqui podra consultar sus constancias. Por el momento no tiene constancias adjuntas.</h3>

				<?php

			} else {

				function generateConstancia($constancias)
				{
					foreach ($constancias as $c) {
						$red = $c['red'];
						$anio = $c['anio'];
						$tipo = $c['tipo_constancia'];


						if($tipo == 'Ponente'){
							$path_url = "ver/constancia/{$tipo}/{$anio}/{$c['submission_id']}";
						}else{
							$path_url = isset($c['path']) ? $c['path'] : "ver/constancia/{$tipo}/{$anio}";
						}
						

						$img_path = "resources/img/caratulas/{$red}/{$anio}/{$tipo}.jpg";

						$alt = $tipo . '_' . $red . '_' . $anio;
						$pendiente = false;

						if (!file_exists($img_path)) {
							$img_path = "resources/img/caratulas/wip.jpg";
							$alt = 'Constancia pendiente';
							//$pendiente = true;
						}
					?>
						<div class="col-xl-2 col-lg-2 col-md-3 col-sm-6" style="padding-bottom: 1rem;">
							<img class="card-img-top" src="<?= base_url($img_path) ?>" alt="<?= $alt ?>">
							<?php
							if ($pendiente === true) {
							?>
								<button style="border-radius: 0 0 10px 10px;" class="btn btn-block bg-<?php echo $_SESSION["red"] ?>">En proceso</button>
							<?php
							} else {
							?>
								<a style="border-radius: 0 0 10px 10px;" class="btn btn-block <?= $_SESSION["red"] ?>" href="<?= base_url($path_url) ?>">Descargar</a>
							<?php
							}
							?>
						</div>
						<?php
					}
				}

				$i = 0;
				echo '
				<div class="card">
					<div class="card-header header_title_card">
						<h3>Constancias adquiridas</h3>
					</div>
					<div class="card-body body_card">
					<p>
						Nota: Las constancias estarán vigentes dentro de nuestra plataforma RedesLA <a href="https://www.redesla.la/redesla/">https://www.redesla.la/redesla/</a>, podrá realizar la descarga en un lapso de 3 meses posteriores al congreso y las de la investigación durante el periodo de participación, después de este tiempo dichas constancias serán eliminadas por cuestiones de nuestros servidores, por lo que se recomienda la descarga y resguardo de estas en algún dispositivo y/o nube segura.
						La regeneración o recuperación de cualquier constancia generará un costo de $100 por usuario y año de participación.
					</p>
					';
					echo '<div id="accordion" class="card-perfil accordion">';
				foreach ($constancias as $key => $constancia) {

					if ($i == 0) {
						//Primer parametro
						$i++;
						?>
						<div class="card">
							<div class="card-header" id="heading<?= $key ?>">
								<h5 class="mb-0">
									<button class="btn btn-link" data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="true" aria-controls="collapse<?= $key ?>" style="text-decoration:none; color:var(--font-primary-color)">
										<span class="titleAnioConstancias">Constancias <?= $key ?></span>
									</button>
								</h5>
							</div>

							<div id="collapse<?= $key ?>" class="collapse show" aria-labelledby="heading<?= $key ?>" data-parent="#accordion">
								<div class="card-body row">
									<?php generateConstancia($constancia) ?>
								</div>
							</div>
						</div>
					<?php
					} else {
					?>
						<div class="card">
							<div class="card-header" id="heading<?= $key ?>">
								<h5 class="mb-0">
									<button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?= $key ?>" aria-expanded="false" aria-controls="collapse<?= $key ?>" style="text-decoration:none; color:var(--font-primary-color)">
										<span class="titleAnioConstancias">Constancias <?= $key ?></span>
									</button>
								</h5>
							</div>
							<div id="collapse<?= $key ?>" class="collapse" aria-labelledby="heading<?= $key ?>" data-parent="#accordion">
								<div class="card-body row">
									<?php generateConstancia($constancia) ?>
								</div>
							</div>
						</div>
					<?php
					}
				}
					echo '
					</div>
					</div>
				</div';
			}
			?>

		</div>

	</div>

</div>