<?php
namespace App\Models;
use CodeIgniter\Model;
class LoginModel extends Model{

    public function exist($tabla,$condiciones){

        $qry=$this->db->table($tabla);
        $qry->select("id");
        $qry->where($condiciones);
        $n = $qry->countAllResults();
        if($n >= 1){
            return true;
        }else{
            return false;
        }
    }

    public function getAllOneRow($tabla,$condiciones){
        $qry=$this->db->table($tabla);
        $qry->select("*");
        $qry->where($condiciones);
        return $qry->get()->getRowArray();
    }

    public function getUserInfo($usuario){

        $qry=$this->db->table('miembros');

        $qry->select("*");

        $qry->select("(SELECT nombre FROM grado_academico WHERE grado_academico.id = miembros.grado) as grado_academico");

        $qry->where("usuario",$usuario);

        return $qry->get()->getRowArray();

    }

    public function redesCA($usuario){

        $qry=$this->db->table('miembros');

        $qry->distinct();

        $qry->select("cuerpoAcademico, redCueCa");

        $qry->where("usuario",$usuario);

        return $qry->get()->getResultArray();
    }

    public function getColumnsOneRow($columnas,$tabla,$condiciones){

        $qry=$this->db->table($tabla);

        $qry->select($columnas);

        $qry->where($condiciones);

        return $qry->get()->getRowArray();

    }
}
