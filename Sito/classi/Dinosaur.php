<?php 
$homepath = substr( $_SERVER['SCRIPT_FILENAME'],0,-strlen($_SERVER['SCRIPT_NAME']) );
if (strpos($_SERVER['SCRIPT_NAME'], 'TecWeb') !== false) {
    $homepath .= "/TecWeb";
}
//$homepath = $_SERVER["DOCUMENT_ROOT"];

include_once ($homepath . "/connect.php");

class Dinosaur {    
                
    //metodi
    public static function printListDinosaur($filter, $editable = false){
        $connect = startConnect();     
        
        $sqlQuery = "SELECT count(nome) as ntot FROM dinosauro";
		$result = $connect->query($sqlQuery);
        $row = $result->fetch_assoc();
        closeConnect($connect);

        return Dinosaur::printListDinosaurLimit($filter, 0, $row["ntot"], $editable);
    }
    public static function printListDinosaurLimit($filter, $startNumView, $numView, $editable = false){
        $connect = startConnect();     
        $echoString="";
        if(isset($connect)){
            $sqlFilter = "";
            if(isset($filter) && $filter!=""){
                $words = explode(" ",$filter);
                $sqlFilter="WHERE ";
                foreach($words as $value){
                    $sqlFilter .= "nome LIKE '%".$value."%' OR peso LIKE '%".$value."%' OR altezza LIKE '%".$value."%' OR lunghezza LIKE '%".$value."%'
                    OR periodomin LIKE '%".$value."%' OR periodomax LIKE '%".$value."%' OR habitat LIKE '%".$value."%' OR alimentazione LIKE '%".$value."%' OR tipologiaalimentazione LIKE '%".$value."%'
                    OR descrizioneautore LIKE '%".$value."%' OR descrizione LIKE '%".$value."%' OR curiosita LIKE '%".$value."%' OR idautore LIKE '%".$value."%' ";
                }
            }
            
            $sqlFilter .= "ORDER BY nome";
            $sqlQuery = "SELECT nome, peso, altezza, lunghezza, tipologiaalimentazione FROM dinosauro ".$sqlFilter." LIMIT ".$startNumView.", ".$numView;
            $result = $connect->query($sqlQuery);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $echoString .='
                    <div class="third wrap-padding">
                        <div id="" class="daily-dino card">
                            <div class="padding-large colored">
                                <h1>'.$row["nome"].'</h1>
                            </div>
                            <!--<img src="img/immagineprofilo.jpg" alt="immagine profilo utente">-->
                            <div class="center padding-2">
                                <p>
                                    <strong>Peso: </strong> '.$row["nome"].'<br>
                                    <strong>Altezza: </strong> '.$row["altezza"].'<br>
                                    <strong>Lunghezza: </strong> '.$row["lunghezza"].'<br>
                                    <strong>Alimentazione: </strong> '.$row["tipologiaalimentazione"].'
                                </p>
                            </div>
                            <div class="center padding-2">';
                            if($editable){
                                $echoString .='
                                    <a href="'.$_SERVER["PHP_SELF"].'?id=dino&sez=formupdate&nome='.$row["nome"].'" class="btn colored"><p> Modifica</p></a>
                                    <a href="'.$_SERVER["PHP_SELF"].'?id=dino&sez=delete&nome='.$row["nome"].'" class="btn colored"><p> Elimina </p></a>
                                ';
                            }
                            else{
                                $echoString .='<a href="" class="btn colored"><p> Visualizza la scheda del dinosauro </p></a>';
                            }
                            $echoString .='    
                            </div>
                        </div>
                    </div>
                    ';                
                }
            } 
            else {
                $echoString = "0 risultati";
            }
        }
        closeConnect($connect);
        return $echoString;
    }

    public function deleteDinosaur($id){
        $echoString = "";
        $connect = startConnect(); 
        if(isset($connect)){
            if(isset($id)){
                $sqlQuery = "DELETE FROM dinosauro WHERE nome = '".$id."' ";
                if( $connect->query($sqlQuery) ){
                    $echoString = "Elemento eliminato";
                } 
                else {
                    $echoString = "Elemento NON eliminato";
                }
            }
        }        
        closeConnect($connect);
        return $echoString;
    }

    public static function formAddDinosaur($url){
        $echoString ='
		
		<header id="header-home" class="full-screen parallax">
			<div class="padding-12 content">						
				<div class="card white wrap-padding">
					<h1>Aggiungi un dinosauro</h1>
				</div>
				<div class="card colored wrap-padding">
					<form action="'.$url.'?id=dino&sez=add" method="POST">
						<p><label for="nome">Nome:</label></p>
						<input type="text" id="nome" name="nome" value="">
						
						<p><label for="peso">Peso in Kg:</label></p>
						<input type="number" id="peso" name="peso" value="">

						<p><label for="altezza">Altezza in cm:</label></p>
						<input type="number" id="altezza" name="altezza" value="">
						
						<p><label for="lunghezza">Lunghezza in cm:</label></p>
						<input type="number" id="lunghezza" name="lunghezza" value="">
						
						<p><label for="periodomin">Periodo minimo in milioni di anni:</label></p>
						<input type="number" id="periodomin" name="periodomin" value="">
						
						<p><label for="periodomax">Periodo massimo in milioni di anni:</label></p>
						<input type="number" id="periodomax" name="periodomax" value="">
						
						<p><label for="habitat">Habitat:</label></p>
						<input type="text" id="habitat" name="habitat" value="">
						
						<br>
						
						<label for="tipologiaalimentazione1">Carnivoro:</label>
						<input type="radio" id="tipologiaalimentazione1" name="tipologiaalimentazione" value="carnivoro" checked>
						
						<label for="tipologiaalimentazione2">Onnivoro:</label>
						<input type="radio" id="tipologiaalimentazione2" name="tipologiaalimentazione" value="onnivoro">
						
						<label for="tipologiaalimentazione3">Erbivoro:</label>
						<input type="radio" id="tipologiaalimentazione3" name="tipologiaalimentazione" value="erbivoro">
						
						<p><label for="alimentazione">Alimentazione:</label></p>
						<input type="text" id="alimentazione" name="alimentazione" value="">
						
						<p><label for="descrizionebreve">Descrizione Breve:</label></p>
						<input type="text" id="descrizionebreve" name="descrizionebreve" value="">
						
						<p><label for="descrizione">Descrizione:</label></p>
						<input type="text" id="descrizione" name="descrizione" value="">
						
						<p><label for="curiosita">Curiosità:</label></p>
						<input type="text" id="curiosita" name="curiosita" value="">

						<br>
						
						<input type="submit" value="AGGIUNGI" title="Avvia l\'operazione" class="card btn wide text-colored white"/>
					</form>
				</div>
			</div>
		</header>
        ';
        return $echoString;

    }

    //sarei quasi indeciso se istanziare il dinosauro e passarlo a questo metodo per il salvataggio nel DB
    public static function addDinosaur($idautore, $nome, $peso, $altezza, $lunghezza, $periodomin, $periodomax, $habitat, $alimentazione, $tipologiaalimentazione, $descrizionebreve, $descrizione, $curiosita){
        $echoString ="";
        $connect = startConnect(); 
        $sqlQuery = "SELECT nome FROM dinosauro WHERE nome = '".$nome."' ";
        $result = $connect->query($sqlQuery);
        if(
            $result->num_rows == 0 &&
            isset($nome) &&
            isset($peso) &&
            isset($altezza)  &&
            isset($lunghezza) &&
            isset($periodomin)  &&
            isset($periodomax) &&
            isset($habitat) &&
            isset($alimentazione)  &&
            isset($tipologiaalimentazione) &&
            isset($descrizionebreve) &&
            isset($descrizione) &&
            isset($curiosita)  /*&&
            bisogna controllare che la data si effettivamente una data
            */
        ){
            $sqlQuery = "INSERT INTO dinosauro (
                nome, peso, altezza, lunghezza, periodomin, periodomax, habitat, alimentazione, tipologiaalimentazione, descrizionebreve, descrizione, curiosita, datains, idautore)
                VALUES ('".$nome."', '".$peso."', '".$altezza."', '".$lunghezza."', '".$periodomin."', '".$periodomax."', '".$habitat."', '".$alimentazione."', '".$tipologiaalimentazione."', '".$descrizionebreve."', '".$descrizione."', '".$curiosita."', '".date('Y-m-j')."', '".$idautore."') ";
            if( $connect->query($sqlQuery) ){
                $echoString = "Elemento Aggiunto";
            } 
            else {
                $echoString = "Elemento NON Aggiunto";
            }
        }
        else{
            $echoString = "Errore campi";
        }           
        closeConnect($connect);
        return $echoString;
    }
    public static function formUpdateDinosaur($url, $id){
        $echoString ="";
        $connect = startConnect(); 
        $sqlQuery = "SELECT * FROM dinosauro WHERE nome = '".$id."' ";
        $result = $connect->query($sqlQuery);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();   
            $alimentazionecarnivora = "";
            $alimentazioneonnivora = "";
            $alimentazioneerbivora = "";
            if($row["tipologiaalimentazione"]=="carnivoro"){
                $alimentazionecarnivora = "checked";
            }
            if($row["tipologiaalimentazione"]=="onnivoro"){
                $alimentazioneonnivora = "checked";                
            }
            if($row["tipologiaalimentazione"]=="erbivoro"){
                $alimentazioneerbivora = "checked";                
            }
            
            $echoString ='
			
			<header id="header-home" class="full-screen parallax">
				<div class="padding-12 content">						
					<div class="card white wrap-padding">
						<h1>Modifica un dinosauro</h1>
					</div>
					<div class="card colored wrap-padding">
						<form action="'.$url.'?id=dino&sez=update" method="POST">
							<p><label for="nome">Nome:</label></p>
							<input type="text" id="nome" name="nome" value="'.$row["nome"].'" readonly>
							
							<p><label for="peso">Peso in Kg:</label></p>
							<input type="number" id="peso" name="peso" value="'.$row["peso"].'">

							<p><label for="altezza">Altezza in cm:</label></p>
							<input type="number" id="altezza" name="altezza" value="'.$row["altezza"].'">
							
							<p><label for="lunghezza">Lunghezza in cm:</label></p>
							<input type="number" id="lunghezza" name="lunghezza" value="'.$row["lunghezza"].'">
							
							<p><label for="periodomin">Periodo minimo in milioni di anni:</label></p>
							<input type="number" id="periodomin" name="periodomin" value="'.$row["periodomin"].'">
							
							<p><label for="periodomax">Periodo massimo in milioni di anni:</label></p>
							<input type="number" id="periodomax" name="periodomax" value="'.$row["periodomax"].'">
							
							<p><label for="habitat">Habitat:</label></p>
							<input type="text" id="habitat" name="habitat" value="'.$row["habitat"].'">
							
							<br>
							
							<label for="tipologiaalimentazione1">Carnivoro:</label>
							<input type="radio" id="tipologiaalimentazione1" name="tipologiaalimentazione" value="carnivoro" '.$alimentazionecarnivora.'>
							
							<label for="tipologiaalimentazione2">Onnivoro:</label>
							<input type="radio" id="tipologiaalimentazione2" name="tipologiaalimentazione" value="onnivoro" '.$alimentazioneonnivora.'>
							
							<label for="tipologiaalimentazione3">Erbivoro:</label>
							<input type="radio" id="tipologiaalimentazione3" name="tipologiaalimentazione" value="erbivoro" '.$alimentazioneerbivora.'>
							
							<p><label for="alimentazione">Alimentazione:</label></p>
							<input type="text" id="alimentazione" name="alimentazione" value="'.$row["alimentazione"].'">
							
							<p><label for="descrizionebreve">Descrizione breve:</label></p>
							<input type="text" id="descrizionebreve" name="descrizionebreve" value="'.$row["descrizionebreve"].'">
							
							<p><label for="descrizione">Descrizione:</label></p>
							<input type="text" id="descrizione" name="descrizione" value="'.$row["descrizione"].'">
							
							<p><label for="curiosita">Curiosità:</label></p>
							<input type="text" id="curiosita" name="curiosita" value="'.$row["curiosita"].'">

							<br>
							
							<input type="submit" value="MODIFICA" title="Avvia l\'operazione" / class="card btn wide text-colored white">
						</form>
					</div>
				</div>
			</header>
            ';
        }
        else{
            echo "Errore: Dinosauro non presente";
        }
        closeConnect($connect);
        return $echoString;

    }

    public static function updateDinosaur($nome, $peso, $altezza, $lunghezza, $periodomin, $periodomax, $habitat, $alimentazione, $tipologiaalimentazione, $descrizionebreve, $descrizione, $curiosita){
    
        $echoString ="";
        $connect = startConnect(); 

        if(
            isset($nome) &&
            isset($peso) &&
            isset($altezza) &&
            isset($lunghezza) &&
            isset($periodomin) &&
            isset($periodomax) &&
            isset($habitat) &&
            isset($alimentazione) &&
            isset($tipologiaalimentazione) &&
            isset($descrizionebreve) &&
            isset($descrizione) &&
            isset($curiosita)/*&&
            bisogna controllare che la data si effettivamente una data
            */
        ){
            $sqlQuery = "UPDATE dinosauro SET peso='".$peso."', altezza='".$altezza."', lunghezza='".$lunghezza."', 
            periodomin='".$periodomin."', periodomax='".$periodomax."', habitat='".$habitat."', alimentazione='".$alimentazione."', tipologiaalimentazione='".$tipologiaalimentazione."', descrizionebreve='".$descrizionebreve."',
            descrizione='".$descrizione."', curiosita='".$curiosita."' WHERE nome='".$nome."'";
            if( $connect->query($sqlQuery) ){                
                $echoString = "Elemento Modificato";
            } 
            else {                
                $echoString = "Elemento NON Modificato";
            }
        }
        else{            
            $echoString = "Errore campi";
        }

        closeConnect($connect);
        return $echoString;
    }
    public static function getDinosaurDay(){
        
        $echoString ="";
        $connect = startConnect(); 

        $sqlQuery = "SELECT lastupdate, info FROM impostazioni WHERE id='DinosauroDelGiorno'";
        $result = $connect->query($sqlQuery);
        
        if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
            $id = $row['info']; 
            if($row['lastupdate']!=date('Y-m-j')){
                $sqlQuery2 = "SELECT nome FROM dinosauro WHERE nome != '$id' ORDER BY rand() LIMIT 1";
                $result2 = $connect->query($sqlQuery2);
                if ($result2->num_rows > 0 && $row2 = $result2->fetch_assoc()) {
                    $id = $row2['nome'];
                    $sqlQuery3 = "UPDATE impostazioni SET lastupdate='".date('Y-m-j')."', info='$id' WHERE  id='DinosauroDelGiorno'";
                    if( !$connect->query($sqlQuery3) ){                
                        $echoString = "Errore: Aggiornamento impostazioni";
                    } 
                }
                else{
                    $echoString = "Errore: Non ci sono dinosauri";
                }
                
            }
            if($echoString == ""){
                
                $sqlQuery4 = "SELECT * FROM dinosauro WHERE nome = '$id'"; 
                $result4 = $connect->query($sqlQuery4);
                
                if ($result4->num_rows > 0 && $row4 = $result4->fetch_assoc()) {
                    $echoString = "
                        <div class=\"daily-dino card\"> <!--tolto wrap-margin-->
                            <div class=\"padding-large colored\">
                                <h1> $row4[nome] </h1>
                            </div>
                            <img src=\"img/dailydino-test.png\" alt=\"Triceratopo\">
                            <div class=\"padding-large\">
                                <ul>
                                    <li><strong>Alimentazione:</strong> $row4[tipologiaalimentazione]</li>
                                    <li><strong>Habitat:</strong>$row4[habitat]</li>
                                    <li><strong>Peso:</strong> $row4[peso]</li>
                                </ul>
                                <p>
                                    $row4[descrizionebreve]
                                </p>
                            </div>
                            <div class=\"center padding-2\">
                                <a href=\"display-specie.php\" class=\"btn colored\"><p> Visualizza la scheda del dinosauro </p></a>
                            </div>
                        </div>                    
                    ";
                }
                else{
                    $echoString = "Errore: Non ci sono dinosauri";
                }
            }

        }
        else{
            $echoString = "Errore: impostazioni non trovate";
        }

        closeConnect($connect);
        return $echoString;
    }
     
}
?>