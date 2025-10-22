<?php require_once __DIR__ . '/protect_admin.php'; ?>
<?php require_once __DIR__ . '/db.php'; ?>

<?php
// Load students for dropdown
$students_rs = $mysqli->query("SELECT id, name FROM tbl_student ORDER BY name ASC");
$students = $students_rs ? $students_rs->fetch_all(MYSQLI_ASSOC) : [];

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $student_id = (int)($_POST['student_id'] ?? 0);
  $date       = $_POST['attendance_date'] ?? '';
  $present    = (int)($_POST['present'] ?? 0);
  $absent     = (int)($_POST['absent'] ?? 0);

  if ($present) $absent = 0;
  if ($student_id <= 0 || empty($date)) {
    $err = 'Please select a student and date.';
  } else {
    $stmt = $mysqli->prepare("INSERT INTO tbl_attendance (student_id, attendance_date, present, absent) VALUES (?,?,?,?)");
    $stmt->bind_param('isii', $student_id, $date, $present, $absent);
    if ($stmt->execute()) {
      header('Location: attendance.php');
      exit;
    } else {
      $err = 'Save failed: ' . $mysqli->error;
    }
  }
}
?>
<?php require_once __DIR__ . '/header.php'; ?>
<h4 class="mb-3">Add Attendance</h4>

<?php if ($err): ?>
  <div class="alert alert-danger py-2"><?= htmlspecialchars($err) ?></div>
<?php endif; ?>

<?php if (count($students) === 0): ?>
  <div class="alert alert-warning">No students found. Add students first.</div>
<?php endif; ?>

<form method="post" class="card card-body shadow-sm">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Student</label>
      <select class="form-select" name="student_id" required <?= count($students) ? '' : 'disabled' ?>>
        <option value="" disabled selected>-- Select --</option>
        <?php foreach ($students as $st): ?>
          <option value="<?= $st['id'] ?>"><?= htmlspecialchars($st['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Date</label>
      <input type="date" class="form-control" name="attendance_date" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Present</label>
      <select class="form-select" name="present">
        <option value="1">Yes</option>
        <option value="0" selected>No</option>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Absent</label>
      <select class="form-select" name="absent">
        <option value="1">Yes</option>
        <option value="0" selected>No</option>
      </select>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary" <?= count($students) ? '' : 'disabled' ?>>Save</button>
    <a href="attendance.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php require_once __DIR__ . '/footer.php'; ?>
