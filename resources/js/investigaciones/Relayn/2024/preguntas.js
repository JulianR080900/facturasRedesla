// JSON con las preguntas
const jsonPreguntas = {
  preguntas: [
    {
      parte: "Datos del encuestador (a)",
      id: "pregunta1",
      texto:
        "Por favor seleccione el medio por el cuál se realizó la encuesta.",
      tipo: "opcion",
      opciones: [
        {
          valor: "personal",
          texto: "Mediante encuesta directa a la persona empresaria.",
        },
        { valor: "videollamada", texto: "Mediante encuesta por videollamada." },
        { valor: "telefono", texto: "Mediante encuesta por vía telefónica." },
        {
          valor: "enlace",
          texto:
            "Soy el Director (a) de la MYPE, me compartieron el enlace para responder.",
        },
      ],
      requerida: true,
    },
    {
      parte: "Datos del encuestador (a)",
      id: "pregunta2",
      instrucciones: `Por favor, preste cuidado en la captura de su nombre y correo electrónico, con estos datos se emitirá su constancia de encuestador (a).
      La persona encuestadora DEBE REGISTRAR SU CORREO ELECTRÓNICO PERSONAL, no está permitido utilizar el correo electrónico de otra persona
      encuestadora. Si captura erróneamente su nombre o correo electrónico ES IMPOSIBLE realizar cambios o modificaciones para la emisión de la constancia.`,
      texto: "Nombre completo del encuestador (a).",
      tipo: "texto",
      requerida: true,
    },
    {
      parte: "Datos del encuestador (a)",
      id: "pregunta3",
      texto: "Correo electrónico del encuestador (a).",
      tipo: "email",
      requerida: true,
    },
    {
      parte: "1ª PARTE: DATOS DE LA EMPRESA Y/O DIRECTOR (A)",
      id: "1",
      instrucciones: "1) Datos de la empresa y/o director (a)",
      texto: "1a) Nombre comercial de la empresa.",
      tipo: "texto",
      requerida: true,
    },
    {
      parte: "1ª PARTE: DATOS DE LA EMPRESA Y/O DIRECTOR (A)",
      id: "2",
      texto: "1b) Tipo de asociación que describe mejor a la empresa.",
      tipo: "opcion",
      opciones: [
        {
          texto: "Está constituida como empresa (S.A., S.R., etc.).",
        },
        {
          texto:
            "Empresa con una persona propietaria sin registro en la Secretaría de Hacienda.",
        },
        {
          texto:
            "Empresa con varias personas propietarias sin registro en la Secretaría de Hacienda.",
        },
        { texto: "Persona física con actividad empresarial." },
        { texto: "Régimen de incorporación fiscal." },
        { texto: "Servicios profesionales (registrado)." },
      ],
      requerida: true,
    },
  ],
};
