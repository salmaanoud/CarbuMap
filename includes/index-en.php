<main>

  <section class="hero">
    <h1>Find the cheapest fuel near you</h1>
    <p>
      Choose your region on the map, select your city
      and compare prices at nearby stations.
    </p>
  </section>

  <div class="section-bienvenue">
    <div class="bienvenue-inner">
      <p>
        Welcome to <strong>CarbuMap</strong>, your fuel price comparator
        in metropolitan France. Our site retrieves real-time prices from over
        <strong>11,000 service stations</strong> through the official French
        government API available at <em>data.economie.gouv.fr</em>.
        Data is submitted directly by the stations themselves
        and regularly updated.
      </p>
      <br>
      <p>
        Whether you need <strong>SP95</strong>, <strong>SP98</strong>,
        <strong>Diesel</strong>, <strong>E10</strong>, <strong>E85</strong>
        or <strong>LPG</strong>, CarbuMap helps you quickly find
        the cheapest station near you.
      </p>
      <br>
      <br>
      <p>
        <strong>CarbuMap</strong> is a university project developed by a team of two as part
        of the Web Development course in L2 Computer Science at CY Cergy Paris University (2025-2026).
        It uses HTML5, CSS3 and PHP8 technologies and relies on several APIs
        to retrieve real-time data. Its goal is to help drivers quickly find
        the cheapest fuel station near them.
      </p>
      <p class="info-cookie">
        This site uses cookies 🍪 to remember your preferences:
        day/night theme and last visited city.
        No personal data is collected.
      </p>
    </div>
  </div>

  <section class="section-carte" id="carte">
    <div class="section-carte-inner">

      <div class="section-titre">
        <h2>Choose your region</h2>
        <p>Click on a region to see fuel prices</p>
      </div>

      <div class="carte-wrapper">
        <div class="carte-container">

          <img
            src="/images/carte-regions.png"
            usemap="#carte-france"
            alt="Map of the 13 regions of France. Click on a region to search for stations."
            width="800"
            height="847"
          >


          <?php
          if ($theme_actuel === 'nuit') {
              $theme_carte = '&theme=nuit';
          } else {
              $theme_carte = '';
          }
          ?>

          <map name="carte-france" id="carte-france">
            <area target="_self" alt="Bretagne" title="Bretagne"
              href="/departement.php?region=BRE&amp;nom=Bretagne<?php echo $theme_carte; ?>"
              shape="poly" coords="27,229,37,228,45,219,52,219,69,214,69,220,76,218,92,218,96,204,110,208,120,216,130,225,133,230,137,236,150,226,170,230,185,236,196,229,212,239,221,239,227,253,229,271,226,287,217,295,202,297,187,305,169,312,160,323,128,315,111,305,93,297,72,291,46,286,39,274,49,266,59,253,42,235">
            <area target="_self" alt="Normandie" title="Normandie"
              href="/departement.php?region=NOR&amp;nom=Normandie<?php echo $theme_carte; ?>"
              shape="poly" coords="192,133,212,139,218,136,232,168,252,170,283,175,309,163,301,152,320,129,352,118,369,105,390,128,385,146,389,174,384,184,377,193,372,206,366,217,351,219,339,222,338,229,342,243,342,253,331,259,318,264,308,248,301,242,291,250,278,237,262,241,244,244,228,236,210,240,207,230,215,225,208,217,205,204,207,193,204,172,192,157">
            <area target="_self" alt="Hauts-de-France" title="Hauts-de-France"
              href="/departement.php?region=HDF&amp;nom=Hauts-de-France<?php echo $theme_carte; ?>"
              shape="poly" coords="381,55,392,33,425,18,432,34,449,46,459,46,476,71,492,76,495,86,516,86,521,107,519,116,519,131,509,145,512,159,498,164,494,172,495,183,492,191,489,201,484,206,468,196,464,188,449,190,436,190,421,183,408,183,390,182,384,170,386,152,392,138,381,116,372,104,379,97,382,86,386,62">
            <area target="_self" alt="Île-de-France" title="Île-de-France"
              href="/departement.php?region=IDF&amp;nom=Ile-de-France<?php echo $theme_carte; ?>"
              shape="poly" coords="373,194,376,214,378,231,387,238,388,247,396,249,399,259,420,258,431,270,423,278,455,272,462,259,472,256,482,241,486,233,477,219,480,211,471,199,466,193,451,192,436,190,419,184,392,183">
            <area target="_self" alt="Grand Est" title="Grand Est"
              href="/departement.php?region=GES&amp;nom=Grand+Est<?php echo $theme_carte; ?>"
              shape="poly" coords="527,118,523,136,517,142,514,157,501,164,492,174,496,190,491,203,481,224,487,235,483,250,489,263,501,276,510,291,555,285,566,298,569,311,596,319,607,306,619,295,632,283,643,287,671,291,685,308,692,326,711,328,713,310,711,290,716,263,722,240,722,211,734,203,739,189,713,190,701,177,688,180,674,178,655,174,648,155,633,154,618,154,601,151,585,149,577,138,553,128,556,94,540,118">
            <area target="_self" alt="Pays de la Loire" title="Pays de la Loire"
              href="/departement.php?region=PDL&amp;nom=Pays+de+la+Loire<?php echo $theme_carte; ?>"
              shape="poly" coords="231,239,243,246,252,246,269,241,276,238,284,249,300,245,311,258,323,266,331,272,333,290,319,307,314,319,303,324,296,346,282,365,270,366,248,371,236,380,248,422,243,433,223,432,201,427,180,410,167,391,174,373,165,360,176,347,166,339,152,343,145,335,167,325,181,309,198,302,210,300,231,278,227,255">
            <area target="_self" alt="Centre-Val de Loire" title="Centre-Val de Loire"
              href="/departement.php?region=CVL&amp;nom=Centre-Val+de+Loire<?php echo $theme_carte; ?>"
              shape="poly" coords="330,229,350,222,370,206,378,227,388,244,397,253,402,263,422,263,427,277,456,277,460,299,457,309,449,314,454,330,455,349,459,373,460,392,447,401,432,408,432,417,421,424,378,429,353,427,339,405,318,381,304,375,292,359,299,325,318,320,336,298,336,280,334,260,345,241">
            <area target="_self" alt="Bourgogne-Franche-Comté" title="Bourgogne-Franche-Comté"
              href="/departement.php?region=BFC&amp;nom=Bourgogne-Franche-Comte<?php echo $theme_carte; ?>"
              shape="poly" coords="463,292,456,276,461,260,477,252,490,268,497,276,505,291,548,289,559,289,569,305,585,322,598,316,609,309,627,286,646,286,664,288,681,301,685,316,678,334,681,350,658,375,652,390,636,418,628,430,620,435,611,433,605,436,594,432,590,419,573,419,567,436,548,437,537,443,514,442,520,426,503,414,494,394,489,401,474,402,465,396,462,379,457,360,451,346,451,326,456,310">
            <area target="_self" alt="Nouvelle-Aquitaine" title="Nouvelle-Aquitaine"
              href="/departement.php?region=NAQ&amp;nom=Nouvelle-Aquitaine<?php echo $theme_carte; ?>"
              shape="poly" coords="246,377,261,368,283,368,295,368,302,381,316,380,321,383,333,396,340,412,353,425,359,431,385,428,404,428,418,431,426,443,435,463,427,476,426,486,430,505,431,519,420,525,411,540,407,550,399,556,374,559,364,569,349,589,335,607,333,625,316,641,301,641,284,646,264,648,264,664,264,674,270,679,278,696,274,712,266,732,258,737,242,743,225,728,208,728,195,716,181,698,189,676,194,645,201,616,207,596,219,583,213,569,209,564,214,521,216,503,230,525,238,530,239,520,227,502,213,489,221,469,221,452,226,429,240,434,255,430,251,414,245,390">
            <area target="_self" alt="Auvergne-Rhône-Alpes" title="Auvergne-Rhône-Alpes"
              href="/departement.php?region=ARA&amp;nom=Auvergne-Rhone-Alpes<?php echo $theme_carte; ?>"
              shape="poly" coords="420,528,408,559,407,583,432,585,443,562,456,582,467,564,486,565,500,569,514,592,529,613,552,613,574,615,599,618,614,625,622,613,610,603,619,587,631,573,648,561,657,558,651,541,679,534,702,516,692,500,679,482,690,468,673,441,672,427,658,429,655,438,646,452,630,450,639,435,624,435,609,435,593,438,586,417,572,422,568,441,538,438,534,447,518,447,508,444,520,423,506,418,494,401,488,406,467,404,461,400,440,408,431,420,422,426,433,449,435,469,427,482,432,501,433,527">
            <area target="_self" alt="Occitanie" title="Occitanie"
              href="/departement.php?region=OCC&amp;nom=Occitanie<?php echo $theme_carte; ?>"
              shape="poly" coords="363,576,375,555,387,560,395,557,402,575,408,587,420,587,446,563,455,583,476,559,494,566,511,583,533,619,551,619,570,639,558,669,546,682,537,687,526,682,495,704,483,708,463,727,459,743,463,763,467,782,432,788,403,787,390,779,387,770,367,764,354,756,317,743,314,757,293,755,271,755,256,742,264,734,270,718,272,710,272,678,256,675,270,651,291,646,311,639,327,633,334,613,343,607,340,594,352,583">
            <area target="_self" alt="Provence-Alpes-Côte d'Azur" title="Provence-Alpes-Côte d'Azur"
              href="/departement.php?region=PAC&amp;nom=Provence-Alpes-Cote-d-Azur<?php echo $theme_carte; ?>"
              shape="poly" coords="562,614,564,636,571,642,563,651,557,669,548,676,542,684,561,696,574,694,582,697,611,697,611,708,632,718,649,720,667,716,684,706,680,701,694,684,704,672,725,657,734,646,740,631,740,619,728,628,705,616,692,602,685,585,698,568,680,557,670,541,652,538,659,555,658,565,641,566,632,573,626,580,619,591,610,602,624,617,611,625,591,622,582,616,569,618">
            <area target="_self" alt="Corse" title="Corse"
              href="/departement.php?region=COR&amp;nom=Corse<?php echo $theme_carte; ?>"
              shape="poly" coords="737,714,749,713,751,688,758,719,761,736,763,757,757,774,757,798,753,808,751,822,739,819,728,812,734,803,722,799,725,791,718,778,717,767,708,758,715,752,708,739,714,728,725,721">
          </map>

        </div>

        <aside class="carte-legende">
          <h3>Regions</h3>
          <?php
          $regions = [
            'ARA' => 'Auvergne-Rhône-Alpes',
            'BFC' => 'Bourgogne-Franche-Comté',
            'BRE' => 'Bretagne',
            'CVL' => 'Centre-Val de Loire',
            'COR' => 'Corse',
            'GES' => 'Grand Est',
            'HDF' => 'Hauts-de-France',
            'IDF' => 'Île-de-France',
            'NOR' => 'Normandie',
            'NAQ' => 'Nouvelle-Aquitaine',
            'OCC' => 'Occitanie',
            'PDL' => 'Pays de la Loire',
            'PAC' => "Provence-Alpes-Côte d'Azur",
          ];
          foreach ($regions as $code => $nom):
          ?>
            <a class="legende-item" href="/departement.php?region=<?php echo $code; ?>&amp;nom=<?php echo urlencode($nom); ?><?php echo $theme_carte; ?>">
              <span class="legende-puce"></span>
              <span><?php echo htmlspecialchars($nom); ?></span>
            </a>
          <?php endforeach; ?>
        </aside>

      </div>

      <!-- info text below map — always shown -->
      <p class="carte-info">
        The map shows the 13 regions of metropolitan France. Prices are updated
        in real time from the official government API. Over 11,000 service stations
        are listed across the country.
      </p>

      <!-- last visited city -->
      <?php
      $c_insee = isset($_COOKIE['carbumap_ville_insee']) ? $_COOKIE['carbumap_ville_insee'] : '';
      $c_dept = isset($_COOKIE['carbumap_dept'])        ? $_COOKIE['carbumap_dept']        : '';
      $c_nom_dept= isset($_COOKIE['carbumap_nom_dept'])    ? $_COOKIE['carbumap_nom_dept']    : '';
      $c_region= isset($_COOKIE['carbumap_region'])      ? $_COOKIE['carbumap_region']      : '';
      $c_ville = isset($_COOKIE['carbumap_ville_nom'])   ? $_COOKIE['carbumap_ville_nom']   : '';

      if (!empty($c_insee) && !empty($c_dept)):
      ?>
        <div class="derniere-ville">
          <p>
            Your last fuel station search was in
            <a href="/departement.php?region=<?php echo urlencode($c_region); ?>&amp;nom=<?php echo urlencode($c_region); ?>&amp;dept=<?php echo urlencode($c_dept); ?>&amp;nom_dept=<?php echo urlencode($c_nom_dept); ?>&amp;ville_insee=<?php echo urlencode($c_insee); ?><?php echo $theme_carte; ?>">
              <strong><?php echo htmlspecialchars($c_ville); ?></strong>
              (<?php echo htmlspecialchars($c_dept); ?>)
              — See fuel prices →
            </a>
          </p>
        </div>
      <?php endif; ?>

    </div>
  </section>

</main>