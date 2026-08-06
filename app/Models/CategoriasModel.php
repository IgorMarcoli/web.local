<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categorias';
    protected $primaryKey       = 'nome';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nome'];

    public function listar(): array
    {
        return $this->db->table('categorias')
            ->select(['nome'])
            ->orderBy('id_categoria', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function exists(string $nome): bool
    {
        if ($nome === '') {
            return false;
        }

        return $this->db->table('categorias')
            ->where('nome', $nome)
            ->countAllResults() > 0;
    }
}
