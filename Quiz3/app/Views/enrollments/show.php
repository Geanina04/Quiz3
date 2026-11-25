<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header text-center">
          <h4>Datos de la matrícula</h4>
        </div>
        <div class="card-body">
          <dl class="row mb-0">
            <dt class="col-sm-4">N.º de matrícula</dt>
            <dd class="col-sm-8"><?= esc($enrollment['id']) ?></dd>

            <dt class="col-sm-4">Estudiante</dt>
            <dd class="col-sm-8"><?= esc($enrollment['student_name']) ?></dd>

            <dt class="col-sm-4">Cédula</dt>
            <dd class="col-sm-8"><?= esc($enrollment['student_document']) ?></dd>

            <dt class="col-sm-4">Correo electrónico</dt>
            <dd class="col-sm-8"><?= esc($enrollment['student_email']) ?></dd>

            <dt class="col-sm-4">Curso</dt>
            <dd class="col-sm-8"><?= esc($enrollment['course_code'] . ' - ' . $enrollment['course_name']) ?></dd>

            <dt class="col-sm-4">Créditos</dt>
            <dd class="col-sm-8"><?= esc($enrollment['course_credits']) ?></dd>

            <dt class="col-sm-4">Carrera</dt>
            <dd class="col-sm-8"><?= esc($enrollment['career_name']) ?></dd>

            <dt class="col-sm-4">Fecha de matrícula</dt>
            <dd class="col-sm-8"><?= esc($enrollment['created_at']) ?></dd>
          </dl>
        </div>
      </div>
      <a href="<?= site_url('/') ?>" class="btn btn-primary btn-block mt-3">Nueva matrícula</a>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
