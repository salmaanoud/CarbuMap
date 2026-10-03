<?php
header('Content-Type: application/json');

if (isset($_GET['dept'])) {
    $code_dept = trim($_GET['dept']);
} else {
    $code_dept = '';
}

if (empty($code_dept)) {
    echo json_encode(['erreur' => 'Code département manquant']);
    exit;
}

$url_api = 'https://data.economie.gouv.fr/api/explore/v2.1/catalog/datasets/prix-des-carburants-en-france-flux-instantane-v2/records/';
$limite = 100;
$decalage = 0;
$total= null;
$toutes_stations = [];

do {
    $params_requete = http_build_query([
        'where' => 'code_departement="' . $code_dept . '"',
        'limit' => $limite,
        'offset' => $decalage,
        'timezone' => 'Europe/Paris',
    ]);

    $url_requete = $url_api . '?' . $params_requete;
    $reponse_brute = file_get_contents($url_requete);

    if ($reponse_brute === false) {
        echo json_encode(['erreur' => "Impossible de contacter l'API carburants"]);
        exit;
    }

    $reponse = json_decode($reponse_brute, true);

    if ($reponse === null) {
        echo json_encode(['erreur' => "Réponse invalide de l'API"]);
        exit;
    }

    if ($total === null) {
        if (isset($reponse['total_count'])) {
            $total = (int) $reponse['total_count'];
        } else {
            $total = 0;
        }
    }

    if (isset($reponse['results']) && is_array($reponse['results'])) {
        foreach ($reponse['results'] as $station) {

            if (isset($station['id'])) {
                $id = $station['id'];
            } else {
                $id = '';
            }

            if (isset($station['adresse'])) {
                $adresse = $station['adresse'];
            } else {
                $adresse = 'Adresse inconnue';
            }

            if (isset($station['ville'])) {
                $ville = $station['ville'];
            } else {
                $ville = '';
            }

            if (isset($station['cp'])) {
                $code_postal = $station['cp'];
            } else {
                $code_postal = '';
            }

            if (isset($station['sp95_prix'])) {
                $prix_sp95 = $station['sp95_prix'];
            } else {
                $prix_sp95 = null;
            }

            if (isset($station['sp98_prix'])) {
                $prix_sp98 = $station['sp98_prix'];
            } else {
                $prix_sp98 = null;
            }

            if (isset($station['gazole_prix'])) {
                $prix_gazole = $station['gazole_prix'];
            } else {
                $prix_gazole = null;
            }

            if (isset($station['e10_prix'])) {
                $prix_e10 = $station['e10_prix'];
            } else {
                $prix_e10 = null;
            }

            if (isset($station['e85_prix'])) {
                $prix_e85 = $station['e85_prix'];
            } else {
                $prix_e85 = null;
            }

            if (isset($station['gplc_prix'])) {
                $prix_gplc = $station['gplc_prix'];
            } else {
                $prix_gplc = null;
            }

            if (isset($station['services_service'])) {
                $services = $station['services_service'];
            } else {
                $services = [];
            }

            if (isset($station['horaires_automate_24_24']) && $station['horaires_automate_24_24'] === 'Oui') {
                $automate_24 = true;
            } else {
                $automate_24 = false;
            }

            if (isset($station['carburants_disponibles'])) {
                $carburants_dispo = $station['carburants_disponibles'];
            } else {
                $carburants_dispo = [];
            }

            if (isset($station['gazole_maj'])) {
                $mise_a_jour = $station['gazole_maj'];
            } else {
                $mise_a_jour = '';
            }

            $toutes_stations[] = [
                'id' => $id,
                'adresse' => $adresse,
                'ville' => $ville,
                'code_postal' => $code_postal,
                'prix_sp95' => $prix_sp95,
                'prix_sp98' => $prix_sp98,
                'prix_gazole'=> $prix_gazole,
                'prix_e10' => $prix_e10,
                'prix_e85' => $prix_e85,
                'prix_gplc'=> $prix_gplc,
                'services' => $services,
                'automate_24'=> $automate_24,
                'carburants_dispo' => $carburants_dispo,
                'mise_a_jour' => $mise_a_jour,
            ];
        }
    }

    $decalage = $decalage + $limite;

} while ($decalage < $total);

echo json_encode([
    'total'=> count($toutes_stations),
    'dept' => $code_dept,
    'stations' => $toutes_stations,
]);
