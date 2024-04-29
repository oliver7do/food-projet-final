<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Gérer la catégorie</h1>

        <br /> <br />

        <?php

        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION);
        }


        ?>
        <br><br>

        <!-- Bouton pour ajouter un administrateur -->
        <a href="<?php echo SITEURL; ?>admin/add.category.php" class="btn-primary">Add Catégorie</a>

        <br /> <br /> <br /> <br />

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Titre</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Actif</th>
                <th>Actions</th>
            </tr>

            <?php

            //Requête pour obtenir toutes les catégories de la base de données
            $sql = "SELECT * FROM category";

            //Exécuter la requête
            $res = mysqli_query($conn, $sql);

            //Compter les lignes
            $count = mysqli_num_rows($res);

            //Créer une variable numéro de série et lui attribuer la valeur 1
            $sn=1;

            //Vérifier si la base de données contient des données ou non
            if($count>0)
            {
                //nous avons des données dans la base de données
                //obtenir les données et les afficher
                while($row=mysqli_fetch_assoc($res))
                {
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];

                    ?>

                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td>

                        <td>
                            <?php 
                                //Vérifier si le nom de l'image est disponible ou non
                                if($image_name!="")
                                {
                                    //Afficher l'image
                                    ?>

                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="100px" >

                                    <?php
                                }
                                else
                                {
                                    //Afficher le message
                                    echo "<div class='error'>Image non ajoutée.</div>";
                                }
                            ?>
                        </td>

                        <td><?php echo $featured; ?></td>
                        <td><?php echo $active; ?></td>
                        <td>
                            <a href="" class="btn-secondary">Mise à jour Catégorie</a>
                            <a href="" class="btn-danger">Supprimer Catégorie</a>
                        </td>
                    </tr>
                <?php
                }
            }
            else
            {
                //Nous n'avons pas de données
                //nous afficherons le message à l'intérieur du tableau
               
                 ?>
                <tr>
                    <td colspan="6">
                        <div>Aucune catégorie trouvée.</div>
                    </td>
                </tr>  
                <?php 
            }
            ?>
               
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>