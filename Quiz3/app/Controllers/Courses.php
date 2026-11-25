<?php

namespace App\Controllers;

use App\Models\CareerModel;
use App\Models\CourseModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Controlador del CRUD de cursos: lee la petición, invoca a los modelos y elige la vista.
 * No contiene SQL ni HTML.
 */
class Courses extends BaseController
{
    // Campos que se leen del formulario
    private const FIELDS = ['name', 'code', 'credits', 'career_id'];

    // GET /courses : listado
    public function index(): string
    {
        return view('courses/index', [
            'title'   => 'Cursos',
            'courses' => model(CourseModel::class)->withCareer(),
        ]);
    }

    // GET /courses/create : formulario vacío
    public function create(): string
    {
        return view('courses/form', [
            'title'   => 'Crear Curso',
            'action'  => site_url('courses'),
            'course'  => null,
            'careers' => model(CareerModel::class)->listAll(),
        ]);
    }

    // POST /courses : crea el curso y vuelve al listado
    public function store(): RedirectResponse
    {
        $courses = model(CourseModel::class);

        if (! $courses->insert($this->request->getPost(self::FIELDS))) {
            return redirect()->back()->withInput()->with('errors', $courses->errors());
        }

        return redirect()->to('courses')->with('success', 'Curso creado correctamente.');
    }

    // GET /courses/{id}/edit : formulario con los datos del curso
    public function edit(int $id): string
    {
        $course = model(CourseModel::class)->find($id);
        if ($course === null) {
            throw PageNotFoundException::forPageNotFound('El curso no existe.');
        }

        return view('courses/form', [
            'title'   => 'Editar Curso',
            'action'  => site_url("courses/{$id}/update"),
            'course'  => $course,
            'careers' => model(CareerModel::class)->listAll(),
        ]);
    }

    // POST /courses/{id}/update : guarda los cambios y vuelve al listado
    public function update(int $id): RedirectResponse
    {
        $courses = model(CourseModel::class);

        if ($courses->find($id) === null) {
            return redirect()->to('courses')->with('error', 'El curso no existe.');
        }

        // El id viaja con los datos para que la regla is_unique ignore el propio curso
        $data = $this->request->getPost(self::FIELDS) + ['id' => $id];

        if (! $courses->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $courses->errors());
        }

        return redirect()->to('courses')->with('success', 'Curso actualizado correctamente.');
    }

    // POST /courses/{id}/delete : elimina el curso (solo por POST)
    public function delete(int $id): RedirectResponse
    {
        $courses = model(CourseModel::class);

        if ($courses->find($id) === null) {
            return redirect()->to('courses')->with('error', 'El curso no existe.');
        }

        if ($courses->hasEnrollments($id)) {
            return redirect()->to('courses')
                ->with('error', 'No se puede eliminar el curso porque tiene matrículas registradas.');
        }

        $courses->delete($id);

        return redirect()->to('courses')->with('success', 'Curso eliminado correctamente.');
    }
}
