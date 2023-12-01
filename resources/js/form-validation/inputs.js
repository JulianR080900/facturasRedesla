
//FUNCION SOLO LETRAS Y SIGNOS DE PUNTUACION

$("input.ol").on("keypress", function (event) {
    key = event.keyCode || event.which;

	tecla = String.fromCharCode(key).toLowerCase();

	letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.,/";

	especiales = "8-37-39-46";

	tecla_especial = false;

	for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;

			break;
		}
	}

	if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		event.preventDefault();
	}
});

//FUNCION LETRAS, SIGNOS DE PUNTUACION Y NUMEROS

$("input.ln").on("keypress", function (event) {
    key = event.keyCode || event.which;

	tecla = String.fromCharCode(key).toLowerCase();

	letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.,/-0123456789#";

	especiales = "8-37-39-46";

	tecla_especial = false;

	for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;

			break;
		}
	}

	if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		event.preventDefault();
	}
});

//FUNCION NUMEROS

$("input.on").on("keypress", function (event) {
    key = event.keyCode || event.which;

	tecla = String.fromCharCode(key).toLowerCase();

	letras = "0123456789+";

	especiales = "8-37-39-46";

	tecla_especial = false;

	for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;

			break;
		}
	}

	if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		event.preventDefault();
	}
});

//FUNCION EMAIL

$("input.oe").on("keypress", function (event) {
    key = event.keyCode || event.which;

	tecla = String.fromCharCode(key).toLowerCase();

	letras = "abcdefghijklmnñopqrstuvwxyz0123456789!#$%&*/=?^_+-{|}~";

	especiales = "8-37-39-46";

	tecla_especial = false;

	for (var i in especiales) {
		if (key == especiales[i]) {
			tecla_especial = true;

			break;
		}
	}

	if (letras.indexOf(tecla) == -1 && !tecla_especial) {
		event.preventDefault();
	}
});