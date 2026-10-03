<main>

  <section class="page-header">
    <div class="page-header-inner">
      <a href="/index.php<?php echo $lien_plan; ?>" class="lien-retour">← Retour à l'accueil</a>
      <h1>Plan du site</h1>
      <p>Toutes les pages de CarbuMap et comment naviguer entre elles</p>
    </div>
  </section>

  <section class="section-plan">
    <div class="section-inner">

      <div class="plan-description">

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">🏠</span>
            <h2><a href="/index.php<?php echo $chgmt_theme_lang; ?>">Accueil</a></h2>
          </div>
          <p class="plan-page-desc">
            Page d'entrée du site. Elle vous présente une carte interactive de France
            découpée en 13 régions. Vous pouvez cliquer sur votre région pour démarrer
            une recherche de stations. Si vous avez déjà visité le site, votre dernière
            ville consultée vous est proposée directement sous la carte pour y revenir en un clic.
            La page est disponible en français et en anglais.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">🗺️</span>
            <h2><a href="/departement.php?region=IDF&nom=Île-de-France<?php echo $chgmt_theme ? '&' . ltrim($chgmt_theme, '?') : ''; ?>">Départements</a></h2>
          </div>
          <p class="plan-page-desc">
            Après avoir choisi votre région, vous arrivez sur cette page.
            Elle vous affiche tous les départements de la région sous forme de cartes cliquables
            avec leur numéro et leur nom. Vous cliquez sur votre département
            pour accéder à la liste des villes.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">⛽</span>
            <h2><a href="/departement.php?region=IDF<?php echo $chgmt_theme ? '&' . ltrim($chgmt_theme, '?') : ''; ?>">Stations</a></h2>
          </div>
          <p class="plan-page-desc">
            Page principale du site. Vous choisissez votre ville dans une liste déroulante
            puis vous validez pour afficher les stations. Un tableau vous présente les prix
            de chaque station pour les 6 types de carburants : SP95, SP98, Gazole, E10, E85 et GPLc.
            Vous pouvez filtrer les résultats par type de carburant pour n'afficher
            que les stations qui le proposent. Les stations ouvertes 24h/24 sont signalées
            par un badge. Si aucune station n'existe dans la ville que vous avez choisie,
            toutes les stations du département vous sont affichées à la place.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">📈</span>
            <h2><a href="/actualites.php<?php echo $chgmt_theme; ?>">Actualités</a></h2>
          </div>
          <p class="plan-page-desc">
            Cette page détecte automatiquement votre département via votre adresse IP
            et vous affiche les prix moyens des carburants dans votre département.
            Des indicateurs vous montrent si les prix ont augmenté, baissé ou sont stables
            depuis votre dernière visite. Dans le tableau des stations,
            les prix inférieurs à la moyenne apparaissent en vert
            et les prix supérieurs en rouge.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">📊</span>
            <h2><a href="/stats.php<?php echo $chgmt_theme; ?>">Statistiques</a></h2>
          </div>
          <p class="plan-page-desc">
            Cette page vous affiche un histogramme des villes les plus recherchées sur CarbuMap
            par l'ensemble des visiteurs du site. Trois chiffres clés sont mis en avant :
            le nombre total de recherches effectuées, le nombre de villes différentes consultées
            et la ville la plus populaire.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">🔧</span>
            <h2><a href="/tech.php<?php echo $chgmt_theme; ?>">Page technique</a></h2>
          </div>
          <p class="plan-page-desc">
            Cette page vous présente les APIs utilisées sur le site. Elle vous affiche
            un film du studio Ghibli choisi aléatoirement à chaque rechargement,
            avec son affiche, sa bannière, son titre en japonais, son année de sortie et sa description.
            Elle vous indique également votre position géographique approximative
            estimée depuis votre adresse IP, ainsi que des informations sur votre connexion.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">💬</span>
            <h2><a href="/contact.php<?php echo $chgmt_theme; ?>">Contact & FAQ</a></h2>
          </div>
          <p class="plan-page-desc">
            Cette page vous présente l'équipe du projet et répond aux questions
            que vous vous posez le plus souvent sur le site : origine des données,
            fiabilité des prix, fonctionnement de la géolocalisation, confidentialité, etc.
            Vous pouvez également contacter les membres de l'équipe par email depuis cette page.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">🗂️</span>
            <h2><a href="/plan.php<?php echo $chgmt_theme_lang; ?>">Plan du site</a></h2>
          </div>
          <p class="plan-page-desc">
            La page que vous consultez en ce moment. Elle vous décrit chaque page du site
            et vous explique comment naviguer entre elles.
            Elle est disponible en français et en anglais.
          </p>
        </div>

      </div>

      <!-- navigation entre les pages -->
      <div class="plan-recap">
        <h2 class="plan-recap-titre">Navigation entre les pages</h2>
        <table class="plan-table">
          <thead>
            <tr>
              <th>Depuis</th>
              <th>Action</th>
              <th>Vers</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Accueil</td>
              <td>Cliquez sur une région de la carte</td>
              <td>Départements</td>
            </tr>
            <tr>
              <td>Accueil</td>
              <td>Cliquez sur votre dernière ville consultée</td>
              <td>Stations (directement)</td>
            </tr>
            <tr>
              <td>Départements</td>
              <td>Cliquez sur un département</td>
              <td>Stations</td>
            </tr>
            <tr>
              <td>Départements</td>
              <td>Cliquez sur le lien retour</td>
              <td>Accueil</td>
            </tr>
            <tr>
              <td>Stations</td>
              <td>Choisissez une ville et validez</td>
              <td>Résultats sur la même page</td>
            </tr>
            <tr>
              <td>Stations</td>
              <td>Cliquez sur le lien retour</td>
              <td>Départements</td>
            </tr>
            <tr>
              <td>Toutes les pages</td>
              <td>Menu de navigation en haut</td>
              <td>Accueil / Actualités / Statistiques / Contact</td>
            </tr>
            <tr>
              <td>Toutes les pages</td>
              <td>Cliquez sur le logo CarbuMap</td>
              <td>Accueil</td>
            </tr>
            <tr>
              <td>Toutes les pages</td>
              <td>Bouton 🌙 / ☀️ en haut à droite</td>
              <td>Même page en thème nuit ou jour</td>
            </tr>
            <tr>
              <td>Toutes les pages</td>
              <td>Liens dans le footer</td>
              <td>Page technique / Plan du site</td>
            </tr>
            <tr>
              <td>Accueil / Plan du site</td>
              <td>Sélecteur de langue FR / EN</td>
              <td>Même page dans l'autre langue</td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </section>

</main>