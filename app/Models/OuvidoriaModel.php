<?php

namespace App\Models;

use CodeIgniter\Model;

class OuvidoriaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ouvidoria';
    protected $primaryKey       = 'ouvidoria_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ouvidoria_id',
        'tipo_manifestacao',
        'escola_id',
        'data_recebimento',
        'responsavel',
        'prazo',
        'data_devolutiva',
        'numero_Ouvidoria'
    ];
    public function getComEscola()
{
    return $this->db->table('ouvidoria o')
        ->select('o.*, e.Nome') 
        ->join('escolas e', 'e.EscolaId = o.escola_id')
        ->get()
        ->getResultArray();
}
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
