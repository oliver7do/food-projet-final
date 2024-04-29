<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Mise à jour de la commande</h1>
        <br><br>

        <?php

            //Vérifier si l'identifiant est défini ou non
            if(isset($_GET['id']))
            {
                //Obtenir les détails de la commande
                $id=$_GET['id'];

                //Importe tous les autres détails en fonction de cet identifiant
                //SQL Query pour obtenir les détails de la commande
                $sql = "SELECT * FROM order WHERE id=$id";
                //Exécuter la requête
                $res = mysqli_query($conn, $sql);
                //Compter les lignes
                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //Détail disponible
                    $row=mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email= $row['customer_email'];
                    $customer_address= $row['customer_address'];
                }
                else
                {
                    //Détail non disponible
                    //Redirection vers la gestion de la commande
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
            else
            {
                //Redirection vers la page de gestion des commandes
                header('location:'.SITEURL.'admin/manage-order.php');
            }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Nom de l'aliment</td>
                    <td><br> <?php echo $food; ?> </br></td>
                </tr>

                <tr>
                    <td>Prix</td>
                    <td>
                        <br> $ <?php echo $price; ?> </br>
                    </td>

                </tr>

                <tr>
                    <td>Qty</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Commandé</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">A la livraison</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Livré</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Annulé</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Nom du client: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Contact client: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Courriel du client: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Adresse du client: </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

            <?php
                //Vérifier si le bouton de mise à jour est cliqué ou non
                if(isset($_POST['submit']))
                {
                    //echo "Clicked";
                    //Reprendre toutes les valeurs du formulaire
                    $id = $_POST['id'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty;

                    $status = $_POST['status'];

                    $customer_name = $_POST['customer_name'];
                    $customer_contact = $_POST['customer_contact'];
                    $customer_email = $_POST['customer_email'];
                    $customer_address = $_POST['customer_address'];

                    //Mise à jour des valeurs
                    $sql2 = "UPDATE order SET
                        qty = $qty,
                        total = $total,
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                        WHERE id=$id
                    ";

                    //Exécuter la requête
                    $res2 = mysqli_query($conn, $sql2);
                    
                    //Vérifier s'il y a eu mise à jour ou non
                    //Et rediriger vers Gérer la commande avec un message
                    if($res2==true)
                    {
                        //Mise à jour
                        $_SESSION['update'] = "<div class='success'>Commande mise à jour avec succès.</div>";
                        header('location:'.SITEURL.'admin/manage-order');
                    }
                    else
                    {
                        //Echec de la mise à jour
                        $_SESSION['update'] = "<div class='error'>Échec de la mise à jour de l'ordre.</div>";
                        header('location:'.SITEURL.'admin/manage-order');
                    }

                }

            ?>

    </div>
</div>
<?php include ('partials/footer.php'); ?>