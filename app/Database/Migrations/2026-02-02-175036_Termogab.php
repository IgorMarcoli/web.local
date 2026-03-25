<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Termogab extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'TermoId' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'usigned'        => TRUE,
                'auto_increment' => TRUE
            ],

            'Processosei' => [
                'type'       => 'VARCHAR',
                'constraint' => 128
            ],

            'Supervisor' => [
                'type' => 'TEXT'
               
            ],

            'Rede' => [
                'type' => 'TEXT'
                
            ],
            'Setor' => [
                'type' => 'TEXT'                
            ],
            'Escola' => [
                'type' => 'TEXT'
                
            ],

            'Tipo' => [
                'type' => 'TEXT'
                
            ],

            'Data' => [
                'type' => 'TEXT'                
            ],

            
        ]);

        $this->forge->addKey('TermoId', TRUE);
        $this->forge->createTable('termogabs');
    }

    public function down()
    {
        $this->forge->dropTable('termogabs');
    }
}
