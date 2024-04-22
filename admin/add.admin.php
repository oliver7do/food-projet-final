<?php include('partials/menu.php'); 
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /> <br />

                <?php
                    if(isset($_SESSION['add']))//Vérifier si la session est définie ou non
                    {
                        echo $_SESSION['add']; //Affichage du message de session si défini
                        unset($_SESSION['add']); //Suppression du message de session
                    }
                ?>

        <form action="" method="post">

            <table class="tbl-30">
                <tr>
                    <td>Nom complet: </td>
                    <td><input type="text" name="full_name" placeholder="Entrez votre nom"></td>
                </tr>

                <tr>
                    <td>Nom d'utilisateur: </td>
                    <td>
                        <input type="text" name="username" placeholder="Nom d'utilisateur">
                    </td>
                </tr>

                <tr>
                    <td>Mot de passe: </td>
                    <td>
                        <input type="password" name="password" placeholder="Votre mot de passe">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit_admin" value="Add Admin" class="btn btn-secondary">
                    </td>
                </tr>
            </table>

                </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
    //Traiter la valeur de from et l'enregistrer dans la base de données

    //Vérifier si le bouton de soumission est cliqué ou non
    if(isset($_POST['submit_admin']))
    {
        //1. Bouton cliqué
        //echo "Bouton cliqué";

        //Récupérer les données du formulaire
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password']; //Password Cryptage avec MDS

        //2. SQL Query pour enregistrer les données dans la base de données
        $sql = "INSERT INTO user SET
            full_name='$full_name',
            username='$username',
            password='$password'
            ";
        //3.Exécuter une requête et enregistrer les données dans la base de données
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //4.Vérifier si les données (Query is Executed) sont insérées ou non et afficher le message approprié
        if($res==TRUE)
        {
            //Data Inserted
            // echo "Données insérées";
            //Créer une variable de session pour afficher un message
            $_SESSION['add'] = "Admin ajouté avec succès";
            //Rediriger la page vers Gérer l'Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //Failed to insert Data
            // echo "Faile pour insérer des données";
            //Créer une variable de session pour afficher un message
            $_SESSION['add'] = "Failed to add Admin";
            //Redirection d'une page vers l'ajout d'un admin
            header("location:".SITEURL.'admin/add.admin.php');
        }
    }
?>