<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid px-4 mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Cursos</h1>
    <a href="<?= site_url('courses/create') ?>" class="btn btn-success">Crear Curso</a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Nombre del Curso</th>
          <th>Código de Curso</th>
          <th>Créditos</th>
          <th>Carrera</th>
          <th class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($courses)): ?>
          <tr>
            <td colspan="5" class="text-center text-muted">No hay cursos registrados.</td>
          </tr>
        <?php endif; ?>
        <?php foreach ($courses as $course): ?>
          <tr>
            <td><?= esc($course['name']) ?></td>
            <td><?= esc($course['code']) ?></td>
            <td><?= esc($course['credits']) ?></td>
            <td><?= esc($course['career_name']) ?></td>
            <td class="text-center text-nowrap">
              <a href="<?= site_url('courses/' . $course['id'] . '/edit') ?>" class="btn btn-sm btn-primary">Editar</a>
              <!-- Eliminar usa POST (form_open agrega el token CSRF) -->
              <?= form_open('courses/' . $course['id'] . '/delete', [
                  'class'    => 'd-inline',
                  'onsubmit' => "return confirm('¿Seguro que desea eliminar este curso?');",
              ]) ?>
                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
              <?= form_close() ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>
