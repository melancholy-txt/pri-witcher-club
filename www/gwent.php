<?php
require_once 'includes/db.php';

$stmt = $pdo->query("SELECT * FROM gwent_decks ORDER BY id ASC");
$decks = $stmt->fetchAll();

include 'layout/header.php';
?>

<section class="hero" style="background: radial-gradient(circle at center, #2c1a1a 0%, #121212 100%);">
  <h2>Gwint (Gwent)</h2>
  <p>Nejlepší karetní hra na sever od Jarugy. Na srazech se pravidelně hrají turnaje.</p>
</section>

<h2>Základní balíčky (Starter Decks)</h2>
<p>Gwint se hraje na setkáních pravidelně. Pro lidi bez hotového balíčku je připravených 5 startovních balíčků:</p>
<br>

<div class="grid">
  <?php foreach ($decks as $deck): ?>
    <div class="card">
      <h3 style="color: var(--primary-color); border-bottom: 1px solid var(--border-color); padding-bottom: 0.5rem; margin-bottom: 1rem;">
        <?= htmlspecialchars($deck['faction']) ?>
      </h3>
      <p style="margin-bottom: 0.5rem;"><strong>Herní styl:</strong> <?= htmlspecialchars($deck['playstyle']) ?></p>
      <p><?= htmlspecialchars($deck['description']) ?></p>
    </div>
  <?php endforeach; ?>
</div>

<?php include 'layout/footer.php'; ?>