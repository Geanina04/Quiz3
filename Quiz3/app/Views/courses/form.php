<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<?php $editing = $course !== null; ?>
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header text-center">
          <h4><?= $editing ? 'Editar Curso' : 'Crear Curso' ?></h4>
        </div>
        <div class="card-body">
          <?= form_open($action) ?>
            <div class="form-group">
              <label for="name">Nombre del Curso</label>
              <input type="text" class="form-control" id="name" name="name" maxlength="100"
                     value="<?= esc(old_value('name', (string) ($course['name'] ?? ''))) ?>" required>
            </div>
            <div class="form-group">
              <label for="code">Código de Curso</label>
              <input type="text" class="form-control" id="code" name="code" maxlength="20"
                     value="<?= esc(old_value('code', (string) ($course['code'] ?? ''))) ?>" required>
              <small class="form-text text-muted">Letras, números y guiones. Ejemplo: ISW-613</small>
            </div>
            <div class="form-group">
              <label for="credits">Cantidad de Créditos</label>
              <input type="number" class="form-control" id="credits" name="credits" min="1" max="20"
                     value="<?= esc(old_value('credits', (string) ($course['credits'] ?? ''))) ?>" required>
            </div>
            <div class="form-group">
              <label for="career_id">Carrera</label>
              <select class="form-control" id="career_id" name="career_id" required>
                <option value="" disabled <?= old_value('career_id', (string) ($course['career_id'] ?? '')) === '' ? 'selected' : '' ?>>Seleccione una carrera</option>
                <?php foreach ($careers as $career): ?>
                  <option value="<?= esc($career['id']) ?>" <?= old_value('career_id', (string) ($course['career_id'] ?? '')) === (string) $career['id'] ? 'selected' : '' ?>>
                    <?= esc($career['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block"><?= $editing ? 'Guardar cambios' : 'Crear Curso' ?></button>
            <a href="<?= site_url('courses') ?>" class="btn btn-link btn-block">Cancelar</a>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
