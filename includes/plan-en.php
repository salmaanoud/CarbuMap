<main>

  <section class="page-header">
    <div class="page-header-inner">
      <a href="/index.php<?php echo $lien_plan; ?>" class="lien-retour">← Back to home</a>
      <h1>Site map</h1>
      <p>All pages of CarbuMap and how to navigate between them</p>
    </div>
  </section>

  <section class="section-plan">
    <div class="section-inner">

      <div class="plan-description">

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">🏠</span>
            <h2><a href="/index.php<?php echo $chgmt_theme_lang; ?>">Home</a></h2>
          </div>
          <p class="plan-page-desc">
            Entry page of the site. It shows you an interactive map of France divided into 13 regions.
            You can click on your region to start searching for stations.
            If you have already visited the site, your last searched city is suggested
            directly below the map so you can go back in one click.
            The page is available in French and English.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">🗺️</span>
            <h2><a href="/departement.php?region=IDF&nom=Île-de-France<?php echo $chgmt_theme ? '&' . ltrim($chgmt_theme, '?') : ''; ?>">Departments</a></h2>
          </div>
          <p class="plan-page-desc">
            After choosing your region, you arrive on this page.
            It shows you all the departments in the region as clickable cards
            with their number and name. You click on your department
            to access the list of cities.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">⛽</span>
            <h2><a href="/departement.php?region=IDF<?php echo $chgmt_theme ? '&' . ltrim($chgmt_theme, '?') : ''; ?>">Stations</a></h2>
          </div>
          <p class="plan-page-desc">
            Main page of the site. You choose your city from a dropdown list
            then submit to display stations. A table shows you the prices
            at each station for the 6 fuel types: SP95, SP98, Diesel, E10, E85 and LPG.
            You can filter the results by fuel type to show only stations offering it.
            Stations open 24/7 are marked with a badge. If no station exists
            in the city you chose, all stations in the department are shown to you instead.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">📈</span>
            <h2><a href="/actualites.php<?php echo $chgmt_theme; ?>">News</a></h2>
          </div>
          <p class="plan-page-desc">
            This page automatically detects your department via your IP address
            and shows you the average fuel prices in your department.
            Indicators show you whether prices have gone up, down or stayed the same
            since your last visit. In the station table,
            prices below average appear in green and prices above in red.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">📊</span>
            <h2><a href="/stats.php<?php echo $chgmt_theme; ?>">Statistics</a></h2>
          </div>
          <p class="plan-page-desc">
            This page shows you a histogram of the most searched cities on CarbuMap
            across all visitors. Three key figures are highlighted for you:
            the total number of searches performed, the number of different cities searched
            and the most popular city on the site.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">🔧</span>
            <h2><a href="/tech.php<?php echo $chgmt_theme; ?>">Technical page</a></h2>
          </div>
          <p class="plan-page-desc">
            This page shows you the APIs used on the site. It displays
            a randomly selected Studio Ghibli film on each reload,
            with its poster, banner, Japanese title, release year and description.
            It also shows you your approximate geographic location estimated from your IP address,
            as well as information about your connection.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">💬</span>
            <h2><a href="/contact.php<?php echo $chgmt_theme; ?>">Contact & FAQ</a></h2>
          </div>
          <p class="plan-page-desc">
            This page introduces you to the project team and answers the questions
            you ask most often about the site: where the data comes from,
            price reliability, how geolocation works, privacy, and more.
            You can also contact the team members by email directly from this page.
          </p>
        </div>

        <div class="plan-page-bloc">
          <div class="plan-page-header">
            <span class="plan-icone">🗂️</span>
            <h2><a href="/plan.php<?php echo $chgmt_theme_lang; ?>">Site map</a></h2>
          </div>
          <p class="plan-page-desc">
            The page you are currently viewing. It describes each page of the site
            and explains how to navigate between them.
            Available in French and English.
          </p>
        </div>

      </div>

      <!-- navigation between pages -->
      <div class="plan-recap">
        <h2 class="plan-recap-titre">Navigation between pages</h2>
        <table class="plan-table">
          <thead>
            <tr>
              <th>From</th>
              <th>Action</th>
              <th>To</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Home</td>
              <td>Click on a region on the map</td>
              <td>Departments</td>
            </tr>
            <tr>
              <td>Home</td>
              <td>Click on your last visited city</td>
              <td>Stations (directly)</td>
            </tr>
            <tr>
              <td>Departments</td>
              <td>Click on a department</td>
              <td>Stations</td>
            </tr>
            <tr>
              <td>Departments</td>
              <td>Click the back link</td>
              <td>Home</td>
            </tr>
            <tr>
              <td>Stations</td>
              <td>Choose a city and submit</td>
              <td>Results on the same page</td>
            </tr>
            <tr>
              <td>Stations</td>
              <td>Click the back link</td>
              <td>Departments</td>
            </tr>
            <tr>
              <td>All pages</td>
              <td>Navigation menu at the top</td>
              <td>Home / News / Statistics / Contact</td>
            </tr>
            <tr>
              <td>All pages</td>
              <td>Click on the CarbuMap logo</td>
              <td>Home</td>
            </tr>
            <tr>
              <td>All pages</td>
              <td>🌙 / ☀️ button at the top right</td>
              <td>Same page in night or day theme</td>
            </tr>
            <tr>
              <td>All pages</td>
              <td>Links in the footer</td>
              <td>Technical page / Site map</td>
            </tr>
            <tr>
              <td>Home / Site map</td>
              <td>FR / EN language selector</td>
              <td>Same page in the other language</td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </section>

</main>