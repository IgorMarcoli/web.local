<?php
namespace App\Models;

use CodeIgniter\Model;

class SetoresModelgab extends Model
{
    protected $table            = 'setores';
    protected $primaryKey       = 'SetorId';

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'SetorId',
        'nome',
        'SupervisorId'
    ];
}