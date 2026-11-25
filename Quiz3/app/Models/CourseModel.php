<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo de cursos: acceso a datos y reglas de negocio (validaciones).
 */
class CourseModel extends Model
{
    protected $table         = 'courses';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'code', 'credits', 'career_id'];

    // Rellena created_at y updated_at automáticamente
    protected $useTimestamps = true;

    // El código se guarda siempre en mayúsculas
    protected $beforeInsert = ['normalizeCode'];
    protected $beforeUpdate = ['normalizeCode'];

    // Reglas de negocio. {id} se reemplaza con el id del curso al editar,
    // para que un curso pueda conservar su propio código.
    protected $validationRules = [
        // Necesaria para que {id} funcione en is_unique (solo viaja al editar)
        'id'        => 'permit_empty|is_natural_no_zero',
        'name'      => 'required|max_length[100]',
        'code'      => 'required|regex_match[/^[A-Za-z0-9][A-Za-z0-9-]{1,19}$/]|is_unique[courses.code,id,{id}]',
        'credits'   => 'required|is_natural_no_zero|less_than_equal_to[20]',
        'career_id' => 'required|is_natural_no_zero|is_not_unique[careers.id]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'El nombre del curso es obligatorio.',
            'max_length' => 'El nombre no puede superar los 100 caracteres.',
        ],
        'code' => [
            'required'    => 'El código del curso es obligatorio.',
            'regex_match' => 'El código debe tener entre 2 y 20 caracteres (letras, números y guiones).',
            'is_unique'   => 'Ya existe un curso con ese código.',
        ],
        'credits' => [
            'required'           => 'La cantidad de créditos es obligatoria.',
            'is_natural_no_zero' => 'Los créditos deben ser un número entero mayor que cero.',
            'less_than_equal_to' => 'Los créditos no pueden ser más de 20.',
        ],
        'career_id' => [
            'required'           => 'Seleccione una carrera.',
            'is_natural_no_zero' => 'Seleccione una carrera válida.',
            'is_not_unique'      => 'Seleccione una carrera válida.',
        ],
    ];

    /**
     * Lista de cursos junto con el nombre de su carrera.
     */
    public function withCareer(): array
    {
        return $this->select('courses.*, careers.name AS career_name')
            ->join('careers', 'careers.id = courses.career_id')
            ->orderBy('courses.name', 'ASC')
            ->findAll();
    }

    /**
     * Regla de negocio: un curso con matrículas no se puede eliminar.
     */
    public function hasEnrollments(int $courseId): bool
    {
        return $this->db->table('enrollments')->where('course_id', $courseId)->countAllResults() > 0;
    }

    protected function normalizeCode(array $event): array
    {
        if (isset($event['data']['code'])) {
            $event['data']['code'] = strtoupper(trim($event['data']['code']));
        }

        return $event;
    }
}
