<?php

namespace App\Models;

use CodeIgniter\Model;

class EmprestimosModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'emprestimos';
    protected $primaryKey       = 'id_emprestimo';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_emprestimo',
        'numero_mochila',
        'secao',
        'servico',
        'nome_recebedor',
        'email_recebedor',
        'nome_responsavel',
        'status_equipamento',
        'numero_chamado',
        'data_emprestimo',
        'data_devolucao',
        'obs'
    ];

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
