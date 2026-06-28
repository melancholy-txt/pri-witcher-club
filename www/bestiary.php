<?php
require_once 'includes/db.php';

$filterDanger = $_GET['danger'] ?? '';

$sql = "SELECT * FROM monsters";
$params = [];

if ($filterDanger) {
    $sql .= " WHERE danger_level = :danger";
    $params[':danger'] = $filterDanger;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$monsters = $stmt->fetchAll();

include 'layout/header.php';
?>

<h2>Bestiář Ústeckého kraje</h2>

<form method="GET" action="bestiary.php" class="filter-section">
    <div class="form-group" style="margin: 0; flex: 1;">
        <label for="danger">Filtrovat podle nebezpečí:</label>
        <select name="danger" id="danger">
            <option value="">Všechny úrovně</option>
            <option value="Nízké" <?= $filterDanger == 'Nízké' ? 'selected' : '' ?>>Nízké</option>
            <option value="Střední" <?= $filterDanger == 'Střední' ? 'selected' : '' ?>>Střední</option>
            <option value="Vysoké" <?= $filterDanger == 'Vysoké' ? 'selected' : '' ?>>Vysoké</option>
            <option value="Kritické" <?= $filterDanger == 'Kritické' ? 'selected' : '' ?>>Kritické</option>
        </select>
    </div>
    <button type="submit" class="btn">Filtrovat</button>
</form>

<div class="grid">
    <?php if (count($monsters) > 0): ?>
        <?php foreach ($monsters as $monster): ?>
            <div class="card">
                <h3><?= htmlspecialchars($monster['name']) ?></h3>
                <p><strong>Lokace:</strong> <?= htmlspecialchars($monster['location']) ?></p>
                <p><strong>Nebezpečí:</strong> <span class="badge danger-<?= htmlspecialchars($monster['danger_level']) ?>"><?= htmlspecialchars($monster['danger_level']) ?></span></p>
                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0;">
                <p><?= nl2br(htmlspecialchars($monster['description'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Žádná monstra nevyhovují vašemu filtru.</p>
    <?php endif; ?>
</div>

<?php include 'layout/footer.php'; ?>
