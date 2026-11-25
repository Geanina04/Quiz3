<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // ignore(true) = INSERT IGNORE: se puede ejecutar varias veces sin duplicar datos
        $this->db->table('careers')->ignore(true)->insertBatch([
            ['name' => 'Ingeniería en Sistemas'],
            ['name' => 'Administración de Empresas'],
            ['name' => 'Contaduría Pública'],
            ['name' => 'Derecho'],
            ['name' => 'Psicología'],
            ['name' => 'Ingeniería Industrial'],
        ]);

        $now = date('Y-m-d H:i:s');

        $courses = [
            ['Programación I', 'ISW-101', 4, 1],
            ['Bases de Datos', 'ISW-210', 4, 1],
            ['Programación en Ambiente Web I', 'ISW-613', 4, 1],
            ['Contabilidad General', 'ADM-110', 3, 2],
            ['Contabilidad de Costos', 'CON-201', 3, 3],
            ['Introducción al Derecho', 'DER-101', 3, 4],
            ['Psicología General', 'PSI-101', 3, 5],
            ['Ingeniería de Métodos', 'IIN-301', 4, 6],
        ];

        $rows = array_map(static fn (array $c): array => [
            'name' => $c[0], 'code' => $c[1], 'credits' => $c[2], 'career_id' => $c[3],
            'created_at' => $now, 'updated_at' => $now,
        ], $courses);

        $this->db->table('courses')->ignore(true)->insertBatch($rows);
    }
}
