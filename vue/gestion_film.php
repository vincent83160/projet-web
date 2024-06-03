<!DOCTYPE html>
<html lang="fr">

<?php
include 'base_gestion.php';
?>

<body>
    <div class="container2">
    <div id="spinner"><img src="/public/assets/gif/spinner.gif" alt="spinner" /></div>
        <input type="hidden" id="context" value="film" />
        <!-- HEADER -->
        <div class="wrapper">
            <div class="one"><img src="/public/assets/img/logo2.png" class="rounded-corners" alt="Plein la bobine !"></div>
            <div class="two">
                <h1>Plein la bobine !</h1>
            </div>
            <?php include 'navbar.php'; ?>

        </div>
        <div class="fields">
            <span>
                <input id="input-film" placeholder="Ajouter un film" type="text" />
            </span>
            <span id="container-list-suggestions">
                <div id="list-suggestions"></div>
            </span>
        </DIV>
        <!-- BODY -->
        <table id="table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col">Affiche</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Date de sortie</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($films as $film) { ?>
                    <tr id="tr-<?php echo $film["id"]; ?>">
                        <td><img src="https://image.tmdb.org/t/p/w185<?= $film['poster_path'] ?>" alt="<?= $film['original_title'] ?>" class="rounded-corners"></td>
                        <td><?= $film['original_title'] ?></td>
                        <td><?= $film['release_date'] ?></td>
                        <td><button class="btn btn-danger btn-delete" id="<?php echo $film["id"]; ?>">Supprimer</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>