<?php require_once __DIR__ . '/protect_admin.php'; ?>
<?php require_once __DIR__ . '/db.php'; ?>

<?php
$id = (int)($_GET['id'] ?? 0);

// Load current attendance
$stmt = $mysqli->prepare("SELECT id, student_id, attendance_date, present, absent FROM tbl_attendance WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$att = $stmt->get_result()->fetch_assoc();
if (!$att) { header('Location: attendance.php'); exit; }

// Load students for dropdown
$students = $mysqli->query("SELECT id, name FROM tbl_student ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $student_id = (int)($_POST['student_id'] ?? 0);
  $date       = $_POST['attendance_date'] ?? '';
  $present    = (int)($_POST['present'] ?? 0);
  $absent     = (int)($_POST['absent'] ?? 0);
  if ($present) $absent = 0;

  $stmt = $mysqli->prepare("UPDATE tbl_attendance SET student_id=?, attendance_date=?, present=?, absent=? WHERE id=?");
  $stmt->bind_param('isiii', $student_id, $date, $present, $absent, $id);
  $stmt->execute();
  header('Location: attendance.php');
  exit;
}
?>

<?php require_once __DIR__ . '/header.php'; ?>
<h4 class="mb-3">Edit Attendance #<?= htmlspecialchars($att['id']) ?></h4>
<form method="post" class="card card-body shadow-sm">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Student</label>
      <select class="form-select" name="student_id" required>
        <?php foreach ($students as $st): ?>
          <option value="<?= $st['id'] ?>" <?= ($st['id'] == $att['student_id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($st['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Date</label>
      <input type="date" class="form-control" name="attendance_date" value="<?= htmlspecialchars($att['attendance_date']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Present</label>
      <select class="form-select" name="present">
        <option value="1" <?= $att['present'] ? 'selected' : '' ?>>Yes</option>
        <option value="0" <?= !$att['present'] ? 'selected' : '' ?>>No</option>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Absent</label>
      <select class="form-select" name="absent">
        <option value="1" <?= $att['absent'] ? 'selected' : '' ?>>Yes</option>
        <option value="0" <?= !$att['absent'] ? 'selected' : '' ?>>No</option>
      </select>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Update</button>
    <a href="attendance.php" class="btn btn-secondary">Back</a>
  </div>
</form>
<?php require_once __DIR__ . '/footer.php'; ?>
