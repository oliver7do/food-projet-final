<?php include('partials-front/menu.php'); ?>

    <?php
        //Vérifier si l'identifiant de l'aliment est défini ou non
        if(isset($_Get['food_id']))
        {
            //Obtenir l'identifiant de l'aliment et les détails de l'aliment sélectionné
            $food_id = $_GET['food_id'];

            //Obtenir les détails de l'aliment sélectionné
            $sql = "SELECT * FROM food WHERE id=$food_id";
            //Exécuter la requête
            $res = mysqli_query($conn, $sql);
            //Compter les lignes
            $count = mysqli_num_rows($res);
            //Vérifier si les données sont disponibles ou non
            if($count==1)
            {
                //Nous avons des données
                //Importer les données de la base de données
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];

            }
            else
            {
                //Aliments non disponibles
                //Redirection vers la page d'accueil
                header('location:'.SITEURL);
            }
        }
        else
        {
            //Redirection vers la page d'accueil
            header('location:'.SITEURL);
        }

    ?>

    <!-- fOOD sEARCH Section Commence ici -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Remplissez ce formulaire pour confirmer votre commande.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Aliments sélectionnés</legend>

                    <div class="food-menu-img">
                        <?php

                            //Vérifier si l'image est disponible ou non
                            if($image_name=="")
                            {
                                //image non disponible
                                echo "<div class='error'>Image non disponible.</div>";
                            }
                            else
                            {
                                //L'image est disponible
                                ?>
                                <img src="<?php echo SITEURL; ?>image/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php
                            }

                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title; ?> </h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantité</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Détails de la livraison</legend>
                    <div class="order-label">Nom complet</div>
                    <input type="text" name="full-name" placeholder="E.g. Oliveira Domingos de" class="input-responsive" required>

                    <div class="order-label">N° de téléphone</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Courriel</div>
                    <input type="email" name="email" placeholder="E.g. chefeoliver10@gmail.com" class="input-responsive" required>

                    <div class="order-label">Adresse</div>
                    <textarea name="address" rows="10" placeholder="E.g. Rue, Ville, Pays" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                //Vérifier si le bouton de soumission est cliqué ou non
                if(isset($_POST['submit']))
                {
                    //Obtenir tous les détails du formulaire

                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; // total = price x qty

                    $order_date = date("Y-m-d h:i:sa"); // Commandé, à la livraison, livré, annulé

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //Enregistrer la commande dans la base de données
                    //Créer un code SQL pour sauvegarder les données 
                    $sql2 = "INSERT INTO order SET
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    ";
                }

                //Exécuter la requête
                $res2 = mysqli_query($conn, $sql2);

                //Vérifier si la requête a été exécutée avec succès ou non
                if($res2==true)
                {
                    //Exécution de la requête et sauvegarde de l'ordre
                    $_SESSION['order'] = "<div class='success text-center'>Aliments commandés avec succès.</div>";
                    header('location:'.SITEURL);

                }
                else
                {
                    //Échec de l'enregistrement de l'ordre
                    $_SESSION['order'] = "<div class='error text-center'>Absence de commande de denrées alimentaires.</div>";
                    header('location:'.SITEURL);
                }


            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Fin ici -->

    <?php include('partials-front/footer.php'); ?>