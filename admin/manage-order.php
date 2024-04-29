<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">  
        <h1>Gérer la commande</h1>


<br /> <br /> <br />

    <?php
        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

    ?>

<table class="tbl-full">
    <tr>
        <th>S.N.</th>
        <th>Nourriture</th>
        <th>Prix</th>
        <th>Qty.</th>
        <th>Total</th>
        <th>Date de la commande</th>
        <th>Statut</th>
        <th>Nom du client</th>
        <th>Contact</th>
        <th>Courriel</th>
        <th>Adresse</th>
        <th>Actions</th>
    </tr>

    <?php

        //Reprend toutes les commandes de la base de données
        $sql = "SELECT * FROM order ORDER BY id DESC"; // Afficher l'ordre le plus récent en premier
        //Exécuter la requête
        $res = mysqli_query($conn, $sql);
        //Compter les lignes
        $count = mysqli_num_rows($res);

        $sn = 1; //Créer un numéro de série et fixer sa valeur initiale à 1

        if($count>0)
        {
            //Commande disponible
            while($row=mysqli_fetch_assoc($res))
            {
                //Importe tous les détails de la commande
                $id = $row['id'];
                $food = $row['food'];
                $price = $row['price'];
                $qty = $row['qty'];
                $total = $row['total'];
                $order_date = $row['order_date'];
                $status = $row['status'];
                $customer_name = $row['customer_name'];
                $customer_contact = $row['customer_contact'];
                $customer_email = $row['customer_email'];
                $customer_address = $row['customer_address'];

                ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>

                        <td>
                            <?php 
                                //Commandé, A la livraison, Livré, Annulé
                                if($status=="Ordered")
                                {
                                    echo "<lable>$status</lable>";
                                }
                                elseif($status=="On Delivery")
                                {
                                    echo "<label style='color: orange;'>$status</label>";
                                }
                                elseif($status=="Delivered")
                                {
                                    echo "<lablel style='color: green;'>$status</lable>";
                                }
                                elseif($status=="Cancelled")
                                {
                                    echo "<lablel style='color: red;'>$status</lable>";
                                }
                            
                            ?>
                        </td>

                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td>
                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Mise à jour Commande</a>  
                        <a href="<?php echo SITEURL; ?>admin/delete-order.php?id=<?php echo $id; ?>" class="btn-danger">Supprimer Commande</a>  
                        </td>
                    </tr>
                <?php

            }

        }
        else
        {
            //Commande disponible
            echo "<tr><td colspan='12' class='error'>Commandes non disponibles</td></tr>";
        }

    ?>


</table>
    </div>
    
</div>

<?php include('partials/footer.php'); ?>