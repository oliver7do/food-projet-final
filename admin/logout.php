<?php
    //Inclure les constants.php pour SITEURL
    include('../config/constants.php');
    //1. Détruire la session 
    session_destroy(); //Unsets $_SESSION['user]

    //2. Redirection vers la page de connexion
    header('location:'.SITEURL.'admin/login.php');



?>