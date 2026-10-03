<?php
// Compteur de visites
$fichier_hits = __DIR__ . '/../data/hits.txt';
$nb_visites = 0;

if (file_exists($fichier_hits)) {
    $nb_visites = (int) file_get_contents($fichier_hits);
}

$nb_visites = $nb_visites + 1;
file_put_contents($fichier_hits, $nb_visites);

// Lien vers le plan du site avec thème + langue
if ($param_theme && $param_langue) {
    $lien_plan = '/plan.php' . $param_theme . '&' . $param_langue;
} elseif ($param_theme) {
    $lien_plan = '/plan.php' . $param_theme;
} elseif ($param_langue) {
    $lien_plan = '/plan.php?' . $param_langue;
} else {
    $lien_plan = '/plan.php';
}
?>

<footer>
  <div class="footer-inner">

    <div class="footer-brand">
      <a href="/index.php<?php echo $param_theme; ?>" class="logo">
        <span class="logo-icone">⛽</span>
        <span class="logo-nom">Carbu<span>Map</span></span>
      </a>
      <p>Comparez les prix des carburants dans toutes les stations de France.</p>
    </div>

    <!-- Liens de navigation -->
    <div class="footer-col">
      <h3>Navigation</h3>
      <ul>
        <li><a href="/index.php<?php echo $param_theme; ?>">Accueil</a></li>
        <li><a href="/actualites.php<?php echo $param_theme; ?>">Actualités</a></li>
        <li><a href="/tech.php<?php echo $param_theme; ?>">Page tech</a></li>
        <li><a href="/contact.php<?php echo $param_theme; ?>">Contact & FAQ</a></li>
        <li><a href="<?php echo $lien_plan; ?>">Plan du site</a></li>
      </ul>
    </div>

    <!-- Sources de données -->
    <div class="footer-col">
      <h3>Sources</h3>
      <ul>
        <li><a href="https://www.prix-carburants.gouv.fr/rubrique/opendata/" target="_blank">prix-carburants.gouv.fr</a></li>
        <li><a href="https://www.data.gouv.fr" target="_blank">data.gouv.fr</a></li>
        <li><a href="https://ipinfo.io" target="_blank">ipinfo.io</a></li>
        <li><a href="https://ghibliapi.vercel.app" target="_blank">Ghibli API</a></li>
        <li><a href="https://www.whatismyip.com" target="_blank">whatismyip.com</a></li>
      </ul>
    </div>

  </div>

  <!-- Compteur de visites et copyright -->
  <div class="footer-bas">
    <span>
      &copy; <?php echo date('Y'); ?> CarbuMap &mdash; Projet Web L2-I S4 &mdash;
      Rayan MOULAI &amp; Salma ANOUD
      &mdash; <strong>Nous avons accueilli <?php echo $nb_visites; ?></strong> visiteur<?php echo $nb_visites > 1 ? 's' : ''; ?>
    </span>
  </div>
</footer>

<!-- Bouton retour en haut de page -->
<a href="#top" class="btn-retour-haut" id="btnHaut" title="Retour en haut">↑</a>

</body>
</html>