<?php include('partials/menu.php'); ?>

<?php
    //Vérifier si l'identifiant est défini ou non
    if(isset($_GET['id']))
    {
        //Obtenir tous les détails
        $id = $_GET['id'];

        //Requête SQL pour obtenir les aliments sélectionnés
        $sql2 = "SELECT * FROM food WHERE id=$id";
        //exécuter la requête
        $res2 = mysqli_query($conn, $sql2);

        //Obtention de la valeur en fonction de la requête exécutée
        $row2 = mysqli_fetch_assoc($res2);

        //Obtenir les valeurs individuelles des aliments sélectionnés
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];


    }



?>



<div class="main-content">
    <div class="wrapper">
        <h1>Mise à jour de l'alimentation</h1>

        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">

        <tr>
            <td>Titre: </td>
            <td>
                <input type="text" name="title" value="<?php echo $title; ?>">
            </td>
        </tr>

        <tr>
            <td>Description: </td>
            <td>
                <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
            </td>
        </tr>

        <tr>
            <td>Prix: </td>
            <td>
                <input type="number" name="price" value="<?php echo $price; ?>">
            </td>
        </tr>

        <tr>
            <td>Image actuelle: </td>
            <td>
                <?php
                if($current_image == "")
                {
                    //Image non disponible
                    echo "<div class='error'>Image non disponible.</div>";
                }
                else
                {
                    //Image disponible
                    ?>
                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                    <?php
                }


                ?>
            </td>
        </tr>

        <tr>
            <td>Sélectionnez Nouvelle image</td>
            <td>
                <input type="file" name="image">
            </td>

        </tr>

        <tr>
            <td>Catégorie: </td>
            <td>
                <select name="category">

                    <?php
                        //Query pour obtenir les catégories actives
                        $sql = "SELECT * FROM category WHERE active='Yes'";
                        //Exécuter la requête
                        $res = mysqli_query($conn, $sql);
                        //Compter les lignes
                        $count = mysqli_num_rows($res);

                        //Vérifier si la catégorie est disponible ou non
                        if($count>0)
                        {
                            //Catégorie disponible
                            while($row=mysqli_fetch_assoc($res))
                            {
                                $category_title = $row['title'];
                                $category_id = $row['id'];

                                // echo "<option value='$category_id'>$Category_title</option>";
                                ?>
                                <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                <?php
                            }
                        }
                        else
                        {
                            //Catégorie non disponible
                            echo "<option value='0'>Catégorie Non disponible.</option>";
                        }
                    ?>

                    <option value="0">Catégorie de test</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>En vedette: </td>
            <td>
                <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Oui
                <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
            </td>
        </tr>

        <tr>
            <td>Actif: </td>
            <td>
                <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Oui
                <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
            </td>
        </tr>

        <tr>
            <td>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                <input type="submit" name="submit_updatefood" value="Update Food" class="btn-secondary">
            </td>
        </tr>

        </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //echo "Bouton cliqué";

                //1. Obtenir tous les détails du formulaire
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Télécharger l'image si elle est sélectionnée

                //Vérifier si le bouton de téléchargement est cliqué ou non
                if(isset($_FILES['image']['name']))
                {
                    //Bouton de téléchargement cliqué
                    $image_name = $_FILES['image']['name']; //Nouveau nom de l'image

                    //Vérifier si le fichier est disponible ou non
                    if($image_name!="")
                    {
                        //L'image est disponible
                        //A. Téléchargement d'une nouvelle image 

                        //Renommer l'image
                        $ext = end(explode('.', $image_name)); //Obtient l'extension de l'image

                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; //Elle sera renommée image

                        //Obtenir le chemin d'accès de la source et le chemin d'accès de la destination
                        $src_path = $_FILES['image']['tmp_name']; //Chemin d'accès
                        $dest_path = "../images//food/".$image_name; //Chemin de destination

                        //Transférer l'image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //Vérifier si l'image est téléchargée ou non
                        if($upload==false)
                        {
                            //Échec du chargement
                            $_SESSION['upload'] = "<div class='error'>Échec du téléchargement d'une nouvelle image.</div>";
                            //Redirection vers la gestion de l'alimentation
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Arrêter le processus
                            die();
                        }
                        //3. Supprime l'image si une nouvelle image est téléchargée et que l'image actuelle existe.
                        //B. Supprimer l'image actuelle si elle est disponible
                        if($current_image!="")
                        {
                            //L'image actuelle est disponible
                            //Supprimer l'image
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //Vérifier si l'image est supprimée ou non
                            if($remove==false)
                            {
                                //échec de la suppression de l'image actuelle
                                $_SESSION['remove-failed'] = "<div class='error'>Faile pour supprimer l'image actuelle.</div>";
                                //redirect to manage food
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //Arrêter le processus
                                die();
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image; //Image par défaut lorsque l'image n'est pas sélectionnée
                    }
                }
                else
                {
                    $image_name = $current_image; //Image par défaut lorsque le bouton n'est pas cliqué
                }

                //4. Mise à jour de la base de données des denrées alimentaires
                $sql3 = "UPDATE food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                    
                    ";

                //Exécuter la requête SQL
                $res3 = mysqli_query($conn, $sql3);

                //Vérifier si la requête est exécutée ou non
                if($res3==true)
                {
                    //Exécution de la requête et mise à jour de l'alimentation
                    $_SESSION['update'] = "<div class='success'>Alimentation Mise à jour réussie.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Echec de la mise à jour de l'alimentation
                    $_SESSION['update'] = "<div class='error'>Échec de la mise à jour.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                

                //Redirection vers la gestion des aliments avec le message de session
            }




        ?>



    </div>

</div>



<?php include('partials/footer.php'); ?>