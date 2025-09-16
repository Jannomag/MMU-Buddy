<?php
session_start();

require_once __DIR__ . '/pass.php';

// Prüfen ob Login-Formular abgeschickt wurde
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["password"] === $CONFIG_PASSWORD) {
        $_SESSION["loggedin"] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Falsches Passwort!";
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>MMU|BUDDY - Login</title>
  <link rel="stylesheet" href="style.css">
  <style>
    html, body {
    	margin: 0;
  		padding: 0;
  		height: 90%;
  		width: 100%;
  		overflow: hidden;
        position: fixed;
	}
	</style>
</head>
<body class="login-page">
  <div class="login-container">
    <div class="logo">
    <?xml version="1.0" encoding="UTF-8"?>
      <svg height="50px" version="1.1" viewBox="0 0 139.07 25.024" xmlns="http://www.w3.org/2000/svg">
      <g transform="translate(-24.345 -95.946)" fill="var(--logo-color)" stroke-linecap="round" stroke-linejoin="round">
      <path d="m24.429 95.946c-0.04659 0-0.08423 0.03764-0.08423 0.08423v24.856c0 0.0466 0.03764 0.0837 0.08423 0.0837h54.971c0.04659 0 0.08423-0.0371 0.08423-0.0837v-24.856c0-0.04659-0.03764-0.08423-0.08423-0.08423zm4.2132 4.5532h4.7413l2.7941 12.277 2.7089-12.277h4.7837v15.431h-3.175v-12.023l-2.7301 12.023h-3.175l-2.773-12.023v12.023h-3.175zm16.732 0h4.7413l2.7936 12.277 2.7094-12.277h4.7837v15.431h-3.175v-12.023l-2.7306 12.023h-3.175l-2.7724-12.023v12.023h-3.175zm17.579 0h3.175v10.457c0 1.8627 0.95227 2.7512 2.9419 2.7512s2.9425-0.88858 2.9425-2.7512v-10.457h3.175v10.457c0 4.3603-3.514 5.4606-6.1175 5.4606s-6.1169-1.1003-6.1169-5.4606z" stroke-width="1.8182" style="paint-order:stroke fill markers"/>
      <path d="m83.866 95.946c-0.04659 0-0.08423 0.03764-0.08423 0.08423v24.856c0 0.0466 0.03764 0.0837 0.08423 0.0837h79.461c0.0466 0 0.0842-0.0371 0.0842-0.0837v-24.856c0-0.04659-0.0376-0.08423-0.0842-0.08423zm4.2132 4.5532h6.8792c4.064 0 5.0374 2.6462 5.0374 4.0644 0 1.3123-0.59266 2.2013-2.1167 3.175 1.7357 1.016 2.5611 2.2225 2.5611 3.7465 0 1.8415-1.0796 4.4447-5.4188 4.4447h-6.9422zm14.891 0h3.175v10.457c0 1.8627 0.95227 2.7512 2.9419 2.7512s2.9425-0.88858 2.9425-2.7512v-10.457h3.175v10.457c0 4.3603-3.514 5.4606-6.1175 5.4606-2.6035 0-6.1169-1.1003-6.1169-5.4606zm15.039 0h6.0327c2.3707 0 3.8313 0.52936 4.8684 1.7782 1.2277 1.4605 1.8836 3.5561 1.8836 5.9268 0 2.3918-0.65594 4.4874-1.8836 5.9268-1.0372 1.2488-2.5189 1.7988-4.8684 1.7988h-6.0327zm15.018 0h6.0327c2.3707 0 3.8313 0.52936 4.8684 1.7782 1.2277 1.4605 1.8836 3.5561 1.8836 5.9268 0 2.3918-0.65593 4.4874-1.8836 5.9268-1.0372 1.2488-2.5189 1.7988-4.8684 1.7988h-6.0327zm12.901 0h3.5352l3.1538 6.8156 2.9419-6.8156h3.5564l-4.8896 9.7157v5.7149h-3.175v-5.7149zm-54.673 2.6458v3.4928h3.4499c1.4605 0 2.2438-0.61398 2.2438-1.7358 0-1.143-0.78329-1.757-2.2438-1.757zm29.929 0v10.139h2.8577c2.3918 0 3.577-1.6719 3.577-5.0586 0-3.4078-1.1852-5.0803-3.577-5.0803zm15.018 0v10.139h2.8577c2.3918 0 3.577-1.6719 3.577-5.0586 0-3.4078-1.1852-5.0803-3.577-5.0803zm-44.947 6.1386v4.0003h3.7884c1.5452 0 2.3497-0.69838 2.3497-1.9895 0-1.3123-0.80456-2.0107-2.3497-2.0107z" stroke-width="2.185" style="paint-order:stroke fill markers"/>
      </g>
      </svg>
  </div>
  <br>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
      <label for="password" data-i18n="login_password"></label>
      <input type="password" id="password" name="password" style="font-size:16px;" required>
      <button type="submit" data-i18n="login_button"></button>
    </form>
  </div>
</body>
<script src="script.js"></script>
</html>
