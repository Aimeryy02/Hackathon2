<?php
function connexionBDD() {
	$bdd = new PDO('mysql:host=localhost;dbname=limesurvey', 'root', 'root')
		or die('Erreur connexion à la base de données');
	return $bdd;
}


//\\ ---------------- Requêtes SQL ----------------//\\

function recupereLesQuestionnaires() {
	$bdd = connexionBDD();
	$requete="SELECT sid FROM lime_surveys;";
	$resultat= $bdd->query($requete);
	$retour=$resultat->fetchAll(); 
	return $retour;
}

function recupereInfosQuestionnaire($numQuest) {
	$nomTable = "lime_survey_" . $numQuest;
	$bdd = connexionBDD();
	$requete="SELECT * FROM $nomTable;";
	$resultat= $bdd->query($requete);
	$retour=$resultat->fetchAll(); 
	return $retour;
}

function recupereColonnes($numQuest) {
	$nomTable = "lime_survey_" . $numQuest;
	$bdd = connexionBDD();
	$requete="SHOW COLUMNS FROM $nomTable;";
	$resultat= $bdd->query($requete);
	$retour=$resultat->fetchAll(); 
	return $retour;
}
?>