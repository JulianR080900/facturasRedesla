<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ConnectionInterface;

class IquatroModel extends Model
{

    protected $db;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db =& $db;
    }

	public function getAll($tabla,$condiciones){
        
        $builder = $this->db->table($tabla);
        $builder->select('*');
        $builder->where($condiciones);
        return $builder->get()->getResultArray();
    }
    

    public function getColumnsOneRow($columnas,$tabla,$condiciones){

        $builder = $this->db->table($tabla)
                        ->select($columnas)
                        ->where($condiciones);

        return $builder->get()->getRowArray();

    }

    public function exist($tabla, $condiciones){

        $builder = $this->db->table($tabla)
                        ->select('id')
                        ->where($condiciones);
                        $builder->countAllResults();

        if ($builder->countAllResults() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getColumns($columnas,$tabla,$condiciones){

        $builder = $this->db->table($tabla)
                        ->select($columnas)
                        ->where($condiciones);

        return $builder->get()->getResultArray();

    }

    public function nombre_autor($aut_id){

        $builder = $this->db->table('author_settings')
                        ->select('setting_value as nombre')
                        ->select('(SELECT setting_value FROM author_settings WHERE locale = "es_ES" AND author_id = '.$aut_id.' AND setting_name = "familyName") as apellidos')
                        ->where('author_id',$aut_id)
                        ->where('locale','es_ES')
                        ->where('setting_name','givenName');
                        
        return $builder->get()->getRowArray();

    }

    public function generalUpdate($tabla,$data,$condiciones){
        
        $builder = $this->db->table($tabla)
                      ->set($data)
                      ->where($condiciones);
        if($builder->update()){
            return true;
        }
        return false;

    }

    public function getAllOneRow($tabla,$condiciones){
        $builder = $this->db->table($tabla);
        $builder->select('*');
        $builder->where($condiciones);
        return $builder->get()->getRowArray();
    }

    public function getAllOrderBy($tabla,$condiciones,$order){

        $builder = $this->db->table($tabla)
                        ->select('*')
                        ->where($condiciones)
                        ->orderBy($order);

        return $builder->get()->getResultArray();

    }

    public function getMinOneRow($columnaMinima,$columnas,$tabla,$condiciones){
        $builder = $this->db->table($tabla)
            ->selectMin($columnaMinima)
            ->select($columnas)
            ->where($condiciones);
        return $builder->get()->getRowArray();
    }
}