<?php
session_start();
if (empty($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}

// Pfad zur JSON-Datei
$configFile = __DIR__ . "/config.json";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $configFile = 'config.json';
    $config = json_decode(file_get_contents($configFile), true);

    // Slots / Container
    if (isset($_POST['containers'])) {
        $containers = json_decode($_POST['containers'], true);
        $config['containers'] = $containers;
    }

    // Settings
    if (isset($_POST['settings'])) {
        $settings = json_decode($_POST['settings'], true);
        $config['settings'] = $settings;
    }

    file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT));
    echo json_encode(['success' => true]);
    exit;
}

// GET: Daten zurückgeben
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['getSlots'])) {
    if (file_exists($configFile)) {
        $data = file_get_contents($configFile);
        echo $data;
    } else {
        echo json_encode(["containers" => [], "settings" => []]);
    }
    exit;
}
?>


<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meine PWA</title>

  <!-- Favicon (kleinste Android Icons als Fallback) -->
  <link rel="icon" type="image/png" sizes="36x36" href="/icons/android-36x36.png">
  <link rel="icon" type="image/png" sizes="48x48" href="/icons/android-48x48.png">
  <link rel="icon" type="image/png" sizes="72x72" href="/icons/android-72x72.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/icons/android-96x96.png">

  <!-- Apple Touch Icon -->
  <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png" sizes="180x180">

  <!-- Manifest für Android/Browser -->
  <link rel="manifest" href="/manifest.json">

  <!-- Theme Color für Browser-UI -->
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="theme-color" media="(prefers-color-scheme: light)" content="#ffffff">

  <!-- Dunkelmodus -->
  <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#1c1e21">

  <!-- iOS Safari -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">



  <title>MMU|BUDDY</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="header">
  <div class="logo">
    <?xml version="1.0" encoding="UTF-8"?>
      <svg height="30px" version="1.1" viewBox="0 0 139.07 25.024" xmlns="http://www.w3.org/2000/svg">
        <g transform="translate(-24.345 -95.946)" fill="var(--logo-color)" stroke-linecap="round" stroke-linejoin="round">
          <path d="m24.429 95.946c-0.04659 0-0.08423 0.03764-0.08423 0.08423v24.856c0 0.0466 0.03764 0.0837 0.08423 0.0837h54.971c0.04659 0 0.08423-0.0371 0.08423-0.0837v-24.856c0-0.04659-0.03764-0.08423-0.08423-0.08423zm4.2132 4.5532h4.7413l2.7941 12.277 2.7089-12.277h4.7837v15.431h-3.175v-12.023l-2.7301 12.023h-3.175l-2.773-12.023v12.023h-3.175zm16.732 0h4.7413l2.7936 12.277 2.7094-12.277h4.7837v15.431h-3.175v-12.023l-2.7306 12.023h-3.175l-2.7724-12.023v12.023h-3.175zm17.579 0h3.175v10.457c0 1.8627 0.95227 2.7512 2.9419 2.7512s2.9425-0.88858 2.9425-2.7512v-10.457h3.175v10.457c0 4.3603-3.514 5.4606-6.1175 5.4606s-6.1169-1.1003-6.1169-5.4606z" stroke-width="1.8182" style="paint-order:stroke fill markers"/>
          <path d="m83.866 95.946c-0.04659 0-0.08423 0.03764-0.08423 0.08423v24.856c0 0.0466 0.03764 0.0837 0.08423 0.0837h79.461c0.0466 0 0.0842-0.0371 0.0842-0.0837v-24.856c0-0.04659-0.0376-0.08423-0.0842-0.08423zm4.2132 4.5532h6.8792c4.064 0 5.0374 2.6462 5.0374 4.0644 0 1.3123-0.59266 2.2013-2.1167 3.175 1.7357 1.016 2.5611 2.2225 2.5611 3.7465 0 1.8415-1.0796 4.4447-5.4188 4.4447h-6.9422zm14.891 0h3.175v10.457c0 1.8627 0.95227 2.7512 2.9419 2.7512s2.9425-0.88858 2.9425-2.7512v-10.457h3.175v10.457c0 4.3603-3.514 5.4606-6.1175 5.4606-2.6035 0-6.1169-1.1003-6.1169-5.4606zm15.039 0h6.0327c2.3707 0 3.8313 0.52936 4.8684 1.7782 1.2277 1.4605 1.8836 3.5561 1.8836 5.9268 0 2.3918-0.65594 4.4874-1.8836 5.9268-1.0372 1.2488-2.5189 1.7988-4.8684 1.7988h-6.0327zm15.018 0h6.0327c2.3707 0 3.8313 0.52936 4.8684 1.7782 1.2277 1.4605 1.8836 3.5561 1.8836 5.9268 0 2.3918-0.65593 4.4874-1.8836 5.9268-1.0372 1.2488-2.5189 1.7988-4.8684 1.7988h-6.0327zm12.901 0h3.5352l3.1538 6.8156 2.9419-6.8156h3.5564l-4.8896 9.7157v5.7149h-3.175v-5.7149zm-54.673 2.6458v3.4928h3.4499c1.4605 0 2.2438-0.61398 2.2438-1.7358 0-1.143-0.78329-1.757-2.2438-1.757zm29.929 0v10.139h2.8577c2.3918 0 3.577-1.6719 3.577-5.0586 0-3.4078-1.1852-5.0803-3.577-5.0803zm15.018 0v10.139h2.8577c2.3918 0 3.577-1.6719 3.577-5.0586 0-3.4078-1.1852-5.0803-3.577-5.0803zm-44.947 6.1386v4.0003h3.7884c1.5452 0 2.3497-0.69838 2.3497-1.9895 0-1.3123-0.80456-2.0107-2.3497-2.0107z" stroke-width="2.185" style="paint-order:stroke fill markers"/>
        </g>
      </svg>
  </div>
  <nav class="header-actions">
    <a href="logout.php" class="logout-button" title="Logout">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor">
        <path d="M16 13v-2H7V8l-5 4 5 4v-3zM20 3H12v2h8v14h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
      </svg>
    </a>
  </nav>
</header>

<!-- icons -->
<!-- brand icon -->
<svg style="display: none;">
  <symbol id="brand-icon" viewBox="0 0 24 24" fill="var(--icon-secondary)">
    <path fill="var(--color-text)" d="M12 2.001c-5.523 0-10 4.477-10 10 0 1.853.504 3.587 1.383 5.075V11.98A8.617 8.617 0 0 1 12 3.383c7.653 0 11.51 9.296 6.094 14.71-4.11 4.11-10.45 2.879-13.27-1.3v2.164a9.97 9.97 0 0 0 7.181 3.041c5.523 0 10-4.477 10-10s-4.477-10-10-10zm2.647 7.353c-2.351-2.352-6.389-.678-6.389 2.647 0 3.324 4.038 4.998 6.389 2.647a3.743 3.743 0 0 0 0-5.293zM12 9.307a2.693 2.693 0 1 0 0 5.387 2.693 2.693 0 0 0 0-5.387z"></path>
    <path fill="#fa6831" d="M12 3.383c7.653 0 11.51 9.296 6.094 14.71-4.11 4.11-10.45 2.879-13.27-1.3v4.437a.718.718 0 1 1-1.436 0v-9.252a8.617 8.617 0 0 1 8.617-8.597zm2.647 5.971c-2.351-2.352-6.389-.678-6.389 2.647 0 3.324 4.038 4.998 6.389 2.647a3.743 3.743 0 0 0 0-5.293z"></path>
  </symbol>
</svg>
<!-- material icon -->
<svg style="display: none;">
  <symbol id ="material-icon" viewBox="0 0 24 24" width="22" height="22" fill="var(--icon-secondary)">
    <path fill="#fa6831" d="M13.235 11.852c0 4.338.665 3.617-6.822 3.617v.762h12.411c.693 0 1.255.562 1.255 1.257v3.257c0 .693-.562 1.255-1.257 1.255H5.18c-1.618-.018-1.617-2.496 0-2.514h12.408v-.764H5.177a1.255 1.255 0 0 1-1.255-1.257V14.21c0-.693.562-1.255 1.257-1.255h5.565v-1.102h2.492z" image-rendering="optimizeQuality"></path>
    <path fill="var(--color-text)" d="M17.655 2v4.624l-4.016 5.228h-3.322L6.301 6.624V2h2.513v3.77l2.715 3.568h.877l2.739-3.567V2z" image-rendering="optimizeQuality"></path>
  </symbol>
</svg>        
<!-- color icon -->
<svg style="display: none;">
  <symbol id="color-icon" width="22px" height="22px" viewBox="0 0 24 24" fill="none">
    <path opacity="0.1" d="M3 7C3 5.11438 3 4.17157 3.58579 3.58579C4.17157 3 5.11438 3 7 3V3V3C8.88562 3 9.82843 3 10.4142 3.58579C11 4.17157 11 5.11438 11 7V12V17C11 18.8856 11 19.8284 10.4142 20.4142C9.82843 21 8.88562 21 7 21V21V21C5.11438 21 4.17157 21 3.58579 20.4142C3 19.8284 3 18.8856 3 17V12V7Z" fill="var(--icon-secondary)"/>
    <path opacity="0.1" d="M18.7671 13.0317L10.7988 21L16.9998 21C18.8854 21 19.8282 21 20.414 20.4142C20.9998 19.8284 20.9998 18.8856 20.9998 17C20.9998 15.1144 20.9998 14.1716 20.414 13.5858C20.0499 13.2217 19.5478 13.0839 18.7671 13.0317Z" fill="var(--icon-primary)"/>
    <path d="M3 7C3 5.11438 3 4.17157 3.58579 3.58579C4.17157 3 5.11438 3 7 3V3V3C8.88562 3 9.82843 3 10.4142 3.58579C11 4.17157 11 5.11438 11 7V12V17C11 18.8856 11 19.8284 10.4142 20.4142C9.82843 21 8.88562 21 7 21V21V21C5.11438 21 4.17157 21 3.58579 20.4142C3 19.8284 3 18.8856 3 17V12V7Z" stroke="var(--icon-secondary)" stroke-width="2" stroke-linejoin="round" fill="var(--icon-primary)"/>
    <path d="M11 7.5L12.6716 5.82843C14.0049 4.49509 14.6716 3.82843 15.5 3.82843C16.3284 3.82843 16.9951 4.49509 18.3284 5.82843L19.1716 6.67157C20.5049 8.00491 21.1716 8.67157 21.1716 9.5C21.1716 10.3284 20.5049 10.9951 19.1716 12.3284L11 20.5" stroke="var(--icon-secondary)" stroke-width="2" stroke-linejoin="round" />
    <path d="M7 21L17 21C18.8856 21 19.8284 21 20.4142 20.4142C21 19.8284 21 18.8856 21 17L21 15.5C21 15.0353 21 14.803 20.9616 14.6098C20.8038 13.8164 20.1836 13.1962 19.3902 13.0384C19.197 13 18.9647 13 18.5 13V13" stroke="var(--icon-secondary)" stroke-width="2" stroke-linejoin="round" />
    <path d="M7 17.01L7 17" stroke="var(--icon-secondary)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </symbol>
</svg>
<!-- end of icons -->


  <main>
    <div class="slot-container" data-container="1">
      <label>
        <input type="text" class="container-title" placeholder="Printer">
      </label>
      <div class="slots-wrapper">
        <div class="slot" data-slot="1">
          <div class="slot-content">
            <h2 class="slot-title">Slot <span style="color: var(--icon-primary);">1</span></h2>
            <div class="field">
              <label for="brand1" data-i18n="brand"></label>
              <div class="select-wrapper">
                <svg class="icon" viewBox="0 0 24 24" fill="var(--icon-secondary)">
                  <use href="#brand-icon"></use>
                </svg>
              <select id="brand1" class="brand"></select>
              </div>
            </div>
            <div class="field">
            <label for="material1" data-i18n="material"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" width="22" height="22" fill="var(--icon-secondary)">
                <use href="#material-icon"></use>  
              </svg>
              <select id="material1" class="material"></select>
            </div>
          </div>
          <div class="field">
            <label for="color1" data-i18n="color"></label>
            <div class="color-wrapper">
              <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none">
                <use href="#color-icon"></use>
              </svg>
              <!-- Custom Color Display -->
              <div class="color-display" id="colorDisplay1" style="background-color:#ff6600;"></div>
              <!-- Native Input (versteckt, aber klickbar) -->
              <input type="color" id="color1" class="color" value="#ff6600">
            </div>
          </div>
        </div>
      </div>

      <div class="slot" data-slot="2">
        <div class="slot-content">
          <h2 class="slot-title">Slot <span style="color: var(--icon-primary);">2</span></h2>
          <div class="field">
            <label for="brand2" data-i18n="brand"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" fill="var(--icon-secondary)">
                <use href="#brand-icon"></use>
              </svg>
              <select id="brand2" class="brand"></select>
            </div>
          </div>
          <div class="field">
            <label for="material2" data-i18n="material"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" width="22" height="22" fill="var(--icon-secondary)">
                <use href="#material-icon"></use>  
              </svg>
              <select id="material2" class="material"></select>
            </div>
          </div>
          <div class="field">
            <label for="color2" data-i18n="color"></label>
            <div class="color-wrapper">
              <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none">
                <use href="#color-icon"></use>
              </svg>
              <!-- Custom Color Display -->
              <div class="color-display" id="colorDisplay2" style="background-color:#ff6600;"></div>
              <!-- Native Input (versteckt, aber klickbar) -->
              <input type="color" id="color2" class="color" value="#ff6600">
            </div>
          </div>
        </div>
      </div>

      <div class="slot" data-slot="3">
        <div class="slot-content">
          <h2 class="slot-title">Slot <span style="color: var(--icon-primary);">3</span></h2>
          <div class="field">
            <label for="brand3" data-i18n="brand"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" fill="var(--icon-secondary)">
                <use href="#brand-icon"></use>
              </svg>
              <select id="brand3" class="brand"></select>
            </div>
          </div>
          <div class="field">
            <label for="material3" data-i18n="material"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" width="22" height="22" fill="var(--icon-secondary)">
                <use href="#material-icon"></use>  
              </svg>
              <select id="material3" class="material"></select>
            </div>
          </div>
          <div class="field">
            <label for="color3" data-i18n="color"></label>
            <div class="color-wrapper">
              <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none">
                <use href="#color-icon"></use>
              </svg>
              <!-- Custom Color Display -->
              <div class="color-display" id="colorDisplay3" style="background-color:#ff6600;"></div>
              <!-- Native Input (versteckt, aber klickbar) -->
              <input type="color" id="color3" class="color" value="#ff6600">
            </div>
          </div>
        </div>
      </div>

      <div class="slot" data-slot="4">
        <div class="slot-content">
          <h2 class="slot-title">Slot <span style="color: var(--icon-primary);">4</span></h2>
          <div class="field">
            <label for="brand4" data-i18n="brand"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" fill="var(--icon-secondary)">
                <use href="#brand-icon"></use>
              </svg>
              <select id="brand4" class="brand"></select>
            </div>
          </div>
          <div class="field">
            <label for="material4" data-i18n="material"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" width="22" height="22" fill="var(--icon-secondary)">
                <use href="#material-icon"></use>  
              </svg>
              <select id="material4" class="material"></select>
            </div>
          </div>
          <div class="field">
            <label for="color4" data-i18n="color"></label>
            <div class="color-wrapper">
              <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none">
                <use href="#color-icon"></use>
              </svg>
              <!-- Custom Color Display -->
              <div class="color-display" id="colorDisplay4" style="background-color:#ff6600;"></div>
              <!-- Native Input (versteckt, aber klickbar) -->
              <input type="color" id="color4" class="color" value="#ff6600">
            </div>
          </div>
        </div>
      </div>

      <div class="slot" data-slot="5">
        <div class="slot-content">
          <h2 class="slot-title">Slot <span style="color: var(--icon-primary);">5</span></h2>
          <div class="field">
            <label for="brand5" data-i18n="brand"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" fill="var(--icon-secondary)">
                <use href="#brand-icon"></use>
              </svg>
              <select id="brand5" class="brand"></select>
            </div>
          </div>
          <div class="field">
            <label for="material5" data-i18n="material"></label>
            <div class="select-wrapper">
              <svg class="icon" viewBox="0 0 24 24" width="22" height="22" fill="var(--icon-secondary)">
                <use href="#material-icon"></use>  
              </svg>
              <select id="material5" class="material"></select>
            </div>
          </div>
          <div class="field">
            <label for="color5" data-i18n="color"></label>
            <div class="color-wrapper">
              <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none">
                <use href="#color-icon"></use>
              </svg>
              <!-- Custom Color Display -->
              <div class="color-display" id="colorDisplay5" style="background-color:#ff6600;"></div>
              <!-- Native Input (versteckt, aber klickbar) -->
              <input type="color" id="color5" class="color" value="#ff6600">
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>

  </main>


  <script src="script.js"></script>
</body>
</html>
