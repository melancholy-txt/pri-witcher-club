<?php
require_once 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM meetings ORDER BY date DESC");
$meetings = $stmt->fetchAll();

include 'layout/header.php';
?>

<h2>Nadcházející a proběhlé srazy</h2>

<div class="grid">
    <?php foreach ($meetings as $meeting): ?>
        <div class="card">
            <h3><?= htmlspecialchars($meeting['topic']) ?></h3>
            <p><strong>Datum a čas:</strong> <?= date('d. m. Y H:i', strtotime($meeting['date'])) ?></p>
            <p><strong>Místo konání:</strong> <?= htmlspecialchars($meeting['location']) ?></p>
            <?php if (!empty($meeting['description'])): ?>
                <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0;">
                <p><?= nl2br(htmlspecialchars($meeting['description'])) ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<?php include 'layout/footer.php'; ?>
