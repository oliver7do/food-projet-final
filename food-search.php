<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Commence ici -->
    <section class="food-search text-center">
        <div class="container">
            <?php

                //Obtenir le mot-clé de recherche
                //$search = $_POST['search'];
                $search = mysqli_real_escape_string($conn, $_POST['search']);

            ?>
            
            <h2>Aliments à la recherche <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Fin ici -->



    <!-- fOOD MEnu Section Commence ici -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php   

            //SQL Query to Get  foods based on search keyword
            //$search = burger '; DROP database name;
            // "SELECT * FROM food WHERE title LIKE '%burger%' OR description LIKE '%burger%'";
            $sql = "SELECT * FROM food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            //Execute The Query
            $res = mysqli_query($conn, $sql);

            //Count Rows
            $count = mysqli_num_rows($res);

            //Check whether food available of not
            if($count>0)
            {
                //Food Available
                while($row=mysqli_fetch_assoc($res))
                {
                    //Get the details
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>
                    <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php
                                        //Check whether image available or not
                                        if($image_name=="")
                                        {
                                            //Image not Available
                                            echo "<div class='error'>Image not available.</div>";
                                        }
                                        else
                                        {
                                            //Image Available
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/food<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
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

                                    <a href="order.html" class="btn btn-primary">Order Now</a>
                                </div>
                        </div>


                    <?php
                }
            }
            else
            {
                //Food Available
                echo "<div class='error'>Food not found.</div>";
            }


            ?>

            <?php
                //Getting Foods from Database that are active and featured
                //SQL Query
                $sql = "SELECT * FROM food WHERE active='Yes' AND featured='Yes' LIMIT 6";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Count Rows
                $count2 = mysqli_num_rows($res2);

                //Check Whether food available or not
                if($count2>0)
                {
                    //Food Avaimable
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //Get all the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];

                        ?>
                        <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php
                                        //Check whether image available or not
                                        if($image_name=="")
                                        {
                                            //Image not Available
                                            echo "<div class='error'>Image not available.</div>";
                                        }
                                        else
                                        {
                                            //Image Available
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/food<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
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

                                    <a href="order.html" class="btn btn-primary">Order Now</a>
                                </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    //Food Not Available
                    echo "<div class='error'>Food not available.</div>";
                }

            ?>

            <div class="food-menu-box">
                <div class="food-menu-img">
                    <img src="images/menu-pizza.jpg" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                </div>

                <div class="food-menu-desc">
                    <h4>Food Title</h4>
                    <p class="food-price">$2.3</p>
                    <p class="food-detail">
                        Made with Italian Sauce, Chicken, and organice vegetables.
                    </p>
                    <br>

                    <a href="#" class="btn btn-primary">Order Now</a>
                </div>
            </div>

        
            


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>