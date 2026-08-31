<?php
header('Content-Type: text/html; charset=UTF-8');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$currentPage = basename($_SERVER['PHP_SELF']);
$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klub Fanoušků Zaklínače - Ústecký kraj</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="main-header">
    <div class="container header-container">
        <div class="logo">
            <a href="index.php">
                <h1>Zaklínač<span>ÚK</span></h1>
            </a>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a href="index.php" class="<?= $currentPage == 'index.php' ? 'active' : '' ?>">Domů</a></li>
                <li><a href="bestiary.php" class="<?= $currentPage == 'bestiary.php' ? 'active' : '' ?>">Bestiář</a></li>
                <li><a href="report.php" class="<?= $currentPage == 'report.php' ? 'active' : '' ?>">Nahlášení</a></li>
                <li><a href="meetings.php" class="<?= $currentPage == 'meetings.php' ? 'active' : '' ?>">Srazy</a></li>
                <li><a href="gwent.php" class="<?= $currentPage == 'gwent.php' ? 'active' : '' ?>">Gwint</a></li>
                <?php if ($isAdmin): ?>
                    <li><a href="admin.php" class="<?= $currentPage == 'admin.php' ? 'active' : '' ?>" style="color: #ffb74d;">Administrace</a></li>
                    <li><a href="logout.php">Odhlásit</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="<?= $currentPage == 'login.php' ? 'active' : '' ?>">Přihlášení</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
