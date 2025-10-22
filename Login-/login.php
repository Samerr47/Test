<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = [
        'admin'  => ['password' => '123456', 'role' => 'admin'],
        'viewer' => ['password' => '123456', 'role' => 'viewer'],
    ];
    $u = trim($_POST['username'] ?? '');
    $p = trim($_POST['password'] ?? '');

    if (isset($users[$u]) && $users[$u]['password'] === $p) {
        $_SESSION['username'] = $u;
        $_SESSION['role']     = $users[$u]['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid credentials';
    }
}
?>
<?php require_once __DIR__ . '/header.php'; ?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="text-center mb-3">تسجيل الدخول</h5>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger py-2"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">اسم المستخدم</label>
            <input class="form-control" name="username" required>
          </div>
          <div class="mb-3">
            <label class="form-label">كلمة المرور</label>
            <input type="password" class="form-control" name="password" required>
          </div>
          <button class="btn btn-primary w-100">دخول</button>
          <div class="small text-muted mt-2">Try: admin / 123456 أو viewer / 123456</div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
