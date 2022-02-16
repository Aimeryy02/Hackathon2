<?php
    /**
     * @package LimePress
     * @version 1.0.0
     */
    /*
    Plugin Name: LimePress
    Plugin URI: https://groupe9.btssiolerebours.org/wordpress/
    Description: LimePress permet de récupérer les profils de LimeSurvey.
    Author: Maxime DUBOSCQ, Nicolas LONGHI
    Version: 1.0.0
    */
    $nomBDD;
    $login;
    $mdp;
    include('fonctions.php');

    


/*** Utilisation des méthodes ***/


    add_shortcode('limepress','reponse'); //Ajout du shortcode
    add_action('admin_menu', 'ajoutMenu'); //Ajout du menu


/*** Fonctions ***/


    function ajoutMenu () {
        add_menu_page('Forms', 'LimePress', 'manage_options','josh-admin-menu', 'menuConfig', 'dashicons-admin-generic', 1);
    }

    function menuConfig() { //Contenu de la page 
        ?>
        <h1>LimePress :</h1>
        <br/><br/><br/>
        Pour utiliser LimePress, vous devez ajouter sur l'une de vos pages un code court. Dans celui-ci, vous devez inscrire entre crochet LimePress.<br/>
        Le module va alors ajouter automatiquement les réponses des utilisateurs de tous les questionnaires.
        <?php
    }

    function reponse() { //Affiche les réponses lorsque le shortcode est utilisé
        $questionnaires = recupereLesQuestionnaires();
        foreach ($questionnaires as $questionnaire) {
            echo '<b>Questionnaire : ' . $questionnaire['sid'] . '</b><br/>';
            $infos = recupereInfosQuestionnaire($questionnaire['sid']);
            $colonnes = recupereColonnes($questionnaire['sid']);
            $nbReponse = 1;
            foreach ($infos as $info) {
                $estime=0;
    $bonheur=0;
    $anxiete=0;
    $curiosite=0;
    $colerique=0;
    $genereux=0;

                $nbE=0;
                $nbA=0;
                $nbB=0;
                $nbC=0;
                $nbD=0;
                $nbG=0;
            foreach($colonnes as $colonne) {
                
                    if ($colonne["Field"] == "id" or $colonne["Field"] == "token" or $colonne["Field"] == "submitdate" or $colonne["Field"] == "lastpage" or $colonne["Field"] == "startlanguage"  or $colonne["Field"] == "seed") {
                        
                    }
                    else {
                        echo '&emsp;•&nbsp;' . $info[$colonne["Field"]] . '&emsp;&emsp;&emsp; → Personne ' . $info['id'] . '<br/>';                       
                        if (strpos($info[$colonne["Field"]], "E") === 0){
                            $estime += substr($info[$colonne["Field"]], -2);
                            $nbE++;
                        }
                        if (strpos($info[$colonne["Field"]], "B") === 0){
                            $bonheur += substr($info[$colonne["Field"]], -2);
                            $nbB++;
                        }
                        if (strpos($info[$colonne["Field"]], "A") === 0){
                            $anxiete += substr($info[$colonne["Field"]], -2);
                            $nbA++;
                        }
                        if (strpos($info[$colonne["Field"]], "C") === 0){
                            $curiosite += substr($info[$colonne["Field"]], -2);
                            $nbC++;
                        }
                        if (strpos($info[$colonne["Field"]], "D") === 0){
                            $colerique += substr($info[$colonne["Field"]], -2);
                            $nbD++;
                        }
                        if (strpos($info[$colonne["Field"]], "G") === 0){
                            $genereux += substr($info[$colonne["Field"]], -2);
                            $nbG++;
                        }
                    }
                }
            }
            echo '<br/>';
            echo <<<HTML
                    <head>
    <meta charset="UTF-8">
    <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-radar.min.js"></script>
    <style type="text/css">
      html, body, #container {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        
      }
    </style>
  <script async src='/cdn-cgi/bm/cv/669835187/api.js'></script></head>
  <body>
    <div id="container"></div>
  <script type="text/javascript">(function(){window['__CF$cv$params']={r:'6de586a73a3d3b43',m:'0nUiE.m4M7Ax77udcE43pVWiKMK4XS3WHKZW07ZXyYw-1645001401-0-AbksOk8NrKrdXRJw2wAs4SZjANKdKoEV1/dtB9BMjZ2sS5dPWYa/peCktrjlscWMi7RZLz+4W4N9hOVypAnui909ZiCIqZMqGgV78IsHhoT22dZA7oVcW5umJ0RTLVGz8+rtQLKgYPWtIEKk9HAmEQuqta1hTjmMp/hHwAFa59HF4dmehtPepKQSyshF9+3t8Q==',s:[0x2ec1f124db,0x37b616208f],}})();</script></body>
  <script>
    anychart.onDocumentReady(function () {
    // our data from bulbapedia
    var data1 = [
        {x: "Bonheur", value: ($bonheur/$nbB)},
        {x: "Curiosité", value: ($curiosite/$nbC)},
        {x: "Anxiété", value: ($anxiete/$nbA)},
        {x: "Colérique", value: ($colerique/$nbD)},
        {x: "Généreux", value: ($genereux/$nbG)},
        {x: "Estime de Soi", value: ($estime/$nbE)},
      ];  

      // create radar chart
      var chart = anychart.radar();
      // set chart yScale settings
      chart.yScale()
        .minimum(0)
        .maximum(10)
        .ticks({'interval':1});

      // create first series
      chart.line(data1)
      // create second series

      // set chart title
      chart.title("Résultat psychologique au questionnaire");

      // set container id for the chart
      chart.container('container');
      // initiate chart drawing
      chart.draw();
      chart.yGrid().palette(["gray 0.1", "gray 0.2"]);
      chart.area(data1).name('Charmander').markers(true).fill("#3AFF00", 0.3).stroke("#3AFF00")

    });
  </script>
HTML;
if ($bonheur>8){
    echo "votre bonheur est de " . $bonheur/$nbB. ". Voici un lien pour essayer de remonter votre bonheur.";
}
        }
    }

?>