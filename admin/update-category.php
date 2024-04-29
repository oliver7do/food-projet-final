<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Catégorie de mise à jour</h1>

        <br><br>

        <?php
        //Vérifier si l'identifiant est défini ou non
        if (isset($_GET['id'])) {
            //Obtention de l'ID et de tous les autres détails
            //echo « Getting data » ;
            $id = $_GET['id'];
            //Créer une requête SQL pour obtenir tous les autres détails
            $sql = "SELECT * FROM category WHERE id=$id";

            //Exécuter la requête
            $res = mysqli_query($conn, $sql);

            //Compter les lignes pour vérifier si l'identifiant est valide ou non
            $count = mysqli_num_rows($res);
            if ($conn) {
                //Réunir toutes les données
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
            } else {
                //redirection vers la catégorie de gestion avec le message de session
                $_SESSION['no-category-found'] = "<div class='error'>Catégorie non trouvée.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        } else {
            //rediriger vers Gérer la catégorie
            header('location:' . SITEURL . 'admin/manage-category.php');
        }



        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Titre: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image != "") {
                            //Afficher l'image
                        ?>
                            <img src="<?php echo SITEURL ?>images/category/<?php echo $current_image; ?>" width="150px">
                        <?php
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>Nouvelle image: </td>
                    <td>
                        <input type="file" name="image" id="">
                    </td>
                </tr>

                <tr>
                    <td>En vedette: </td>
                    <td>
                        <input <?php if ($featured == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="featured" value="Yes"> Oui
                        <input <?php if ($featured == "No") {
                                    echo "checked";
                                } ?>type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Actif: </td>
                    <td>
                        <input <?php if ($active == "Yes") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="Yes"> Oui

                        <input <?php if ($active == "No") {
                                    echo "checked";
                                } ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit_category" value="Update Category" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
        if (isset($_POST['submit_category'])) {
            //echo "Clicked";
            //1. Récupérer toutes les valeurs de notre formulaire
            $id = $_POST['id'];
            $title = $_POST['title'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. Mise à jour de la nouvelle image si elle est sélectionnée
            //Vérifier si l'image est sélectionnée ou non
            if (isset($_FILES['image']['name'])) {
                //Obtenir l'image Détails
                $image_name = $_FILES['image']['name'];

                //Vérifier si l'image est disponible ou non
                if ($image_name != "") {
                    //Image disponible
                    //A. Télécharger la nouvelle image

                    //Renommer automatiquement notre image
                    // Obtenir l'extension de notre image (jpg, png, gif, etc) par exemple « special.food1.jpg »
                    // $ext = end($image_name) ;

                    // $test = explode('-', $ext) ;
                    //Renommer l'image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $image_name; // e.g. Food_Category_834.jpg

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/" . $image_name;

                    //Enfin, téléchargez l'image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    // Vérifier si l'image est téléchargée ou non
                    //Et si l'image n'est pas téléchargée, nous arrêterons le processus et afficherons un message d'erreur.
                    if ($upload == false) {
                        //Définir le message
                        $_SESSION['upload'] = "<div class='error'>Échec du téléchargement de l'image. </div>";
                        //Redirection vers la page d'ajout de catégorie
                        header('location:' . SITEURL . 'admin/manage-category.php');
                        //Arrêter le processus
                        die();
                    }
                    //B. Remove the current Page if available
                    if ($current_image != "") {
                        $remove_path = "../images/category/" . $current_image;

                        $remove = unlink($remove_path);
                        //Vérifier si l'image est supprimée ou non
                        //si l'image n'est pas supprimée, afficher un message et arrêter le processus
                        if ($remove == false) {
                            //Échec de la suppression de l'image
                            $_SESSION['failed-remove'] = "<div class='error>Échec de la suppression de l'image actuelle.</div>";
                            header('location:' . SITEURL . 'admin/manage-category.php');
                            die(); //Arrêter le processus
                        }
                    }
                } else {
                    $image_name = $current_image;
                }
            } else {
                $image_name = $current_image;
            }
            //3. Mise à jour de la base de données
            $sql2 = "UPDATE category SET
            title = '$title',
            image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            WHERE id=$id
            ";

            //Exécuter la requête
            $res2 = mysqli_query($conn, $sql2);
            //4. Redirect to manage Category with Message
            //Vérifier l'exécution ou non
            if ($res2 == true) {
                //Catégorie mise à jour
                $_SESSION['update'] = "<div class='success'>Catégorie mise à jour avec succès.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            } else {
                //a échoué à la catégorie mise à jour
                $_SESSION['update'] = "<div class='error'>Échec de la mise à jour de la catégorie.</div>";
                header('location:' . SITEURL . 'admin/manage-category.php');
            }
        }

        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>