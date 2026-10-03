<?php
$titre_page        = 'Actualités';
$chemin_historique = __DIR__ . '/data/historique_prix.json';
$url_serveur       = 'http://' . $_SERVER['HTTP_HOST'];

require_once 'includes/header.php';

// Géolocalisation de l'utilisateur
$code_dept = '';
$ville_ip = '';
$erreur_geoloc = '';

$reponse_geoloc = file_get_contents($url_serveur . '/api/geoloc.php');

if ($reponse_geoloc === false) {
    $erreur_geoloc = 'Impossible de détecter votre position.';
} else {
    $geoloc = json_decode($reponse_geoloc, true);
    if (isset($geoloc['erreur'])) {
        $erreur_geoloc = $geoloc['erreur'];
    } else {
        if (isset($geoloc['dept'])) {
            $code_dept = $geoloc['dept'];
        }
        if (isset($geoloc['ville'])) {
            $ville_ip = $geoloc['ville'];
        }
    }
}

// Stations du département
$stations= [];
$erreur_api = '';

if (!empty($code_dept)) {
    $reponse_carb = file_get_contents($url_serveur . '/api/carburants.php?dept=' . urlencode($code_dept));

    if ($reponse_carb === false) {
        $erreur_api = 'Impossible de récupérer les prix carburants.';
    } else {
        $donnees_carb = json_decode($reponse_carb, true);
        if (isset($donnees_carb['erreur'])) {
            $erreur_api = $donnees_carb['erreur'];
        } elseif (isset($donnees_carb['stations'])) {
            $stations = $donnees_carb['stations'];
        }
    }
}

// Prix moyens par carburant
$liste_carburants = ['sp95', 'sp98', 'gazole', 'e10', 'e85', 'gplc'];
$prix_moyens      = [];

foreach ($liste_carburants as $carb) {
    $total = 0;
    $count = 0;
    foreach ($stations as $s) {
        if (isset($s['prix_' . $carb]) && $s['prix_' . $carb] !== null && $s['prix_' . $carb] > 0) {
            $total = $total + $s['prix_' . $carb];
            $count = $count + 1;
        }
    }
    if ($count > 0) {
        $prix_moyens[$carb] = round($total / $count, 3);
    } else {
        $prix_moyens[$carb] = null;
    }
}

// Chargement de l'historique des prix
$historique = [];
if (file_exists($chemin_historique)) {
    $contenu = file_get_contents($chemin_historique);
    $historique = json_decode($contenu, true);
    if ($historique === null) {
        $historique = [];
    }
}

if (isset($historique[$code_dept])) {
    $prix_precedents = $historique[$code_dept];
} else {
    $prix_precedents = null;
}

function calculer_tendance($prix_ancien, $prix_actuel) {
    if ($prix_actuel === null) {
        return ['direction' => 'indispo', 'diff' => 0];
    }
    if ($prix_ancien === null) {
        return ['direction' => 'nouveau', 'diff' => 0];
    }

    $diff = round($prix_actuel - $prix_ancien, 3);

    if ($diff > 0.005) {
        return ['direction' => 'hausse', 'diff' => $diff];
    } elseif ($diff < -0.005) {
        return ['direction' => 'baisse', 'diff' => $diff];
    } else {
        return ['direction' => 'stable', 'diff' => 0];
    }
}

$tendances = [];
foreach ($liste_carburants as $carb) {
    if (isset($prix_precedents[$carb])) {
        $prix_ancien = $prix_precedents[$carb];
    } else {
        $prix_ancien = null;
    }
    $tendances[$carb] = calculer_tendance($prix_ancien, $prix_moyens[$carb]);
    $tendances[$carb]['actuel'] = $prix_moyens[$carb];
}

// Sauvegarde pour la prochaine visite
if (!empty($code_dept) && !empty($prix_moyens)) {
    $historique[$code_dept] = array_merge(
        ['date' => date('Y-m-d H:i:s')],
        $prix_moyens
    );
    file_put_contents($chemin_historique, json_encode($historique, JSON_PRETTY_PRINT));
}

$noms_carburants = [
    'sp95'=> 'SP95',
    'sp98' => 'SP98',
    'gazole' => 'Gazole',
    'e10' => 'E10',
    'e85' => 'E85',
    'gplc' => 'GPLc',
];

function icone_tendance($direction) {
    if ($direction === 'hausse') {
        return ['icone' => '↑', 'classe' => 'tendance-hausse'];
    } elseif ($direction === 'baisse') {
        return ['icone' => '↓', 'classe' => 'tendance-baisse'];
    } elseif ($direction === 'stable') {
        return ['icone' => '→', 'classe' => 'tendance-stable'];
    } elseif ($direction === 'nouveau') {
        return ['icone' => '★', 'classe' => 'tendance-nouveau'];
    } else {
        return ['icone' => '—', 'classe' => 'tendance-indispo'];
    }
}

function fmt_prix($prix) {
    if ($prix === null || $prix == 0) {
        return '—';
    }
    return number_format((float) $prix, 3, ',', '') . ' €';
}
?>

<main>

  <section class="page-header">
    <div class="page-header-inner">
      <a href="/index.php<?php echo $param_theme; ?>" class="lien-retour">← Retour à l'accueil</a>
      <h1>Actualités carburants</h1>
      <p>
        <?php if (!empty($ville_ip) && !empty($code_dept)): ?>
          Prix dans votre département :
          <strong><?php echo htmlspecialchars($ville_ip); ?> (<?php echo htmlspecialchars($code_dept); ?>)</strong>
        <?php else: ?>
          Tendances des prix en France
        <?php endif; ?>
      </p>
    </div>
  </section>

  <section class="section-actualites">
    <div class="section-inner">

      <?php if (!empty($erreur_geoloc)): ?>
        <p class="message-erreur"><?php echo htmlspecialchars($erreur_geoloc); ?></p>
      <?php endif; ?>

      <?php if (!empty($erreur_api)): ?>
        <p class="message-erreur"><?php echo htmlspecialchars($erreur_api); ?></p>
      <?php endif; ?>

      <?php if (!empty($tendances)): ?>

        <!-- Cartes de tendance par carburant -->
        <div class="section-bloc">
          <h2>Prix moyens dans le département</h2>

          <?php if ($prix_precedents === null): ?>
            <p class="message-info">
              Première visite — les tendances seront disponibles à votre prochaine visite.
            </p>
          <?php endif; ?>

          <div class="grille-tendances">
            <?php foreach ($tendances as $carb => $t):
              $infos = icone_tendance($t['direction']);
            ?>
              <div class="carte-tendance <?php echo $infos['classe']; ?>">
                <div class="tendance-nom"><?php echo $noms_carburants[$carb]; ?></div>
                <div class="tendance-prix"><?php echo fmt_prix($t['actuel']); ?></div>
                <div class="tendance-icone">
                  <?php echo $infos['icone']; ?>
                  <?php if ($t['diff'] != 0): ?>
                    <span class="tendance-diff">
                      <?php echo ($t['diff'] > 0 ? '+' : '') . number_format($t['diff'], 3, ',', ''); ?> €
                    </span>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Tableau des stations avec coloration par rapport à la moyenne -->
        <?php if (!empty($stations)): ?>
          <div class="section-bloc">
            <h2>
              Stations du département
              <small>(<?php echo count($stations); ?> stations)</small>
            </h2>

            <div class="tableau-container">
              <table class="tableau-stations">
                <thead>
                  <tr>
                    <th>Station</th>
                    <th>SP95</th><th>SP98</th><th>Gazole</th>
                    <th>E10</th><th>E85</th><th>GPLc</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($stations as $station): ?>
                    <tr>
                      <td class="td-station">
                        <div class="station-adresse">
                          <?php echo htmlspecialchars($station['adresse']); ?>
                        </div>
                        <div class="station-badges">
                          <?php if ($station['automate_24']): ?>
                            <span class="badge badge-vert">24h/24</span>
                          <?php endif; ?>
                          <?php
                          $carbs = [
                            'SP95' => $station['prix_sp95'],
                            'SP98' => $station['prix_sp98'],
                            'Gazole' => $station['prix_gazole'],
                            'E10' => $station['prix_e10'],
                            'E85' => $station['prix_e85'],
                            'GPLc' => $station['prix_gplc'],
                          ];
                          foreach ($carbs as $nom => $prix) {
                              if ($prix !== null && $prix > 0) {
                                  echo '<span class="badge badge-carburant">' . $nom . '</span>';
                              }
                          }
                          ?>
                        </div>
                      </td>

                      <?php
                      $prix_station = [
                        'sp95' => $station['prix_sp95'],
                        'sp98'=> $station['prix_sp98'],
                        'gazole' => $station['prix_gazole'],
                        'e10'=> $station['prix_e10'],
                        'e85' => $station['prix_e85'],
                        'gplc' => $station['prix_gplc'],
                      ];
                      foreach ($liste_carburants as $carb):
                          $prix = $prix_station[$carb];

                          if (isset($prix_moyens[$carb])) {
                              $moy = $prix_moyens[$carb];
                          } else {
                              $moy = null;
                          }

                          if ($prix !== null && $prix > 0 && $moy !== null) {
                              if ($prix > $moy + 0.01) {
                                  $classe_prix = 'prix prix-dessus';
                              } elseif ($prix < $moy - 0.01) {
                                  $classe_prix = 'prix prix-dessous';
                              } else {
                                  $classe_prix = 'prix';
                              }
                          } else {
                              $classe_prix = 'prix';
                          }
                      ?>
                        <td class="<?php echo $classe_prix; ?>">
                          <?php echo fmt_prix($prix); ?>
                        </td>
                      <?php endforeach; ?>

                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <p class="legende-prix">
              <span class="prix-dessous">Vert</span> = moins cher que la moyenne du département &nbsp;|&nbsp;
              <span class="prix-dessus">Rouge</span> = plus cher que la moyenne
            </p>

          </div>
        <?php endif; ?>

      <?php endif; ?>

    </div>
  </section>

  <!-- Tableau historique des prix moyens en France 2020–2025 -->
  <section class="section-actualites">
    <div class="section-inner">
      <div class="section-bloc">
        <h2>Évolution des prix moyens en France (2020 – 2025)</h2>
        <p class="legende-prix">
          Prix moyens annuels à la pompe en France métropolitaine — source : Ministère de l'Écologie / INSEE
        </p>
        <div class="tableau-container" style="margin-top: 16px;">
          <table class="tableau-stations">
            <thead>
              <tr>
                <th>Année</th>
                <th>SP95</th><th>SP98</th><th>Gazole</th>
                <th>E10</th><th>E85</th><th>GPLc</th>
              </tr>
            </thead>
            <tbody>
              <tr><td><strong>2020</strong></td><td class="prix">1,330 €</td><td class="prix">1,430 €</td><td class="prix">1,240 €</td><td class="prix">1,300 €</td><td class="prix">0,550 €</td><td class="prix">0,730 €</td></tr>
              <tr><td><strong>2021</strong></td><td class="prix">1,550 €</td><td class="prix">1,660 €</td><td class="prix">1,480 €</td><td class="prix">1,520 €</td><td class="prix">0,620 €</td><td class="prix">0,780 €</td></tr>
              <tr><td><strong>2022</strong></td><td class="prix">1,870 €</td><td class="prix">1,980 €</td><td class="prix">1,850 €</td><td class="prix">1,830 €</td><td class="prix">0,780 €</td><td class="prix">0,920 €</td></tr>
              <tr><td><strong>2023</strong></td><td class="prix">1,780 €</td><td class="prix">1,890 €</td><td class="prix">1,720 €</td><td class="prix">1,740 €</td><td class="prix">0,750 €</td><td class="prix">0,960 €</td></tr>
              <tr><td><strong>2024</strong></td><td class="prix">1,710 €</td><td class="prix">1,820 €</td><td class="prix">1,650 €</td><td class="prix">1,680 €</td><td class="prix">0,720 €</td><td class="prix">0,980 €</td></tr>
              <tr><td><strong>2025</strong></td><td class="prix">1,690 €</td><td class="prix">1,800 €</td><td class="prix">1,630 €</td><td class="prix">1,660 €</td><td class="prix">0,740 €</td><td class="prix">0,990 €</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

</main>

<?php require_once 'includes/footer.php'; ?>
