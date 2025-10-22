<?php require_once __DIR__ . '/auth.php'; ?>
<?php require_once __DIR__ . '/header.php'; ?>

<h4 class="mb-3">Welcome</h4>
<p class="text-muted">Simple role-based demo (admin can edit, viewer is read-only).</p>

<div class="card shadow-sm">
  <div class="card-body">
    <?php if ($_SESSION['role'] === 'admin'): ?>
      <h6 class="mb-2">Admin actions</h6>
      <a href="student-add.php" class="btn btn-success btn-sm me-2">Add Student</a>
      <a href="attendance-add.php" class="btn btn-success btn-sm">Add Attendance</a>
      <hr>
    <?php else: ?>
      <div class="alert alert-info py-2">Viewer: read-only access.</div>
    <?php endif; ?>

    <a href="student.php" class="btn btn-primary btn-sm me-2">Students</a>
    <a href="attendance.php" class="btn btn-primary btn-sm">Attendance</a>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
