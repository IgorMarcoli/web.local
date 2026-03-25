<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bancogab extends Migration
{
    public function up()
    {
       $this->forge->addField([
            'BancoId' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'usigned'        => TRUE,
                'auto_increment' => TRUE
            ],

            'Nome' => [
                'type'       => 'VARCHAR',
                'constraint' => 128
            ],

            'Setor' => [
               'type' => 'TEXT'
               
            ],

            'Data' => [
                'type' => 'TEXT'
                
            ],
            'Qtde' => [
                'type' => 'TEXT'
                
            ],
            'Status' => [
                'type' => 'TEXT'
                
            ],


            
        ]);

        $this->forge->addKey('BancoId', TRUE);
        $this->forge->createTable('bancogabs');
    }

    public function down()
    {
        $this->forge->dropTable('bancogabs');
    }
}
