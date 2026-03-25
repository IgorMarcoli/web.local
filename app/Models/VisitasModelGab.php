<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitasModelgab extends Model
{
    protected $table = 'visitas_gab';
    protected $primaryKey = 'VisitaId';
    protected $returnType = 'array';

    protected $allowedFields = [
        'VisitaId',
        'SupervisorId',
        'EscolaId',
        'DataVisita',
        'Tipo',
        'Observacoes',
        'TermoArquivo'
    ];
}
