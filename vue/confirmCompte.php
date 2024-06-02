<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Plein la bobine !</title> 
    <link rel="icon" href="/public/assets/img/logo2.png" />
    <?php include 'base.html'; ?>
</head>

<body>
    <!-- HEADER -->
    <div class="wrapper">
        <div class="one"><img src="/public/assets/img/logo2.png" class="rounded-corners" alt="Plein la bobine !"></div>
        <div class="two">
            <h1>Plein la bobine !</h1>
        </div>
<?php
include 'navbar.php';
?>
    </div>

    <!-- BODY -->
    <div class="holy-grail-grid">
        <main class="main-content">
        <h1>Compte confirmé, félicitations!!</h1>
        </main>
        <section class="left-sidebar">
        
        </section>
 
    </div>
    <div id="button-ToGame">
        <?php
        if (isset($_SESSION["pseudo"])) {
        ?>
            
            <a href="/game/game" class="button">Jouer</a>
       
        <?php
        }
        ?>
    </div>

</body>

</html>