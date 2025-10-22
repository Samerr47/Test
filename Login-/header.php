<?php require_once __DIR__ . '/config.php'; ?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>Simple Admin/Viewer App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary mb-2 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">النظام</a>
    <div class="ms-auto d-flex align-items-center gap-3">
      <?php if (!empty($_SESSION['username'])): ?>
        <span class="badge text-bg-secondary">
          <?= htmlspecialchars($_SESSION['username']) ?> (<?= htmlspecialchars($_SESSION['role']) ?>)
        </span>
        <a class="btn btn-outline-danger btn-sm" href="logout.php">خروج</a>
      <?php else: ?>
        <a class="btn btn-primary btn-sm" href="login.php">دخول</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<!-- Back only bar -->
<div class="bg-light border-bottom py-2 mb-3">
  <div class="container">
    <button type="button" class="btn btn-secondary btn-sm" onclick="history.back()">Back</button>
  </div>
</div>

<div class="container">
