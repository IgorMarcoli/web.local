<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Maquinas extends Migration
{
    public function up()
    {
        $this->forge->addField([

      'MaquinaId' => [
        'type'           => 'INT',
        'constraint'     => 11,
        'usigned'        => TRUE,
        'auto_increment' => TRUE
    ],

    'Modelo' => [
        'type'       => 'VARCHAR',
        'constraint' => 128
    ],

    'Marca' => [
        'type' => 'TEXT',
    ],

    'Qtde' => [
        'type' => 'TEXT',
        
    ],
    
    'Estadodeconservacao' => [
        'type' => 'TEXT',
    ],
    
     'Localizacao'=> [
        'type' => 'CHAR',
        'constraint' => 30
    ], 
    ]);

$this->forge->addKey('MaquinaId', TRUE);
$this->forge->createTable('maquinas');
    }
    public function down()
    {
        $this->forge->dropTable('maquinas');
    }
}


