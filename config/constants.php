<?php
    //Démarrer la session
    session_start();


    //1. Exécuter une requête et enregistrer les données dans la base de données
        //Créer des constantes pour stocker des valeurs non répétitives
    define('SITEURL', 'http://localhost/food-projet-final/');
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-projet-final');

    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD); //Connexion à la base de données
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); //Sélection de la base de données

?>