<?php
$page_courante = basename($_SERVER['PHP_SELF']);
$pages_avec_langue = ['index.php', 'plan.php'];

// Gestion du thème jour / nuit
if (isset($_GET['theme'])) {
    $theme = $_GET['theme'] === 'nuit' ? 'nuit' : 'jour';
    setcookie('carbumap_theme', $theme, time() + 60 * 60 * 24 * 30, '/');

} elseif (isset($_COOKIE['carbumap_theme'])) {
    $valeur_cookie = $_COOKIE['carbumap_theme'];

    if ($valeur_cookie !== 'jour' && $valeur_cookie !== 'nuit') {
        setcookie('carbumap_theme', '', time() - 3600, '/');
        $theme = 'jour';
    } else {
        $theme = $valeur_cookie;
    }

} else {
    $theme = 'jour';
}

if ($theme === 'nuit') {
    $fichier_css = 'style-nuit.css';
} else {
    $fichier_css = 'style-jour.css';
}

if ($theme === 'nuit') {
    $param_theme = '?theme=nuit';
} else {
    $param_theme = '';
}

if ($theme === 'nuit') {
    $theme_oppose = 'jour';
} else {
    $theme_oppose = 'nuit';
}

// On garde tout les paramètres GET existant et on change juste le theme
// comme ça sur departement.php les parametres région/dept sont conservés
$params_bascule = $_GET;
$params_bascule['theme'] = $theme_oppose;
$url_bascule_theme = strtok($_SERVER['REQUEST_URI'], '?') . '?' . http_build_query($params_bascule);

// Gestion de la langue
if (isset($_GET['lang'])) {
    $langue = $_GET['lang'] === 'en' ? 'en' : 'fr';
    setcookie('carbumap_langue', $langue, time() + 60 * 60 * 24 * 30, '/');
} elseif (isset($_COOKIE['carbumap_langue']) && $_COOKIE['carbumap_langue'] === 'en') {
    $langue = 'en';
} else {
    $langue = 'fr';
}

if ($langue === 'en') {
    $param_langue = 'lang=en';
} else {
    $param_langue = '';
}

// Lien accueil avec thème + langue
if ($param_theme && $param_langue) {
    $lien_accueil = '/index.php' . $param_theme . '&' . $param_langue;
} elseif ($param_theme) {
    $lien_accueil = '/index.php' . $param_theme;
} elseif ($param_langue) {
    $lien_accueil = '/index.php?' . $param_langue;
} else {
    $lien_accueil = '/index.php';
}

// Alias pour les anciennes pages
$theme_actuel = $theme;
$chgmt_theme  = $param_theme;
$lang         = $langue;
$chgmt_lang   = $param_langue;

// Variable utilisée dans plan-fr.php et plan-en.php
// Combine thème + langue pour les liens internes
if ($param_theme && $param_langue) {
    $chgmt_theme_lang = $param_theme . '&' . $param_langue;
} elseif ($param_theme) {
    $chgmt_theme_lang = $param_theme;
} elseif ($param_langue) {
    $chgmt_theme_lang = '?' . $param_langue;
} else {
    $chgmt_theme_lang = '';
}

// Lien vers le plan du site (conserve thème + langue)
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
<!DOCTYPE html>
<html lang="<?php echo $langue; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="CarbuMap – Comparez les prix des carburants près de chez vous.">
  <title><?php echo isset($titre_page) ? htmlspecialchars($titre_page) . ' – CarbuMap' : 'CarbuMap'; ?></title>
  <link rel="icon" type="image/png" href="/images/favicon.png">
  <link rel="stylesheet" href="/<?php echo $fichier_css; ?>">
</head>
<body id="top">

<header>
  <div class="header-inner">

    <!-- Logo (doublon avec le lien Accueil dans la nav) -->
    <div class="logo" aria-hidden="true">
      <span class="logo-icone">⛽</span>
      <span class="logo-nom">Carbu<span>Map</span></span>
    </div>

    <!-- Navigation principale -->
    <nav aria-label="Navigation principale">
      <ul>
        <li><a href="<?php echo $lien_accueil; ?>" class="<?php echo $page_courante === 'index.php' ? 'active' : ''; ?>">Accueil</a></li>
        <li><a href="/actualites.php<?php echo $param_theme; ?>" class="<?php echo $page_courante === 'actualites.php' ? 'active' : ''; ?>">Actualités</a></li>
        <li><a href="/stats.php<?php echo $param_theme; ?>" class="<?php echo $page_courante === 'stats.php' ? 'active' : ''; ?>">Statistiques</a></li>
        <li><a href="/contact.php<?php echo $param_theme; ?>" class="<?php echo $page_courante === 'contact.php' ? 'active' : ''; ?>">Contact & FAQ</a></li>
      </ul>
    </nav>

    <div class="header-droite">

      <!-- Sélecteur de langue (seulement sur l'accueil et le plan du site) -->
      <?php if (in_array($page_courante, $pages_avec_langue)): ?>
        <form method="get" action="/<?php echo $page_courante; ?>" style="display:inline;">
          <input type="hidden" name="theme" value="<?php echo htmlspecialchars($theme); ?>">
          <label for="lang" class="sr-only">Langue</label>
          <select name="lang" id="lang" class="select-langue">
            <option value="fr" <?php echo $langue === 'fr' ? 'selected' : ''; ?>>Français</option>
            <option value="en" <?php echo $langue === 'en' ? 'selected' : ''; ?>>Anglais</option>
          </select>
          <button type="submit" class="btn-langue">OK</button>
        </form>
      <?php endif; ?>

      <!-- Bouton bascule jour/nuit -->
      <a href="<?php echo $url_bascule_theme; ?>" class="btn-theme" title="Passer en mode <?php echo $theme_oppose; ?>">
        <?php echo $theme === 'nuit' ? '☀️' : '🌙'; ?>
      </a>

    </div>

  </div>
</header>