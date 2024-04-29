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

    <?php 
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- CAtégories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explorer les aliments</h2>

            <?php
                //Créer une requête SQL pour afficher les catégories de la base de données
                $sql = "SELECT * FROM category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //Exécuter la requête
                $res = mysqli_query($conn, $sql);
                //Comptez les lignes pour vérifier si la catégorie est disponible ou non.
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //Catégories disponibles
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Importe les valeurs telles que id, title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php

                                    if($image_name=="")
                                    {
                                        //Afficher le message
                                        echo "<div class='error'>Image non disponible</div>";
                                    }
                                    else
                                    {
                                        //Image disponible
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">

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
                            
                                <!-- <h3 class="float-text text-white"><?php echo $title; ?>Pizza</h3> -->
                    </div>
  
                        <?php
                    }
                }
                else
                {
                    //Aliments non disponibles
                    echo "<div class='error'>Nourriture non disponible.</div>";
                }

            ?>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Fin ici -->

    <!-- fOOD MEnu Section Commence ici -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Menu alimentaire</h2>

           


            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="#">Voir tous les aliments</a>
        </p>
    </section>
    <!-- fOOD Menu Section Fin ici -->

    <?php include('partials-front/footer.php'); ?>