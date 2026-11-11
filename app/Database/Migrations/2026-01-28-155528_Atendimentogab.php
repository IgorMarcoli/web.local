<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Atendimentogab extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'AtendimentoId' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'usigned'        => TRUE,
                'auto_increment' => TRUE
            ],

            'Nome' => [
                'type'       => 'VARCHAR',
                'constraint' => 128
            ],

            'Data' => [
                'type'       => 'VARCHAR',
                'constraint' => 40
            ],

            'Tipo' => [
                'type' => 'CHAR',
                'constraint' => 30
            ],

            'Descricao' => [
                'type' => 'TEXT'
            ],

             'Atendidopor' => [
                'type' => 'CHAR',
                'constraint' => 30
            ],

             'Status' => [
                'type' => 'CHAR',
                'constraint' => 30
            ],
        ]);

        $this->forge->addKey('AtendimentoId', TRUE);
        $this->forge->createTable('atendimentogabs');
    }

    public function down()
    {
       $this->forge->dropTable('atendimentogabs');
    }
}
