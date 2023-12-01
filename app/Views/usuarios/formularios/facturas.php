<style>
	.drop-area {
		border: 5x dashed #ddd;
		border-radius: 5px;
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, 0.8);
		/* Fondo semitransparente */
		z-index: 5;
		/* Z-index alto para asegurarse de que esté por encima de otros elementos */
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
	}

	.drop-area.active {
		background-color: #b8d4fe;
		color: black;
		border: 2px dashed #618ac9;
	}

	.drop-area h2 {
		font-size: 30px;
		color: #fff;
		font-weight: 500;
		text-align: center;
	}

	.drop-area h6{
		text-align: center;
	}

	.drop-area span {
		font-size: 25px;
		font-weight: 500;
		color: #fff;
	}

	.drop-area button#btnFile {
		padding: 10px 25px;
		font-size: 20px;
		border: 0px;
		outline: none;
		background-color: #5256ad;
		color: white;
		border-radius: 5px;
		cursor: pointer;
		margin: 20px;
	}

	.drop-area button {
		padding: 10px 25px;
		font-size: 20px;
		border: 0px;
		outline: none;
		border-radius: 5px;
		cursor: pointer;
		margin: 20px;
	}

	.file-container {
		display: flex;
		align-items: center;
		gap: 10px;
		padding: 10px;
		border: solid 1px #ddd;
	}

	#preview {
		margin-top: 10px;
	}

	.status-text {
		padding: 0 10px;
	}

	.loaderCustom {
		display: inline-block;
		text-align: center;
		line-height: 86px;
		text-align: center;
		position: relative;
		padding: 0 48px;
		font-size: 48px;
		font-family: Arial, Helvetica, sans-serif;
		color: #fff;
	}

	.loaderCustom:before,
	.loaderCustom:after {
		content: "";
		display: block;
		width: 15px;
		height: 15px;
		background: currentColor;
		position: absolute;
		animation: load .7s infinite alternate ease-in-out;
		top: 0;
	}

	.loaderCustom:after {
		top: auto;
		bottom: 0;
	}

	@keyframes load {
		0% {
			left: 0;
			height: 43px;
			width: 15px;
			transform: translateX(0)
		}

		50% {
			height: 10px;
			width: 40px
		}

		100% {
			left: 100%;
			height: 43px;
			width: 15px;
			transform: translateX(-100%)
		}
	}

	#loaderCustom {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0, 0, 0, 0.5);
		/* Fondo semitransparente */
		z-index: 9999;
		/* Z-index alto para asegurarse de que esté por encima de otros elementos */
		display: flex;
		align-items: center;
		justify-content: center;
	}

	#info_importante {
		display: flex;
		align-items: center;
		flex-direction: column;
		align-content: flex-start;
		justify-content: center;
	}

	/* #manual{
		color: blue;
		cursor: pointer;
		font-weight: 500;
		font-size: 18px;
		text-decoration: underline;
	} */
</style>

<div id="loaderCustom">
	<span class="loaderCustom"></span>
</div>

<div class="content">

	<div class="card">
		<div class="card-header card-header-congresos">
			<h4 class="card-title text-uppercase">datos de factura</h4>
		</div>
		<div class="card-body card-carpetas">
			<form id="frm_factura" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-8 col-sm-12">
						<div class="form-group">
							<h2>Datos de la factura</h2>
							<hr>
						</div>
						<div class="form-group">
							<label for="">Correo electrónico</label>
							<input type="email" class="form-control" id="correo" name="correo" placeholder="example@dominio.com" required>
						</div>
						<div class="form-group">
							<label for="">Uso de la factura</label>
							<select class="custom-select d-block w-100" id="uso" name="uso" required readonly>
								<option value="general" selected>Gastos en general</option>
								<!-- <option value="definir">Por definir</option> -->
							</select>
						</div>
						<div class="form-group">
							<label for="">Calle</label>
							<input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" required>
						</div>
						<div class="form-group">
							<label for="">Número exterior</label>
							<input type="text" class="form-control" id="noext" name="noext" placeholder="Numero exterior" required>
						</div>
						<div class="form-group">
							<label for="">Número interior</label>
							<input type="text" class="form-control" id="noint" name="noint" placeholder="Numero interior">
						</div>
						<div class="form-group">
							<label for="">Código postal</label>
							<input type="number" class="form-control" id="cp" name="cp" placeholder="C.P" required>
						</div>
						<div class="form-group">
							<label for="">Colonia</label>
							<input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" required>
						</div>
						<div class="form-group">
							<label for="">Localidad</label>
							<input type="text" class="form-control" id="localidad" name="localidad" placeholder="Localidad" required>
						</div>
						<div class="form-group">
							<label for="">País</label>
							<select class="form-control" name="cbx_pais" id="cbx_pais" required>
								<option value="" disabled selected>Selecciona un país</option>
								<?php
								foreach ($paises as $pais) {
								?>
									<option value="<?php echo $pais["id"] ?>"><?php echo $pais["nombre"] ?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group">
							<label for="">Estado</label>
							<select class="form-control" name="cbx_estado" id="cbx_estado" required></select>
						</div>

						<div class="form-group">
							<label for="">Municipio</label>
							<select class="form-control" name="cbx_municipio" id="cbx_municipio" required></select>
						</div>

						<div class="form-group">
							<label for="regimen_fiscal">Régimen fiscal</label>
							<select class="form-control" name="regimen_fiscal" id="regimen_fiscal" required>

								<option value="" disabled selected>Selecciona el Régimen fiscal</option>

								<option value="601 - General de Ley Personas Morales">601 - General de Ley Personas Morales</option>

								<option value="603 - Personas Morales con Fines no Lucrativos">603 - Personas Morales con Fines no Lucrativos</option>

								<!-- <option value="605 - Sueldos y Salarios e Ingresos Asimilados a Salarios">605 - Sueldos y Salarios e Ingresos Asimilados a Salarios</option> -->

								<option value="606 - Arrendamiento">606 - Arrendamiento</option>

								<option value="607 - Régimen de Enajenación o Adquisición de Bienes">607 - Régimen de Enajenación o Adquisición de Bienes</option>

								<option value="608 - Demás ingresos">608 - Demás ingresos</option>

								<option value="610 - Residentes en el Extranjero sin Establecimiento Permanente en México">610 - Residentes en el Extranjero sin Establecimiento Permanente en México</option>

								<option value="611 - Ingresos por Dividendos (socios y accionistas)">611 - Ingresos por Dividendos (socios y accionistas)</option>

								<option value="612 - Personas Físicas con Actividades Empresariales y Profesionales">612 - Personas Físicas con Actividades Empresariales y Profesionales</option>

								<option value="614 - Ingresos por interes">614 - Ingresos por interes</option>

								<option value="615 - Régimen de los ingresos por obtención de premios">615 - Régimen de los ingresos por obtención de premios</option>

								<option value="616 - Sin obligaciones fiscales">616 - Sin obligaciones fiscales</option>

								<option value="620 - Sociedades Cooperativas de Producción que adoptan por diferir sus ingresos">620 - Sociedades Cooperativas de Producción que adoptan por diferir sus ingresos</option>

								<option value="621 - Incorporación Fiscal">621 - Incorporación Fiscal</option>

								<option value="622 - Actividades Agricolas, Ganaderas, Silvícolas y Pesqueras">622 - Actividades Agricolas, Ganaderas, Silvícolas y Pesqueras</option>

								<option value="623 - Opcional para Grupos de Sociedades">623 - Opcional para Grupos de Sociedades</option>

								<option value="624 - Coordinados">624 - Coordinados</option>

								<option value="625 - Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas">625 - Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas</option>

								<option value="626 - Régimen Simplificado de Confianza">626 - Régimen Simplificado de Confianza</option>

								<option value="628 - Hidrocarburos">628 - Hidrocarburos</option>

								<option value="629 - De los Regimenes Fiscales Preferentes y de las Empresas Multinacionales">629 - De los Regimenes Fiscales Preferentes y de las Empresas Multinacionales</option>

								<option value="630 - Enajenación de acciones en bolsa de valores">630 - Enajenación de acciones en bolsa de valores</option>

							</select>
						</div>

						<div class="form-group">
							<?php
							if (count($id_pagos) != 2) {
							?>
								<input type="text" name="tipo" id="tipo" value="separado" hidden>
							<?php
							} else {
							?>
								<label for="">¿Como desea su factura?</label>
								<select name="tipo" id="tipo" class="form-control" required>
									<option value="" disabled selected>Selecciona una opción</option>
									<option value="separado">Separado</option>
									<option value="junto">Juntos</option>
								</select>
							<?php
							}
							?>

						</div>

					</div>

					<div class="col-md-4 col-sm-12 text-center" id="info_importante">
						<div class="form-group">
							<h2>Información de la Constancia de Situación Fiscal</h2>
							<hr>
						</div>
						<div class="form-group">
							<i class="fas fa-file-pdf" style="font-size: 3rem; color: #F40F02;"></i>
							<p id="nombre_archivo">Ningun archivo seleccionado</p>
							<input type="file" id="csf2" accept="application/pdf" class="form-control" />
						</div>
						<div class="form-group">
							<label for="">Nombre / Razón social</label>
							<p id="lbl_razons">No identificado</p>
							<input type="text" class="form-control" placeholder="Nombre/razon social" id="nombre" name="nombre" required>
						</div>

						<div class="form-group">
							<label for="">RFC</label>
							<p id="lbl_rfc">No identificado</p>
							<input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC" required minlength="12" maxlength="13" pattern="^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$">
						</div>

						<input type="text" name="id_pagos_facturar" id="id_pagos_facturar" require value="<?= $id_pagos_facturar ?>" hidden>
					</div>
				</div>
				<hr>
				<button type="submit" class="btn btn-block bg-<?= $_SESSION['red'] ?>">Solicitar factura</button>
				<div class="drop-area">
					<h2>Arrastre y suelte su CONSTANCIA DE SITUACIÓN FISCAL</h2>
					<button type="button" id='btnFile'>Seleccione su archivo</button>
					<span>O</span>
					<button type='button' class='btn btn-warning' id='manual'>Ingrese sus datos manualmente</button>
					<input type="file" name="csf" id="csf" accept="application/pdf" hidden />
					
					<h6>Si el sistema no lee su CSF o es del extranjero podrá ingresar de manera manual los datos.</h6>
				</div>

			</form>
		</div>
	</div>

</div>


















<script type="text/javascript" src="<?php echo base_url("resources/js/form-validation/index.js") ?>"></script>

<script type="text/javascript" src="<?php echo base_url("resources/js/factura.js") ?>"></script>