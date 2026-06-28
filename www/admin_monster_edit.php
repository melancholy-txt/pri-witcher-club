<?php
require_once 'includes/auth.php';
require_admin();
require_once 'includes/db.php';

$id = $_GET['id'] ?? 0;
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? 0;
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $danger = trim($_POST['danger'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name && $location && $danger) {
        $stmt = $pdo->prepare("UPDATE monsters SET name = ?, location = ?, danger_level = ?, description = ? WHERE id = ?");
        try {
            $stmt->execute([$name, $location, $danger, $description, $id]);
            $message = "Záznam byl úspěšně upraven.";
            $messageType = "success";
        } catch (\PDOException $e) {
            $message = "Chyba při úpravě záznamu.";
            $messageType = "error";
        }
    } else {
        $message = "Vyplňte prosím všechna povinná pole.";
        $messageType = "error";
    }
}

// Fetch monster
$stmt = $pdo->prepare("SELECT * FROM monsters WHERE id = ?");
$stmt->execute([$id]);
$monster = $stmt->fetch();

if (!$monster) {
    header('Location: admin.php');
    exit;
}

include 'layout/header.php';
?>

<h2>Upravit záznam: <?= htmlspecialchars($monster['name']) ?></h2>

<?php if ($message): ?>
    <div class="card" style="border-color: <?= $messageType === 'success' ? 'var(--primary-color)' : 'orange' ?>; padding: 1rem;">
        <p><?= htmlspecialchars($message) ?></p>
    </div>
<?php endif; ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <a href="admin.php" style="display: inline-block; margin-bottom: 1rem;">&larr; Zpět do Administrace</a>

    <form method="POST" action="admin_monster_edit.php?id=<?= $monster['id'] ?>">
        <input type="hidden" name="id" value="<?= $monster['id'] ?>">
        
        <div class="form-group">
            <label for="name">Jméno netvora / Typ:</label>
            <input type="text" id="name" name="name" required value="<?= htmlspecialchars($monster['name']) ?>">
        </div>
        
        <div class="form-group">
            <label for="location">Lokace výskytu:</label>
            <input type="text" id="location" name="location" required value="<?= htmlspecialchars($monster['location']) ?>">
        </div>

        <div class="form-group">
            <label for="danger">Úroveň nebezpečí:</label>
            <select name="danger" id="danger" required>
                <option value="Nízké" <?= $monster['danger_level'] == 'Nízké' ? 'selected' : '' ?>>Nízké</option>
                <option value="Střední" <?= $monster['danger_level'] == 'Střední' ? 'selected' : '' ?>>Střední</option>
                <option value="Vysoké" <?= $monster['danger_level'] == 'Vysoké' ? 'selected' : '' ?>>Vysoké</option>
                <option value="Kritické" <?= $monster['danger_level'] == 'Kritické' ? 'selected' : '' ?>>Kritické</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Popis:</label>
            <textarea id="description" name="description" rows="5"><?= htmlspecialchars($monster['description']) ?></textarea>
        </div>

        <button type="submit" class="btn">Uložit změny</button>
    </form>
</div>

<?php include 'layout/footer.php'; ?>
