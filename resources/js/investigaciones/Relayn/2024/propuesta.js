let preguntaActual = 0; // Para rastrear la pregunta actual
const respuestas = {}; // Variable global para almacenar las respuestas del usuario

function mostrarPregunta(pregunta) {
  const preguntaContainer = document.getElementById("preguntaContainer");
  preguntaContainer.innerHTML = ""; // Limpiar contenido anterior

  const preguntaDiv = document.createElement("div");
  preguntaDiv.classList.add("pregunta");

  const parte = document.createElement("h1");
  const texto = document.createTextNode(pregunta.parte);
  parte.appendChild(texto);

  preguntaDiv.appendChild(parte);

  const div = document.createElement('hr')
  preguntaDiv.appendChild(div)

  // Mostrar instrucciones si están establecidas
  if (pregunta.instrucciones && pregunta.instrucciones.trim() !== "") {
    const instruccionesParrafo = document.createElement("p");
    instruccionesParrafo.classList.add("instrucciones");
    instruccionesParrafo.textContent = pregunta.instrucciones;
    preguntaDiv.appendChild(instruccionesParrafo);
  }

  const label = document.createElement("label");
  label.textContent = pregunta.texto;

  let inputElement;

  if (pregunta.tipo === "texto") {
    inputElement = document.createElement("input");
    inputElement.type = "text";
    inputElement.value = respuestas[pregunta.id] || ""; // Establecer valor desde respuestas si existe
  } else if (pregunta.tipo === "numero") {
    inputElement = document.createElement("input");
    inputElement.type = "number";
    inputElement.value = respuestas[pregunta.id] || ""; // Establecer valor desde respuestas si existe
  } else if (pregunta.tipo === "opcion") {
    inputElement = document.createElement("select");
    const optionDefault = document.createElement("option");
    optionDefault.value = "";
    optionDefault.text = "Seleccione una opción";
    optionDefault.disabled = true; // Deshabilitar la opción
    optionDefault.selected = true; // Seleccionar la opción por defecto
    inputElement.appendChild(optionDefault);

    pregunta.opciones.forEach((opcion) => {
      const option = document.createElement("option");
      option.value = opcion.valor || opcion.texto; // Usar el valor como valor del option
      option.text = opcion.texto; // Usar el texto como contenido del option
      inputElement.appendChild(option);
    });

    inputElement.value = respuestas[pregunta.id] || ""; // Establecer valor desde respuestas si existe
  } else if (pregunta.tipo === "email") {
    inputElement = document.createElement("input");
    inputElement.type = "email";
    inputElement.value = respuestas[pregunta.id] || ""; // Establecer valor desde respuestas si existe
  }

  if (pregunta.requerida) {
    inputElement.required = true;
  }

  inputElement.id = pregunta.id;
  inputElement.classList.add("form-control");
  inputElement.addEventListener("change", function () {
    respuestas[pregunta.id] = inputElement.value; // Actualizar respuestas cuando cambie el valor
  });

  preguntaDiv.appendChild(label);
  preguntaDiv.appendChild(inputElement);
  preguntaContainer.appendChild(preguntaDiv);
}

// Función para avanzar a la siguiente pregunta
function siguientePregunta() {
  const inputActual = document.getElementById(
    jsonPreguntas.preguntas[preguntaActual].id
  );

  // Verificar si la respuesta a la pregunta actual es válida (en este caso, no está en blanco si es requerida)

  if (
    jsonPreguntas.preguntas[preguntaActual].requerida &&
    (inputActual.value.trim() === "" ||
      validarTipoDato(
        inputActual,
        jsonPreguntas.preguntas[preguntaActual].tipo
      ) === false)
  ) {
    alert("Por favor, responde la pregunta actual antes de continuar.");
  } else {
    preguntaActual++;
    if (preguntaActual < jsonPreguntas.preguntas.length) {
      mostrarPregunta(jsonPreguntas.preguntas[preguntaActual]);
      document.getElementById("regresarBtn").disabled = false; // Habilitar el botón de regresar
    } else {
      alert("Has completado el formulario.");
      // Puedes agregar más lógica aquí, como enviar las respuestas a un servidor.
    }
  }
}

// Función para regresar a la pregunta anterior
function preguntaAnterior() {
  if (preguntaActual > 0) {
    preguntaActual--;
    mostrarPregunta(jsonPreguntas.preguntas[preguntaActual]);
    document.getElementById("regresarBtn").disabled = preguntaActual === 0; // Deshabilitar si estamos en la primera pregunta
  }
}

document.addEventListener("DOMContentLoaded", function () {
  mostrarPregunta(jsonPreguntas.preguntas[preguntaActual]);

  const continuarBtn = document.getElementById("continuarBtn");
  const regresarBtn = document.getElementById("regresarBtn");

  continuarBtn.addEventListener("click", function () {
    // Puedes agregar validación de respuestas aquí si es necesario
    siguientePregunta();
  });

  regresarBtn.addEventListener("click", function () {
    preguntaAnterior();
  });
});

// Función genérica para validar el tipo de dato esperado
function validarTipoDato(inputElement, tipoDato) {
  const valor = inputElement.value.trim();

  switch (tipoDato) {
    case "texto":
      return true; // No se realiza validación específica para texto

    case "numero":
      // Validar si es un número
      return !isNaN(valor);

    case "email":
      // Validar si es una dirección de correo electrónico válida
      const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
      return emailRegex.test(valor);

    // Agregar más casos para otros tipos de datos si es necesario

    default:
      return true; // Si no se especifica un tipo de dato válido, no se realiza validación
  }
}
