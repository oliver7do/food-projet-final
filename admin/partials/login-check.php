<?php
    //Autorisation - Contrôle d'accès
    //Vérifier si l'utilisateur est connecté ou non
    if(!isset($_SESSION['user'])) //Si la session utilisateur n'est pas définie
    {
        //L'utilisateur n'est pas connecté
        //Redirection vers la page de connexion avec un message
        $_SESSION['no-login-message'] = "<div class='error text-center>Veuillez vous connecter pour accéder au panneau d'administration.</div>";
        //Redirection vers la page de connexion
        header('location:'.SITEURL.'admin/login.php');
    }

?>