<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Ajouter de la nourriture</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }  

        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Titre</td>
                    <td>
                        <input type="text" name="title" placeholder="Titre de la nourriture">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description de la nourriture."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Prix: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Sélectionner une image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Catégorie: </td>
                    <td>
                        <select name="category">

                            <?php
                                //Créer un code PHP pour afficher les catégories de la base de données
                                //1. Créer un code SQL pour obtenir toutes les catégories actives de la base de données
                                $sql = "SELECT * FROM category WHERE active='Oui'";

                                //Exécution de la requête
                                $res = mysqli_query($conn, $sql);

                                //Compter les lignes pour vérifier si nous avons des catégories ou non
                                $count = mysqli_num_rows($res);

                                //Si le nombre est supérieur à zéro, nous avons des catégories, sinon nous n'avons pas de catégories.
                                if($count>0)
                                {
                                    //Nous avons des catégories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //obtenir les détails des catégories
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        
                                        <?php
                                    }
                                }
                                else
                                {
                                    //Nous n'avons pas de catégorie
                                    ?>
                                    <option value="0">No Category </option>
                                    <?php
                                }

                                //2. Affichage sur la liste déroulante

                            ?>

                            <option value="1">Nourriture</option>
                            <option value="2">Snacks</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>En vedette: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes"> Oui
                        <input type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Actif: </td>
                    <td>
                        <input type="radio" name="active" value="Yes"> Oui
                        <input type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit_addfood" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <?php 

            //Vérifier si le bouton est cliqué ou non
            if(isset($_POST['submit']))
            {
                //Ajouter l'aliment dans la base de données
                //echo "Clicked" ;
                
                //1. Récupérer les données du formulaire
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //Vérifier si les boutons de radion pour featured et active sont cochés ou non
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //Réglage de la valeur par défaut
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //Réglage Valeur par défaut
                }

                //2. Télécharger l'image si elle est sélectionnée
                //Vérifier si l'image sélectionnée est cliquée ou non et télécharger l'image seulement si l'image est sélectionnée
                if(isset($_FILES['image']['name']))
                {
                    //Obtenir les détails de l'image sélectionnée
                    $image_name = $_FILES['iamge']['name'];

                    //Vérifier si l'image est sélectionnée ou non Télécharger l'image uniquement si elle est sélectionnée
                    if($image_name!="")
                    {
                        //L'image est sélectionnée 
                        //A. Renommer l'image
                        //Obtenir l'extension de l'image sélectionnée (jpg, png, gif, etc.) "Oliveira-Domingos.jpg" Oliveira Domingos jpg
                        $ext = end(explode(',', $image_name));

                        //Créer un nouveau nom pour l'image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; //Le nouveau nom de l'image peut être "Food-Name-657.jpg"

                        //B. télécharger l'image
                        //Obtenir le chemin Src et le chemin Destination

                        //Le chemin d'accès à la source est l'emplacement actuel de l'image
                        $src = $_FILES['image']['tmp_name'];

                        //Chemin de destination de l'image à télécharger
                        $dst = "../image/food/".$image_name;

                        //Enfin, téléchargez l'image de l'aliment
                        $upload = move_uploaded_file($src, $dst);

                        //Vérifier si l'image a été téléchargée ou non
                        if($upload==false)
                        {
                            //Échec du téléchargement de l'image
                            //Redirection vers la page d'ajout d'aliments avec un message d'erreur
                            $_SESSION['upload'] = "<div class='error'>Échec du téléchargement de l'image</div>";
                            header('location:'.SITEURL.'admin/add.food.php');
                            //Arrêter le processus
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = ""; //Définition de la valeur par défaut comme vide
                }

                //3. Insérer dans la base de données

                //Créer une requête SQL pour sauvegarder ou ajouter de la nourriture
                //Pour les valeurs numériques, nous n'avons pas besoin de passer la valeur entre guillemets '' Mais pour les valeurs de type chaîne, il est obligatoire d'ajouter des guillemets. ''
                $sql2 = "INSERT INTO food SET
                title = '$title',
                description = '$description',
                price = '$price',
                image_name = '$image_name',
                category_id = '$category,
                featured = '$featured',
                active = '$active'
                ";

                //Exécuter la requête
                $res2 = mysqli_query($conn, $sql);
                //Vérifier si les données ont été insérées ou non

                if($res2 == true)
                {
                    //Données insérées avec succès
                    $_SESSION['add'] = "<div class='success'>Aliments ajoutés avec succès.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Échec de l'insertion des données
                    $_SESSION['add'] = "<div class='error'>Échec de l'ajout d'aliments.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                //4. Redirection avec message vers la page de gestion des aliments
            }


        ?>

    </div>
</div>





<?php include('partials/footer.php'); ?>