$( document ).ready(function(){

    $("input[name='id_autor[]']").prop("readonly",true);

    $("input[name='autores[]'").prop("readonly",true);

    $("#titulo").prop("readonly",true);

    $("#prefijo").prop("readonly",true);

    $("#subtitulo").prop("readonly",true);

    $("#btnRegistrar").prop("disabled",true);

})



$("button[name='editarAutor']").on("click",function(event){

    identificador = event.target.id;

    disabled = $("#autor_"+identificador).is('[readonly]');

    disabled2 = $("#autor_appat_"+identificador).is('[readonly]');

    disabled3 = $("#autor_apmat_"+identificador).is('[readonly]');



    disabled ? $("#autor_"+identificador).prop("readonly",false) : $("#autor_"+identificador).prop("readonly",true);

    disabled2 ? $("#autor_appat_"+identificador).prop("readonly",false) : $("#autor_appat_"+identificador).prop("readonly",true);

    disabled3 ? $("#autor_apmat_"+identificador).prop("readonly",false) : $("#autor_apmat_"+identificador).prop("readonly",true);



    

});



$("#editPrefijo").on("click",function(){

    disabledPrefijo = $("#prefijo").is('[readonly]');

    disabledPrefijo ? $("#prefijo").prop("readonly",false) : $("#prefijo").prop("readonly",true);

});



$("#editTitulo").on("click",function(){

    disabledTitulo = $("#titulo").is('[readonly]');

    disabledTitulo ? $("#titulo").prop("readonly",false) : $("#titulo").prop("readonly",true);

});



$("#editSubtitulo").on("click",function(){

    disabledSubtitulo = $("#subtitulo").is('[readonly]');

    disabledSubtitulo ? $("#subtitulo").prop("readonly",false) : $("#subtitulo").prop("readonly",true);

});



$("#prefijo, #titulo, input[name='autores[]'], #nombre_completo_ponente").on("keypress", function (event) {

	key = event.keyCode || event.which;

	tecla = String.fromCharCode(key).toLowerCase();

	letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";

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



$("#checkbox").on("click",function(){

    $('#checkbox').prop('checked') ? $("#btnRegistrar").prop("disabled",false) : $("#btnRegistrar").prop("disabled",true);

});






/*
if(message == "vacios"){

	Swal.fire({

        icon: 'warning',

        title: 'OJO',

        text: 'Complete correctamente los campos requeridos, no deje campos vacios.',

      });

}



if(message == "terminos"){

    Swal.fire({

        icon: 'warning',

        title: 'OJO',

        text: 'Favor de aceptar los terminos y condiciones.',

      });

}



if(message == "error3"){

    Swal.fire({

        icon: 'warning',

        title: 'Lo sentimos',

        text: 'La ponencia ya se encuentra registrada',

      });

}



if(message == "error4"){

    Swal.fire({

        icon: 'warning',

        title: 'Lo sentimos',

        text: 'Clave incorrecta',

      });

}



if(message == "success"){

    Swal.fire({

        icon: 'success',

        title: 'Hecho',

        text: 'Ponencia añadida',

      });

}



if(message == 'faltaPago'){

    Swal.fire({

        icon: 'warning',

        title: 'Lo sentimos',

        text: 'Completa el pago en su totalidad para poder confirmar su tipo de asistencia',

    });

}



if(message == 'successOyente'){

    Swal.fire({

        icon: 'success',

        title: 'Listo',

        text: 'Registramos su tipo de asistencia. Lo esperamos en el evento',

    });

}

*/



