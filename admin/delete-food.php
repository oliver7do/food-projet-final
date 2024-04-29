<?php
    //Inclure la page des constantes
    include('../config/constants.php');

    // echo « Supprimer la page alimentaire » ;

    if(isset($_GET['id']) && isset($_GET['image_name'])) //Soit l'utilisateur « && » ou « AND ».
    {
        //Processus de suppression
        // echo « Processus de suppression » ;

        //1. Obtenir l'ID et le nom de l'image
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Supprimer l'image si elle est disponible
        //Vérifier si l'image est disponible ou non et ne la supprimer que si elle est disponible 
        if($image_name != "")
        {
            //Il y a une image et il faut la retirer du dossier
            //Obtenir le chemin d'accès à l'image
            $path = "../image/food/".$image_name;

            //Supprimer le fichier image du dossier
            $remove = unlink($path);

            //Vérifier si l'image est supprimée ou non
            if($remove==false)
            {
                //Échec de la suppression de l'image
                $_SESSION['upload'] = "<div class='error'>Échec de la suppression du fichier image.</div>";
                //Redirection vers la gestion de l'alimentation
                header('location:'.SITEURL.'admin/manage-food.php');
                //Redirection vers la gestion de l'alimentation
                die();

            }
        }

        //3. Supprimer un aliment de la base de données
        $sql = "DELETE FROM food WHERE id=$id";
        //Exécuter la requête
        $res = mysqli_query($conn, $sql);
        
        //Vérifier si la requête a été exécutée ou non et définir le message de session respectivement
        //4. Redirection vers Manage Food avec message de session
        if($res==true)
        {
            //Aliments supprimés
            $_SESSION['delete'] = "<div class='success'>Aliments supprimés avec succès.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Aliments supprimés
            $_SESSION['delete'] = "<div class='error'>Échec de la suppression des aliments.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        
    }
    else
    {
        //Redirection vers la page de gestion des aliments
        //echo « Redirect » ;
        $_SESSION['delete'] = "<div class='error'>Accès non autorisé.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>