$("#botones_redes,button.botones_maestros").on("click", function(event){
    $("#c_miembros").hide();
    c_maestros = event.target.id;
    funct_concat = '';
    validaciones = '';
    validaciones_concat = '';
    for(x = 1; x <= c_maestros; x++){
      if(x == 1){
        $("#card_maestros").append('<div class="form-row"><h3>Miembro'+x+' (Líder)</h3></div><div id="registro'+x+'" ><div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="nombre'+x+'">Nombre(s) *</label><input type="text" class="form-control" id="nombre'+x+'" name="nombre'+x+'" placeholder="Nombre(s)"><div class="invalid-feedback">Ingresa tu nombre(s).</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="appat1">Apellido Paterno *</label><input type="text" class="form-control" id="appat'+x+'" name="appat'+x+'" placeholder="Apellido Paterno"><div class="invalid-feedback">Ingresa tu apellido paterno.</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="apmat1">Apellido Materno *</label><input type="text" class="form-control" id="apmat'+x+'" name="apmat'+x+'" placeholder="Apellido Materno"><div class="invalid-feedback">Ingresa tu apellido materno.</div></div></div><div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="grado'+x+'">Grado académico *</label><select class="form-control" name="grado'+x+'" id="grado'+x+'"><option value="0">Grado académico...</option><option value="1">Licenciatura</option><option value="2">Ingeniería</option><option value="3">Maestría</option><option value="4">Doctorado</option></select></div><div class="col-xl-5 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="especialidad'+x+'">Especialidad *</label><input type="text" class="form-control" id="especialidad'+x+'" name="especialidad'+x+'" placeholder="Especialidad"><div class="invalid-feedback">Ingresa tu especialidad.</div></div><div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="validationCustom'+x+'">SNI</label><div class="form-row"><label class="custom-control custom-radio custom-control-inline"><input type="radio" name="radio_'+x+'" id="radio_'+x+'" value="no" checked="" class="custom-control-input" onclick="toggle'+x+'(this)"><span class="custom-control-label">No</span></label><label class="custom-control custom-radio custom-control-inline"><input type="radio" name="radio_'+x+'" id="radio_'+x+'" value="si" class="custom-control-input" onclick="toggle'+x+'(this)"><span class="custom-control-label">Si</span></label></div></div></div><div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2" id="divnivSNI'+x+'" style="display:none;"><label for="nivelSNI'+x+'">Nivel de SNI</label><select class="form-control" name="nivelSNI'+x+'" id="nivelSNI'+x+'" required><option selected="true" disabled value="0">Nivel de SNI...</option><option value="1">Candidato a Investigador Nacional</option><option value="2">Investigador Nacional Nivel I</option><option value="3">Investigador Nacional Nivel II</option><option value="4">Investigador Nacional Nivel III</option><option value="5">Investigador Nacional Emérito</option></select><div class="invalid-feedback">Nivel de SNI.</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2" id="divanoSNI'+x+'" style="display:none;"><label for="anoSNI'+x+'">Año de SNI</label><input type="text" class="form-control" id="anoSNI'+x+'" name="anoSNI'+x+'" placeholder="Año SNI"></div></div><div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="telefono'+x+'">Teléfono *</label><input type="text" class="form-control" id="telefono'+x+'" name="telefono'+x+'" placeholder="Teléfono"><div class="invalid-feedback">Ingresa tu teléfono.</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="correop'+x+'">Correo personal *</label><input type="email" class="form-control" id="correop'+x+'" name="correop'+x+'" placeholder="Correo personal"><div class="invalid-feedback">Ingresa un correo personal.</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="correoi'+x+'">Correo institucional *</label><input type="email" class="form-control" id="correoi'+x+'" name="correoi'+x+'" placeholder="Correo institucional"><div class="invalid-feedback">Ingresa un correo institucional.</div></div></div><hr></div>');
        $("#card_maestros").append('<input type="text" class="form-control" placeholder="Validar correo" id="validacioncorreo'+x+'"><br><button type="button" class="btn btn-light btn-block" id="validacion'+x+'">Validad correo</button><hr>');
        $("#registro"+x).hide();
      }else{
        $("#card_maestros").append('<div class="form-row"><h3>Miembro'+x+'</h3></div><div id="registro'+x+'" ><div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="nombre'+x+'">Nombre(s) *</label><input type="text" class="form-control" id="nombre'+x+'" name="nombre'+x+'" placeholder="Nombre(s)"><div class="invalid-feedback">Ingresa tu nombre(s).</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="appat1">Apellido Paterno *</label><input type="text" class="form-control" id="appat'+x+'" name="appat'+x+'" placeholder="Apellido Paterno"><div class="invalid-feedback">Ingresa tu apellido paterno.</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="apmat1">Apellido Materno *</label><input type="text" class="form-control" id="apmat'+x+'" name="apmat'+x+'" placeholder="Apellido Materno"><div class="invalid-feedback">Ingresa tu apellido materno.</div></div></div><div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="grado'+x+'">Grado académico *</label><select class="form-control" name="grado'+x+'" id="grado'+x+'"><option value="0" selected="true" disabled>Grado académico...</option><option value="1">Licenciatura</option><option value="2">Ingeniería</option><option value="3">Maestría</option><option value="4">Doctorado</option></select></div><div class="col-xl-5 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="especialidad'+x+'">Especialidad *</label><input type="text" class="form-control" id="especialidad'+x+'" name="especialidad'+x+'" placeholder="Especialidad"><div class="invalid-feedback">Ingresa tu especialidad.</div></div><div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="validationCustom'+x+'">SNI</label><div class="form-row"><label class="custom-control custom-radio custom-control-inline"><input type="radio" name="radio_'+x+'" id="radio_'+x+'" value="no" checked="" class="custom-control-input" onclick="toggle'+x+'(this)"><span class="custom-control-label">No</span></label><label class="custom-control custom-radio custom-control-inline"><input type="radio" name="radio_'+x+'" id="radio_'+x+'" value="si" class="custom-control-input" onclick="toggle'+x+'(this)"><span class="custom-control-label">Si</span></label></div></div></div><div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2" id="divnivSNI'+x+'" style="display:none;"><label for="nivelSNI'+x+'">Nivel de SNI</label><select class="form-control" name="nivelSNI'+x+'" id="nivelSNI'+x+'" required><option selected="true" disabled value="0">Nivel de SNI...</option><option value="1">Candidato a Investigador Nacional</option><option value="2">Investigador Nacional Nivel I</option><option value="3">Investigador Nacional Nivel II</option><option value="4">Investigador Nacional Nivel III</option><option value="5">Investigador Nacional Emérito</option></select><div class="invalid-feedback">Nivel de SNI.</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2" id="divanoSNI'+x+'" style="display:none;"><label for="anoSNI'+x+'">Año de SNI</label><input type="text" class="form-control" id="anoSNI'+x+'" name="anoSNI'+x+'" placeholder="Año SNI"></div></div><div class="form-row"><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="telefono'+x+'">Teléfono *</label><input type="text" class="form-control" id="telefono'+x+'" name="telefono'+x+'" placeholder="Teléfono"><div class="invalid-feedback">Ingresa tu teléfono.</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="correop'+x+'">Correo personal *</label><input type="email" class="form-control" id="correop'+x+'" name="correop'+x+'" placeholder="Correo personal"><div class="invalid-feedback">Ingresa un correo personal.</div></div><div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 mb-2"><label for="correoi'+x+'">Correo institucional *</label><input type="email" class="form-control" id="correoi'+x+'" name="correoi'+x+'" placeholder="Correo institucional"><div class="invalid-feedback">Ingresa un correo institucional.</div></div></div><hr></div>');
        $("#card_maestros").append('<input type="text" class="form-control" placeholder="Validar correo" id="validacioncorreo'+x+'"><br><button type="button" class="btn btn-light btn-block" id="validacion'+x+'">Validad correo</button><hr>');
        $("#registro"+x).hide();
      }
      funciones = 'function toggle'+x+'(elemento) {if(elemento.value=="si") {document.getElementById("divnivSNI'+x+'").style.display = "";document.getElementById("divanoSNI'+x+'").style.display = "";}else{document.getElementById("divnivSNI'+x+'").style.display = "none";document.getElementById("divanoSNI'+x+'").style.display = "none";}}';
      funct_concat = funct_concat + funciones;
      $("#validacioncorreo"+x).on('keypress',function(event){  /*correos*/
        key = event.keyCode || event.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = "abcdefghijklmnñopqrstuvwxyz1234567890@_.-";
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
      $("#nombre"+x+",#appat"+x+",#apmat"+x+",#especialidad"+x).on('keypress',function(event){ /*Nombres con acentos*/
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
      $("#telefono"+x+",#anoSNI"+x).on('keypress',function(event){  /*Solamente numeros*/
        key = event.keyCode || event.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = "1234567890";
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
      validaciones = "$('#validacion"+x+"').on('click', function(){"+
        "correo_de_validacion = $('#validacioncorreo"+x+"').val();"+
        "correo = validarEmail(correo_de_validacion);"+
        "if(correo == true){"+
        '$.ajax({'+
          'type: "POST",'+
          "url: base_url + 'check_email_registro',"+
          'data: {'+
              '"correo" :' + "correo_de_validacion"+
          "},"+
          "dataType : 'json',"+
          "success: function (data) {  "+
              "alert("+x+"); "+
              "if(data['nombre'] != null){"+
              "alert('entra');"+
              "$('#validacion"+x+"').hide(); $('#validacioncorreo"+x+"').hide(); "+
              "$('#registro"+x+"').show();"+
              "$('#nombre"+x+"').val(data['nombre']).prop('disabled', true);"+
              "$('#appat"+x+"').val(data['apaterno']).prop('disabled', true);"+
              "$('#apmat"+x+"').val(data['amaterno']).prop('disabled', true);"+ 
              "$('#especialidad"+x+"').val(data['especialidad']).prop('disabled', true);"+
              "$('#telefono"+x+"').val(data['telefono']).prop('disabled', true);"+
              "$('#correop"+x+"').val(data['correo']).prop('disabled', true);"+
              "$('#correoi"+x+"').val(data['correo_institucional']).prop('disabled', true);"+ 
              "$('#grado"+x+"').val(data['grado_academico']).prop('disabled', true);"+
              "if(data['nivelSNI'] == ''){ $('input[name=radio_"+x+"][value=no]').prop('checked',true).prop('disabled',true); $('input[name=radio_"+x+"][value=si]').prop('disabled',true); }"+
              "else if(data['nivelSNI'] != ''){ $('input[name=radio_"+x+"][value=si]').prop('checked',true).prop('disabled',true); $('input[name=radio_"+x+"][value=no]').prop('disabled',true); $('#nivelSNI"+x+"').val(data['nivelSNI']).prop('disabled', true); $('#anoSNI"+x+"').val(data['anoSNI']).prop('disabled', true); }"+
              "console.log(data);"+
              "}"+
              "else if(data['nombre'] == null){"+
              "$('#validacion"+x+"').hide(); $('#validacioncorreo"+x+"').hide(); "+
              "$('#registro"+x+"').show();"+
              "$('#correop"+x+"').val(correo_de_validacion).prop('disabled', true);"+
              "}"+
          "}"+
      "});"+
      "}else{"+
        "Swal.fire({"+
        "icon: 'error',"+
        "title: 'Oops...',"+
        "text: 'Ingrese un correo electronico válido',"+
    "});"+
      "}"+
        "});";
      validaciones_concat = validaciones_concat + validaciones;
    }
    $("#funciones").append(funct_concat);
    $("#validacionesdecorreos").append(validaciones_concat);
    $("#card_maestros").append('<button type="button" id="maestros" class="btn btn-primary btn-block">Siguiente</button>')
    $("#form_maestros").fadeIn();
    $("#maestros").on("click",function(){
        correcto = 0;
        for(q = 1; q <= c_maestros; q++){
          nombre = $("#nombre"+q).val().trim();
          appat = $("#appat"+q).val().trim();
          apmat = $("#apmat"+q).val().trim();
          cbx_ga = $("#grado"+q+" option:selected").val().trim(); //no debe ser 0, si es 1 debe llenar el input de otro grado academico
          especialidad = $("#especialidad"+q).val().trim();
          sni = $("input[name='radio_"+q+"']").prop("checked"); //false = si true = no jajaja perdon por eso pero funciona 
          telefono = $("#telefono"+q).val().trim();
          correop = $("#correop"+q).val().trim();
          correoi = $("#correoi"+q).val().trim();

          if(nombre == "" || appat == "" || apmat == "" || cbx_ga == 0 || especialidad == "" || telefono == "" || correop == "" || correoi == ""){
            alert("llena");
          }else{
            if(sni === false){
              nivelSNI = $("#nivelSNI"+q+" option:selected").val(); //no debe ser 0
              anoSNI = $("#anoSNI"+q).val().trim();
              if(nivelSNI == 0 || anoSNI == ""){
                alert("llenaSNI");
                if(correcto > 1){
                  correcto--;
                }
              }else{
                correcto++;
              }
            }else{
              correcto++;
            }
          }
        }
        check_institucional = 0;
        if(correcto == c_maestros){
          for(var t = 1; t <= c_maestros; t++){ //2 debe dar 4
            nombre = $("#nombre"+t).val().trim();
            appat = $("#appat"+t).val().trim();
            apmat = $("#apmat"+t).val().trim();
            cbx_ga = $("#grado"+t+" option:selected").val().trim(); //no debe ser 0, si es 1 debe llenar el input de otro grado academico
            especialidad = $("#especialidad"+t).val().trim();
            sni = $("input[name='radio_"+t+"']").prop("checked"); //false = si true = no jajaja perdon por eso pero funciona 
            telefono = $("#telefono"+t).val().trim();
            correop = $("#correop"+t).val().trim();
            correoi = $("#correoi"+t).val().trim();
            validacion_correo = validarEmail(correoi);
            if(validacion_correo == false){
              check_institucional++;
            }else{
              nivelSNI = $("#nivelSNI"+t+" option:selected").val(); //no debe ser 0
              anoSNI = $("#anoSNI"+t).val().trim();
              if(t == 1){
                if(sni === false){
                  a_maestros.push([nombre,
                    appat,
                    apmat,
                    cbx_ga,
                    especialidad,
                    sni,
                    telefono,
                    correop,
                    correoi,
                    nivelSNI,
                    anoSNI,
                    'maestro',
                    '1',
                    red]);
                }else{
                  a_maestros.push([nombre,
                    appat,
                    apmat,
                    cbx_ga,
                    especialidad,
                    sni,
                    telefono,
                    correop,
                    correoi,
                    '',
                    '',
                    'maestro',
                    '1',
                  red]);
                }
              }else{
                if(sni === false){
                  a_maestros.push([nombre,
                    appat,
                    apmat,
                    cbx_ga,
                    especialidad,
                    sni,
                    telefono,
                    correop,
                    correoi,
                    nivelSNI,
                    anoSNI,
                    'maestro',
                    '0',
                    red]);
                }else{
                  a_maestros.push([nombre,
                    appat,
                    apmat,
                    cbx_ga,
                    especialidad,
                    sni,
                    telefono,
                    correop,
                    correoi,
                    '',
                    '',
                    'maestro',
                    '0',
                    red]);
                }
              }
              
            }
            }
            
            if(check_institucional != 0){
              alert("algunos de los correos no es un correo");
              check_institucional = 0;
              a_maestros = [];
            }else{
              $.ajax({
                type: "POST",
                url: base_url + 'insert_registro',
                data: {
                    'a_institucion': a_institucion,
                    'a_maestros': a_maestros
                },success: function (data) {  
                    console.log(JSON.stringify(data));
                    a_maestros = [];
                }
            });
            }
        }
      });
  });