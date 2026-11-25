<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header text-center">
          <h4>Matrícula de estudiantes</h4>
        </div>
        <div class="card-body">
          <?php if (empty($courses)): ?>
            <div class="alert alert-warning mb-0">No hay cursos disponibles para matricular.</div>
          <?php else: ?>
            <?= form_open('enrollments') ?>
              <div class="form-group">
                <label for="student_name">Nombre del estudiante</label>
                <input type="text" class="form-control" id="student_name" name="student_name" maxlength="100"
                       value="<?= esc(old_value('student_name')) ?>" required>
              </div>
              <div class="form-group">
                <label for="student_document">Cédula</label>
                <input type="text" class="form-control" id="student_document" name="student_document" maxlength="20"
                       value="<?= esc(old_value('student_document')) ?>" required>
              </div>
              <div class="form-group">
                <label for="student_email">Correo electrónico</label>
                <input type="email" class="form-control" id="student_email" name="student_email" maxlength="100"
                       value="<?= esc(old_value('student_email')) ?>" required>
              </div>
              <div class="form-group">
                <label for="course_id">Curso</label>
                <select class="form-control" id="course_id" name="course_id" required>
                  <option value="" disabled <?= old_value('course_id') === '' ? 'selected' : '' ?>>Seleccione un curso</option>
                  <?php foreach ($courses as $course): ?>
                    <option value="<?= esc($course['id']) ?>" <?= old_value('course_id') === (string) $course['id'] ? 'selected' : '' ?>>
                      <?= esc($course['code'] . ' - ' . $course['name'] . ' (' . $course['credits'] . ' créditos) · ' . $course['career_name']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Matricular</button>
            <?= form_close() ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
