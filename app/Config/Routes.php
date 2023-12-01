<?php

namespace Config;

use CodeIgniter\Commands\Utilities\Routes;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('LoginController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();

# ==========LOGIN============
$routes->get('/', 'LoginController::index');
$routes->post('/login','LoginController::login');



/* $routes->group('/admin', static function ($routes) {

    $routes->get('descargar/(:any)/(:any)', 'AdminController::descargarArchivos/$1/$2');

    $routes->get('dashboard', 'AdminController::index');

    $routes->group('usuarios', static function ($routes) {
        $routes->get('lista', 'AdminController::usuarios');
        $routes->get('getListado', 'AdminController::getListadoUsuarios');
        $routes->get('editar/(:num)', 'AdminController::editUsuario/$1');
        $routes->post('update', 'AdminController::updateUsuario');
        $routes->post('eliminar', 'AdminController::eliminarUsuario');
    });

    $routes->group('cuerpos', static function ($routes) {
        $routes->get('lista', 'AdminController::cuerpos');
        $routes->get('getListado', 'AdminController::getListadoCuerpos');
        $routes->get('editar/(:num)', 'AdminController::editCuerpo/$1');
        $routes->post('update', 'AdminController::updateUsuario');
        $routes->post('eliminar', 'AdminController::deleteClaveCuerpo');
        $routes->get('mensajes', 'AdminController::mensajesCuerpos');
        $routes->get('verMensaje/(:any)/(:any)/(:num)', 'AdminController::verMensaje/$1/$2/$3');
        $routes->post('imageUpload', 'AdminController::imageUpload');
        $routes->post('guardarMensaje', 'AdminController::guardarMensaje');
        $routes->get('updateActivo/(:num)/(:any)', 'AdminController::updateActivo/$1/$2');
        $routes->get('cambioMiembros/(:any)', 'AdminController::cambioMiembros/$1');
        $routes->post('updateClaveCuerpo', 'AdminController::updateClaveCuerpo');
        $routes->post('addMunicipioCa', 'AdminController::addMunicipioCa');
        $routes->get('lider/(:num)/(:any)','AdminController::cambiar_lider/$1/$2');
        $routes->group('agregar',static function ($routes){
            $routes->post('verificar', 'AdminController::verificarCorreo');
            $routes->post('submit', 'AdminController::AddMiembro');
            $routes->get('(:any)','AdminController::formAgregar/$1');
        });
        $routes->group('descargas',static function ($routes){
            $routes->get('direcciones','AdminController::dirreccionesEnvioCuerpos');
        });
        

        $routes->group('orden_autores',static function ($routes){
            $routes->get('lista','AdminController::orden_autores');
            $routes->get('getListadoOrdenAutores','AdminController::getListadoOrdenAutores');
        });
    });

    $routes->group('entrevistas', static function ($routes){
        $routes->get('getDatosInvestigacionReleg2023', 'AdminController::getDatosInvestigacionReleg2023');
        $routes->get('lista', 'AdminController::equiposReleg');
        $routes->get('getListado', 'AdminController::listaEquiposReleg');
        $routes->get('ver/(:any)', 'AdminController::verEntrevistas/$1');
        $routes->get('getListadoEquipo/(:any)', 'AdminController::verEntrevistasEquipo/$1)');
        $routes->get('entrevista/(:num)', 'AdminController::entrevista/$1');
        $routes->get('bitacora/(:num)', 'AdminController::bitacora/$1');
        $routes->get('mensajeCorreoyAlert/(:any)/(:any)', 'AdminController::mensajeCorreoyAlert/$1/$2');
        $routes->post('enviarMensajeUpdate', 'AdminController::enviarMensajeUpdate');
        $routes->get('constancia_relmo/(:any)', 'AdminController::constancia_relmo/$1');
        $routes->get('validarEntrevista/(:num)/(:num)', 'AdminController::validarEntrevista/$1/$2');
        $routes->get('categorizacion/(:any)', 'AdminController::categorizacion/$1');
        $routes->get('getListaCategorizacion/(:any)', 'AdminController::getListaCategorizacion/$1');

        $routes->group('capitulo', static function ($routes) {
            $routes->group('digital', static function ($routes) {
                $routes->post('validar', 'AdminController::validarCapDigitalReleg2022');
                $routes->post('getWord', 'AdminController::getWordDigital2022');
                $routes->get('(:any)', 'AdminController::capituloRelegDigital/$1');
            });
            $routes->post('guardar', 'AdminController::guardarCapitulo');
            $routes->post('getWord', 'AdminController::getWordCapitulo');
            $routes->get('(:any)', 'AdminController::capituloReleg/$1');
        });
    });

    $routes->group('categorias', static function ($routes){

        $routes->group('digitales', static function ($routes){
            $routes->get('lista', 'AdminController::categoriasDigitales');
            $routes->get('getListadoCategorias', 'AdminController::getListadoCategoriasDigitales');
            $routes->post('actualizarGrupo', 'AdminController::actualizarGrupoLista');
            $routes->get('agregar', 'AdminController::agregarCategoriasDigitales');
            $routes->post('post', 'AdminController::submitAgregarCategoriaDigital');
            $routes->get('editar/(:num)', 'AdminController::editarCategoriaDigital/$1');
            $routes->post('actualizar', 'AdminController::actualizarCategoriaDigital');
            $routes->post('diagrama', 'AdminController::diagramaGrupos');
            $routes->group('dimensiones', static function ($routes){
                $routes->get('lista', 'AdminController::gruposDigital');
                $routes->get('getListadoDimensiones', 'AdminController::getListadoDimensiones');
                $routes->get('agregar', 'AdminController::agregarGrupoDigital');
                $routes->post('post', 'AdminController::submitGrupoDigital');
                $routes->get('editar/(:num)', 'AdminController::editarGrupo/$1');
                $routes->post('actualizar', 'AdminController::actualizarGrupo');
                $routes->post('eliminar', 'AdminController::eliminarDimension');
            });
        });

        $routes->get('lista','AdminController::categorias');
        $routes->get('getListadoCategorias', 'AdminController::getListadoCategorias');
        $routes->get('editar/(:num)', 'AdminController::editarCategoria/$1');
        $routes->post('update', 'AdminController::updateCategorias');
        $routes->get('mensajeValidacion/(:num)/(:num)', 'AdminController::mensajeValidacion/$1/$2');
        $routes->post('updateEstado', 'AdminController::updateEstadoCategorias');
        $routes->get('eliminar/(:num)', 'AdminController::eliminarCategoria/$1');
        $routes->post('actualizarGrupo', 'AdminController::actualizarGrupoListaNormal');
        $routes->post('escalas', 'AdminController::getEscalas');
        $routes->post('actualizarEscala', 'AdminController::actualizarEscala');

    });

    $routes->group('constancias', static function ($routes){
        $routes->get('agregar','AdminController::vistaConstancias');
        $routes->post('getCuerpos', 'AdminController::getCuerposConstancias');
        $routes->post('insert', 'AdminController::insertConstancias');
        $routes->post('previsualizar', 'AdminController::previsualizarConstancia');
    });

    $routes->group('libros', static function ($routes) {
        $routes->get('lista', 'AdminController::libros');
        $routes->get('getListadoLibros', 'AdminController::getListadoLibros');
        $routes->get('editar/(:num)', 'AdminController::editarLibro/$1');
        $routes->get('agregar','AdminController::agregarLibro');
        $routes->post('insert','AdminController::insertLibro');
        $routes->post('eliminar','AdminController::eliminarLibro');
        $routes->post('update', 'AdminController::updateLibro');

        $routes->group('indices', static function ($routes) {
            $routes->get('lista/(:num)', 'AdminController::indices/$1');
            $routes->get('getListadoIndices/(:num)', 'AdminController::getListadoIndices/$1');
            $routes->get('editar/(:num)', 'AdminController::editarIndice/$1');
            $routes->post('update', 'AdminController::updateIndice');
            $routes->post('eliminar', 'AdminController::eliminarIndice');
            $routes->post('agregar', 'AdminController::agregarIndice');
        });

        $routes->group('editoriales', static function($routes){
            $routes->get('lista', 'AdminController::editoriales');
            $routes->get('getListado', 'AdminController::getListadoEditorial');
            $routes->get('agregar', 'AdminController::agregarEditorial');
            $routes->post('insert', 'AdminController::insertEditorial');
            $routes->get('editar/(:num)', 'AdminController::editarEditorial/$1');
            $routes->post('update', 'AdminController::updateEditorial');
            $routes->post('eliminar', 'AdminController::eliminarEditorial');
        });

        $routes->get('carta', 'AdminController::carta');
        $routes->post('getCapitulos', 'AdminController::getCapitulos');
        $routes->post('getPDF', 'AdminController::getPDFCarta');
    });

    $routes->group('miembros', static function ($routes) {
        $routes->get('lista', 'AdminController::miembros');
        $routes->get('getListadoMiembros', 'AdminController::getListadoMiembros');
        $routes->get('editar/(:num)', 'AdminController::editMiembro/$1');
        $routes->post('updateMiembro', 'AdminController::updateMiembro');
        $routes->post('eliminar','AdminController::eliminarMiembro');
        $routes->post('eliminarAccesos','AdminController::eliminarAccesos');
        $routes->get('getExcelMiembros', 'AdminController::getExcelMiembros');
    });
    
    $routes->group('congresos', static function ($routes) {
        $routes->get('instrucciones', 'AdminController::instruccionesCongreso');
        $routes->get('verMensaje/(:any)/(:any)/(:num)', 'AdminController::verMensajeInstruccionesCongresos/$1/$2/$3');
        $routes->get('verMensaje/(:any)/(:any)/(:num)/(:any)', 'AdminController::verInstruccionesCongresos/$1/$2/$3/$4');
        $routes->post('guardarInstruccion', 'AdminController::guardarInstruccion');
    });

    $routes->group('proyectos', static function ($routes) {
        $routes->get('lista', 'AdminController::proyectosAdmin');
        $routes->get('getListadoproyectosAdmin','AdminController::getListadoproyectosAdmin');
        $routes->get('agregar','AdminController::agregarProyecto');
        $routes->post('insert','AdminController::insertProyecto');
        $routes->get('activar/(:num)', 'AdminController::activarProyecto/$1');
        $routes->get('editar/(:num)', 'AdminController::editarProyecto/$1');
        $routes->get('verInstrucciones/(:num)','AdminController::verInstruccionesProyecto/$1');
    });

    $routes->group('finanzas', static function ($routes) {
        $routes->group('proyectos', static function ($routes) {
            $routes->get('lista', 'AdminController::proyectos');
            $routes->get('getListadoProyectos', 'AdminController::getListadoProyectos');
            $routes->get('movimientos/(:num)', 'AdminController::movimientosProyecto/$1');
            $routes->get('getListadoMovimientosPago/(:num)', 'AdminController::getListadoMovimientosPago/$1');
            $routes->post('eliminarmultiple','AdminController::eliminarmultiple');
        });
        $routes->group('movimientos', static function ($routes) {
            $routes->get('lista', 'AdminController::movimientos');
            $routes->get('getListadoMovimientos', 'AdminController::getListadoMovimientos');
            $routes->get('validar/(:num)', 'AdminController::validarMovimiento/$1');
            $routes->get('rechazar/(:num)', 'AdminController::rechazarMovimiento/$1');
            $routes->post('eliminarMovimiento','AdminController::eliminarMovimiento');
            $routes->post('updateMov', 'AdminController::updateMov');
        });
        $routes->group('facturas', static function ($routes){
            $routes->get('lista', 'AdminController::facturas');
            $routes->get('getListadoFacturas','AdminController::getListadoFacturas');
            $routes->get('ver/(:num)','AdminController::verFactura/$1');
            $routes->post('rechazar', 'AdminController::rechazarFactura');
            $routes->post('aceptar', 'AdminController::aceptarFactura');
            $routes->post('eliminarFactura','AdminController::eliminarFactura');
            $routes->group('factura', static function ($routes){
                $routes->group('lista', 'AdminController::facturaApi');
            });
        });
        $routes->group('factura', static function ($routes){
            $routes->post('getProductos', 'facturaApiController::getProductos');
            $routes->post('getImpuestos', 'facturaApiController::getImpuestos');
            $routes->post('getUsosCFDI', 'facturaApiController::getUsosCFDI');
            $routes->post('getSeries', 'facturaApiController::getSeries');
            $routes->post('getFormaPago', 'facturaApiController::getFormaPago');
            $routes->post('getMetodoPago', 'facturaApiController::getMetodoPago');
            $routes->post('getMoneda', 'facturaApiController::getMoneda');
            $routes->post('getPaises', 'facturaApiController::getPaises');
            $routes->post('getUID', 'facturaApiController::getUID');
            $routes->post('generateClient', 'facturaApiController::generateClient');
            $routes->post('verificarCSF', 'facturaApiController::verificarCSF');
            $routes->get('getEmpresas', 'facturaApiController::getEmpresas');

            $routes->post('emitirFactura', 'facturaApiController::emitirFactura');
            $routes->post('getArchivos', 'facturaApiController::getArchivos');

            $routes->group('cfdi40', static function ($routes){
                $routes->get('lista', 'facturaApiController::cfdi40lista');
                $routes->post('getListadoCFDI40', 'facturaApiController::getListadoCFDI40');
            });
        });
    });

    $routes->group('investigaciones', static function ($routes) {
        $routes->group('equipos', static function ($routes) {
            $routes->get('getListaInvestigacionesEquipos/(:any)', 'AdminController::getListaInvestigacionesEquipos/$1');
            $routes->get('getExcelEquipos/(:any)', 'AdminController::getExcelEquipos/$1');
            $routes->get('getExcelEncuestas/(:any)', 'AdminController::getExcelEncuestas/$1');
            $routes->get('(:any)/(:num)', 'AdminController::investigacionesEquipos/$1/$2');
        });

        $routes->group('verEquipo', static function ($routes) {
            $routes->get('getListaInvestigacionesEquipo/(:any)/(:any)', 'AdminController::getListaInvestigacionesEquipo/$1/$2');
            $routes->get('getExcelEncuestasEquipo/(:any)/(:any)', 'AdminController::getExcelEncuestasEquipo/$1/$2');
            $routes->get('getExcelEncuestasEquipoValidos/(:any)/(:any)', 'AdminController::getExcelEncuestasEquipoValidos/$1/$2');
            $routes->get('verCuestionario/(:num)/(:any)', 'AdminController::verCuestionarioAdmin/$1/$2');
            $routes->get('chartGiro/(:any)/(:any)', 'AdminController::chartGiroEquipo/$1/$2');
            $routes->post('validar', 'AdminController::validarInvestigacion');
            $routes->get('(:any)/(:any)', 'AdminController::verEquipoInvestigacion/$1/$2');
        });

        $routes->group('(:any)/(:num)', static function ($routes) {
            $routes->get('inicio', 'InvestigacionesController::listaAdmin/$1/$2'); //RED ANIO
            $routes->post('getListaInvestigacionesEquipos', 'InvestigacionesController::getListaInvestigacionesEquipos');
            $routes->get('getExcelEncuestasEquipo/(:any)/(:any)', 'InvestigacionesController::getExcelEncuestasEquipo/$3/$4');
            $routes->get('getExcelEncuestasEquipoValidas/(:any)/(:any)', 'InvestigacionesController::getExcelEncuestasEquipoValidas/$3/$4');
            $routes->post('updatePhase', 'InvestigacionesController::updatePhaseAdmin');

            $routes->group('descargas', static function ($routes) {
                $routes->get('equipos/(:any)', 'InvestigacionesController::getExcelEquipos/$3');
                $routes->get('encuestas/(:any)', 'InvestigacionesController::getExcelEncuestas/$3');
                $routes->get('encuestasValidas/(:any)', 'InvestigacionesController::getExcelEncuestasValidas/$3');
                $routes->get('orden_autores', 'InvestigacionesController::excelOrdenAutores/$1/$2');
                $routes->get('encuestasEquipo/(:any)/(:any)', 'InvestigacionesController::getExcelEncuestasEquipo/$3/$4');
                $routes->get('encuestasEquipoValidos/(:any)/(:any)', 'InvestigacionesController::getExcelEncuestasEquipoValidas/$3/$4');
                $routes->get('archivos', 'InvestigacionesController::descargarTodoArhivos/$1/$2');
                $routes->get('bd2/(:any)','InvestigacionesController::bd2/$1/$2/$3');
            });
            $routes->group('ver', static function ($routes) {
                $routes->get('carta/(:any)/(:any)/(:any)', 'InvestigacionesController::verCartaAdmin/$1/$2/$3/$4/$5');//red anio claveCuerpo tipo
            });
            $routes->group('subir', static function ($routes) {
                $routes->post('preliminar/(:any)', 'InvestigacionesController::subirPreliminar/$1/$2/$3');
                $routes->post('final/(:any)', 'InvestigacionesController::subirFinal/$1/$2/$3');
                $routes->post('agradecimientos/(:any)', 'InvestigacionesController::subirAgradecimientos/$1/$2/$3');
            });

            $routes->group('revision', static function ($routes) {
                $routes->get('(:any)/(:any)', 'InvestigacionesController::revisionAdmin/$1/$2/$3/$4');
            });
        });

        $routes->group('cartas', static function ($routes) {
            $routes->get('inicio', 'InvestigacionesController::cartasInicio');
            $routes->post('getListaCartas', 'InvestigacionesController::getListaCartas');
            $routes->post('subir', 'InvestigacionesController::subirCartas');
            $routes->get('downloadDerechos/(:any)/(:any)/(:any)/(:any)','InvestigacionesController::downloadDerechos/$1/$2/$3/$4'); #red/anio/obra/tipo
        });

        $routes->group('marcajes', static function ($routes) {
            $routes->get('inicio', 'InvestigacionesController::marcajesInicio');
            $routes->post('getListaMarcajes', 'InvestigacionesController::getListaMarcajes');
            $routes->get('ver/(:num)', 'InvestigacionesController::verMarcaje/$1');
            $routes->post('updateMarcaje', 'InvestigacionesController::updateMarcaje');
        });

        
    });

    $routes->group('dictamen', static function ($routes) {
        $routes->group('libro_congreso', static function ($routes) {
            $routes->get('lista', 'AdminController::libro_congreso_dictamen');
            $routes->get('getListadoCartasLibroCongreso', 'AdminController::getListadoCartasLibroCongreso');
            $routes->get('editar/(:num)', 'AdminController::editDictamenCongreso/$1');
            $routes->get('agregar', 'AdminController::agregarCartaDictamenCongreso');
            $routes->post('getPDF', 'AdminController::getPdfCartaDictamenCongreso');
            $routes->post('insert', 'AdminController::insertCartaDictamenCongreso');
            $routes->post('eliminar', 'AdminController::eliminarCartaDictamenCongreso');
            $routes->get('descargar/(:num)', 'AdminController::descargarPdfCartaDictamenCongreso/$1');
        });
        $routes->post('getInfoIquatro', 'AdminController::getInfoIquatro');
    });

    $routes->group('charts', static function ($routes) {
        $routes->group('individual', static function ($routes) {
            $routes->get('ingresos_gastos/(:any)/(:any)', 'ChartsController::ingresos_gastos/$1/$2');
            $routes->get('insumos/(:any)/(:any)', 'ChartsController::insumos/$1/$2');
        });
        $routes->group('general', static function ($routes) {

        });
    });

    $routes->group('cursos', static function ($routes) {
        $routes->post('getListado/(:num)', 'AdminController::getListadoCursos/$1');
        
        $routes->post('pago', 'AdminController::pagoCurso');
        $routes->get('getCSVMoodle/(:num)/(:any)', 'AdminController::getCSVMoodle/$1/$2');
        $routes->post('addConstancias/(:num)', 'AdminController::addConstancias/$1');
        $routes->post('correo_dc3/(:num)', 'AdminController::correo_dc3/$1');
        $routes->get('dc3/(:num)', 'AdminController::dc3/$1');
        $routes->get('reenviar_correo_inscripcion/(:num)', 'AdminController::reenviar_correo_inscripcion/$1');
        $routes->get('(:any)/lista', 'AdminController::cursos/$1');
    });

    $routes->group('carpetas', static function ($routes) {
        $routes->get('lista', 'AdminController::carpetas');
        $routes->get('getListadoCarpetas','AdminController::getListadoCarpetas');
        $routes->get('editar/(:num)', 'AdminController::editarCarpetas/$1');
    });

    $routes->group('congresos', static function ($routes) {

        $routes->get('lista','CongresosController::congresos_info');
        $routes->get('getlistacongresosinfo','CongresosController::getlistacongresosinfo');
        $routes->get('editar/(:num)', 'CongresosController::editarCongreso/$1');
        $routes->get('activo/(:num)/(:any)', 'CongresosController::activo/$1/$2');
        $routes->get('agregarcongreso','CongresosController::agregarcongreso');
        $routes->post('insert','CongresosController::insertCongreso');
        $routes->get('ver/(:num)', 'CongresosController::verDesgloseCongreso/$1');
        $routes->get('constancias/(:any)/(:num)', 'CongresosController::descargarConstanciasAdmin/$1/$2');

        #$routes->get('generarUsuarios','CongresosController::generarUsuarios');
        $routes->get('getSubmissionIds','CongresosController::getSubmissionIds');

        $routes->group('cartas', static function ($routes) {
            $routes->get('lista', 'CongresosController::cartas_aceptacion');
            $routes->get('getListado', 'CongresosController::getListadoCartas');
            $routes->post('enviar', 'CongresosController::enviarCartas');
            $routes->post('cancelar', 'CongresosController::cancelarCarta');
            #$routes->post('enviar', 'CongresosController::enviarCartas');
        });

        $routes->group('asistencia',static function ($routes){
            $routes->get('inicio','CongresosController::asistencia');
            $routes->post('getInfoGafete','CongresosController::getInfoGafete');
            $routes->post('updateKit', 'CongresosController::updateKit');
        });
        
        $routes->group('moderadores',static function ($routes){
            $routes->get('lista','CongresosController::moderador');
            $routes->get('getlistadomoderador','CongresosController::getlistadomoderador');
            $routes->get('editar/(:num)','CongresosController::editarmoderador/$1');
            $routes->post('update', 'CongresosController::updatemoderador');
            $routes->get('agregar','CongresosController::agregarmoderador');
            $routes->post('insert','CongresosController::insertmoderador');
            $routes->post('eliminar', 'CongresosController::eliminarmoderador');
        });

        $routes->group('mesas',static function ($routes){
            $routes->get('lista','CongresosController::mesas');
            $routes->get('getlistamesas','CongresosController::getlistamesas');
            $routes->get('editar/(:num)','CongresosController::editarmesas/$1');
            $routes->post('update', 'CongresosController::updatemesas');      
            $routes->get('agregar','CongresosController::agregarmesas');
            $routes->post('insert','CongresosController::insertmesas');
            $routes->post('eliminar', 'CongresosController::eliminarmesa');
        });

        $routes->group('enlaces',static function ($routes){
            $routes->get('lista','CongresosController::enlaces');
            $routes->get('getlistaenlaces','CongresosController::getlistaenlaces');
            $routes->get('agregar','CongresosController::agregaenlace');
            $routes->post('insert','CongresosController::insertenlace');
            $routes->post('eliminar', 'CongresosController::eliminarenlace');
            $routes->get('editar/(:num)','CongresosController::editarenlace/$1');
            $routes->post('update', 'CongresosController::updateenlace');

        }); 

        $routes->group('horarios',static function ($routes){
            $routes->get('lista', 'CongresosController::horarios');
            $routes->get('getListado', 'CongresosController::getListadoHorarios');
            $routes->post('updateAspectos', 'CongresosController::updateAspectos');
            $routes->post('insert', 'CongresosController::insertHorario');
            $routes->get('ver/(:num)', 'CongresosController::verHorario/$1');
            $routes->post('act_datos_congreso', 'CongresosController::act_datos_congreso');
            $routes->get('previsualizacion/(:num)', 'CongresosController::previsualizacionHorarioCongresoView/$1');

            $routes->group('moderadores', static function($routes){
                $routes->get('lista', 'CongresosController::horariosModeradores');
            });

            $routes->group('enlaces', static function($routes){
                $routes->get('lista', 'CongresosController::horariosEnlaces');
                $routes->post('constancias_ponentes', 'CongresosController::constancias_ponentes');
                $routes->get('instrucciones', 'CongresosController::instruccionesEnlaces');
            });

        });

        $routes->group('ponencias', static function ($routes) {
            $routes->get('lista', 'CongresosController::ponencias');
            $routes->get('getListado', 'CongresosController::getListadoPonencias');
            $routes->post('update', 'CongresosController::updateMesa');
        });

        $routes->group('participantes', static function ($routes) {
            $routes->get('lista', 'CongresosController::participantes');
            $routes->get('getListado', 'CongresosController::getListadoParticipantes');
            $routes->post('update', 'CongresosController::updateMesa');
        });

        $routes->group('ganadores', static function ($routes) {
            $routes->get('lista/(:any)/(:num)', 'CongresosController::ganadores/$1/$2'); #red/anio
            $routes->post('submit', 'CongresosController::updateGanadores'); #red/anio
        });


        
    });

    $routes->group('capitulos',static function ($routes){
        $routes->group('impresos', static function($routes){
            $routes->get('lista','AdminController::descarga_releg');
            $routes->get('getlistadescarga','AdminController::getlistadescarga');
            $routes->get('descargar','AdminController::descargar');
        });
        $routes->group('digitales', static function($routes){
            $routes->get('lista','AdminController::descarga_digital_releg');
            $routes->get('getlistadescargaDigitales','AdminController::getlistadescargaDigitales');
            $routes->get('descargar','AdminController::descargarDigital');
            $routes->get('generar','AdminController::generarCapitulosDigitalesReleg2023');
        });
    });

    #$routes->get('insertConstanciasAsistencia', 'AdminController::insertConstanciasAsistencia');

    


    
    $routes->post('generalUpdateAdmin/(:any)', 'AdminController::generalUpdate/$1');
    $routes->get('visualizadorMails/(:any)', 'AdminController::visualizadorMails/$1');
    $routes->get('visualizadorComprobantes/(:any)', 'AdminController::visualizadorComprobantes/$1');
    $routes->get('visualizadorCSF/(:any)', 'AdminController::visualizadorCSF/$1');
}); */

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
