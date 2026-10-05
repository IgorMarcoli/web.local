<?php

namespace App\Models;

use CodeIgniter\Model;

class ContatoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'contatos';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nome', 'setor', 'ramal', 'email'];
    protected $useTimestamps    = false;
    protected $skipValidation   = true;
    protected $protectFields    = true;
}
