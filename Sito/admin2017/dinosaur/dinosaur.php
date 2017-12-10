<?php

include_once ($_SERVER['DOCUMENT_ROOT'] ."/classi/Dinosaur.php");
if(isset($_SESSION['user'])){

	if(isset($_GET["sez"]))
		$sezione=$_GET["sez"];
	else
		$sezione = "list";

	switch ($sezione ) {
		case 'list':
			?>
			<form action="<?php echo $_SERVER["PHP_SELF"]?>" method="GET">
				<input type="hidden" name="id" value="dino">
				<input type="hidden" name="sez"  value="list">
				<label for="filtra">Filtro:</label>
				<input type="text" id="filtra" name="filter" value="<?php if(isset($_GET["filter"])) echo $_GET["filter"]; ?>">
				<input type="submit" value="Cerca" title="Avvia la ricerca" />
			</form>
		
			<a href="panel.php?id=dino&sez=formadd" class="menu_entry">
				<p>Aggiungi un Dinosauro</p>
			</a>
			<?php
			if(isset($_GET["filter"]))
				echo Dinosaur::printListDinosaur($_GET["filter"]);
			else
				echo Dinosaur::printListDinosaur("");
			break;
		case 'formadd':
				echo Dinosaur::formAddDinosaur($_SERVER["PHP_SELF"]);
			break;
		case 'add':
			echo Dinosaur::addDinosaur($_SESSION['user']->getEmail(), $_POST["nome"], $_POST["peso"], $_POST["altezza"], $_POST["lunghezza"], $_POST["periodomin"], $_POST["periodomax"], $_POST["habitat"], $_POST["alimentazione"], $_POST["tipologiaalimentazione"], $_POST["descrizioneautore"], $_POST["descrizione"], $_POST["curiosita"]);
			break;			
		case 'formupdate':
			echo Dinosaur::formUpdateDinosaur($_SERVER["PHP_SELF"],$_GET['nome']);
			break;
		case 'update':
			echo Dinosaur::updateDinosaur($_POST["nome"], $_POST["peso"], $_POST["altezza"], $_POST["lunghezza"], $_POST["periodomin"], $_POST["periodomax"], $_POST["habitat"], $_POST["alimentazione"], $_POST["tipologiaalimentazione"], $_POST["descrizioneautore"], $_POST["descrizione"], $_POST["curiosita"]);
			break;	
		case 'delete':
			if(isset($_GET["nome"]))
				echo Dinosaur::deleteDinosaur($_GET["nome"]);
			break;
		
		default:
			header("Location: http://". $_SERVER['HTTP_HOST']."/error.php");
			exit();
			break;
	}
}
else{
	
	header("Location: http://". $_SERVER['HTTP_HOST']."/error.php");
	exit();
}
 ?>

