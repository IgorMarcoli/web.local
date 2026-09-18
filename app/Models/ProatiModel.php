<?php

namespace App\Models;

use CodeIgniter\Model;

class ProatiModel extends Model
{
    protected $table         = 'login';
    protected $primaryKey    = 'usuario_id'; // AJUSTE se a PK da tabela login tiver outro nome
    protected $returnType    = 'array';
    protected $allowedFields = ['perfil', 'nome', 'email', 'escola_id', 'telefone', 'foto'];

    /**
     * Retorna todos os usuários com perfil "PROATI", já trazendo o nome
     * da escola correspondente através da FK EscolaId (uuid).
     *
     * AJUSTE os nomes das colunas abaixo ("Perfil", "EscolaId", "Nome" da
     * escola) caso sejam diferentes no seu banco.
     */
    public function getProatis(): array
    {
        return $this->db->table('perfis')
            ->select('perfis.*, escolas."nome" as NomeEscola')
            ->join('escolas', 'escolas."id" = perfis."escola_id"', 'left')
            ->where('perfis."perfil"', 'PROATI')
            ->orderBy('perfis."nome"', 'ASC')
            ->get()
            ->getResultArray();
    }
}