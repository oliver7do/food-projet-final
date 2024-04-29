<?php
//Inclure un fichier de constantes
include('../config/constants.php');

//echo "Supprimer la page" ;
//Vérifier si les valeurs id et image_name sont définies ou non
if (isset($_GET['id']) and isset($_GET['image_name'])) {
    //Obtention de la valeur et suppression
    //echo "Obtenir la valeur et supprimer" ;
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //Retirer le fichier image physique est disponible
    if ($image_name != "") {
        //est disponible. Il faut donc supprimer l'ir
        $path = "../images/category/" . $image_name;
        //Supprimer l'image
        $remove = unlink($path);

        //Si la suppression de l'image échoue, ajoutez un message d'erreur et arrêtez le processus.
        if ($remove == false) {
            //Définir le message de session
            $_SESSION['remove'] = "<div class='error'>Échec de la suppression de l'image de la catégorie.</div>";
            //Redirection vers la page de gestion des catégories
            header('location:' . SITEURL . 'admin/manage-category.php');
            //Arrêter le processus
            die();
        }
    }

    //Supprimer des données de la base de données
    //Requête SQL pour supprimer des données de la base de données
    $sql = "DELETE FROM category WHERE id=$id";

    //Exécuter la requête
    $res = mysqli_query($conn, $sql);

    //Vérifier si les données sont supprimées de la base de données ou non
    if ($res == true) {
        //Définir le message de réussite et la redirection
        $_SESSION['delete'] = "<div class='success'>Catégorie supprimée avec succès.</div>";
        //Redirection vers Gérer la catégorie
        header('location:' . SITEURL . 'admin/manage-category.php');
    }
} else {
    //Définir le message d'échec et la redirection
    $_SESSION['delete'] = "<div class='success'>Échec de la suppression de la catégorie.</div>";
    //rediriger vers la gestion de la catégorie Page
    header('location:' . SITEURL . 'admin/manage-category.php');
}
