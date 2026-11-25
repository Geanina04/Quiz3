<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCareers extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        // true = IF NOT EXISTS: no falla si la tabla ya existe
        $this->forge->createTable('careers', true, ['ENGINE' => 'InnoDB']);
    }

    public function down(): void
    {
        $this->forge->dropTable('careers', true);
    }
}
