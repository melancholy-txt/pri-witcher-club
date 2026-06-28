<?php
require_once 'includes/auth.php';

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
  header('Location: admin.php');
  exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if ($username === 'admin' && $password === 'admin') {
    $_SESSION['admin_logged_in'] = true;
    header('Location: admin.php');
    exit;
  } else {
    $error = 'Neplatné přihlašovací údaje.';
  }
}

include 'layout/header.php';
?>

<h2>Přihlášení do Administrace</h2>

<div class="card" style="max-width: 400px; margin: 0 auto;">
  <?php if ($error): ?>
    <p style="color: #ff5252; margin-bottom: 1rem;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

  <form method="POST" action="login.php">
    <div class="form-group">
      <label for="username">Uživatelské jméno:</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Heslo:</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="btn" style="width: 100%;">Přihlásit</button>
  </form>
</div>

<?php include 'layout/footer.php'; ?>