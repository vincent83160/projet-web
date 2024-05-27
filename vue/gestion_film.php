<!DOCTYPE html>
<html>

<head>
    <title>Plein la bobine !</title>
    <link rel="icon" href="/public/assets/img/logo2.png" />

    <link rel="stylesheet" href="/public/assets/css/style.css">
    <?php
    include 'base.html';
    ?>
</head>

<body>
    <!-- HEADER -->
    <div class="wrapper">
        <div class="one"><img src="/public/assets/img/logo2.png" class="rounded-corners" alt="Plein la bobine !"></div>
        <div class="two">
            <h1>Plein la bobine !</h1>


        </div>
        <?php include 'navbar.php'; ?>

    </div>

    <!-- BODY -->
    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">Affiche</th>
                <th scope="col">Nom</th>
                <th scope="col">Année</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film) { ?>
                <tr>
                    <td><img src="https://image.tmdb.org/t/p/w185<?= $film['poster_path'] ?>" alt="<?= $film['original_title'] ?>" class="rounded-corners"></td>
                    <td><?= $film['original_title'] ?></td>
                    <td><?= $film['release_date'] ?></td>
                    <td></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>