<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/db.php';

// (اختياري أثناء التشخيص) فعّل رؤية الأخطاء:
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle delete BEFORE any output
if ($_SESSION['role'] === 'admin' && isset($_GET['delete'])) {
  $id = (int)$_GET['delete'];
  if ($id > 0) {
    $stmt = $mysqli->prepare("DELETE FROM tbl_attendance WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
  }
  header('Location: attendance.php');
  exit;
}

// Fetch rows
$sql = "SELECT a.id, a.attendance_date, a.present, a.absent, s.name AS student_name
        FROM tbl_attendance a
        JOIN tbl_student s ON s.id = a.student_id
        ORDER BY a.attendance_date DESC, a.id DESC";
$result = $mysqli->query($sql);

// If query failed, show why (بدل صفحة بيضاء)
if (!$result) {
  die('Query failed: ' . $mysqli->error);
}

require_once __DIR__ . '/header.php';
?>
<h4 class="mb-3">Attendance</h4>

<?php if ($_SESSION['role'] === 'admin'): ?>
  <a href="attendance-add.php" class="btn btn-success mb-3">Add Attendance</a>
<?php endif; ?>

<table class="table table-bordered table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>#</th><th>Student</th><th>Date</th><th>Present</th><th>Absent</th><th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($result->num_rows === 0): ?>
      <tr><td colspan="6" class="text-center text-muted">No attendance records yet.</td></tr>
    <?php else: ?>
      <?php while ($a = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $a['id'] ?></td>
          <td><?= htmlspecialchars($a['student_name']) ?></td>
          <td><?= htmlspecialchars($a['attendance_date']) ?></td>
          <td><?= $a['present'] ? '✔︎' : '' ?></td>
          <td><?= $a['absent']  ? '✔︎' : '' ?></td>
          <td>
            <?php if ($_SESSION['role'] === 'admin'): ?>
              <a class="btn btn-sm btn-primary" href="attendance-edit.php?id=<?= $a['id'] ?>">Edit</a>
              <a class="btn btn-sm btn-danger" href="attendance.php?delete=<?= $a['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
            <?php else: ?>
              <span class="text-muted">View only</span>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php endif; ?>
  </tbody>
</table>

<?php require_once __DIR__ . '/footer.php'; ?>
