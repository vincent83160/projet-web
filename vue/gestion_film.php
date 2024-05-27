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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($films as $film) { ?>
                <tr>
                    <td><img src="/public/assets/img/<?= $film['affiche'] ?>" alt="<?= $film['nom'] ?>" class="rounded-corners"></td>
                    <td><?= $film['nom'] ?></td>
                    <td><?= $film['annee'] ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</body>

</html>