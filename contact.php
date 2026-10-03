<?php
$titre_page = 'Contact & FAQ';
require_once 'includes/header.php';
?>

<main>

  <section class="page-header">
    <div class="page-header-inner">
      <a href="/index.php" class="lien-retour">← Retour à l'accueil</a>
      <h1>À propos & FAQ</h1>
      <p>Questions fréquentes et présentation du projet</p>
    </div>
  </section>

  <div class="section-inner faq-contenu">

    <!-- equipe -->
    <section class="faq-section">

      <h2 class="faq-section-titre">Le projet</h2>
      <p class="faq-section-desc">
        CarbuMap est un projet réalisé en binôme dans le cadre de l'UE Développement Web de L2 Informatique à CY Cergy Paris Université.
      </p>

      <div class="equipe-grille">
        <div class="equipe-card">
          <div class="equipe-avatar">SA</div>
          <div class="equipe-infos">
            <h3 class="equipe-nom">Salma Anoud</h3>
            <p class="equipe-role">Développement du projet</p>
            <p class="equipe-desc">Participation à la conception et au développement de l'application web.</p>
          </div>
        </div>

        <div class="equipe-card">
          <div class="equipe-avatar">RM</div>
          <div class="equipe-infos">
            <h3 class="equipe-nom">Rayan Moulai</h3>
            <p class="equipe-role">Développement du projet</p>
            <p class="equipe-desc">Participation à la conception et au développement de l'application web.</p>
          </div>
        </div>
      </div>

      <div class="gestion-bloc">
        <h3 class="gestion-titre">Comment ça marche</h3>
        <div class="gestion-grille">
          <div class="gestion-item">
            <span class="gestion-icone">⛽</span>
            <div>
              <strong>Prix carburants</strong>
              <p>Récupérés en temps réel depuis l'API officielle du gouvernement sur data.economie.gouv.fr.</p>
            </div>
          </div>
          <div class="gestion-item">
            <span class="gestion-icone">🗺️</span>
            <div>
              <strong>Données géographiques</strong>
              <p>Régions, départements et communes viennent de fichiers de données publiques.</p>
            </div>
          </div>
          <div class="gestion-item">
            <span class="gestion-icone">📊</span>
            <div>
              <strong>Statistiques</strong>
              <p>Les villes recherchées sont enregistrées de façon anonyme dans un CSV pour la page statistiques.</p>
            </div>
          </div>
          <div class="gestion-item">
            <span class="gestion-icone">🔒</span>
            <div>
              <strong>Confidentialité</strong>
              <p>Aucune donnée personnelle n'est stockée par l'application.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="faq-section">
      <h2 class="faq-section-titre">Questions fréquentes</h2>
      <p class="faq-section-desc">Quelques informations sur le fonctionnement de CarbuMap.</p>

      <div class="faq-liste">
        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> D'où viennent les prix ?</h3>
          <p class="faq-reponse">De l'API officielle du gouvernement sur data.economie.gouv.fr. Les données correspondent aux prix transmis par les stations.</p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Les prix sont-ils fiables ?</h3>
          <p class="faq-reponse">Ce sont les dernières données disponibles transmises par les stations. Un décalage peut exister lorsqu'une station n'a pas encore actualisé ses prix.</p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Comment fonctionne la géolocalisation ?</h3>
          <p class="faq-reponse">L'application utilise l'adresse IP via ipinfo.io pour estimer une position. Cette estimation reste approximative et ne nécessite pas l'accès au GPS.</p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Quels carburants sont affichés ?</h3>
          <p class="faq-reponse">SP95, SP98, Gazole, E10, E85 et GPLc selon les carburants proposés par chaque station.</p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Comment chercher une station ?</h3>
          <p class="faq-reponse">Sélectionnez une région sur la carte, puis un département et une ville. Les stations disponibles et leurs prix sont ensuite affichés.</p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Comment changer le thème ?</h3>
          <p class="faq-reponse">Le bouton 🌙 ou ☀️ en haut de la page permet de passer du thème clair au thème sombre.</p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> À quoi sert la page technique ?</h3>
          <p class="faq-reponse">Elle présente plusieurs exemples d'utilisation d'APIs et de formats de données intégrés au projet.</p>
        </div>
      </div>
    </section>

  </div>

</main>

<?php require_once 'includes/footer.php'; ?>