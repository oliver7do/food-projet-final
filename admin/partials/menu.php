<?php 
    include('../config/constants.php'); 
    include('login-check.php');
?>

<html>
    <head>
        <title>Site web de Food Order - Page d'accueil</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <!-- Début de la section du menu --> 
        <div class="menu">
            <div class="wrapper">
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-category.php">Catégorie</a></li>
                    <li><a href="manage-food.php">Nourriture</a></li>
                    <li><a href="manage-order.php">Commande</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </div>
        </div>
        <!-- Fin de la section du menu--> 