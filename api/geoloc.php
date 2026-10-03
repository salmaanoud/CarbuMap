<?php
header('Content-Type: application/json');

/**
 * @brief Retourne l'adresse IP réelle du visiteur.
 *
 * Parcourt une liste ordonnée d'en-têtes HTTP pour trouver une IP valide,
 * en priorisant Cloudflare, les proxys, puis l'adresse directe.
 *
 * @return string Adresse IP valide (IPv4 ou IPv6), ou "0.0.0.0" si aucune trouvée.
 */
function get_ip_visiteur() {
    $headers = [
        'HTTP_CF_CONNECTING_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_REAL_IP',
        'REMOTE_ADDR',
    ];

    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = trim(explode(',', $_SERVER[$header])[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }

    return '0.0.0.0';
}

$ip = get_ip_visiteur();

// En local, aucune IP publique exploitable n'est disponible pour la géolocalisation.
if ($ip === '127.0.0.1' || $ip === '::1' || $ip === '0.0.0.0') {
    echo json_encode([
        'erreur' => 'Géolocalisation indisponible en environnement local.'
    ]);
    exit;
}

$url_ipinfo = 'https://ipinfo.io/' . urlencode($ip) . '/geo';
$json_brut = file_get_contents($url_ipinfo);

if ($json_brut === false) {
    echo json_encode(['erreur' => 'Impossible de contacter ipinfo.io']);
    exit;
}

$donnees = json_decode($json_brut, true);

if ($donnees === null) {
    echo json_encode(['erreur' => 'Réponse JSON invalide de ipinfo.io']);
    exit;
}

if (isset($donnees['city'])) {
    $ville = $donnees['city'];
} else {
    $ville = '';
}

if (isset($donnees['region'])) {
    $region = $donnees['region'];
} else {
    $region = '';
}

if (isset($donnees['country'])) {
    $pays = $donnees['country'];
} else {
    $pays = '';
}

if (isset($donnees['postal'])) {
    $code_postal = $donnees['postal'];
} else {
    $code_postal = '';
}

$code_dept = '';
if (!empty($code_postal)) {
    $code_dept = substr($code_postal, 0, 2);
}

echo json_encode([
    'ip' => $ip,
    'ville' => $ville,
    'region' => $region,
    'pays' => $pays,
    'cp' => $code_postal,
    'dept' => $code_dept,
]);
