<?php

namespace App\Models;

use CodeIgniter\Model;

class ChamadoModel extends Model
{
    protected $table = 'chamados';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['numero', 'escola', 'solicitante', 'contato', 'categoria', 'prioridade', 'descricao', 'status', 'responsavel', 'prazo', 'solucao', 'criado_por', 'created_at', 'updated_at'];
    protected $useTimestamps = false;
}
