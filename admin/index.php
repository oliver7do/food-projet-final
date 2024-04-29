<?php include('partials/menu.php'); ?>

        <!-- Début de la section du contenu principal --> 
        <div class="main-content">
            <div class="wrapper">
                <h1>Tableau de bord</h1>
                <br><br>

                <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                 ?>

                 <br><br>

                <div class="col-4 text-center">

                    <?php
                        //sql Requête
                        $sql = "SELECT * FROM category";
                        //Exécuter la requête 
                        $res = mysqli_query($conn, $sql);
                        //Compter les lignes
                        $count = mysqli_num_rows($res);

                    ?>

                    <h1><?php echo $count; ?></h1>
                    <br/>
                    Catégories
                </div>

                <div class="col-4 text-center">

                    <?php
                        //sql Requête
                        $sql2 = "SELECT * FROM food";
                        //Exécuter la requête
                        $res2 = mysqli_query($conn, $sql2);
                        //Compter les lignes
                        $count2 = mysqli_num_rows($res2);
                    ?>
                
                    <h1><?php echo $count2; ?></h1>
                    <br/>
                    Aliments
                </div>

                <div class="col-4 text-center">

                    <?php
                        //sql Requête
                        $sql3 = "SELECT * FROM order";
                        //Exécuter la requête
                        $res3 = mysqli_query($conn, $sql3);
                        //Compter les lignes
                        $count3 = mysqli_num_rows($res3);
                    ?>
                
                    <h1><?php echo $count3; ?></h1>
                    <br/>
                    Total des commandes
                </div>

                <div class="col-4 text-center">
                    <?php
                        //Créer une requête SQL pour obtenir le total des recettes générées
                        //Fonction d'agrégation en SQL
                        $sql4 = "SELECT SUM(total) AS Total FROM order WHERE status 'Delivered'";

                        //Exécuter la requête
                        $res4 = mysqli_query($conn, $sql4);

                        //Obtenir la valeur
                        $count4 = mysqli_num_rows($res4);

                        //Obtenir le revenu total
                        $total_revenue = $row4['Total'];

                    ?>
                
                    <h1><?php echo $total_revenue; ?></h1>
                    
                    <br/>
                    Recettes générées
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Contenu principal Fin de section--> 

<?php include('partials/footer.php'); ?>