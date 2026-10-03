<?php
$titre_page = 'Statistiques';
require_once 'includes/header.php';

$chemin_csv  = __DIR__ . '/data/consultations.csv';
$consultations   = [];
$total_consultations = 0;

if (file_exists($chemin_csv)) {

    $fichier = fopen($chemin_csv, 'r');
    fgetcsv($fichier, 0, ',', '"', '\\'); // saute la ligne d'en-tête

    while ($ligne = fgetcsv($fichier, 0, ',', '"', '\\')) {
        if (!isset($ligne[1])) {
            continue;
        }

        $nom_ville = trim($ligne[1]);
        $dept_ville = '';

        if (isset($ligne[2])) {
            $dept_ville = trim($ligne[2]);
        }

        if (empty($nom_ville)) {
            continue;
        }

        if (isset($consultations[$nom_ville])) {
            $consultations[$nom_ville]['nb']++;
        } else {
            $consultations[$nom_ville] = ['nb' => 1, 'dept' => $dept_ville];
        }

        $total_consultations++;
    }

    fclose($fichier);
}

uasort($consultations, function($a, $b) {
    return $b['nb'] - $a['nb'];
});

$max_visites = 1;
$ville_top = '—';

if (!empty($consultations)) {
    $max_visites = reset($consultations)['nb'];
    $ville_top = array_key_first($consultations);
}
?>

<main>

  <section class="page-header">
    <div class="page-header-inner">
      <a href="/index.php" class="lien-retour">← Retour à l'accueil</a>
      <h1>Statistiques</h1>
      <p>Les villes les plus recherchées sur CarbuMap</p>
    </div>
  </section>

  <section class="section-stats-page">
    <div class="section-inner">

      <!-- Chiffres clés -->
      <div class="stats-chiffres">
        <div class="stats-chiffre-card">
          <span class="stats-chiffre-nb"><?php echo $total_consultations; ?></span>
          <span class="stats-chiffre-label">Recherches au total</span>
        </div>
        <div class="stats-chiffre-card">
          <span class="stats-chiffre-nb"><?php echo count($consultations); ?></span>
          <span class="stats-chiffre-label">Villes différentes</span>
        </div>
        <div class="stats-chiffre-card">
          <span class="stats-chiffre-nb"><?php echo htmlspecialchars($ville_top); ?></span>
          <span class="stats-chiffre-label">Ville la plus cherchée</span>
        </div>
      </div>

      <!-- Histogramme des villes -->
      <div class="stats-histogramme-bloc">
        <h2>
          Toutes les villes consultées
          <small>(<?php echo count($consultations); ?> ville<?php echo count($consultations) > 1 ? 's' : ''; ?>)</small>
        </h2>

        <?php if (empty($consultations)): ?>
          <p class="message-info">
            Pas encore de données. Les stats s'afficheront quand des utilisateurs auront cherché des villes.
          </p>
        <?php else: ?>

          <div class="histogramme">
            <?php foreach ($consultations as $nom_ville => $data):
              $pourcentage = round(($data['nb'] / $max_visites) * 100);
            ?>
              <div class="histo-ligne">

                <div class="histo-ville">
                  <?php echo htmlspecialchars($nom_ville); ?>
                  <?php if (!empty($data['dept'])): ?>
                    <span class="histo-dept">(<?php echo htmlspecialchars($data['dept']); ?>)</span>
                  <?php endif; ?>
                </div>

                <div class="histo-barre-container">
                  <div class="histo-barre" style="width: <?php echo $pourcentage; ?>%;"></div>
                </div>

                <div class="histo-nb">
                  <?php echo $data['nb']; ?>
                  <span class="histo-nb-label">visite<?php echo $data['nb'] > 1 ? 's' : ''; ?></span>
                </div>

              </div>
            <?php endforeach; ?>
          </div>

        <?php endif; ?>
      </div>

    </div>
  </section>

</main>

<?php require_once 'includes/footer.php'; ?>
