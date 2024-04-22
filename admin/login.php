<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Connexion - Système de Commande de Nourriture</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Connexion</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }

            ?>
            <br><br>

            <!-- Le formulaire de connexion commence ici -->

            <form action="" method="POST" class="text-center">
            Nom d'utilisateur : <br>
            <input type="text" name="username" placeholder="Saisir le nom d'utilisateur"><br><br>
            
            Mot de passe : <br>
            <input type="text" name="password" placeholder="Saisir le mot de passe"><br><br>

            <input type="submit" name="submit" value="Login" class="btn-primary">
            </form>


            <!-- Le formulaire de connexion se termine ici -->

            <p class="text-center">Créé par - <a href="www.oliver.com"></a>Oliver Riche</p>
        </div>
    
    </body>
</html>

<?php 

    //Vérifier si le bouton de soumission est cliqué ou non
    if(isset($_POST['submit']))
    {
        //Processus de connexion
        //1. Récupérer les données du formulaire de connexion
        $username = $_POST['username'];
        $password = $_POST['password'];

        //2. SQL pour vérifier si l'utilisateur avec le nom d'utilisateur et le mot de passe existe ou non
        $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";

        //3. Exécuter la requête
        $res = mysqli_query($conn, $sql);

        //4. Compter les lignes pour vérifier si l'utilisateur existe ou non
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //Utilisateur disponible et succès de la connexion
            $_SESSION['login'] = "<div class='success'>Connexion réussie.</div>";
            $_SESSION['user'] = $username; //ID vérifie si l'utilisateur est connecté ou non et logout le désactive

            //Redirection vers l'accueil/le tableau de bord
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //Utilisateur non disponible et succès de la connexion
            $_SESSION['login'] = "<div class='error text-center'>Le nom d'utilisateur ou le mot de passe ne correspond pas.</div>";
            //Redirection vers l'accueil/le tableau de bord
            header('location:'.SITEURL.'admin/login.php');

        }
    }

?>