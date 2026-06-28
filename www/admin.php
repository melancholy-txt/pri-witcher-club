<?php
require_once 'includes/auth.php';
require_admin();
require_once 'includes/db.php';

$message = '';
$messageType = '';

// Handle Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add_meeting') {
            $topic = trim($_POST['topic'] ?? '');
            $date = trim($_POST['date'] ?? '');
            $location = trim($_POST['location'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if ($topic && $date && $location) {
                $stmt = $pdo->prepare("INSERT INTO meetings (topic, date, location, description) VALUES (?, ?, ?, ?)");
                $stmt->execute([$topic, $date, $location, $description]);
                $message = "Sraz byl úspěšně přidán.";
                $messageType = "success";
            } else {
                $message = "Vyplňte všechna pole pro nový sraz.";
                $messageType = "error";
            }
        } elseif ($action === 'delete_meeting') {
            $id = $_POST['id'] ?? 0;
            $stmt = $pdo->prepare("DELETE FROM meetings WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Sraz byl smazán.";
            $messageType = "success";
        } elseif ($action === 'delete_monster') {
            $id = $_POST['id'] ?? 0;
            $stmt = $pdo->prepare("DELETE FROM monsters WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Záznam z bestiáře byl smazán.";
            $messageType = "success";
        }
    }
}

// Fetch data
$meetings = $pdo->query("SELECT * FROM meetings ORDER BY date DESC")->fetchAll();
$monsters = $pdo->query("SELECT * FROM monsters ORDER BY id DESC")->fetchAll();

include 'layout/header.php';
?>

<h2>Administrace</h2>

<?php if ($message): ?>
    <div class="card" style="border-color: <?= $messageType === 'success' ? 'var(--primary-color)' : 'orange' ?>; padding: 1rem;">
        <p><?= htmlspecialchars($message) ?></p>
    </div>
<?php endif; ?>

<div class="grid">
    <div class="card">
        <h3>Správa Srazů</h3>
        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0;">
        
        <form method="POST" action="admin.php" style="margin-bottom: 2rem; background: rgba(0,0,0,0.1); padding: 1rem; border-radius: 6px;">
            <h4>Přidat nový sraz</h4>
            <input type="hidden" name="action" value="add_meeting">
            <div class="form-group" style="margin-bottom: 0.5rem;">
                <input type="text" name="topic" placeholder="Téma srazu" required>
            </div>
            <div class="form-group" style="margin-bottom: 0.5rem;">
                <input type="datetime-local" name="date" required>
            </div>
            <div class="form-group" style="margin-bottom: 0.5rem;">
                <input type="text" name="location" placeholder="Místo konání" required>
            </div>
            <div class="form-group" style="margin-bottom: 0.5rem;">
                <textarea name="description" placeholder="Popis srazu (volitelné)" rows="2"></textarea>
            </div>
            <button type="submit" class="btn" style="font-size: 0.8rem; padding: 0.5rem 1rem;">Přidat sraz</button>
        </form>

        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);">Téma</th>
                    <th style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);">Datum</th>
                    <th style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);">Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($meetings as $m): ?>
                    <tr>
                        <td style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);"><?= htmlspecialchars($m['topic']) ?></td>
                        <td style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);"><?= date('d.m.Y', strtotime($m['date'])) ?></td>
                        <td style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);">
                            <form method="POST" action="admin.php" style="display:inline;">
                                <input type="hidden" name="action" value="delete_meeting">
                                <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn" style="background: transparent; color: #ff5252; padding: 0; font-size: 0.9rem;" onclick="return confirm('Opravdu smazat?');">Smazat</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <h3>Správa Bestiáře</h3>
        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr>
                    <th style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);">Jméno</th>
                    <th style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);">Nebezpečí</th>
                    <th style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);">Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monsters as $mon): ?>
                    <tr>
                        <td style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);"><?= htmlspecialchars($mon['name']) ?></td>
                        <td style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);"><?= htmlspecialchars($mon['danger_level']) ?></td>
                        <td style="padding: 0.5rem; border-bottom: 1px solid var(--border-color);">
                            <a href="admin_monster_edit.php?id=<?= $mon['id'] ?>" style="margin-right: 10px; font-size: 0.9rem;">Upravit</a>
                            <form method="POST" action="admin.php" style="display:inline;">
                                <input type="hidden" name="action" value="delete_monster">
                                <input type="hidden" name="id" value="<?= $mon['id'] ?>">
                                <button type="submit" class="btn" style="background: transparent; color: #ff5252; padding: 0; font-size: 0.9rem;" onclick="return confirm('Opravdu smazat?');">Smazat</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
