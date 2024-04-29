<?php include('partials-front/menu.php'); ?>

     <!-- fOOD sEARCH Section Commence ici -->
     <section class="food-search text-center">
        <div class="container"> 
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Recherche d'aliments.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
     </section>
    <!-- fOOD sEARCH Section Fin ici -->



    <!-- fOOD MEnu Section Commence ici -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu alimentaire</h2>

            <?php
                //Afficher les aliments qui sont actifs
                $sql = "SELECT * FROM food WHERE active='Yes'";

                //Exécuter la requête
                $res=mysqli_query($conn, $sql);

                //Compter les lignes
                $count = mysqli_num_rows($res);

                //Vérifier si les aliments sont disponibles ou non
                if($count>0)
                {
                    //Alimentation disponible
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Obtenir les valeurs
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];

                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    //Vérifier si l'image est disponible ou non
                                    if($image_name=="")
                                    {
                                        //Image non disponible
                                        echo "<div class='error'>Image non disponible.</div>";
                                    }
                                    else
                                    {
                                        //Image disponible
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">$<?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Commander maintenant</a>
                            </div>
                        </div>
                        <?php
                    }
                }

            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Fin ici -->

    <?php include('partials-front/footer.php'); ?>