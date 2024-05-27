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
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>
</body>

</html>