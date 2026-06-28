<?php
require_once 'includes/db.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $danger = trim($_POST['danger'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($name && $location && $danger) {
        $sql = "INSERT INTO monsters (name, location, danger_level, description) VALUES (:name, :location, :danger, :description)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':name' => $name,
                ':location' => $location,
                ':danger' => $danger,
                ':description' => $description
            ]);
            $message = "Záznam byl úspěšně přidán do Bestiáře!";
            $messageType = "success";
        } catch (\PDOException $e) {
            $message = "Chyba při ukládání do databáze.";
            $messageType = "error";
        }
    } else {
        $message = "Vyplňte prosím všechna povinná pole (Jméno, Lokace, Nebezpečí).";
        $messageType = "error";
    }
}

include 'layout/header.php';
?>

<h2>Nahlásit nestvůru</h2>

<?php if ($message): ?>
    <div class="card" style="border-color: <?= $messageType === 'success' ? 'var(--primary-color)' : 'orange' ?>;">
        <p><?= htmlspecialchars($message) ?></p>
    </div>
<?php endif; ?>

<div class="card">
    <form method="POST" action="report.php">
        <div class="form-group">
            <label for="name">Jméno netvora / Typ:</label>
            <input type="text" id="name" name="name" required placeholder="Např. Polednice">
        </div>
        
        <div class="form-group">
            <label for="location">Lokace výskytu (Ústecký kraj):</label>
            <input type="text" id="location" name="location" required placeholder="Např. Hrad Hněvín, Most">
        </div>

        <div class="form-group">
            <label for="danger">Úroveň nebezpečí:</label>
            <select name="danger" id="danger" required>
                <option value="Nízké">Nízké</option>
                <option value="Střední">Střední</option>
                <option value="Vysoké">Vysoké</option>
                <option value="Kritické">Kritické</option>
            </select>
        </div>

        <div class="form-group">
            <label for="description">Popis události / Vzhled:</label>
            <textarea id="description" name="description" rows="5" placeholder="Co jste přesně viděli? Kdy k tomu došlo?"></textarea>
        </div>

        <button type="submit" class="btn">Odeslat hlášení</button>
    </form>
</div>

<?php include 'layout/footer.php'; ?>
