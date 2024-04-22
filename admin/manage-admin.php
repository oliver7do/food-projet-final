<?php include('partials/menu.php'); ?>

        <!-- Début de la section du contenu principal --> 
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Admin</h1>

                <br /> 

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add']; //Affichage du message de session
                        unset($_SESSION['add']); //Suppression du message de session
                    }
                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                    }
                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];
                        unset($_SESSION['pwd-not-match']);
                    }
                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                    }
                ?>
                <br><br><br>

                <!-- Bouton pour ajouter un administrateur -->
                <a href="add.admin.php" class="btn-primary">Add Admin</a>

                <br /> <br /> <br />

                <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Nom complet</th>
                        <th>Nom d'utilisateur</th>
                        <th>Actions</th>
                    </tr>

                    <?php 
                        //Requête pour obtenir tous les Admin
                        $sql = "SELECT * FROM user";
                        //Exécuter la requête
                        $res = mysqli_query($conn, $sql);
                        //Vérifier si la requête est exécutée ou non
                        if($res==TRUE)
                        {
                            // Compter les lignes pour vérifier si nous avons des données dans la base de données ou non
                            $count = mysqli_num_rows($res); // pour obtenir toutes les lignes de la base de données

                            $sn=1; //Créer une variable et lui attribuer une valeur

                            //Vérifier le nombre de lignes
                            if($count>0)
                            {
                                //we have data in database
                                while($rows=mysqli_fetch_assoc($res))
                                {
                                    //Utilisation d'une boucle while pour obtenir toutes les données de la base de données.
                                    //Et la boucle while fonctionnera tant que nous aurons des données dans la base de données.
                                    
                                    //Get individual data
                                    $id=$rows['id'];
                                    $full_name=$rows['full_name'];
                                    $username=$rows['username'];

                                    //Afficher le Valeus dans notre tableau
                                    ?>
                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-zero">Changer le mot de passe</a>
                                        <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Mise à jour Admin</a>  
                                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Supprimer Admin</a>  
                                        </td>
                                    </tr>
                                    <?php

                                }
                            }
                            else
                            {
                                //nous n'avons pas de données dans la base
                            }
                        }


                    ?>
                </table>

                
            </div>
        </div>
        <!-- Contenu principal Fin de section--> 

<?php include('partials/footer.php'); ?>