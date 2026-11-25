<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Controlador de matrículas: lee la petición, invoca a los modelos y elige la vista.
 * No contiene SQL ni HTML.
 */
class Enrollments extends BaseController
{
    // Campos que se leen del formulario
    private const FIELDS = ['student_name', 'student_document', 'student_email', 'course_id'];

    // GET / : formulario de matrícula con el listado de cursos
    public function create(): string
    {
        return view('enrollments/form', [
            'title'   => 'Matrícula de estudiantes',
            'courses' => model(CourseModel::class)->withCareer(),
        ]);
    }

    // POST /enrollments : guarda la matrícula y muestra los datos del registro
    public function store(): RedirectResponse
    {
        $enrollments = model(EnrollmentModel::class);
        $data        = $this->request->getPost(self::FIELDS);

        if ($enrollments->alreadyEnrolled($data['student_document'], $data['course_id'])) {
            return redirect()->back()->withInput()
                ->with('error', 'Este estudiante ya está matriculado en ese curso.');
        }

        $id = $enrollments->insert($data);
        if ($id === false) {
            return redirect()->back()->withInput()->with('errors', $enrollments->errors());
        }

        return redirect()->to("enrollments/{$id}")->with('success', 'Matrícula realizada correctamente.');
    }

    // GET /enrollments/{id} : datos del registro de matrícula
    public function show(int $id): string
    {
        $enrollment = model(EnrollmentModel::class)->findWithCourse($id);
        if ($enrollment === null) {
            throw PageNotFoundException::forPageNotFound('La matrícula no existe.');
        }

        return view('enrollments/show', [
            'title'      => 'Matrícula realizada',
            'enrollment' => $enrollment,
        ]);
    }
}
