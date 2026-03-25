<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Agenda extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'AgendaId' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'usigned'        => TRUE,
                'auto_increment' => TRUE
            ],

            'Nomelocal' => [
                'type'       => 'VARCHAR',
                'constraint' => 128
            ],

            'Data' => [
                'type' => 'CHAR',
                'constraint' => 40
               
            ],

            'Tipo' => [
                'type' => 'CHAR',
                'constraint' => 40
                
            ],
            'Descricao' => [
                'type' => 'TEXT',
                
            ],
            'Solicitadopor' => [
                'type' => 'CHAR',
                'constraint' => 40
                
            ],

            'Atendidopor' => [
                'type' => 'CHAR',
                'constraint' => 40
                
            ],

            'status' => [
                'type' => 'CHAR',
                'constraint' => 40
                
            ],

            
        ]);

        $this->forge->addKey('AgendaId', TRUE);
        $this->forge->createTable('agendas');
    
    }

    public function down()
    {
       $this->forge->dropTable('agendas');
    }
}
