<?php

namespace App\Models;

use CodeIgniter\Model;

class OuvidoriaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ouvidoriagabs';
    protected $primaryKey       = 'ouvidoria_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ouvidoria_id',
        'numero_protocolo',
        'tipo_manifestacao',
        'escola_id',
        'envolvidos',
        'data_criacao',
        'data_resposta',
        'responsavel_resposta',
    ];

    public function getComEscola()
    {
        return $this->db->table('ouvidoriagabs o')
            ->select('o.*, e.nome as nome_escola') 
            ->join('escolas e', 'e.id = o.escola_id', 'left')
            ->orderBy('o.ouvidoria_id', 'DESC')
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
