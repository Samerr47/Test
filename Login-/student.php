<?php require_once __DIR__ . '/auth.php'; ?>
<?php require_once __DIR__ . '/db.php'; ?>
<?php require_once __DIR__ . '/header.php'; ?>

<h4 class="mb-3">Students</h4>

<?php if ($_SESSION['role'] === 'admin'): ?>
  <a href="student-add.php" class="btn btn-success mb-3">Add Student</a>
<?php endif; ?>

<?php
$result = $mysqli->query("SELECT id, name, roll_number, dob, class FROM tbl_student ORDER BY id DESC");
?>
<table class="table table-bordered table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>#</th><th>Name</th><th>Roll</th><th>DOB</th><th>Class</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($s = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $s['id'] ?></td>
        <td><?= htmlspecialchars($s['name']) ?></td>
        <td><?= htmlspecialchars($s['roll_number']) ?></td>
        <td><?= htmlspecialchars($s['dob']) ?></td>
        <td><?= htmlspecialchars($s['class']) ?></td>
        <td>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="student-edit.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="student.php?delete=<?= $s['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
          <?php else: ?>
            <span class="text-muted">View only</span>
          <?php endif; ?>
        </td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/footer.php'; ?>

<?php
// Handle delete (admin only)
if ($_SESSION['role'] === 'admin' && isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  $stmt = $mysqli->prepare("DELETE FROM tbl_student WHERE id = ?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  header('Location: student.php');
  exit;
}
