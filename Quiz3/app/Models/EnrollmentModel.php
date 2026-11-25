<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Modelo de matrículas: un estudiante se matricula en un curso.
 */
class EnrollmentModel extends Model
{
    protected $table         = 'enrollments';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['student_name', 'student_document', 'student_email', 'course_id'];

    // Solo se guarda la fecha de creación (la tabla no tiene updated_at)
    protected $useTimestamps = true;
    protected $updatedField  = '';

    // La cédula se guarda en mayúsculas y sin espacios sobrantes
    protected $beforeInsert = ['normalizeDocument'];

    protected $validationRules = [
        'student_name'     => 'required|min_length[3]|max_length[100]',
        'student_document' => 'required|regex_match[/^[0-9A-Za-z-]{5,20}$/]',
        'student_email'    => 'required|valid_email|max_length[100]',
        'course_id'        => 'required|is_natural_no_zero|is_not_unique[courses.id]',
    ];

    protected $validationMessages = [
        'student_name' => [
            'required'   => 'El nombre del estudiante es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede superar los 100 caracteres.',
        ],
        'student_document' => [
            'required'    => 'La cédula es obligatoria.',
            'regex_match' => 'La cédula debe tener entre 5 y 20 caracteres (letras, números y guiones).',
        ],
        'student_email' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Ingrese un correo electrónico válido.',
            'max_length'  => 'El correo no puede superar los 100 caracteres.',
        ],
        'course_id' => [
            'required'           => 'Seleccione un curso.',
            'is_natural_no_zero' => 'Seleccione un curso válido.',
            'is_not_unique'      => 'Seleccione un curso válido.',
        ],
    ];

    /**
     * Regla de negocio: un estudiante no puede matricularse dos veces en el mismo curso.
     */
    public function alreadyEnrolled(mixed $document, mixed $courseId): bool
    {
        // Datos que todavía no son válidos los rechaza la validación del modelo
        if (! is_string($document) || ! is_string($courseId) || ! ctype_digit($courseId)) {
            return false;
        }

        return $this->where('student_document', strtoupper(trim($document)))
            ->where('course_id', (int) $courseId)
            ->countAllResults() > 0;
    }

    /**
     * Una matrícula junto con los datos de su curso y su carrera.
     */
    public function findWithCourse(int $id): ?array
    {
        return $this->select('enrollments.*, courses.name AS course_name, courses.code AS course_code,
                courses.credits AS course_credits, careers.name AS career_name')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->join('careers', 'careers.id = courses.career_id')
            ->where('enrollments.id', $id)
            ->first();
    }

    protected function normalizeDocument(array $event): array
    {
        if (isset($event['data']['student_document'])) {
            $event['data']['student_document'] = strtoupper(trim($event['data']['student_document']));
        }

        return $event;
    }
}
