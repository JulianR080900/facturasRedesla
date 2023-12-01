<?php
namespace App\Models;
use CodeIgniter\Model;
use Exception;

class AdminModel extends Model{

    public function getAll($tabla,$condiciones){
        $db = \Config\Database::connect('default');
        $builder = $db->table($tabla);
        $builder->select('*');
        $builder->where($condiciones);
        return $builder->get()->getResultArray();
    }

    public function getAllOneRow($tabla,$condiciones){
        $db = \Config\Database::connect('default');
        $builder = $db->table($tabla);
        $builder->select('*');
        $builder->where($condiciones);
        return $builder->get()->getRowArray();
    }

    public function datos_universidad($ca){
        #ME DESESPERE AL TRATAR DE USAR FROMSUBQUERY XD
        $db = \Config\Database::connect('default');

        $builder = $db->table('cuerpos_academicos')
                      ->select("nombre,(SELECT nombre FROM municipios where id = municipio) as municipio, 
                      (SELECT nombre FROM estados where id = estado) as estado, 
                      (SELECT nombre FROM pais where id = pais) as pais")
                      ->where('claveCuerpo',$ca);

        return $builder->get()->getRowArray();
    }

    public function generalUpdate($tabla,$data,$condiciones){
        
        $db = \Config\Database::connect('default');

        $builder = $db->table($tabla)
                      ->set($data)
                      ->where($condiciones);
        if($builder->update()){
            return true;
        }
        return false;

    }

    public function miembros_actuales($ca){

        $db = \Config\Database::connect('default');

        $builder = $db->table('miembros');

        $builder->select("CONCAT(nombre, ' ',apaterno,' ',amaterno) as nombreCompleto");

        $builder->select("id, lider, telefono, especialidad,orden_impreso, orden_digital");

        $builder->select("(SELECT correo FROM usuarios WHERE usuarios.usuario = miembros.usuario) as correo");

        $builder->select("(SELECT correo_institucional FROM usuarios WHERE usuarios.usuario = miembros.usuario) as correo_institucional");

        $builder->select("(SELECT profile_pic FROM usuarios WHERE usuarios.usuario = miembros.usuario) as img_user");

        $builder->select("(SELECT tipo FROM usuarios WHERE usuarios.usuario = miembros.usuario) as tipo");

        $builder->select("(SELECT nombre FROM grado_academico WHERE grado_academico.id = miembros.grado) as grado_academico");

        $builder->where("cuerpoAcademico",$ca);

        return $builder->get()->getResultArray();

    }

    public function getColumnsOneRow($columnas,$tabla,$condiciones){

        $db = \Config\Database::connect('default');

        $builder = $db->table($tabla)
                        ->select($columnas)
                        ->where($condiciones);

        return $builder->get()->getRowArray();

    }

    public function exist($tabla, $condiciones){

        $db = \Config\Database::connect('default');

        $builder = $db->table($tabla)
                        ->select('id')
                        ->where($condiciones);

        if ($builder->countAllResults() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function generalInsert($tabla,$data){

        $db = \Config\Database::connect('default');

        $builder = $db->table($tabla);

        if($builder->insert($data)){
            return true;
        }else{
            return false;
        }

    }

    public function generalInsertLastId($data,$tabla){
        $db = \Config\Database::connect('default');

        $builder = $db->table($tabla);

        if($builder->insert($data)){
            return $db->insertID();
        }else{
            return false;
        }
    }

    public function getColumnsOrderBy($columnas,$tabla,$condiciones,$order){

        $db = \Config\Database::connect('default');

        $builder = $db->table($tabla)
                        ->select($columnas)
                        ->where($condiciones)
                        ->orderBy($order);

        return $builder->get()->getResultArray();

    }

    public function generalDelete($tabla,$condiciones){
        $db = \Config\Database::connect('default');

        try{
            $db->table($tabla)
            ->where($condiciones)
            ->delete();
            return true;
        }catch(Exception){
            return false;
        }
    }

    public function getAllDistinc($columnas,$tabla,$condiciones){
        $db = \Config\Database::connect('default');
        $builder = $db->table($tabla);
        $builder->distinct();
        $builder->select($columnas);
        $builder->where($condiciones);
        return $builder->get()->getResultArray();
    }

    public function getAllColums($columnas,$tabla,$condiciones){

        $db = \Config\Database::connect('default');

        $builder = $db->table($tabla)
                        ->select($columnas)
                        ->where($condiciones);

        return $builder->get()->getResultArray();

    }

    public function count($tabla,$condiciones){
        $db = \Config\Database::connect('default');
        $builder = $db->table($tabla)
                   ->where($condiciones);
        return $builder->countAllResults();
    }

    public function countWithLike($tabla,$condiciones,$like){
        $db = \Config\Database::connect('default');
        $builder = $db->table($tabla)
                   ->where($condiciones)
                   ->like($like);
        return $builder->countAllResults();
    }

    public function generalInsertBatch($tabla, $data){
        $db = \Config\Database::connect();
        $builder = $db->table($tabla);

        return $builder->insertBatch($data);
    }

    public function getRandomRows($tabla,$columnas,$condiciones,$cantidad){
        $db = \Config\Database::connect('default');

        $builder = $db->table($tabla)
                        ->select($columnas)
                        ->where($condiciones)
                        ->orderBy('RAND()')
                        ->limit($cantidad);

        return $builder->get()->getResultArray();
    }

}