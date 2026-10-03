<?php
$titre_page = 'Départements';
require_once 'includes/header.php';

// Paramètres GET
if (isset($_GET['region'])) {
    $code_region = htmlspecialchars(trim($_GET['region']));
} else {
    $code_region = '';
}

if (isset($_GET['nom'])) {
    $nom_region = htmlspecialchars(trim($_GET['nom']));
} else {
    $nom_region = 'Région inconnue';
}

if (isset($_GET['dept'])) {
    $code_dept = htmlspecialchars(trim($_GET['dept']));
} else {
    $code_dept = '';
}

if (isset($_GET['nom_dept'])) {
    $nom_dept = htmlspecialchars(trim($_GET['nom_dept']));
} else {
    $nom_dept = '';
}

if (isset($_GET['ville_insee'])) {
    $ville_insee = htmlspecialchars(trim($_GET['ville_insee']));
} else {
    $ville_insee = '';
}

if (isset($_GET['carburant'])) {
    $filtre_carb = htmlspecialchars(trim($_GET['carburant']));
} else {
    $filtre_carb = '';
}

if (isset($_GET['station'])) {
    $station_ouverte = htmlspecialchars(trim($_GET['station']));
} else {
    $station_ouverte = '';
}

if (empty($code_region)) {
    header('Location: /index.php');
    exit;
}

// Lecture du code INSEE de la région
$code_insee_region = '';
$chemin_regions    = __DIR__ . '/data/regions.csv';

if (!file_exists($chemin_regions)) {
    die('<p>Erreur : fichier regions.csv introuvable.</p>');
}

$fich_regions = fopen($chemin_regions, 'r');
fgetcsv($fich_regions, 0, ',', '"', '\\');

while ($ligne = fgetcsv($fich_regions, 0, ',', '"', '\\')) {
    if (isset($ligne[0]) && trim($ligne[0]) === $code_region) {
        $code_insee_region = trim($ligne[1]);
        break;
    }
}
fclose($fich_regions);

if (empty($code_insee_region)) {
    header('Location: /index.php');
    exit;
}

// Lecture des départements de la région
$liste_depts  = [];
$chemin_depts = __DIR__ . '/data/departements.csv';

if (!file_exists($chemin_depts)) {
    die('<p>Erreur : fichier departements.csv introuvable.</p>');
}

$fich_depts = fopen($chemin_depts, 'r');
fgetcsv($fich_depts, 0, ',', '"', '\\');

while ($ligne = fgetcsv($fich_depts, 0, ',', '"', '\\')) {
    if (isset($ligne[1]) && trim($ligne[1]) === $code_insee_region) {
        $liste_depts[] = [
            'code' => trim($ligne[0]),
            'nom'  => trim($ligne[6]),
        ];
    }
}
fclose($fich_depts);

usort($liste_depts, function($a, $b) {
    return strcmp($a['nom'], $b['nom']);
});

// Lecture des villes du département sélectionné
$liste_villes = [];

if (!empty($code_dept)) {
    $chemin_villes = __DIR__ . '/data/villes.csv';

    if (file_exists($chemin_villes)) {
        $fich_villes = fopen($chemin_villes, 'r');
        fgetcsv($fich_villes, 0, ',', '"', '\\');

        while ($ligne = fgetcsv($fich_villes, 0, ',', '"', '\\')) {
            if (!isset($ligne[0])) {
                continue;
            }

            $insee_ville  = trim($ligne[0]);
            $longueur_dept = strlen($code_dept);

            if (substr($insee_ville, 0, $longueur_dept) === $code_dept) {
                $liste_villes[] = [
                    'insee'  => $insee_ville,
                    'nom'  => ucwords(strtolower(trim($ligne[1]))),
                    'postal' => trim($ligne[2]),
                ];
            }
        }
        fclose($fich_villes);

        usort($liste_villes, function($a, $b) {
            return strcmp($a['nom'], $b['nom']);
        });

        // Suppression des doublons de noms
        $noms_vus = [];
        $villes_uniques = [];

        foreach ($liste_villes as $v) {
            if (!in_array($v['nom'], $noms_vus)) {
                $villes_uniques[] = $v;
                $noms_vus[]       = $v['nom'];
            }
        }

        $liste_villes = $villes_uniques;
    }
}

// Nom de la ville sélectionnée
$nom_ville = '';

foreach ($liste_villes as $v) {
    if ($v['insee'] === $ville_insee) {
        $nom_ville = $v['nom'];
        break;
    }
}

// Sauvegarde en cookie de la dernière ville
if (!empty($nom_ville) && !empty($ville_insee)) {
    $expiration = time() + 60 * 60 * 24 * 90;
    setcookie('carbumap_ville_insee', $ville_insee, $expiration, '/');
    setcookie('carbumap_dept', $code_dept, $expiration, '/');
    setcookie('carbumap_nom_dept', $nom_dept, $expiration, '/');
    setcookie('carbumap_region', $code_region, $expiration, '/');
    setcookie('carbumap_ville_nom',$nom_ville, $expiration, '/');
}

// Enregistrement dans consultations.csv
if (!empty($nom_ville) && !empty($code_dept)) {
    $chemin_consult = __DIR__ . '/data/consultations.csv';
    $ligne_csv      = date('Y-m-d H:i:s') . ',' . $nom_ville . ',' . $code_dept . "\n";
    file_put_contents($chemin_consult, $ligne_csv, FILE_APPEND);
}

// Récupération des stations via l'API interne
$stations  = [];
$total_stations  = 0;
$erreur_api = '';
$mode_dept_complet = false;

if (!empty($ville_insee)) {
    $url_api = 'http://' . $_SERVER['HTTP_HOST'] . '/api/carburants.php?dept=' . urlencode($code_dept);
    $reponse_brute = file_get_contents($url_api);

    if ($reponse_brute === false) {
        $erreur_api = "Impossible de contacter l'API carburants.";
    } else {
        $reponse = json_decode($reponse_brute, true);

        if (isset($reponse['erreur'])) {
            $erreur_api = $reponse['erreur'];

        } elseif (isset($reponse['stations'])) {
            $stations_ville = [];

            foreach ($reponse['stations'] as $s) {
                if (strtolower(trim($s['ville'])) === strtolower(trim($nom_ville))) {
                    $stations_ville[] = $s;
                }
            }

            if (!empty($stations_ville)) {
                $stations = $stations_ville;
            } else {
                $stations  = $reponse['stations'];
                $mode_dept_complet = true;
                usort($stations, function($a, $b) {
                    return strcmp($a['ville'], $b['ville']);
                });
            }

            if (!empty($filtre_carb)) {
                $cle_prix  = 'prix_' . $filtre_carb;
                $stations_filtrees  = [];
                foreach ($stations as $s) {
                    if (isset($s[$cle_prix]) && $s[$cle_prix] !== null && $s[$cle_prix] > 0) {
                        $stations_filtrees[] = $s;
                    }
                }
                $stations = $stations_filtrees;
            }

            $total_stations = count($stations);
        }
    }
}

/**
 * @brief Formate un prix de carburant pour l'affichage.
 *
 * @param float|null $prix Prix brut issu de l'API (peut être null, "" ou 0).
 * @return string Prix formaté avec 3 décimales et le symbole €, ou "—" si absent.
 */
function formater_prix($prix) {
    if ($prix === null || $prix === '' || $prix == 0) {
        return '—';
    }
    return number_format((float) $prix, 3, ',', '') . ' €';
}

$liste_carburants = [
    ''  => 'Tous les carburants',
    'sp95' => 'SP95',
    'sp98' => 'SP98',
    'gazole' => 'Gazole',
    'e10' => 'E10',
    'e85'  => 'E85',
    'gplc' => 'GPLc',
];

if ($theme === 'nuit') {
    $param_theme_carte = '&theme=nuit';
} else {
    $param_theme_carte = '';
}
?>

<main>

  <section class="page-header">
    <div class="page-header-inner">
      <a href="/index.php<?php echo $param_theme; ?>#carte" class="lien-retour">← Retour à la carte</a>
      <h1><?php echo $nom_region; ?></h1>
      <p>
        <?php if (!empty($code_dept)): ?>
          <?php echo htmlspecialchars($nom_dept); ?> — choisissez votre ville
        <?php else: ?>
          Choisissez un département
        <?php endif; ?>
      </p>
    </div>
  </section>

  <!-- Liste des départements de la région -->
  <div class="section-departements">
    <div class="section-inner">

      <?php if (empty($liste_depts)): ?>
        <p class="message-vide">Aucun département trouvé pour cette région.</p>
      <?php else: ?>

        <div class="grille-departements">
          <?php foreach ($liste_depts as $dept): ?>

            <?php if ($code_dept === $dept['code']): ?>
              <a class="carte-dept carte-dept-actif"
            <?php else: ?>
              <a class="carte-dept"
            <?php endif; ?>
                 href="/departement.php?region=<?php echo urlencode($code_region); ?>&amp;nom=<?php echo urlencode($nom_region); ?>&amp;dept=<?php echo urlencode($dept['code']); ?>&amp;nom_dept=<?php echo urlencode($dept['nom']); ?><?php echo $param_theme_carte; ?>">
              <span class="dept-code"><?php echo htmlspecialchars($dept['code']); ?></span>
              <span class="dept-nom"><?php echo htmlspecialchars($dept['nom']); ?></span>
            </a>

          <?php endforeach; ?>
        </div>

      <?php endif; ?>

    </div>
  </div>

  <!-- Formulaire sélection ville + filtre carburant -->
  <?php if (!empty($code_dept) && !empty($liste_villes)): ?>

    <div class="section-ville">
      <div class="section-inner">

        <form method="get" action="/departement.php" class="form-ville">

          <input type="hidden" name="region" value="<?php echo $code_region; ?>">
          <input type="hidden" name="nom"  value="<?php echo $nom_region; ?>">
          <input type="hidden" name="dept" value="<?php echo $code_dept; ?>">
          <input type="hidden" name="nom_dept" value="<?php echo $nom_dept; ?>">

          <?php if ($theme === 'nuit'): ?>
            <input type="hidden" name="theme" value="nuit">
          <?php endif; ?>

          <!-- Sélecteur de ville -->
          <div class="champ-ville">
            <label for="ville_insee">Votre ville :</label>
            <select name="ville_insee" id="ville_insee">
              <option value="">-- Sélectionnez une ville --</option>
              <?php foreach ($liste_villes as $v): ?>
                <option value="<?php echo htmlspecialchars($v['insee']); ?>"
                  <?php echo ($ville_insee === $v['insee']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($v['nom']); ?>
                  (<?php echo htmlspecialchars($v['postal']); ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Filtre par type de carburant -->
          <div class="champ-ville">
            <label for="carburant">Type de carburant :</label>
            <select name="carburant" id="carburant">
              <?php foreach ($liste_carburants as $valeur => $libelle): ?>
                <option value="<?php echo $valeur; ?>"
                  <?php echo ($filtre_carb === $valeur) ? 'selected' : ''; ?>>
                  <?php echo $libelle; ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <button type="submit" class="btn-recherche">Voir les stations →</button>

        </form>

      </div>
    </div>

  <?php endif; ?>

  <!-- Tableau des stations de carburant -->
  <?php if (!empty($ville_insee)): ?>

    <div class="section-ville">
      <div class="section-inner">
        <div class="section-resultats">

          <h2>
            <?php if ($mode_dept_complet): ?>
              Pas de station à <span><?php echo htmlspecialchars($nom_ville); ?></span>
              — stations du département
            <?php else: ?>
              <span><?php echo $total_stations; ?></span>
              station<?php echo $total_stations > 1 ? 's' : ''; ?>
              à <span><?php echo htmlspecialchars($nom_ville); ?></span>
            <?php endif; ?>
            <?php if (!empty($filtre_carb)): ?>
              <small>— <?php echo htmlspecialchars($liste_carburants[$filtre_carb]); ?></small>
            <?php endif; ?>
          </h2>

          <?php if (!empty($erreur_api)): ?>
            <p class="message-erreur"><?php echo $erreur_api; ?></p>

          <?php elseif (empty($stations)): ?>
            <p class="message-vide">Aucune station trouvée.</p>

          <?php else: ?>

            <div class="tableau-container">
              <table class="tableau-stations">
                <thead>
                  <tr>
                    <th>Station</th>
                    <?php if (empty($filtre_carb)): ?>
                      <th>SP95</th><th>SP98</th><th>Gazole</th>
                      <th>E10</th><th>E85</th><th>GPLc</th>
                    <?php else: ?>
                      <th><?php echo htmlspecialchars($liste_carburants[$filtre_carb]); ?></th>
                    <?php endif; ?>
                    <th>Services</th>
                  </tr>
                </thead>
                <tbody>

                  <?php foreach ($stations as $index => $station):
                    $id_station  = 'station_' . $index;
                    $est_ouverte = ($station_ouverte === $id_station);

                    $params_url = $_GET;
                    if ($est_ouverte) {
                        unset($params_url['station']);
                    } else {
                        $params_url['station'] = $id_station;
                    }
                    $url_services = '/departement.php?' . http_build_query($params_url) . '#' . $id_station;
                  ?>

                    <tr id="<?php echo $id_station; ?>">
                      <td class="td-station">
                        <div class="station-adresse">
                          <?php echo htmlspecialchars($station['adresse']); ?>
                          <?php if ($mode_dept_complet): ?>
                            <span class="station-ville-tag">
                              <?php echo htmlspecialchars($station['ville']); ?>
                            </span>
                          <?php endif; ?>
                        </div>
                        <div class="station-badges">
                          <?php if ($station['automate_24']): ?>
                            <span class="badge badge-vert">24h/24</span>
                          <?php endif; ?>
                          <?php
                          $carburants_dispo = [
                            'SP95' => $station['prix_sp95'],
                            'SP98' => $station['prix_sp98'],
                            'Gazole' => $station['prix_gazole'],
                            'E10' => $station['prix_e10'],
                            'E85' => $station['prix_e85'],
                            'GPLc'=> $station['prix_gplc'],
                          ];
                          foreach ($carburants_dispo as $nom => $prix) {
                              if ($prix !== null && $prix != 0) {
                                  echo '<span class="badge badge-carburant">' . $nom . '</span>';
                              }
                          }
                          ?>
                        </div>
                      </td>

                      <?php if (empty($filtre_carb)): ?>
                        <td class="prix"><?php echo formater_prix($station['prix_sp95']); ?></td>
                        <td class="prix"><?php echo formater_prix($station['prix_sp98']); ?></td>
                        <td class="prix"><?php echo formater_prix($station['prix_gazole']); ?></td>
                        <td class="prix"><?php echo formater_prix($station['prix_e10']); ?></td>
                        <td class="prix"><?php echo formater_prix($station['prix_e85']); ?></td>
                        <td class="prix"><?php echo formater_prix($station['prix_gplc']); ?></td>
                      <?php else: ?>
                        <td class="prix"><?php echo formater_prix($station['prix_' . $filtre_carb]); ?></td>
                      <?php endif; ?>

                      <td class="td-services">
                        <a href="<?php echo htmlspecialchars($url_services); ?>" class="btn-savoir-plus">
                          <?php echo $est_ouverte ? 'Fermer ✕' : 'En savoir +'; ?>
                        </a>
                      </td>

                    </tr>

                    <!-- Services de la station (dépliable) -->
                    <?php if ($est_ouverte): ?>
                      <tr class="tr-services">
                        <td colspan="<?php echo empty($filtre_carb) ? '9' : '4'; ?>">
                          <div class="services-liste">
                            <?php
                            if (!empty($station['services']) && is_array($station['services'])) {
                                foreach ($station['services'] as $service) {
                                    echo '<span class="service-item">' . htmlspecialchars($service) . '</span>';
                                }
                            } else {
                                echo '<span class="service-vide">Aucun service renseigné</span>';
                            }
                            ?>
                          </div>
                        </td>
                      </tr>
                    <?php endif; ?>

                  <?php endforeach; ?>

                </tbody>
              </table>
            </div>

          <?php endif; ?>

        </div>
      </div>
    </div>

  <?php endif; ?>

</main>

<?php require_once 'includes/footer.php'; ?>