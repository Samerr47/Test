<?php require_once __DIR__ . '/protect_admin.php'; ?>
<?php require_once __DIR__ . '/db.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name'] ?? '');
  $roll  = trim($_POST['roll_number'] ?? '');
  $dob   = $_POST['dob'] ?? '';
  $class = trim($_POST['class'] ?? '');

  $stmt = $mysqli->prepare("INSERT INTO tbl_student (name, roll_number, dob, class) VALUES (?, ?, ?, ?)");
  $stmt->bind_param('ssss', $name, $roll, $dob, $class);
  $stmt->execute();
  header('Location: student.php');
  exit;
}
?>

<?php require_once __DIR__ . '/header.php'; ?>
<h4 class="mb-3">Add Student</h4>
<form method="post" class="card card-body shadow-sm">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Roll</label>
      <input class="form-control" name="roll_number" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">DOB</label>
      <input type="date" class="form-control" name="dob" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Class</label>
      <input class="form-control" name="class" required>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a href="student.php" class="btn btn-secondary">Cancel</a>
  </div>
</form>
<?php require_once __DIR__ . '/footer.php'; ?>
