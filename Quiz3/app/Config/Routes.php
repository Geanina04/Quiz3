<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Página principal: formulario de matrícula
$routes->get('/', 'Enrollments::create');
$routes->post('enrollments', 'Enrollments::store');          // guarda la matrícula
$routes->get('enrollments/(:num)', 'Enrollments::show/$1');  // muestra los datos del registro

// CRUD de cursos. Eliminar y actualizar solo aceptan POST.
$routes->group('courses', static function (RouteCollection $routes): void {
    $routes->get('', 'Courses::index');                   // listado
    $routes->get('create', 'Courses::create');            // formulario de creación
    $routes->post('', 'Courses::store');                  // guarda el curso nuevo
    $routes->get('(:num)/edit', 'Courses::edit/$1');      // formulario de edición
    $routes->post('(:num)/update', 'Courses::update/$1'); // guarda los cambios
    $routes->post('(:num)/delete', 'Courses::delete/$1'); // elimina el curso
});
