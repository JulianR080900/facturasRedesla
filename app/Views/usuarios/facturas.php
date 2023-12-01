<style>
	.fila-seleccionada {
		background-color: #f0f0f0 !important;
		/* Cambia el color de fondo a tu preferencia */
	}

	table.dataTable tbody tr{
		background-color: transparent;
	}

	table td:first-child {
		cursor: pointer !important;
	}

	.fila-seleccionada td:first-child {
		/* Estilos CSS para el primer td */
		/* Ejemplo: */
		background-color: lightgreen !important;
		font-weight: bold;
		cursor: pointer;
	}
</style>

<div class="content">
	<div class="card card-perfil">
		<div class="card-body">
			<div class="card-title">
				<h4>Facturas</h4>
			</div>
			<span class="n_<?= ucfirst(session('red')) ?>">Importante: Posicione su mouse sobre el espacio en blanco (columna <b><u>Seleccionar</u></b>) de los registros que quiera facturar y dé clic para seleccionar el (los) pago (s) a facturar (Una vez seleccionado un registro, la columna <b><u>Seleccionar</u></b> del registro se marcara con color verde).</span>
			<div class="row">
				<div class="col-md-12">
					<form action="./facturas/formulario" method="post" id="formFacturas">
						<div class="table-responsive">
							<table class="table table-striped" id="dt_facturas">
								<thead>
									<tr>
										<th class="centered">Seleccionar</th>
										<th class="centered">Movimiento</th>
										<th class="centered">Estado</th>
										<th class="centered">Comprobante (s)</th>
										<th class="centered">Fecha del comprobante</th>
										<th class="centered">Archivos</th>
									</tr>
								</thead>
								<tbody id="dt_facturas"></tbody>
							</table>
						</div>
						<input type="text" name="movimientos" id="movimientos" hidden>
					</form>
					<legend>Su factura se encontrará <b>disponible</b> de 5 días a 10 días y la podrá descargar desde la carpeta de <b>Archivos</b></legend>
					<button type="button" class="btn btn-block btn-success" id="enviar">Enviar</button>
				</div>
			</div>
		</div>
	</div>


</div>

<script type="text/javascript" src="<?php echo base_url("resources/js/factura.js") ?>"></script>