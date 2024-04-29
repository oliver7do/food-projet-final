<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Ajouter une catégorie</h1>

        <br><br>

        <?php
        if (isset($_SESSION['add'])) 
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if (isset($_SESSION['upload'])) 
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }


        ?>

        <!-- Début du formulaire d'ajout de catégorie -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Titre: </td>
                    <td>
                        <input type="text" name="title" placeholder="catégorie titre">
                    </td>
                </tr>

                <tr>
                    <td>Choisir une image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>


                </tr>


                <tr>
                    <td>En vedette: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Oui
                        <input type="radio" name="featured" value="No"> Non
                    </td>
                </tr>

                <tr>
                    <td>Actif: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Oui
                        <input type="radio" name="active" value="No"> Non
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit_add_category" value="Ajouter une catégorie" class="btn-secondary">
                    </td>
                </tr>


            </table>

        </form>
        <!-- Fin du formulaire d'ajout de catégorie -->

        <?php

        //Vérifier si le bouton d'envoi est cliqué ou non
        if (isset($_POST['submit_add_category'])) {
            //echo "Cliquer";

            //1. Obtenir la valeur du formulaire Catégorie
            $title = $_POST['title'];

            //Pour les entrées radio, nous devons vérifier si le bouton est sélectionné ou non.
            if (isset($_POST['featured'])) {
                //Obtenir la valeur du formulaire
                $featured = $_POST['featured'];
            } else {
                //Définir la valeur par défaut
                $featured = "No";
            }
            if (isset($_POST['active'])) {
                //Obtenir la valeur du formulaire
                $active = $_POST['active'];
            } else {
                //Définir la valeur par défaut
                $active = "No";
            }

            //Vérifier si l'image est sélectionnée ou non et définir la valeur du nom de l'image en conséquence.
            // print_r($_FILES['image']);

            if (isset($_FILES['image']['name'])) {
                // Télécharger l'image
                //Pour télécharger une image, nous avons besoin du nom de l'image, du chemin d'accès à la source et du chemin d'accès à la destination.
                $image_name = $_FILES['image']['name'];

                //Upload the image only if image is selected
                if($image_name != "")
                {
                    //Auto rename our image

                    //Rename the image
                    $images_name = "Food_Category_".rand(000, 999).'.'.$image_name; // e.g. Food_Category_834.jpg

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $images_name;

                    //Enfin, téléchargez l'image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Vérifier si l'image est téléchargée ou non
                    //Et si l'image n'est pas téléchargée, nous arrêterons le processus et afficherons un message d'erreur.
                    if ($upload==false) 
                    {
                        //Définir le message
                        $_SESSION['upload'] = "<div class='error'>Échec du téléchargement de l'image. </div>";
                        //Redirect to Add Category Page
                        header('location:'.SITEURL.'admin/add.category.php');
                        //Stop the process
                        die();
                    }
                }
            } 
            else 
            {
                //Ne pas télécharger d'image et définir la valeur de image_name comme vide
                $image_name = "";
            }

            //2. Créer une requête SQL pour insérer une catégorie dans la base de données
            $sql = "INSERT INTO category SET
                    title='$title',
                    image_name=$images_name,
                    featured='$featured',
                    active='$active'
                    ";

            //3. Exécuter la requête et l'enregistrer dans la base de données
            $res = mysqli_query($conn, $sql);

            //4. Vérifier si la requête a été exécutée ou non et si des données ont été ajoutées ou non
            if ($res == true) {
                //Requête exécutée et catégorie ajoutée
                $_SESSION['add'] = "<div class='success'>Catégorie ajoutée avec succès.</div>";
                //Redirection vers la page de gestion des catégories
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //Échec de l'ajout d'une catégorie
                $_SESSION['add'] = "<div class='error'>Échec de l'ajout d'une catégorie.</div>";
                //Redirection vers la page de gestion des catégories
                header('location:' . SITEURL . 'admin/add-category.php');
            }
        }
        ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>