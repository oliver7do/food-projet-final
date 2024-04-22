<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Gérer la catégorie</h1>

        <br /> <br />

        <?php

        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION);
        }


        ?>
        <br><br>

        <!-- Bouton pour ajouter un administrateur -->
        <a href="<?php echo SITEURL; ?>admin/add.category.php" class="btn-primary">Add Catégorie</a>

        <br /> <br /> <br /> <br />

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Titre</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <tr>
                <td>1. </td>
                <td>Oliveira Domingos</td>
                <td>Oliver</td>
                <td>
                    <a href="" class="btn-secondary">Mise à jour Admin</a>
                    <a href="" class="btn-danger">Supprimer Admin</a>
                </td>
            </tr>

        </table>
    </div>

</div>

<?php include('partials/footer.php'); ?>