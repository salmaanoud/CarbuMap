<?php
$titre_page = 'Page technique';
require_once 'includes/header.php';

// cURL utilisé car alwaysdata bloque les appels HTTPS avec file_get_contents
/**
 * @brief Effectue un appel HTTP GET via cURL et retourne le corps de la réponse.
 *
 * @param string $url URL complète à appeler.
 * @return string|false Corps de la réponse HTTP, ou false en cas d'erreur cURL.
 *
 * @warning La vérification SSL (CURLOPT_SSL_VERIFYPEER) est désactivée
 *          pour compatibilité avec l'hébergeur alwaysdata.
 */
function appel_api($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $reponse = curl_exec($ch);
    curl_close($ch);
    return $reponse;
}

// Film Ghibli aléatoire (JSON)
$film_ghibli = null;
$erreur_ghibli = '';

$json_ghibli = appel_api('https://ghibliapi.vercel.app/films');

if ($json_ghibli === false) {
    $erreur_ghibli = "Impossible de contacter l'API Ghibli.";
} else {
    $liste_films = json_decode($json_ghibli, true);
    if (!empty($liste_films) && is_array($liste_films)) {
        $film_ghibli = $liste_films[array_rand($liste_films)];
    } else {
        $erreur_ghibli = 'Aucun film trouvé.';
    }
}

// Géolocalisation IP (JSON via ipinfo.io)
$geoloc        = null;
$erreur_geoloc = '';

$url_serveur = 'http://' . $_SERVER['HTTP_HOST'];
$json_geoloc = file_get_contents($url_serveur . '/api/geoloc.php');

if ($json_geoloc === false) {
    $erreur_geoloc = 'Impossible de récupérer votre position.';
} else {
    $geoloc = json_decode($json_geoloc, true);
    if (isset($geoloc['erreur'])) {
        $erreur_geoloc = $geoloc['erreur'];
        $geoloc        = null;
    }
}

// Informations réseau (XML via whatismyip.com)
$donnees_xml = null;
$erreur_xml = '';
$url_xml  = '';

$ip_visiteur = $_SERVER['REMOTE_ADDR'];
$cle_xml   = '27fd9af680545b394ff49aa31231bb97';
$url_xml  = 'https://api.whatismyip.com/ip-address-lookup.php?key=' . $cle_xml . '&input=' . urlencode($ip_visiteur) . '&output=xml';

$reponse_xml = appel_api($url_xml);

if ($reponse_xml === false) {
    $erreur_xml = "Impossible de contacter l'API whatismyip.";
} elseif (substr(trim($reponse_xml), 0, 1) !== '<') {
    $erreur_xml = 'Réponse invalide reçue — limite de requêtes peut-être atteinte.';
} else {
    $donnees_xml = simplexml_load_string($reponse_xml);
    if ($donnees_xml === false) {
        $erreur_xml = 'Impossible de lire le flux XML reçu.';
    }
}
?>

<main>

  <section class="page-header">
    <div class="page-header-inner">
      <a href="/index.php<?php echo $param_theme; ?>" class="lien-retour">← Retour à l'accueil</a>
      <h1>Page technique</h1>
      <p>Démonstration des APIs utilisées sur CarbuMap</p>
    </div>
  </section>

  <section class="section-tech">
    <div class="section-inner">

      <!-- Bloc 1 : Film Ghibli aléatoire via l'API JSON -->
      <div class="tech-bloc">

        <div class="tech-bloc-header">
          <span class="tech-badge tech-badge-json">JSON</span>
          <h2>Film Ghibli aléatoire</h2>
        </div>

        <p class="tech-desc">
          À chaque rechargement de la page un film différent du studio Ghibli s'affiche.
        </p>

        <?php if (!empty($erreur_ghibli)): ?>
          <p class="message-erreur"><?php echo htmlspecialchars($erreur_ghibli); ?></p>

        <?php elseif ($film_ghibli): ?>

          <div class="ghibli-card">

            <!-- Images du film -->
            <div class="ghibli-images">
              <?php if (!empty($film_ghibli['image'])): ?>
                <figure>
                  <img src="<?php echo htmlspecialchars($film_ghibli['image']); ?>"
                       alt="Affiche du film <?php echo htmlspecialchars($film_ghibli['title']); ?>"
                       class="ghibli-img">
                  <figcaption>Affiche — <?php echo htmlspecialchars($film_ghibli['title']); ?></figcaption>
                </figure>
              <?php endif; ?>

              <?php if (!empty($film_ghibli['movie_banner'])): ?>
                <figure>
                  <img src="<?php echo htmlspecialchars($film_ghibli['movie_banner']); ?>"
                       alt="Bannière du film <?php echo htmlspecialchars($film_ghibli['title']); ?>"
                       class="ghibli-banner">
                  <figcaption>Bannière — <?php echo htmlspecialchars($film_ghibli['title']); ?></figcaption>
                </figure>
              <?php endif; ?>
            </div>

            <!-- Informations du film -->
            <div class="ghibli-infos">

              <h3 class="ghibli-titre-film"><?php echo htmlspecialchars($film_ghibli['title']); ?></h3>

              <?php if (!empty($film_ghibli['original_title'])): ?>
                <p class="ghibli-meta">
                  <span class="ghibli-label">Titre japonais :</span>
                  <span lang="ja"><?php echo htmlspecialchars($film_ghibli['original_title']); ?></span>
                </p>
              <?php endif; ?>

              <p class="ghibli-meta">
                <span class="ghibli-label">Année :</span>
                <?php
                if (isset($film_ghibli['release_date'])) {
                    echo htmlspecialchars($film_ghibli['release_date']);
                } else {
                    echo '—';
                }
                ?>
              </p>

              <?php if (!empty($film_ghibli['description'])): ?>
                <p class="ghibli-description">
                  <span class="ghibli-label">Description :</span><br>
                  <?php echo htmlspecialchars($film_ghibli['description']); ?>
                </p>
              <?php endif; ?>

            </div>

          </div>

        <?php endif; ?>

        <div class="tech-flux-lien">
          <a href="https://ghibliapi.vercel.app/films" target="_blank">
            Voir le flux JSON — ghibliapi
          </a>
        </div>

      </div>

      <!-- Bloc 2 : Géolocalisation IP via ipinfo.io (JSON) -->
      <div class="tech-bloc">

        <div class="tech-bloc-header">
          <span class="tech-badge tech-badge-json">JSON</span>
          <h2>Votre position approximative</h2>
        </div>

        <p class="tech-desc">
          Votre position est estimée à partir de votre adresse IP via l'API <strong>ipinfo</strong>.
        </p>

        <?php if (!empty($erreur_geoloc)): ?>
          <p class="message-erreur"><?php echo htmlspecialchars($erreur_geoloc); ?></p>

        <?php elseif ($geoloc): ?>

          <div class="geo-grille">
            <div class="geo-card">
              <span class="geo-label">Adresse IP</span>
              <span class="geo-valeur"><?php echo htmlspecialchars($geoloc['ip']); ?></span>
            </div>
            <div class="geo-card">
              <span class="geo-label">Ville estimée</span>
              <span class="geo-valeur">
                <?php
                if (!empty($geoloc['ville'])) {
                    echo htmlspecialchars($geoloc['ville']);
                } else {
                    echo '—';
                }
                ?>
              </span>
            </div>
            <div class="geo-card">
              <span class="geo-label">Région</span>
              <span class="geo-valeur">
                <?php
                if (!empty($geoloc['region'])) {
                    echo htmlspecialchars($geoloc['region']);
                } else {
                    echo '—';
                }
                ?>
              </span>
            </div>
            <div class="geo-card">
              <span class="geo-label">Département</span>
              <span class="geo-valeur">
                <?php
                if (!empty($geoloc['dept'])) {
                    echo htmlspecialchars($geoloc['dept']);
                } else {
                    echo '—';
                }
                ?>
              </span>
            </div>
            <div class="geo-card">
              <span class="geo-label">Pays</span>
              <span class="geo-valeur">
                <?php
                if (!empty($geoloc['pays'])) {
                    echo htmlspecialchars($geoloc['pays']);
                } else {
                    echo '—';
                }
                ?>
              </span>
            </div>
          </div>

        <?php endif; ?>

        <div class="tech-flux-lien">
          <a href="https://ipinfo.io/<?php echo $geoloc ? htmlspecialchars($geoloc['ip']) : ''; ?>/geo" target="_blank">
            Voir le flux JSON — ipinfo.io
          </a>
        </div>

      </div>

      <!-- Bloc 3 : Informations réseau via whatismyip.com (XML) -->
      <div class="tech-bloc">

        <div class="tech-bloc-header">
          <span class="tech-badge tech-badge-xml">XML</span>
          <h2>Informations réseau</h2>
        </div>

        <p class="tech-desc">
          Données sur votre connexion récupérées via l'API
          <strong>whatismyip</strong> au format XML.
        </p>

        <?php if (!empty($erreur_xml)): ?>
          <p class="message-erreur"><?php echo htmlspecialchars($erreur_xml); ?></p>

        <?php elseif ($donnees_xml): ?>

          <div class="geo-grille">
            <div class="geo-card">
              <span class="geo-label">Adresse IP</span>
              <span class="geo-valeur"><?php echo htmlspecialchars((string) $donnees_xml->server_data->ip); ?></span>
            </div>
            <div class="geo-card">
              <span class="geo-label">Ville</span>
              <span class="geo-valeur"><?php echo htmlspecialchars((string) $donnees_xml->server_data->city); ?></span>
            </div>
            <div class="geo-card">
              <span class="geo-label">Région</span>
              <span class="geo-valeur"><?php echo htmlspecialchars((string) $donnees_xml->server_data->region); ?></span>
            </div>
            <div class="geo-card">
              <span class="geo-label">Pays</span>
              <span class="geo-valeur"><?php echo htmlspecialchars((string) $donnees_xml->server_data->country); ?></span>
            </div>
            <div class="geo-card">
              <span class="geo-label">FAI</span>
              <span class="geo-valeur"><?php echo htmlspecialchars((string) $donnees_xml->server_data->isp); ?></span>
            </div>
          </div>

        <?php endif; ?>

        <div class="tech-flux-lien">
          <a href="<?php echo htmlspecialchars($url_xml); ?>" target="_blank">
            Voir le flux XML — whatismyip.com
          </a>
        </div>

      </div>

    </div>
  </section>

</main>

<?php require_once 'includes/footer.php'; ?>
