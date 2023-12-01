<link rel="stylesheet" href="<?= base_url('resources/css/pagos.css') ?>">

<div class="content">


	<div class="card card-perfil">
		<div class="card-body">
			<div class="card-title">
				<h4>Pagos</h4>
			</div>
			<h5>Proyectos disponibles</h5>
			<h5 class="n_<?= $_SESSION['red'] ?>">PARA HABILITAR UN PROYECTO SELECCIONE LA CONVOCATORIA EN LA QUE PARTICIPARÁ</h5>
			<?php

			$entro = 0;

			foreach ($array_pagos as $pago) {

				//tomamos el nombre del proyecto es: $pago["proyecto"]

				$explode = explode(' ', $pago["proyecto"]);

				if (($explode[0] == 'Congreso' || $explode[0] == 'Oyente') && $entro == 0) {

			?>

					<a href='<?php echo base_url("resources/pdf/manual_pago_congreso.pdf") ?>' target="_blank"><i class="fas fa-file-pdf" style="color:red"></i> Manual para registro de pago y solicitud de factura en zona congreso</a>

				<?php

					$entro = 1;
				} else if (($explode[0] == 'Esquema' || $explode[0] == 'Desafío' || $explode[0] == 'Investigación')  && $entro == 0) {

				?>

					<a href='<?php echo base_url("resources/pdf/manual_pagos_investigadores.pdf") ?>' target="_blank"><i class="fas fa-file-pdf" style="color:red"></i> Manual para registro de pago y solicitud de factura en zona investigación</a>

			<?php

					$entro = 1;
				}
			}

			?>

			<hr>

			<!-- <form method="post" action="<?php echo base_url("addPagoUsuario") ?>" id="submitId"> -->

			<select class="form-control" name="paquete" required id="proyecto">

				<option disabled selected value="">Seleccione un proyecto</option>

				<?php

				foreach ($paq_disponibles as $paq) {

					if ($_SESSION["pais"] == 2) {

				?>

						<option id="paquete" value="<?php echo $paq["id"] ?>"><?php echo $paq["nombre"] . " " . $paq["redCueCa"] . " " . $paq["anio"] . " $" . $paq["montoMx"] . ".00 MXN " . $paq["monto_escritoMx"] ?></option>

					<?php

					} else {

					?>

						<option id="paquete" value="<?php echo $paq["id"] ?>"><?php echo $paq["nombre"] . " " . $paq["redCueCa"] . " " . $paq["anio"] . " $" . $paq["montoUs"] . ".00 USD " . $paq["monto_escritoUs"] ?></option>

				<?php

					}
				}

				?>

			</select><br>

			<?php
			if($suma_restantes > 0){
				?>
				<button class="btn btn-block btn-danger" type="button">Podrás añadir un nuevo proyecto cuando liquídes tu deuda</button>
				<p class="text-center">Restante: <span class="text-danger">$<?= $suma_restantes ?></span></p>
				<p class="text-center">Importante: Si ya registro el pago pero aún permanece la leyenda de adeudo, por favor contacte al equipo RedesLA para que validen su pago.</p>
				<?php
			}else{
				?>
				<button class="btn btn-block bg-<?= $_SESSION['red'] ?>" type="submit" id="btnAddProyecto">Agregar proyecto <i class="fa-solid fa-circle-plus"></i></button>
				<?php
			}
			?>

			<!-- </form> -->



			<hr>



			<div id="mensajesProyectos"></div>

			<?php

			if (empty($array_pagos)) {

				echo "<h3>No se ha asociado ningun proyecto al cuerpo académico</h3>";
			} else {

			?>


				<div class="row overflow-auto">

					<div class="col-md-12">
						<h3>Pagos</h3>
						<div class="card bg-dark">

							<div class="card-body card-body-pagos">

								<div class="row">

									<div class="col-md-12">

										<table class="table table-hover">

											<thead>

												<tr>

													<th scope="col">ID</th>

													<th scope="col">Paquete</th>

													<th scope="col">Monto</th>

													<th scope="col">Restante</th>

													<th scope="col"></th>

												</tr>

											</thead>

											<tbody>

												<?php

												$i = 1;

												foreach ($array_pagos as $pago) {

												?>

													<tr class="accordion-toggle collapsed" id="accordion<?php echo $i; ?>" data-toggle="collapse" data-parent="#accordion<?php echo $i; ?>" href="#collapse<?php echo $i; ?>" style="cursor:pointer">

														<td scope="row"><?php echo $pago["id"] ?></td>

														<td><?php echo $pago["proyecto"] ?></td>

														<?php

														$fecha_hoy = date('Y-m-d');

														if ($fecha_hoy <= $pago["pronto_pago"]["fechaLimite_prontoPago"]) {

															if ($_SESSION["pais"] == 2) {

														?>
																<td><del>$<?php echo $pago["pronto_pago"]["montoMx"]; ?></del> $<?php $prontoPago = $pago["pronto_pago"]["pronto_PagoMX"] . ' ' . $pago["moneda"];

																																echo $prontoPago;
																															} else {

																																?>
																<td><del>$<?php echo $pago["pronto_pago"]["montoUs"]; ?></del> $<?php $prontoPago = $pago["pronto_pago"]["pronto_PagoUs"] . ' ' . $pago["moneda"];

																																echo $prontoPago;
																															}

																																?>
																</td>

																<?php

																if ($_SESSION["pais"] == 2) {

																	echo "<script>

														var targetDiv = document.getElementById('mensajesProyectos');

														targetDiv.innerHTML += '<p style=" . '"' . "font-size: 12px;" . '"' . ">El proyecto " . $pago["proyecto"] . " tiene un descuento por <b class=" . 'n_' . $_SESSION["red"] . ">pronto pago</b>, de $" . $pago["pronto_pago"]["montoMx"] . " " . $pago["moneda"] . " a <b class=" . 'n_' . $_SESSION["red"] . ">$" . $prontoPago . "</b>. El descuento solamente se aplicará si se recibe el monto total del descuento de <b class=" . 'n_' . $_SESSION["red"] . ">pronto pago</b> antes de <b class=" . 'n_' . $_SESSION["red"] . ">" . $pago["pronto_pago"]["fechaLimite_prontoPago"] . "</b></p>';

														</script>";
																} else {

																	echo "<script>

														var targetDiv = document.getElementById('mensajesProyectos');

														targetDiv.innerHTML += '<p style=" . '"' . "font-size: 12px;" . '"' . ">El proyecto " . $pago["proyecto"] . " tiene un descuento por <b class=" . 'n_' . $_SESSION["red"] . ">pronto pago</b>, de $" . $pago["pronto_pago"]["montoUs"] . " " . $pago["moneda"] . " a <b class=" . 'n_' . $_SESSION["red"] . ">$" . $prontoPago . "</b>. El descuento solamente se aplicará si se recibe el monto total del descuento de <b class=" . 'n_' . $_SESSION["red"] . ">pronto pago</b> antes de <b class=" . 'n_' . $_SESSION["red"] . ">" . $pago["pronto_pago"]["fechaLimite_prontoPago"] . "</b></p>';

														</script>";
																}
															} else {

																?>

																<td>$<?php echo $pago["monto"] . ' ' . $pago["moneda"]; ?></td>

															<?php

															}

															?>

															<td>$<?php echo $pago["restante"] . ' ' . $pago["moneda"]; ?></td>

															<td><i class="fas fa-chevron-down"></i></td>

													</tr>

													<div class="col-md-12">

														<tr class="hide-table-padding">

															<td colspan="5">

																<div id="collapse<?php echo $i; ?>" class="collapse in p-3">

																	<table class="table text-center">

																		<thead class="thead-table-facturas">

																			<tr>

																				<th scope="col">Movimiento</th>

																				<th scope="col">Comprobante</th>

																				<th scope="col">Estado</th>

																			</tr>

																		</thead>

																		<tbody>

																			<?php

																			if (isset($pago["movimientos"])) {

																				foreach ($pago["movimientos"] as $movimiento) {

																			?>

																					<tr class="table-body-facturas">

																						<?php

																						$return = strpos($movimiento["movimiento"], "+");

																						echo $return === 0 ? '<td class="verde">' . $movimiento["movimiento"] . ' ' . $pago["moneda"] . '</td>' : '<td style="color:red">' . $movimiento["movimiento"] . ' ' . $pago["moneda"] . '</td>'; ?>

																						<td> <?php echo $movimiento["comprobante"] == "No requiere" ? "Se ingresó proyecto" : "<a href=" . base_url("visualizador/" . $movimiento["comprobante"]) . "><i class='far fa-file-alt'></i></a>" ?></td>

																						<td><?php echo $movimiento["estado"] == 0 ? "<i class='fas fa-times-circle' style='color:red'></i>" : "<i class='fas fa-check-circle' style='color:green'></i>" ?></td>

																						<td></td>

																					</tr>

																				<?php

																				}
																			} else {

																				?>

																				<td colspan='4' style="color: #000;">Proyecto añadido automáticamente por haber pagado el proyecto de Investigación</td>

																			<?php

																			}

																			?>

																		</tbody>

																	</table>

																	<?php

																	if ($pago["restante"] > "0") { //CAMBIO
																		if($pago['monto'] == $pago['restante']){
																			?>
																			<button class="btn btn-block btn-danger btnEliminarPago" data-id='<?= $pago['id'] ?>'>Eliminar proyecto <i class="fa-solid fa-trash"></i></button>
																			<?php
																		}
																		?>
																		<button class="btn btn-block bg-<?= $_SESSION['red'] ?> btn-add-pago" name="addPago" onclick="funcionMax(this)" data-max="<?= $pago['restante'] ?>" value="<?php echo $pago["id"]; ?>">Añadir movimiento <i class="fa-solid fa-file-invoice-dollar"></i></button>
																	<?php

																	}else if($pago['monto'] == $pago['restante']){
																		?>
																		<button class="btn btn-block btn-danger btnEliminarPago" data-id='<?= $pago['id'] ?>'>Eliminar proyecto <i class="fa-solid fa-trash"></i></button>
																		<?php
																	}

																	?>

																</div>

															</td>

														</tr>

													</div>

												<?php

													$i++;
												}

												?>

											</tbody>

										</table>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

			<?php

			}

			?>
		</div>
	</div>



</div>



<div id="modalMoldePagos" class="modal fade hide bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

	<div class="modal-dialog modal-lg">

		<div class="modal-content">

			<div class="modal-header">

				<h5 class="modal-title" id="exampleModalLongTitle">Añadir pago</h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: var(--font-primary-color);">

					<span aria-hidden="true">&times;</span>

				</button>

			</div>

			<div class="modal-body">

				<form action="./addMovimiento" method="post" enctype="multipart/form-data">

					<div class="col-md-12">

						<label for="cantidad"><b>Cantidad pagada</b></label>

						<p class="n_<?= $_SESSION['red'] ?>"><i>Recuerde revisar si aplica para los descuentos de pronto pago</i></p>

						<input type="number" min='0' step="0.01" class="form-control" name="cantidad" id="cantidad" required placeholder="Ingrese una cantidad">

						<label for="fecha"><b>Fecha de pago</b></label>

						<input id="fecha" name="fecha" class="form-control" type="date" required placeholder="Ingrese la fecha en que realizó el pago">

						<label class="form-label" for="comprobante"><b>Cargar comprobante</b></label>

						<input type="file" class="form-control" id="comprobante" name="comprobante" required accept=".jpg,.pdf,.png,.jpeg">

						<input type="text" name="id_pago" id="id_pago" hidden value="">

						<hr>

						<button type="submit" class="btn form-control bg-<?= $_SESSION['red'] ?>">Cargar pago</button>

					</div>

				</form>

			</div>

		</div>

	</div>

</div>

<script type="text/javascript" src="<?php echo base_url("resources/js/pagos.js") ?>"></script>