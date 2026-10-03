<?php
$titre_page = 'Contact & FAQ';
require_once 'includes/header.php';
?>

<main>

  <section class="page-header">
    <div class="page-header-inner">
      <a href="/index.php" class="lien-retour">← Retour à l'accueil</a>
      <h1>Contact & FAQ</h1>
      <p>Questions fréquentes et présentation de l'équipe</p>
    </div>
  </section>

  <div class="section-inner faq-contenu">

    <!-- equipe -->
    <section class="faq-section">

      <h2 class="faq-section-titre">L'équipe</h2>
      <p class="faq-section-desc">
        CarbuMap est un projet fait en binôme dans le cadre de l'UE de développement web L2-I S4 à Cergy Paris Université.
      </p>

      <div class="equipe-grille">

        <div class="equipe-card">
          <div class="equipe-avatar">RM</div>
          <div class="equipe-infos">
            <h3 class="equipe-nom">Rayan Moulai</h3>
            <p class="equipe-role">Back-end & APIs</p>
            <p class="equipe-desc">
              PHP côté serveur, appels aux APIs carburants et géolocalisation, gestion des fichiers CSV, réalisation map.
            </p>
            <div class="equipe-tags">
              <span class="equipe-tag">PHP</span>
              <span class="equipe-tag">APIs</span>
              <span class="equipe-tag">CSV</span>
              <span class="equipe-tag">JSON</span>
            </div>
          </div>
        </div>

        <div class="equipe-card">
          <div class="equipe-avatar">SA</div>
          <div class="equipe-infos">
            <h3 class="equipe-nom">Salma Anoud</h3>
            <p class="equipe-role">Front-end & Design</p>
            <p class="equipe-desc">
              Design du site, HTML/CSS, PHP côté serveur, thème jour/nuit.
            </p>
            <div class="equipe-tags">
              <span class="equipe-tag">HTML5</span>
              <span class="equipe-tag">CSS3</span>
              <span class="equipe-tag">Design</span>
            </div>
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
              <p>Régions, départements et communes viennent des fichiers CSV de l'INSEE sur data.gouv.fr.</p>
            </div>
          </div>
          <div class="gestion-item">
            <span class="gestion-icone">📊</span>
            <div>
              <strong>Statistiques</strong>
              <p>Les villes cherchées sont enregistrées de façon anonyme dans un CSV pour la page stats.</p>
            </div>
          </div>
          <div class="gestion-item">
            <span class="gestion-icone">🔒</span>
            <div>
              <strong>Confidentialité</strong>
              <p>On ne stocke aucune donnée personnelle.</p>
            </div>
          </div>
        </div>
      </div>

    </section>

    <!-- FAQ -->
    <section class="faq-section">

      <h2 class="faq-section-titre">Questions fréquentes</h2>
      <p class="faq-section-desc">Les questions qu'on nous pose le plus souvent.</p>

      <div class="faq-liste">

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> D'où viennent les prix ?</h3>
          <p class="faq-reponse">
            De l'API officielle du gouvernement (data.economie.gouv.fr), les mêmes données que sur prix-carburants.gouv.fr.
            Ce sont les stations elles-mêmes qui mettent à jour leurs prix.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Les prix sont-ils fiables ?</h3>
          <p class="faq-reponse">
            Ce sont les dernières données transmises par les stations. Il peut y avoir un petit décalage
            si une station n'a pas encore mis à jour son prix.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Comment marche la géolocalisation ?</h3>
          <p class="faq-reponse">
            On utilise votre adresse IP via ipinfo.io pour estimer votre position.
            C'est approximatif, pas besoin d'accès GPS.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Quels carburants sont affichés ?</h3>
          <p class="faq-reponse">
            SP95, SP98, Gazole, E10, E85 et GPLc. Toutes les stations ne proposent pas tous ces types.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Comment chercher une station ?</h3>
          <p class="faq-reponse">
            Cliquez sur votre région sur la carte, choisissez votre département, puis votre ville dans la liste.
            Les stations s'affichent ensuite avec leurs prix.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Pas de station dans ma ville ?</h3>
          <p class="faq-reponse">
            Si on ne trouve aucune station dans votre ville, on affiche toutes celles du département
            avec leur ville indiquée pour que vous puissiez trouver la plus proche.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> C'est quoi les prix en vert et rouge ?</h3>
          <p class="faq-reponse">
            Sur la page Actualités, le vert veut dire que le prix est en dessous de la moyenne du département,
            le rouge qu'il est au-dessus.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Comment changer le thème ?</h3>
          <p class="faq-reponse">
            Cliquez sur le bouton 🌙 ou ☀️ en haut à droite.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> C'est quoi les tendances ?</h3>
          <p class="faq-reponse">
            La page Actualités compare les prix actuels avec ceux de votre dernière visite.
            ↑ hausse, ↓ baisse, → stable. Disponible à partir de la deuxième visite.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Mes données sont collectées ?</h3>
          <p class="faq-reponse">
            Non. On enregistre seulement la ville cherchée et l'heure, de façon anonyme, pour les stats.
            Pas de compte, pas de données personnelles.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> Combien de stations ?</h3>
          <p class="faq-reponse">
            Plus de 11 000 stations en France métropolitaine dans les 13 régions.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> C'est quoi le badge 24h/24 ?</h3>
          <p class="faq-reponse">
            La station a un automate en libre-service, on peut faire le plein même la nuit.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> C'est quoi la page technique ?</h3>
          <p class="faq-reponse">
            Une page qui montre les APIs utilisées : un film Ghibli aléatoire et votre position estimée par IP.
          </p>
        </div>

        <div class="faq-item">
          <h3 class="faq-question"><span class="faq-slash">///</span> C'est gratuit ?</h3>
          <p class="faq-reponse">
            Oui, totalement. C'est un projet universitaire fait par deux étudiants en L2 Informatique à Cergy.
          </p>
        </div>

      </div>
    </section>

    <!-- contact -->
    <section class="faq-section">

      <h2 class="faq-section-titre">Nous contacter</h2>
      <p class="faq-section-desc">Un bug à signaler ou une question ? Écrivez-nous.</p>

      <div class="contact-grille">
        <div class="contact-card">
          <span class="contact-icone">📧</span>
          <h3>Rayan Moulai</h3>
          <p>rayan.moulai@etu-cyu.fr</p>
        </div>
        <div class="contact-card">
          <span class="contact-icone">📧</span>
          <h3>Salma Anoud</h3>
          <p>salma.anoud@etu-cyu.fr</p>
        </div>
        <div class="contact-card">
          <span class="contact-icone">🏫</span>
          <h3>Université</h3>
          <p>Cergy Paris Université — L2 Informatique S4</p>
        </div>
      </div>

    </section>

  </div>

</main>

<?php require_once 'includes/footer.php'; ?>