<!DOCTYPE html>
<html lang="fr">

<?php
include 'base_gestion.php';
?>

<body>

    <div class="container2">
        <input type="hidden" id="context" value="user" />
        <!-- HEADER -->
        <div class="wrapper">
            <div class="one"><img src="/public/assets/img/logo.webp" width="100" height="100" class="rounded-corners" alt="Plein la bobine !"></div>
            <div class="two">
                <h1>Plein la bobine !</h1>
            </div>
            <?php include 'navbar.php'; ?>

        </div>

        <!-- BODY -->
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr id="tr-<?php echo $user["id"]; ?>">
                        <td><?php echo $user["email"]; ?></td>
                        <td><?php echo $user["pseudo"]; ?></td>
                        <td><?php echo $user["role"]; ?></td>
                        <td><button class="btn btn-danger btn-delete" id="<?php echo $user["id"]; ?>">Supprimer</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>