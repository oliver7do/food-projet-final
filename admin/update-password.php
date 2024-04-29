<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Changer le mot de passe</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Mot de passe actuel :</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Mot de passe actuel">
                    </td>
                </tr>

                <tr>
                    <td>Nouveau mot de passe</td>
                    <td>
                        <input type="password" name="new_password" placeholder="Nouveau mot de passe">
                    </td>
                </tr>

                <tr>
                    <td>Confirmer le mot de passe</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe">
                    </td>
                </tr>

                <td>
                <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit_password" value="Change Password" class="btn-secondary">
                </td>
                </td>

            </table>
        </form>
    </div>
</div>

<?php
//Vérifier si le bouton Soumettre a été cliqué sur Non
if (isset($_POST['submit_password'])) {
    //echo "Cliquez";

    //1. Obtenir les données du formulaire
    $id = $_POST['id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    //2. Vérifier si l'utilisateur avec l'ID et le mot de passe actuels existe ou non
    $sql = "SELECT * FROM user WHERE id=$id AND password='$current_password'";

    //Exécuter la requête
    $res = mysqli_query($conn, $sql);

    if ($res == true) {

        //Vérifier si les données sont disponibles ou non
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            //L'utilisateur existe et le mot de passe peut être modifié
            //echo "Utilisateur trouvé"

            //Vérifier si le nouveau mot de passe et la confirmation correspondent ou non
            if ($new_password == $confirm_password) {
                //Mettre à jour le mot de passe
                $sql2 = "UPDATE user SET
                            password='$new_password'
                            WHERE id=$id
                            ";

                //Exécuter la requête
                $res2 = mysqli_query($conn, $sql2);

                //Vérifier si la requête a été exécutée ou non
                if ($res2 == true) {
                    //Affichage du message de réussite
                    //Redirec pour gérer la page d'administration avec le message Succès
                    $_SESSION['change-pwd'] = "<div class='success'>Le mot de passe a été modifié avec succès. </div>";
                    //Rediriger l'utilisateur
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    //Affichage du message d'erreur
                    //Redirec pour gérer la page d'administration avec le message Erro
                    $_SESSION['change-pwd'] = "<div class='error'>n'a pas réussi à changer de mot de passe. </div>";
                    //Rediriger l'utilisateur
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                //Redirec pour gérer la page d'administration avec le message Erro
                $_SESSION['pwd-not-match'] = "<div class='error'>Le mot de passe n'a pas été enregistré. </div>";
                //Rediriger l'utilisateur
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            //L'utilisateur n'existe pas Définir le message et rediriger
            $_SESSION['user-not-found'] = "<div class='error'>Utilisateur introuvable. </div>";
            //Rediriger l'utilisateur
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    }

    //3. Vérifier si le nouveau mot de passe et le mot de passe de confirmation correspondent ou non.

    //4. Modifier le mot de passe si tout ce qui précède est vrai
}
?>

<?php include('partials/footer.php'); ?>