<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEnrollments extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'student_name'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'student_document' => ['type' => 'VARCHAR', 'constraint' => 20],
            'student_email'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'course_id'        => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        // Un estudiante no puede matricularse dos veces en el mismo curso
        $this->forge->addUniqueKey(['student_document', 'course_id']);
        $this->forge->addKey('course_id');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('enrollments', true, ['ENGINE' => 'InnoDB']);
    }

    public function down(): void
    {
        $this->forge->dropTable('enrollments', true);
    }
}
