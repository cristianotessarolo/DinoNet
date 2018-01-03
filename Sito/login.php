<?php
	$homepath = substr( $_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME']) );
	if (strpos($_SERVER['SCRIPT_NAME'], 'TecWeb') !== false) {
		$homepath .= "/TecWeb";
	}
	//$homepath = $_SERVER["DOCUMENT_ROOT"];

	include_once ($homepath . "/connect.php");
	include_once ($homepath . "/classi/User.php");

	session_start();
	
	if(isset($_SESSION['user'])){	
		session_unset();
	}

	if(isset($_POST['email']) && isset($_POST["password"])){
		session_unset();
		if(User::login($_POST["email"],$_POST["password"],'0')){
			$_SESSION['user'] = new User($_POST['email']);
			header("Location: index.php");
		}	
	}
?>
<!DOCTYPE html>
<html xml:lang="it-IT" lang="it-IT">
<head>
	<title>Accesso | Dino Net</title>
	<meta name="description" content="Descrizione">
	<meta name="author" content="Alessandro Zangari, Cristiano Tessarolo, Matteo Rizzo">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/index.css">
    <link type="text/css" rel="stylesheet" href="css/print.css" media="print">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Chelsea+Market">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	
	<!-- Favicon -->
	
	<link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
	<link rel="manifest" href="img/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="img/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
</head>

<!-- Body -->

<body>

<?php include_once('loading.php') ?>

<?php include_once('menu.php') ?>

<div id="main" class="main">

    <!-- Topbar -->

    <?php include_once('topbar.php') ?>

    <!-- /Topbar -->

<!-- Header -->

<header id="header-home" class="parallax padding-6">
	<div class="content">
		<div id="title-card" class="card">
			<h1> Accedi al tuo account </h1>
			<h2>Entra nel mondo dei dinosauri!</h2>
		</div>
		
		<!-- Login -->

		<div id="login">
			<div class="card colored wrap-padding">
				<form action="#" method="POST">
					<p><label for="input-email" xml:lang="en" lang="en">email</label></p>
					<input id="input-email" type="text" placeholder="email" name="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>">
					<p><label for="input-passw" xml:lang="en" lang="en">password</label></p>
					<input id="input-passw" type="password" placeholder="password" name="password">
					<br><br>
					<input type="submit" value="ACCEDI" class="card btn wide text-colored white">
				</form>
			</div>
			<div class="card white wrap-padding">
				<h1>Non hai ancora un account?</h1>
				<br>
				<a href="register.php" class="btn card colored wrap-margin"><p> Registrati </p></a>
			</div>
		</div>
		
		<!-- /Login -->
	</div>

</header>

<!-- /Header -->

<?php include_once('breadcrumb.php') ?>

<?php include_once('footer.php') ?>

<?php include_once('tothetop.php') ?>

</div>

</body>

<!-- /Body -->

</html>