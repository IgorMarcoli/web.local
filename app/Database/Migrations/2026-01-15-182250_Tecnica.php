<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tecnica extends Migration
{
    public function up()
    {
    $this->forge->addField([
    'VisitaId' => [
        'type'           => 'INT',
        'constraint'     => 11,
        'usigned'        => TRUE,
        'auto_increment' => TRUE
    ],

    'Local' => [
        'type'       => 'VARCHAR',
        'constraint' => 128
    ],

    'Data' => [
        'type' => 'CHAR',
        'constraint' => 120
    ],

    'Tipo' => [
        'type' => 'TEXT',
        
    ],
    
    'Descricao' => [
        'type' => 'TEXT',
    ],
    
    'Solicitadopor' => [
        'type' => 'CHAR',
        'constraint' => 30
    ],
]);

$this->forge->addKey('VisitaId', TRUE);
$this->forge->createTable('tecnicas');
    }
    public function down()
    {
        $this->forge->dropTable('tecnicas');
    }
}
