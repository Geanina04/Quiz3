<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCourses extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'code'       => ['type' => 'VARCHAR', 'constraint' => 20],
            'credits'    => ['type' => 'TINYINT', 'constraint' => 3, 'unsigned' => true],
            'career_id'  => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->addKey('career_id');
        $this->forge->addForeignKey('career_id', 'careers', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('courses', true, ['ENGINE' => 'InnoDB']);
    }

    public function down(): void
    {
        $this->forge->dropTable('courses', true);
    }
}
