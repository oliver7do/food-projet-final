<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        
        <br><br>

        <?php
            //1. Obtenir l'ID de l'Admin sélectionné
            $id=$_GET['id'];

            //2. Créer une requête SQL pour obtenir les détails
            $sql="SELECT * FROM user";

            //Exécuter la requête
            $res=mysqli_query($conn, $sql);

            //Vérifier si la requête est exécutée ou non
            if($res==true)
            {
                // Vérifier si la requête est disponible ou non
                $count = mysqli_num_rows($res);
                // Vérifier si nous avons des données administratives ou non
                if($count==1)
                {
                    //Obtenir les détails
                    // echo "Admin disponible";
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else{
                    //Redirection vers la page Gérer l'Admin
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                   <td>Nom complet</td>
                   <td>
                    <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                   </td>
                </tr>

                <tr>
                    <td>Nom d'utilisateur</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden"  name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit_admin" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>

<?php

        // Vérifier si le bouton de soumission est cliqué ou non
        if($_POST['submit'])
        {
            //echo "Bouton cliqué" ;
            //Il faut récupérer toutes les valeurs pour les mettre à jour
            $id = $_POST['id'];
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];

            //Créer une requête SQL pour mettre à jour l'Admin
            $sql = "UPDATE user SET
            full_name = '$full_name,
            username = '$username
            WHERE id='$id'
            "; 

            //Exécuter la requête
            $res = mysqli_query($conn, $sql);

            //Vérifier si la requête a été exécutée avec succès ou non
            if($res==true)
            {
                //Requête exécutée et Admin mis à jour
                $_SESSION['update'] = "<div class='error'>Failed to Delete Admin.</div>";
                //Redirection vers la page d'administration de la gestion
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
?>


<?php include('partials/footer.php'); ?>