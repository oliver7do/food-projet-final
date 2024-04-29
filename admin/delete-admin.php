<?php

    //Include constants.php file here
    include('../config/constants.php');

    // 1. obtenir l'ID de l'Admin à supprimer
    $id = $_GET['id'];

    // 2. Créer une requête SQL pour supprimer un administrateur
    $sql = "DELETE FROM user WHERE id=$id";

    //Exécuter la requête
    $res = mysqli_query($conn, $sql);

    // Vérifier si la requête a été exécutée avec succès ou non
    if($res==true)
    {
        //La requête a été exécutée avec succès et l'administrateur l'a supprimée.
        //echo "Admin Supprimé"; 
        //Créer une variable de session pour afficher le message
        $_SESSION['delete'] = "<div class='error'>Admin supprimé avec succès.</div>";
        //Requête exécutée avec succès et Admin supprimé
        header(('location:'.SITEURL.'admin/manage-admin.php'));
       
    }
    else{
        //Échec de la suppression de l'Admin
        // echo "Échec de la suppression Admin";

        $_SESSION['delete'] = "<div class='error'>Échec de la suppression de l'administrateur. Réessayez plus tard.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    // 3. Redirection vers la page Manage Admin avec message (succès/erreur)



?>