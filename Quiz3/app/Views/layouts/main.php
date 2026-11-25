<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'Quiz 3') ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= site_url('/') ?>">Quiz 3 · CodeIgniter 4</a>
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('/') ?>">Matrícula</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('courses') ?>">Cursos</a>
      </li>
    </ul>
  </nav>

  <div class="container-fluid mt-3 px-4">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success" role="alert"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger" role="alert"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
      <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
          <?php foreach (session()->getFlashdata('errors') as $message): ?>
            <li><?= esc($message) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>

  <?= $this->renderSection('content') ?>

  <footer class="footer mt-auto py-3 bg-light">
    <div class="container text-center">
      <span class="text-muted">&copy; 2026 My Website. All rights reserved.</span>
    </div>
  </footer>
</body>

</html>
