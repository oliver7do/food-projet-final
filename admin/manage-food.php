<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">  
        <h1>Gérer la nourriture</h1>

        <br /> <br />

<!-- Bouton pour ajouter un administrateur -->
<a href="<?php echo SITEURL; ?>admin/add.food.php" class="btn-primary">Add Nourriture</a>

<br /> <br /> <br />

<?php
    if(isset($_SESSION['add']))
    {
        echo $_SESSION['add'];
        unset($_SESSION['add']);
    }
    if(isset($_SESSION['delete']))
    {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }
    if(isset($_SESSION['upload']))
    {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    }
    if(isset($_SESSION['unauthorize']))
    {
        echo $_SESSION['unauthorize'];
        unset($_SESSION['unauthorize']);
    }
    if(isset($_SESSION['update']))
    {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }


?>

<table class="tbl-full">
    <tr>
        <th>S.N.</th>
        <th>Titre</th>
        <th>Prix</th>
        <th>Image</th>
        <th>En vedette</th>
        <th>Actif</th>
        <th>Actions</th>
    </tr>

    <?php 
        //Créer une requête SQL pour obtenir tous les aliments
        $sql = "SELECT * FROM food";

        //Exécuter la requête
        $res = mysqli_query($conn, $sql);

        //Compter les lignes pour vérifier si nous avons des aliments ou non
        $count = mysqli_num_rows($res);

        //Créer la variable numéro de série et fixer la valeur par défaut à 1
        $sn=1;

        if($count>0)
        {
            //Nous avons des aliments dans la base de données
            //Reprendre les aliments dans la base de données et les afficher
            while($row=mysqli_fetch_assoc($res))
            {
                //obtient les valeurs des différentes colonnes
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];
                ?>

            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $title; ?></td>
                <td><?php echo $price; ?></td>
                <td>
                    <?php 
                        //Vérifier si nous avons une image ou non
                        if($image_name=="")
                        {
                            //Nous n'avons pas d'image, afficher un message d'erreur
                            echo "<div class='error'>Image non ajoutée.</div>";
                        }
                        else
                        {
                            //Nous avons une image, Afficher l'image
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                            <?php
                        }
                    
                    ?>
                </td>
                <td><?php echo $featured; ?></td>
                <td><?php echo $active; ?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-secondary">Mise à jour nourriture</a>  

                    
                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Supprimer nourriture</a>  
                </td>
            </tr>


                <?php
            }
        }
        else
        {
            //aliments non ajoutés dans la base de données
            echo "<tr> <td colspan='7' class='error'> Aliments non encore ajoutés. </td> </tr>";
        }


    ?>
</table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>