<?php

namespace App\Models;

use CodeIgniter\Model;

class SupervisoresModelgab extends Model
{
    protected $table = 'supervisores';
    protected $primaryKey = 'SupervisorId';
    protected $returnType = 'array';

    protected $allowedFields = [
        'Nome',
        'SetorId'
    ];
}
