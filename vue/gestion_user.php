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
                <th scope="col">Email</th>
                <th scope="col">Pseudo</th>
                <th scope="col">Rôle</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
                <tr> 
                    <td><?php echo $user["email"]; ?></td>
                    <td><?php echo $user["pseudo"];; ?></td>
                    <td><?php echo $user["role"];; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>