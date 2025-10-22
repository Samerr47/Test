<?php require_once __DIR__ . '/protect_admin.php'; ?>
<?php require_once __DIR__ . '/db.php'; ?>

<?php
$id = (int)($_GET['id'] ?? 0);
$stmt = $mysqli->prepare("SELECT id, name, roll_number, dob, class FROM tbl_student WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();
if (!$student) { header('Location: student.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? '');
  $roll  = trim($_POST['roll_number'] ?? '');
  $dob   = $_POST['dob'] ?? '';
  $class = trim($_POST['class'] ?? '');

  $stmt = $mysqli->prepare("UPDATE tbl_student SET name=?, roll_number=?, dob=?, class=? WHERE id=?");
  $stmt->bind_param('ssssi', $name, $roll, $dob, $class, $id);
  $stmt->execute();
  header('Location: student.php');
  exit;
}
?>

<?php require_once __DIR__ . '/header.php'; ?>
<h4 class="mb-3">Edit Student #<?= htmlspecialchars($student['id']) ?></h4>
<form method="post" class="card card-body shadow-sm">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Roll</label>
      <input class="form-control" name="roll_number" value="<?= htmlspecialchars($student['roll_number']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">DOB</label>
      <input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($student['dob']) ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Class</label>
      <input class="form-control" name="class" value="<?= htmlspecialchars($student['class']) ?>" required>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Update</button>
    <a href="student.php" class="btn btn-secondary">Back</a>
  </div>
</form>
<?php require_once __DIR__ . '/footer.php'; ?>
