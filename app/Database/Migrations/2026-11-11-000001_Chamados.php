<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Chamados extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'numero' => ['type' => 'VARCHAR', 'constraint' => 24],
            'escola' => ['type' => 'VARCHAR', 'constraint' => 180],
            'solicitante' => ['type' => 'VARCHAR', 'constraint' => 160],
            'contato' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'categoria' => ['type' => 'VARCHAR', 'constraint' => 80],
            'prioridade' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'Normal'],
            'descricao' => ['type' => 'TEXT'],
            'status' => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'Aberto'],
            'responsavel' => ['type' => 'VARCHAR', 'constraint' => 160, 'null' => true],
            'prazo' => ['type' => 'DATE', 'null' => true],
            'solucao' => ['type' => 'TEXT', 'null' => true],
            'criado_por' => ['type' => 'VARCHAR', 'constraint' => 160],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('numero');
        $this->forge->createTable('chamados');

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'chamado_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'autor' => ['type' => 'VARCHAR', 'constraint' => 160],
            'tipo' => ['type' => 'VARCHAR', 'constraint' => 30],
            'detalhe' => ['type' => 'TEXT'],
            'created_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('chamado_id');
        $this->forge->createTable('chamados_historico');
    }

    public function down()
    {
        $this->forge->dropTable('chamados_historico', true);
        $this->forge->dropTable('chamados', true);
    }
}
